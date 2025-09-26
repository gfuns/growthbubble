<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTickets extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function lastReplier()
    {
        $ticket = TicketResponses::where("ticket_id", $this->id)->latest()->first();
        return $ticket->user->last_name . " " . $ticket->user->other_names;
    }

    public function lastActivity()
    {
        $ticket = TicketResponses::where("ticket_id", $this->id)->latest()->first();
        return $ticket->created_at->diffforhumans();
    }
}
