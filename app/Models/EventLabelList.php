<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLabelList extends Model
{
    use HasFactory;

    public $timestamps  = true;

    protected $fillable = ['event_id', "name"];
}
