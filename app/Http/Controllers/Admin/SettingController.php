<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view settings')->only(['index']);
        $this->middleware('permission:edit settings')->only(['saveBasic', 'saveSms']);
    }

    public function index()
    {
        $setting = Setting::firstOrCreate(['id' => 1]);

        return view('admin.settings.settings', compact('setting'));
    }

    public function saveBasic(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bd_title' => 'nullable|string|max:255',
            'bd_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'bd_email' => 'nullable|email|max:255',
            'bd_contact' => 'nullable|string|max:20',
            'bd_address' => 'nullable|string',
            'bd_location' => 'nullable|string|max:255',
            'bd_support_mail' => 'nullable|email|max:255',
        ]);

        if ($request->hasFile('bd_logo')) {
            $validated['bd_logo'] = $this->uploadLogo($request->file('bd_logo'));
        }

        Setting::updateOrCreate(['id' => 1], $validated);

        return response()->json([
            'success' => true,
            'message' => 'Basic details saved successfully!',
        ]);
    }

    public function saveSms(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sms_meta' => 'nullable|string|max:255',
            'sms_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sms_email' => 'nullable|email|max:255',
            'sms_contact' => 'nullable|string|max:20',
            'sms_address' => 'nullable|string',
            'sms_location' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('sms_logo')) {
            $validated['sms_logo'] = $this->uploadLogo($request->file('sms_logo'));
        }

        Setting::updateOrCreate(['id' => 1], $validated);

        return response()->json([
            'success' => true,
            'message' => 'SMS details saved successfully!',
        ]);
    }

    protected function uploadLogo($file): string
    {
        $directory = public_path('uploads/settings');
        if (! file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/settings/' . $filename;
    }
}