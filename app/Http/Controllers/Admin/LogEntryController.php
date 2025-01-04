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
            'number' => 'required|string|max:100',
            'household_id' => 'required|exists:households,id',
            'male_id' => 'required|exists:animals,id',
            'female_id' => 'required|exists:animals,id',
            'coverage' => 'required|string|max:300',
            'lambing' => 'required|string|max:300',
            'status' => 'required|string|max:300',
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
