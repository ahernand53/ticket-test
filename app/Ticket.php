<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Ticket extends Model
{

    protected $with = [
        'details',
        'user'
    ];

    public $timestamps = false;

    protected $fillable = [
        'issue',
        'priority',
        'state',
        'assignationDate',
        'user_id'
    ];

    protected $casts = [
        'state' => 'boolean',
        'assignationDate' => 'date:M d Y'
    ];

    protected $attributes = [
        'state' => true
    ];

    public static function rules() {
        return [
            'issue' => 'required|string',
            'priority' => 'required|in:' . implode(',', array('ALTO', 'MEDIO', 'BAJO')),
            'assignationDate' => 'required|date:yyyy-mm-dd',
            'task' => 'required|string'
        ];
    }

    public function details() {
        return $this->hasOne(TicketDetails::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
