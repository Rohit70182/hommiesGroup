<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\Tasks\Backup\FileSelection;
use Spatie\Backup\Tasks\Backup\DbDumperFactory;
use Spatie\Backup\Tasks\Backup\BackupJob;

class BackupJobFactory
{
    public static function createFromArray(array $config): BackupJob
    {
 
        return (new BackupJob())
            ->setFileSelection(static::createFileSelection($config['backup']['source']['files']))
            ->setDbDumpers(static::createDbDumpers($config['backup']['source']['databases']))
            ->setBackupDestinations(BackupDestinationFactory::createFromArray($config['backup']));
    }

    protected static function createFileSelection(array $sourceFiles): FileSelection
    {
        return FileSelection::create($sourceFiles['include'])
            ->excludeFilesFrom($sourceFiles['exclude'])
            ->shouldFollowLinks(isset($sourceFiles['follow_links']) && $sourceFiles['follow_links'])
            ->shouldIgnoreUnreadableDirs(Arr::get($sourceFiles, 'ignore_unreadable_directories', false));
    }

    protected static function createDbDumpers(array $dbConnectionNames): Collection
    {
        return collect($dbConnectionNames)->mapWithKeys(function (string $dbConnectionName) {
            return [$dbConnectionName => DbDumperFactory::createFromConnection($dbConnectionName)];
        });
    }
}

