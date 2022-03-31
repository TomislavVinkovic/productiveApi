@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <form action="{{ route('productive.storeTask') }}" method="POST">
                
                @csrf

                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input class="form-control" type="text" name="title" id="title" required />
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="task_list" class="form-label">Task list</label>
                    <select name="task_list" id="task_list" class="form-select" required>
                        <option selected disabled>-- Select a task list --</option>
                        @foreach ($project->taskLists() as $taskList)
                            <option value="{{ $taskList->id }}">{{ $taskList->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="initial_estimate" class="form-label">Initial estimate(in minutes)</label>
                    <input class="form-control"  type="number" min="1" id="initial_estimate" name="initial_estimate" required />
                </div>

                <button class="btn btn-primary" type="submit">Create a new project</button>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>
@endsection