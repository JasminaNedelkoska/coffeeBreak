<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'has_hip_chat'
    ];

    public function staffMember()
    {
        return $this->belongsTo('App\Models\StaffMember', 'team', 'id');
    }
}