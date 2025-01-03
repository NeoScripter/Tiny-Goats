<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function animalOwner()
    {
        return $this->hasMany(Animal::class, 'household_owner_id');
    }

    public function animalBreeder()
    {
        return $this->hasMany(Animal::class, 'household_breeder_id');
    }

    public function logEntries()
    {
        return $this->hasMany(LogEntry::class);
    }
}
