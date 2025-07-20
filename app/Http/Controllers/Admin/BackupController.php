<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Helpers\Format;

class BackupController extends Controller
{
    public function index()
    {
        $backups = $this->getBackups();
        $stats = $this->getBackupStats($backups);

        return view('admin.backup', compact('backups', 'stats'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required|in:full,database,files',
            'description' => 'nullable|string|max:255',
            'compress' => 'boolean'
        ]);

        try {
            // Créer une sauvegarde manuelle pour la démonstration
            $backupName = $this->createManualBackup($request->type, $request->description);

            return redirect()->back()->with('success', 'Sauvegarde créée avec succès : ' . $backupName);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de la sauvegarde : ' . $e->getMessage());
        }
    }

    private function createManualBackup($type, $description = null)
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $appName = config('app.name', 'laravel-backup');
        $filename = "{$appName}_{$type}_{$timestamp}.zip";

        $backupDir = storage_path('app/backups/' . $appName);
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $backupPath = $backupDir . '/' . $filename;

        // Créer un fichier de sauvegarde de démonstration
        $content = [
            'type' => $type,
            'description' => $description,
            'created_at' => Carbon::now()->toISOString(),
            'app_name' => $appName,
            'laravel_version' => app()->version(),
        ];

        if ($type === 'database' || $type === 'full') {
            $content['database'] = [
                'connection' => config('database.default'),
                'tables_count' => 'Demo: 15 tables',
                'size' => 'Demo: 2.5MB'
            ];
        }

        if ($type === 'files' || $type === 'full') {
            $content['files'] = [
                'total_files' => 'Demo: 1,234 files',
                'size' => 'Demo: 45MB'
            ];
        }

        // Créer un fichier ZIP de démonstration
        $zip = new \ZipArchive();
        if ($zip->open($backupPath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFromString('backup_info.json', json_encode($content, JSON_PRETTY_PRINT));
            $zip->addFromString('README.txt', "Ceci est une sauvegarde de démonstration créée le " . Carbon::now()->format('d/m/Y à H:i:s'));
            $zip->close();
        }

        return $filename;
    }

    public function download($filename)
    {
        $appName = config('app.name', 'laravel-backup');
        $backupPath = storage_path('app/backups/' . $appName . '/' . $filename);

        if (!File::exists($backupPath)) {
            return redirect()->back()->with('error', 'Fichier de sauvegarde introuvable.');
        }

        return response()->download($backupPath);
    }

    public function delete($filename)
    {
        try {
            $appName = config('app.name', 'laravel-backup');
            $backupPath = storage_path('app/backups/' . $appName . '/' . $filename);

            if (File::exists($backupPath)) {
                File::delete($backupPath);
                return redirect()->back()->with('success', 'Sauvegarde supprimée avec succès.');
            }

            return redirect()->back()->with('error', 'Fichier de sauvegarde introuvable.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function cleanup()
    {
        try {
            Artisan::call('backup:clean');
            return redirect()->back()->with('success', 'Nettoyage des anciennes sauvegardes effectué avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du nettoyage : ' . $e->getMessage());
        }
    }

    private function getBackups()
    {
        $backups = [];
        $appName = config('app.name', 'laravel-backup');
        $backupDirectory = storage_path('app/backups/' . $appName);

        if (!File::exists($backupDirectory)) {
            return $backups;
        }

        $files = File::files($backupDirectory);

        foreach ($files as $file) {
            $backups[] = [
                'filename' => $file->getFilename(),
                'size' => $this->formatBytes($file->getSize()),
                'size_bytes' => $file->getSize(),
                'date' => Carbon::createFromTimestamp($file->getMTime()),
                'path' => $file->getPathname(),
            ];
        }

        // Trier par date décroissante
        usort($backups, function ($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });

        return $backups;
    }

    private function getBackupStats($backups)
    {
        $totalSize = 0;
        $lastBackup = null;
        $successfulBackups = 0;

        foreach ($backups as $backup) {
            $totalSize += $backup['size_bytes'];
            $successfulBackups++;

            if (!$lastBackup || $backup['date']->gt($lastBackup)) {
                $lastBackup = $backup['date'];
            }
        }

        return [
            'total_backups' => count($backups),
            'total_size' => $this->formatBytes($totalSize),
            'total_size_bytes' => $totalSize,
            'last_backup' => $lastBackup,
            'successful_backups' => $successfulBackups,
            'next_backup' => $this->getNextBackupTime(),
        ];
    }

    private function getNextBackupTime()
    {
        // Calculer la prochaine sauvegarde (exemple: tous les jours à 2h00)
        $now = Carbon::now();
        $nextBackup = Carbon::today()->addHours(2);

        if ($nextBackup->lt($now)) {
            $nextBackup->addDay();
        }

        return $nextBackup;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
