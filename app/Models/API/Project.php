<?php

namespace App\Models\API;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreateProjectRequest;
use App\Models\API\TaskList;
use App\Models\API\TaskListFactory;

class Project {

    //env("PRODUCTIVE_X_AUTH_TOKEN") - API key
    //env("PRODUCTIVE_X_ORGANIZATION_ID") - Organization Id

    private array $task_lists;

    public function __construct(
        private int $id,
        private string $name,
        private int $organization_id,
        private int $company_id,
        private int $project_manager_id,
        private $workflow_id,
        bool $taskLists,
        bool $tasks
    ) {
        if($taskLists) {
            $this->getTaskLists();
        }
        if($tasks) {
            $this->getTasks();
        }
        
    }

    public function __get($name){
        if($this->$name) {
            return $this->$name;
        }
        else {
            return null;
        }
    }

    public function taskLists() {
        return $this->task_lists;
    }

    private function getTaskLists() {
        $response = Http::acceptJson()->withHeaders([
            "Content-Type" => env("PRODUCTIVE_CONTENT_TYPE"),
            "X-Auth-Token" => env("PRODUCTIVE_X_AUTH_TOKEN"),
            "X-Organization-Id" => env("PRODUCTIVE_X_ORGANIZATION_ID")
        ])->get(env("PRODUCTIVE_BASE_URL") . "/task_lists", [
            'filter[project_id]' => $this->id
        ]);

        foreach(json_decode($response->body())->data as $taskList) {
            $this->task_lists[] = TaskListFactory::createFromJson($taskList);
        }
    }
    
    public static function createProject(CreateProjectRequest $request) {
        
        $data = [
            "data" => [
                "type" => "projects",
                "attributes" => [
                    "name" => $request->name,
                    "project_type_id" => "1"
                ],
                "relationships" => [
                    "company" => [
                        "data" => [
                            "type" => "companies",
                            "id" => "38849",
                        ]
                    ],
                    "project_manager" => [
                        "data" => [
                            "type" => "people",
                            "id" => "52137"
                        ]
                    ],
                    "workflow" => [
                        "data" => [
                            "type" => "workflows",
                            "id" => "3207"
                        ]
                    ]
                ]
            ]
        ];
        
        $response = Http::accept("text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5")->withHeaders([
            "Content-Type" => env("PRODUCTIVE_CONTENT_TYPE"),
            "X-Auth-Token" => env("PRODUCTIVE_X_AUTH_TOKEN"),
            "X-Organization-Id" => env("PRODUCTIVE_X_ORGANIZATION_ID")
        ])->post(env("PRODUCTIVE_BASE_URL") . "/projects", $data);

        return json_decode($response->body());
    }

    public static function getProjects($props = []): array {
        $response = Http::acceptJson()->withHeaders([
            "Content-Type" => env("PRODUCTIVE_CONTENT_TYPE"),
            "X-Auth-Token" => env("PRODUCTIVE_X_AUTH_TOKEN"),
            "X-Organization-Id" => env("PRODUCTIVE_X_ORGANIZATION_ID")
        ])->get(env("PRODUCTIVE_BASE_URL") . "/projects", $props === []? $props: []);

        $projects = [];

        foreach(json_decode($response->body())->data as $project) {
            $projects[] = ProjectFactory::createFromJson($project);
        }
        return $projects;
    }

    public static function getProjectById(int $id) {
        $response = Http::acceptJson()->withHeaders([
            "Content-Type" => env("PRODUCTIVE_CONTENT_TYPE"),
            "X-Auth-Token" => env("PRODUCTIVE_X_AUTH_TOKEN"),
            "X-Organization-Id" => env("PRODUCTIVE_X_ORGANIZATION_ID")
        ])->get(env("PRODUCTIVE_BASE_URL") . "/projects/$id");
        $project = ProjectFactory::createFromJson(json_decode($response->body())->data, true, true);
        return $project;
    }

    

    //sve vezano za taskove

    private function getTasks() {
        $response = Http::acceptJson()->withHeaders([
            "Content-Type" => env("PRODUCTIVE_CONTENT_TYPE"),
            "X-Auth-Token" => env("PRODUCTIVE_X_AUTH_TOKEN"),
            "X-Organization-Id" => env("PRODUCTIVE_X_ORGANIZATION_ID")
        ])->get(env("PRODUCTIVE_BASE_URL") . "/tasks", [
            'filter[project_id]' => $this->id
        ]);
        foreach(json_decode($response->body())->data as $task) {
            $t = TaskFactory::createFromJson($task);
            //I would implement this in c in a way smarter way. For demonstration purposes only, I will use this stupid, slowest solution
            //this is used to save tasks to their respective task lists
            foreach($this->task_lists as $tl) {
                if($tl->id === $t->task_list_id) {
                    $tl->addTask($t);
                    break;
                }
            }
        }
    }
}

class ProjectFactory {
    public static function createFromJson($projectJSON, $task_lists = false, $tasks = false) {
        return new Project(
            $projectJSON->id,
            $projectJSON->attributes->name,
            $projectJSON->relationships->organization->data->id,
            $projectJSON->relationships->company->data->id,
            $projectJSON->relationships->project_manager->data->id,
            $projectJSON->relationships->workflow->data->id,
            $task_lists,
            $tasks
        );
    }
}