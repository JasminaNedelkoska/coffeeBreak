<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    protected $table = 'staff_member';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'hip_chat_identifier', 'password'
    ];

    public function memberTeam()
    {
        return $this->hasOne('App\Models\Team', 'id', 'team');
    }

    public function coffeeBreak()
    {
        return $this->hasMany('App\Models\CoffeeBreakPreference', 'requested_by', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\Users', 'id_user_login', 'id');
    }
}