<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Database\Query\Processors\Processor;

class BackupController extends Controller

{
    /*
     * Backup files 
    */
    public function show()
    {
        $directory = public_path('backup/').env('APP_NAME');
        $files = file::files($directory);
        $names = [];
        foreach ($files as $file) {
            $names[] = array(
                "filename" => $file->getFileName(),
                "filesize" => $file->getsize(),
                "ext" => $file->getExtension(),
                "time" => $file->getCTime(),
            );
        }
        return view('dashboard.backup.backup', compact('names'));
    }
    /*
     * Take Backup 
    */
    public function backup()
    {
        
  
        try {
            Artisan::call('backup:test', ['--only-db' => true]);
            
                return redirect()->back()->with('success', "Backup has been taken");
          
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
    /*
     * Download Backup
    */
    public function download($filename)
    {
        $file_path = public_path('backup/' .env('APP_NAME').'/'. $filename);
        return response()->download($file_path);
    }
    /*
     * Delete Backupfile
    */

    public function delete($filename)
    {
        $file_path = public_path('backup/' .env('APP_NAME').'/'. $filename);
        unlink($file_path);
        return redirect('/dashboard/backup')->with('success', "Backup File has been deleted");
    }
    /*
     * Restore Backup
    */
    public function restore($filename)
    {
      
        $file_path = public_path('backup/' .env('APP_NAME').'/'. $filename);
        $zip = new \ZipArchive;
        $res = $zip->open($file_path);
        if ($res === TRUE) {
            $zip->extractTo(public_path('backup/').env('APP_NAME'));
            $zip->close();
        }
        $file = public_path('backup/'.env('APP_NAME').'/db-dumps/mysql-'.env('DB_DATABASE').'.sql');
        if( DB::unprepared(file_get_contents($file))){
            unlink($file);
            return redirect('/dashboard/backup')->with('success', "Backup  has been restored");
        }
    }
}
