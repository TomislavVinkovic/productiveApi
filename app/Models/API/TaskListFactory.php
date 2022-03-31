<?php

namespace App\Models\API;

use App\Models\API\TaskList;


class TaskListFactory {
    public static function createFromJson($taskListJSON) {
        return new TaskList(
            $taskListJSON->id,
            $taskListJSON->attributes->name,
            $taskListJSON->attributes->position,
        );
    }
}