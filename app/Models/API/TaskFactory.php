<?php

namespace App\Models\API;

use App\Models\API\Task;

class TaskFactory {

    public static function createFromJson($taskJSON) {
        return new Task(
            $taskJSON->id,
            $taskJSON->attributes->title,
            $taskJSON->attributes->description,
            $taskJSON->attributes->initial_estimate,
            $taskJSON->relationships->task_list->data->id
        );
    }

}