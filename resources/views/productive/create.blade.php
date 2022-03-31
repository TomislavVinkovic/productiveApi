@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <h1>Projects</h1>
        </div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <form action="{{ route('productive.store') }}" method="POST">
                
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" type="text" name="name" id="name" required />
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">Project type</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="0" selected disabled>-- Select a project type --</option>
                        <option value="1"> Internal </option>
                        <option value="2"> Client </option>
                    </select>
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