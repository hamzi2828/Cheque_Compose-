<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteSettingController extends Controller
{
    public function create()
    {
        return view('site-settings.create', [
            'title'    => 'Site Settings',
            'settings' => SiteSetting::current(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => ['nullable', 'string', 'max:255'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'login_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        $existing = SiteSetting::current();

        SiteSetting::updateOrCreate(
            ['slug' => SiteSetting::SLUG],
            ['settings' => [
                'title'       => $request->input('title'),
                'logo'        => $this->uploadImage($request, 'logo') ?? $existing['logo'] ?? null,
                'login_image' => $this->uploadImage($request, 'login_image') ?? $existing['login_image'] ?? null,
            ]]
        );

        return redirect()->back()->with('success', 'Settings have been updated.');
    }

    /**
     * Store an uploaded image under public/uploads/site-settings and return
     * its relative path, or null when no new file was uploaded.
     */
    private function uploadImage(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $path = 'uploads/site-settings/';
        $dir  = public_path($path);

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }

        $file     = $request->file($field);
        $fileName = time() . '-' . $field . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $fileName);

        return $path . $fileName;
    }
}
