<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoffeeBreakPreference extends Model
{
    protected $table = 'coffee_break_preference';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'type', 'sub_type', 'requested_by', 'requested_date', 'details'
    ];

    protected $casts = [
        "details" => "array"
    ];

    public function setDetailsAttribute($value)
    {
        if ($this->attributes['type'] === "drink") {
            $this->attributes['details']["number_of_sugars"] = isset($value['details']["number_of_sugars"]) ?? 0;
            $this->attributes['details']["milk"] = isset($value['details']["milk"]) ?? false;
        } else {
            $this->attributes['details']["flavour"] = isset($value['details']["flavour"]) ?? "don't mind";
        }
    }

    public function staffMember()
    {
        return $this->belongsTo('App\Models\StaffMember', 'id', 'requested_by');
    }
}