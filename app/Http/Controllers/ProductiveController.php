<?php

namespace App\Http\Controllers;
use App\Models\API\Project;
use App\Models\API\Task;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\CreateTaskRequest;

class ProductiveController extends Controller {

    public function index() {
        return view('productive.index');
    }

    public function projects() {
        $projects = Project::getProjects([
            'status' => 1 //dohvati samo aktivne projekte
        ]);
        return view('productive.projects', [
            'projects' => $projects
        ]);
    }

    public function show($project_id) {
        $project = Project::getProjectById($project_id);
        //dd($project);
        return view('productive.show', [
            'project' => $project
        ]);
    }

    public function create() {
        return view('productive.create');
    }

    public function store(CreateProjectRequest $request) {
        $validated = $request->validated;
        $response = Project::createProject($request);
        return redirect(route ('productive'));
    }

    public function createTask($projectId) {

        //caching could be added here, to have less constly API requests
        $project = Project::getProjectById($projectId);
        return view('productive.createTask', [
            'project' => $project
        ]);
    }

    public function storeTask(CreateTaskRequest $request) {
        $validated = $request->validated();
        $response = Task::createTask($request);
        return redirect(route('productive.show', $request->project_id));
    }
}
