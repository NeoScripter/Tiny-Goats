<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogEntry;
use Illuminate\Http\Request;

class LogEntryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:100',
            'household_id' => 'nullable|exists:households,id',
            'male_id' => 'nullable|exists:animals,id',
            'female_id' => 'nullable|exists:animals,id',
            'coverage' => 'nullable|string|max:300',
            'lambing' => 'nullable|string|max:300',
            'status' => 'nullable|string|max:300',
        ]);

        LogEntry::create($validated);

        return redirect()->back()->with('success', 'Запись успешно создана!');
    }

    public function destroy($log_entry_id)
    {
        $log_entry = LogEntry::findOrFail($log_entry_id);

        $log_entry->delete();

        return redirect()->back()->with('success', 'Запись успешно удалена!');
    }
}
