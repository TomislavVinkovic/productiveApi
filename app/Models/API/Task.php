<?php

namespace App\Models\API;

use App\Http\Requests\CreateTaskRequest;
use Illuminate\Support\Facades\Http;

class Task {

    public function __construct(
        private int $id,
        private string $title,
        private ?string $description,
        private ?int $initial_estimate, //procjena vremena rjesavanja zadatka u minutama
        private int $task_list_id
    ) {}

    public static function createTask(CreateTaskRequest $request) {

        $data = [
            'data' => [
                'type' => 'tasks',
                'attributes' => [
                    'title' => $request->title,
                    'description' => $request->description,
                    'initial_estimate' => $request->initial_estimate,
                ],
                'relationships' => [
                    'project' => [
                        'data' => [
                            'type' => 'projects',
                            'id' => $request->project_id
                        ]
                    ],
                    'task_list' => [
                        'data' => [
                            'type' => 'task_lists',
                            'id' => $request->task_list
                        ]
                    ],
                ]
            ]
        ];

        $response = Http::accept("text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5")->withHeaders([
            "Content-Type" => env("PRODUCTIVE_CONTENT_TYPE"),
            "X-Auth-Token" => env("PRODUCTIVE_X_AUTH_TOKEN"),
            "X-Organization-Id" => env("PRODUCTIVE_X_ORGANIZATION_ID")
        ])->post(env("PRODUCTIVE_BASE_URL") . "/tasks", $data);
        
        return json_decode($response->body());
    }

    public function __get($name) {
        if($this->$name) {
            return $this->$name;
        }
        else {
            return null;
        }
    }

}