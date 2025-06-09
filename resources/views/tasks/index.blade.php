@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2>All Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($tasks->isEmpty())
        <p>No tasks found.</p>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="mb-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text">
                                <strong>Type:</strong> {{ ucfirst($task->type) }}<br>
                                <strong>Priority:</strong> {{ ucfirst($task->priority) }}<br>
                                <strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($task->status)) }}
                            </p>

                            <div class="gap-2 d-flex">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm">View</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Created {{ $task->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
