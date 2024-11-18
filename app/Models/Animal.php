<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'isMale', 'breed', 'forSale', 'color', 'eyeColor', 'birthDate',
        'direction', 'siblings', 'hornedness', 'birthCountry', 'residenceCountry',
        'status', 'labelNumber', 'height', 'rudiment', 'extraInfo',
        'certificates', 'showOnMain', 'images', 'mother_id', 'father_id'
    ];

    protected $casts = [
        'isMale' => 'boolean',
        'forSale' => 'boolean',
        'showOnMain' => 'boolean',
        'images' => 'array',
        'birthDate' => 'date',
    ];

    public function mother()
    {
        return $this->belongsTo(Animal::class, 'mother_id');
    }

    public function father()
    {
        return $this->belongsTo(Animal::class, 'father_id');
    }

    public function children()
    {
        return Animal::where('mother_id', $this->id)
                     ->orWhere('father_id', $this->id);
    }
}
