<?php
namespace App\Events;
use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TicketUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $ticket;
    public $meta;

    public function __construct(Ticket $ticket, $meta = [])
    {
        $this->ticket = $ticket->load('calls');
        $this->meta = $meta;
    }

    // broadcast on public channel 'antrian'
    public function broadcastOn()
    {
        return new Channel('antrian');
    }

    // (opsional) event name
    public function broadcastAs()
    {
        return 'ticket.updated';
    }
}
