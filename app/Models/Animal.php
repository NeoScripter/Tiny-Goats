<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isMale',
        'breed',
        'forSale',
        'color',
        'eyeColor',
        'birthDate',
        'direction',
        'siblings',
        'hornedness',
        'birthCountry',
        'residenceCountry',
        'status',
        'labelNumber',
        'height',
        'rudiment',
        'extraInfo',
        'certificates',
        'showOnMain',
        'images',
        'mother_id',
        'father_id'
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

    // Relationship to get children where the animal is the mother
    public function childrenAsMother()
    {
        return $this->hasMany(Animal::class, 'mother_id');
    }

    // Relationship to get children where the animal is the father
    public function childrenAsFather()
    {
        return $this->hasMany(Animal::class, 'father_id');
    }

    // Combined relationship for all children (both as mother and father)
    public function children()
    {
        return $this->childrenAsMother()->union($this->childrenAsFather());
    }
}
