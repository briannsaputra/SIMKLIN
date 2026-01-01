<?php

namespace App\Models;

use App\Models\TicketCall;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['number','status','called_at','finished_at'];

    public function calls()
    {
        return $this->hasMany(TicketCall::class);
    }
}
