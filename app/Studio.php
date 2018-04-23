<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = [
        'name', 'sid', 'amenities', 'equipments', 'clients', 'rate', 'coverPic', 'profilePic', 'about', 'address'
    ];

    protected $table = 'studios';
    protected $primaryKey = 'sid';

    /**

     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];
}
