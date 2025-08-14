<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Log une activité
     */
    protected function logActivity(string $action, string $description = null, array $properties = [])
    {
        if (!auth()->check()) {
            return;
        }

        ActivityLog::log($action, auth()->id(), $description, $properties);
    }

    /**
     * Log automatiquement les actions CRUD
     */
    public static function bootLogsActivity()
    {
        // Lors de la création
        static::created(function ($model) {
            if (auth()->check()) {
                ActivityLog::log(
                    strtolower(class_basename($model)) . '.create',
                    auth()->id(),
                    'Création de ' . class_basename($model) . ' #' . $model->id,
                    ['model_id' => $model->id, 'model_type' => get_class($model)]
                );
            }
        });

        // Lors de la mise à jour
        static::updated(function ($model) {
            if (auth()->check()) {
                ActivityLog::log(
                    strtolower(class_basename($model)) . '.update',
                    auth()->id(),
                    'Mise à jour de ' . class_basename($model) . ' #' . $model->id,
                    ['model_id' => $model->id, 'model_type' => get_class($model), 'changes' => $model->getDirty()]
                );
            }
        });

        // Lors de la suppression
        static::deleted(function ($model) {
            if (auth()->check()) {
                ActivityLog::log(
                    strtolower(class_basename($model)) . '.delete',
                    auth()->id(),
                    'Suppression de ' . class_basename($model) . ' #' . $model->id,
                    ['model_id' => $model->id, 'model_type' => get_class($model)]
                );
            }
        });
    }
}