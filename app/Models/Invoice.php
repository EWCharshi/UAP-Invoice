<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'pickup_location',
        'dropoff_location',
        'trip_date',
        'trip_time',
        'vehicle_type',
        'base_fare',
        'distance_fare',
        'total_amount',
        'notes',
        'status',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'trip_date' => 'date',
        'trip_time' => 'datetime:H:i',
        'base_fare' => 'decimal:2',
        'distance_fare' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function markAsCancelled()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    public function getFormattedTotalAttribute()
    {
        return '£' . number_format($this->total_amount, 2);
    }

    public function getFormattedDateAttribute()
    {
        return $this->trip_date->format('M d, Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->trip_time->format('g:i A');
    }
}
