<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class EventDetail extends Model
{
    use HasFactory;

    protected $appends = ["limit_description"];

    public function getLimitDescriptionAttribute() {
        return Str::limit($this->description);
    }
}
