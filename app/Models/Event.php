<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    public function eventDetail() {
        return $this->hasOne(EventDetail::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function eventLabelLists() {
        return $this->hasMany(EventLabelList::class, "event_id");
    }
}
