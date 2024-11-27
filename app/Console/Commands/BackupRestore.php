<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Backup\Exceptions\InvalidCommand;

class BackupRestore extends BackupCommand
{
    /** @var string */
    protected $signature = 'backup:test {--filename=} {--only-db} {--db-name=*} {--only-files} {--only-to-disk=} {--disable-notifications} {--timeout=}';
    
    /** @var string */
    protected $description = 'Run the backup.';
    
    public function handle()
    {
     
        consoleOutput()->comment('Starting backup...');
        
        $disableNotifications = $this->option('disable-notifications');
        
        if ($this->option('timeout') && is_numeric($this->option('timeout'))) {
            set_time_limit((int) $this->option('timeout'));
        }
        
        try {
        
            $this->guardAgainstInvalidOptions();
            
            $backupJob = \App\Models\BackupJobFactory::createFromArray(config('backup'));
          
            if ($this->option('only-db')) {
               
                $backupJob->dontBackupFilesystem();
            }
            if ($this->option('db-name')) {
                $backupJob->onlyDbName($this->option('db-name'));
            }
            
            if ($this->option('only-files')) {
                $backupJob->dontBackupDatabases();
            }
            
            if ($this->option('only-to-disk')) {
                $backupJob->onlyBackupTo($this->option('only-to-disk'));
            }
            
            if ($this->option('filename')) {
                $backupJob->setFilename($this->option('filename'));
            }
            
            if ($disableNotifications) {
                $backupJob->disableNotifications();
            }
            
            $backupJob->run();
            
            consoleOutput()->comment('Backup completed!');
        } catch (Exception $exception) {
            consoleOutput()->error("Backup failed because: {$exception->getMessage()}.");
            
            if (! $disableNotifications) {
                event(new BackupHasFailed($exception));
            }
            
            return 1;
        }
    }
    
    protected function guardAgainstInvalidOptions()
    {
        if ($this->option('only-db') && $this->option('only-files')) {
            throw InvalidCommand::create('Cannot use `only-db` and `only-files` together');
        }
    }
}
