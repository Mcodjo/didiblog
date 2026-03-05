<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'about_title' => SiteSetting::get('about_title', 'Bonjour, je suis Cadnel DOSSOU'),
            'about_description' => SiteSetting::get('about_description', ''),
            'about_image' => SiteSetting::get('about_image', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'),
            'about_stat1_value' => SiteSetting::get('about_stat1_value', '4 300+'),
            'about_stat1_label' => SiteSetting::get('about_stat1_label', 'Personnes accompagnées'),
            'about_stat2_value' => SiteSetting::get('about_stat2_value', '85%'),
            'about_stat2_label' => SiteSetting::get('about_stat2_label', 'Taux de réussite'),
            'about_stat3_value' => SiteSetting::get('about_stat3_value', '8+'),
            'about_stat3_label' => SiteSetting::get('about_stat3_label', "Années d'expérience"),
            'about_stat4_value' => SiteSetting::get('about_stat4_value', '5'),
            'about_stat4_label' => SiteSetting::get('about_stat4_label', 'Formations disponibles'),
            
            'qui_suis_je_title' => SiteSetting::get('qui_suis_je_title', 'Coach Didi, ton expert en employabilité'),
            'qui_suis_je_description1' => SiteSetting::get('qui_suis_je_description1', ''),
            'qui_suis_je_description2' => SiteSetting::get('qui_suis_je_description2', ''),
            'qui_suis_je_image' => SiteSetting::get('qui_suis_je_image', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'),
            'qui_suis_je_stat1_value' => SiteSetting::get('qui_suis_je_stat1_value', '4 300+'),
            'qui_suis_je_stat1_label' => SiteSetting::get('qui_suis_je_stat1_label', 'Personnes accompagnées'),
            'qui_suis_je_stat2_value' => SiteSetting::get('qui_suis_je_stat2_value', '85%'),
            'qui_suis_je_stat2_label' => SiteSetting::get('qui_suis_je_stat2_label', 'Taux de réussite'),
        ];
        
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'about_stat1_value' => 'nullable|string|max:50',
            'about_stat1_label' => 'nullable|string|max:100',
            'about_stat2_value' => 'nullable|string|max:50',
            'about_stat2_label' => 'nullable|string|max:100',
            'about_stat3_value' => 'nullable|string|max:50',
            'about_stat3_label' => 'nullable|string|max:100',
            'about_stat4_value' => 'nullable|string|max:50',
            'about_stat4_label' => 'nullable|string|max:100',
            'qui_suis_je_title' => 'nullable|string|max:255',
            'qui_suis_je_description1' => 'nullable|string',
            'qui_suis_je_description2' => 'nullable|string',
            'qui_suis_je_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'qui_suis_je_stat1_value' => 'nullable|string|max:50',
            'qui_suis_je_stat1_label' => 'nullable|string|max:100',
            'qui_suis_je_stat2_value' => 'nullable|string|max:50',
            'qui_suis_je_stat2_label' => 'nullable|string|max:100',
        ]);

        $imageFields = ['about_image', 'qui_suis_je_image'];

        foreach ($validated as $key => $value) {
            if (in_array($key, $imageFields)) {
                continue;
            }
            SiteSetting::set($key, $value);
        }

        if ($request->hasFile('about_image')) {
            $oldImage = SiteSetting::get('about_image');
            if ($oldImage && str_starts_with($oldImage, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
            }
            $path = $request->file('about_image')->store('settings', 'public');
            SiteSetting::set('about_image', '/storage/' . $path);
        }

        if ($request->hasFile('qui_suis_je_image')) {
            $oldImage = SiteSetting::get('qui_suis_je_image');
            if ($oldImage && str_starts_with($oldImage, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
            }
            $path = $request->file('qui_suis_je_image')->store('settings', 'public');
            SiteSetting::set('qui_suis_je_image', '/storage/' . $path);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Les paramètres ont été mis à jour avec succès.');
    }
}