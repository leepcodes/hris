<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    public function index()
    {
        $grouped = SystemSetting::query()->orderBy('group')->get()->groupBy('group');

        return view('system-config.index', ['grouped' => $grouped]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group' => ['required', 'string'],
            'key' => ['required', 'string'],
            'value' => ['nullable'],
        ]);

        SystemSetting::query()->updateOrCreate(
            ['group' => $validated['group'], 'key' => $validated['key']],
            ['value' => ['value' => $validated['value']], 'is_public' => false]
        );

        return back()->with('status', 'Configuration saved.');
    }
}
