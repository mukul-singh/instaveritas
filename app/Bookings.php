<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = [
        'bid', 'sid', 'uid', 'bookingTime', 'dateOfBooking'
    ];

    protected $table = 'Bookings';
    protected $primaryKey = 'bid';

    /**

     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];
}
