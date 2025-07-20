<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'E-Library',
                'type' => 'text',
                'description' => 'Nom du site affiché dans le titre et la navigation'
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'description' => 'Logo principal du site (format recommandé: PNG, 200x60px)'
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'description' => 'Icône du site (favicon) - format ICO ou PNG 32x32px'
            ],
            [
                'key' => 'site_logo_dark',
                'value' => null,
                'type' => 'image',
                'description' => 'Logo pour le mode sombre (optionnel)'
            ],
            [
                'key' => 'site_description',
                'value' => 'Votre bibliothèque numérique moderne',
                'type' => 'text',
                'description' => 'Description courte du site'
            ],
            [
                'key' => 'admin_logo',
                'value' => null,
                'type' => 'image',
                'description' => 'Logo pour l\'interface d\'administration'
            ]
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
