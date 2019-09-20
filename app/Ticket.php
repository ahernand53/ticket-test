<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Ticket extends Model
{

    protected $with = [
        'details',
        'user',
        'userAssigned'
    ];

    public $timestamps = false;

    protected $fillable = [
        'issue',
        'priority',
        'state',
        'assignation_date',
        'user_id',
        'user_assigned'
    ];

    protected $casts = [
        'state' => 'boolean'
    ];

    protected $attributes = [
        'state' => true
    ];

    public static function rules() {
        return [
            'issue' => 'required|string',
            'priority' => 'required|in:' . implode(',', array('ALTO', 'MEDIO', 'BAJO')),
            'assignation_date' => 'required|date:yyyy-mm-dd',
            'task' => 'required|string',
            'user' => 'required',
            'userAssigned' => 'required'
        ];
    }

    public function details() {
        return $this->hasOne(TicketDetails::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function userAssigned() {
        return $this->belongsTo(
            User::class,
            'user_assigned',
            'id'
        );
    }
}
