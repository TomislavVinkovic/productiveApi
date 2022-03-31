@extends('layouts.app')

@section('content')

    @if (empty($project->taskLists()))
    <div class="row mt-3">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <div class="alert alert-primary">
                This project has no task lists
            </div>
        </div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>
    
    @else
        @foreach ($project->taskLists() as $task_list)
            <div class="row mt-3">
                <div class="col-md-2 d-none d-md-block"></div>
                <div class="col-sm-12 col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">{{ $task_list->name }}</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Estimated time(in minutes)</th>
                        </tr>
                        @if (empty($task_list->tasks()))
                            <td colspan="2">This Task list has no tasks</td>
                        @else
                            @foreach ($task_list->tasks() as $task)
                            <tr>
                                <td class="p-3"> <i>{{ $task->title }}</i> </td>
                                <td> {{ $task->initial_estimate }} </td>
                            </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="col-md-2 d-none d-md-block"></div>
            </div>
        @endforeach
    @endif

    <div class="row mt-5">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <a href="{{ route('productive.createTask', $project->id) }}" class="w-100 btn btn-primary">New task</a>
        </div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>
@endsection