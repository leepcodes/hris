<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemSettingController extends Controller
{
    public function index()
    {
        abort_unless(request()->user()->hasPermission('settings.view'), 403);

        $settings = DB::table('system_settings')->orderBy('group')->orderBy('key')->paginate(20);

        return view('system-settings.index', compact('settings'));
    }

    public function update(Request $request, string $group)
    {
        abort_unless($request->user()->hasPermission('settings.update'), 403);

        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.key' => ['required', 'string'],
            'settings.*.value' => ['nullable'],
        ]);

        DB::transaction(function () use ($validated, $group): void {
            foreach ($validated['settings'] as $setting) {
                DB::table('system_settings')->updateOrInsert(
                    ['group' => $group, 'key' => $setting['key']],
                    [
                        'value' => json_encode($setting['value'], JSON_THROW_ON_ERROR),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        return back()->with('status', 'Settings updated.');
    }
}
