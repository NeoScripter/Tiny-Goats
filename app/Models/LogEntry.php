<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function male()
    {
        return $this->belongsTo(Animal::class);
    }

    public function female()
    {
        return $this->belongsTo(Animal::class);
    }
}
