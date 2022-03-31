@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8"><h1>Projects</h1></div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>

    <div class="row mt-2">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <div class="table-div">
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                    @foreach ($projects as $project)
                        @if (!empty($projects))
                            <tr>
                                <td>
                                    <a href="{{ route('productive.show', $project->id) }}">{{ $project->id }}</a>
                                </td>
                                <td>
                                    {{ $project->name }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="2">No projects found</td>
                            </tr>
                        @endif
                        
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>
    <div class="row mt-2">
        <div class="col-md-2 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-8">
            <a class="btn btn-primary w-100" href="{{ route('productive.create') }}">
                New project
            </a>
        </div>
        <div class="col-md-2 d-none d-md-block"></div>
    </div>
@endsection