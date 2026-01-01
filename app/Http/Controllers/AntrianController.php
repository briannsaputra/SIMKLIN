<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Events\TicketUpdated;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    // halaman utama (Inertia) untuk user ambil tiket
    public function index()
    {
        $current = Ticket::where('status', 'called')->orderBy('called_at', 'desc')->first();
        $nextNumber = Ticket::max('number') ? Ticket::max('number') + 1 : 1;

        return Inertia::render('Antrian/Index', [
            'current' => $current,
            'nextNumber' => $nextNumber,
            'waiting_count' => Ticket::where('status', 'waiting')->count(),
        ]);
    }

    // ambil tiket (customer)
    public function takeTicket(Request $req)
    {
        return DB::transaction(function () {
            $max = Ticket::lockForUpdate()->max('number') ?? 0;
            $ticket = Ticket::create([
                'number' => $max + 1,
                'status' => 'waiting',
            ]);

            event(new TicketUpdated($ticket, ['type' => 'created']));

            return response()->json(['ticket' => $ticket], 201);
        });
    }

    // admin: panggil berikutnya
    public function callNext(Request $req)
    {
        // ambil tiket with smallest id yang status waiting
        $ticket = Ticket::where('status', 'waiting')->orderBy('number')->first();
        if (! $ticket) {
            return response()->json(['message' => 'tidak ada antrian'], 404);
        }

        $ticket->update([
            'status' => 'called',
            'called_at' => now(),
        ]);

        $ticket->calls()->create([
            'called_by' => $req->user()?->name ?? 'Petugas',
            'action' => 'call',
            'called_at' => now(),
        ]);

        event(new TicketUpdated($ticket, ['type' => 'called']));

        return response()->json(['ticket' => $ticket]);
    }

    // admin: finish current called ticket
    public function finishTicket(Request $req, Ticket $ticket)
    {
        $ticket->update(['status' => 'done']);
        $ticket->calls()->create([
            'called_by' => $req->user()?->name ?? 'Petugas',
            'action' => 'finished',
            'called_at' => now(),
        ]);

        event(new TicketUpdated($ticket, ['type' => 'finished']));

        return response()->json(['ticket' => $ticket]);
    }

    public function adminPage()
    {
        // data awal untuk dashboard admin
        $current = Ticket::where('status', 'called')->orderBy('called_at', 'desc')->first();
        $waiting = Ticket::where('status', 'waiting')->orderBy('number')->get();

        return Inertia::render('Antrian/Admin', [
            'current' => $current,
            'waiting' => $waiting,
        ]);
    }

    public function status()
    {
        return response()->json([
            'current' => Ticket::whereNotNull('called_at')
                ->whereNull('finished_at')
                ->orderBy('called_at', 'desc')
                ->first(),

            'waiting' => Ticket::whereNull('called_at')
                ->orderBy('created_at')
                ->get(),
        ]);
    }
}
