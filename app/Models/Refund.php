<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'ticket_id',
        'performance_id',
        'obra_id',
        'payment_id',
        'refund_id',
        'amount',
        'status',
        'reason',
        'refunded_at'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
