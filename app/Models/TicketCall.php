<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketCall extends Model
{
    protected $fillable = ['ticket_id', 'called_by', 'called_at', 'action'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
