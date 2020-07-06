<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use Uuid, HasApiTokens;

    const STATUS_INACTIVE = -1;
    const STATUS_ACTIVE = 1;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency');
    }

    public function holder()
    {
        return $this->belongsTo('App\Models\Holder');
    }
}
