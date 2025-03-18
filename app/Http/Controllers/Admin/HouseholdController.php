<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Household;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HouseholdController extends Controller
{
    public function index(Request $request)
    {
        $name = Str::title($request->query('name'));
        $char = $request->query('char');

        $households = Household::when($name, fn($query) => $query->where('name', 'ILIKE', "%$name%"))
            ->when($char, fn($query) => $query->where('name', 'ILIKE', "$char%"))
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        return view('admin.households.index', compact('households'));
    }

    public function create()
    {
        return view('admin.households.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:households,name',
            'speciality' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:255',
            'extraInfo' => 'nullable|string|max:1500',
            'breeds' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'contacts' => 'nullable|string|max:1500',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        $validated['showOnMain'] = $request->has('showOnMain');

        $image = $request->file('image')
        ? $request->file('image')->store('households', 'public')
        : null;

        $validated['image'] = $image;

        Household::create($validated);

        return redirect()->route('households.index')->with('success', 'Хозяйство успешно создано!');
    }


    public function show(Household $household)
    {
        $household->load('logEntries.male', 'logEntries.female');
        $maleAnimals = Animal::where('isMale', true)->get();
        $femaleAnimals = Animal::where('isMale', false)->get();

        $animals_for_sale = Animal::select('id', 'name')
        ->where('household_owner_id', $household->id)
        ->where('forSale', true)->get();

        $all_animals = Animal::select('id', 'name')
        ->where('household_owner_id', $household->id)->get();

        return view('admin.households.show', compact('household', 'maleAnimals', 'femaleAnimals', 'animals_for_sale', 'all_animals'));
    }


    public function edit(Household $household)
    {
        $maleAnimals = Animal::where('isMale', true)->get();
        $femaleAnimals = Animal::where('isMale', false)->get();

        return view('admin.households.edit', compact('household', 'maleAnimals', 'femaleAnimals'));
    }

    public function update(Request $request, Household $household)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:255',
            'extraInfo' => 'nullable|string|max:1500',
            'breeds' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'contacts' => 'nullable|string|max:1500',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        $validated['showOnMain'] = $request->has('showOnMain');

        if ($request->hasFile('image')) {
            if ($household->image) {
                Storage::disk('public')->delete($household->image);
            }
            $image = $request->file('image')->store('households', 'public');
        } else {
            $image = $household->image;
        }
        $validated['image'] = $image;

        $household->update($validated);

        return redirect()->route('households.index')->with('success', 'Хозяйство успешно обновлено!');
    }


    public function destroy(Household $household)
    {
        if ($household->image) {

            if (Storage::disk('public')->exists($household->image)) {
                Storage::disk('public')->delete($household->image);
            }
        }

        $household->delete();
        return redirect()->route('households.index')->with('success', 'Хозяйство успешно удалено!');
    }
}
