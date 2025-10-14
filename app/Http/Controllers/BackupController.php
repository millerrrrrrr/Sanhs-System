<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    // public function backup()
    // {
    //     $timestamp = date('Y-m-d_H-i-s');
    //     $sqlFile = storage_path("backups/db_backup_{$timestamp}.sql");
    //     $zipFile = storage_path("backups/db_backup_{$timestamp}.zip");

    //     // Database credentials
    //     $dbHost = env('DB_HOST');
    //     $dbUser = env('DB_USERNAME');
    //     $dbPass = env('DB_PASSWORD');
    //     $dbName = env('DB_DATABASE');

    //     // Step 1: Export database to SQL
    //     $command = "mysqldump -h $dbHost -u $dbUser -p$dbPass $dbName > \"$sqlFile\"";
    //     exec($command, $output, $result);

    //     if ($result !== 0) {
    //         return back()->with('error', 'Database backup failed.');
    //     }

    //     // Step 2: Zip the SQL file
    //     $zip = new ZipArchive();
    //     if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
    //         $zip->addFile($sqlFile, basename($sqlFile));
    //         $zip->close();

    //         // Optional: remove the plain SQL after zipping
    //         unlink($sqlFile);

    //         return back()->with('success', "Backup created: " . basename($zipFile));
    //     } else {
    //         return back()->with('error', 'Failed to create zip archive.');
    //     }
    // }
}
