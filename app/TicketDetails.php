<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDetails extends Model
{
    protected $fillable = [
        'task',
        'state',
        'concluding_remarks',
        'ticket_id'
    ];

    protected $attributes = [
        'state' => true
    ];

    public $timestamps = false;

    protected $casts = [
        'state' => 'boolean'
    ];

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}
