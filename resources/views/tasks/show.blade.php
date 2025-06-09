@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('tasks.index') }}" class="mb-3 btn btn-link">← Back to tasks</a>

    <div class="mb-4 card">
        <div class="card-body">
            <h2>{{ $task->title }}</h2>
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm float-end">
            ✏️ Edit
            </a>
            <p><strong>Type:</strong> {{ ucfirst($task->type) }}</p>
            <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
            <p><strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($task->status)) }}</p>

            @if ($task->description)
                <div class="mt-3">
                    <h5>Description</h5>
                    <p>{{ $task->description }}</p>
                </div>
            @endif

            @if ($task->documentation)
                <div class="mt-4">
                    <h5>Documentation</h5>
                    <div class="p-3 rounded bg-light">
                        <pre class="mb-0" style="white-space: pre-wrap;">{{ $task->documentation }}</pre>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Subtasks --}}
    <div class="mb-4">
        <h4>Subtasks</h4>

        @if ($task->subtasks->isEmpty())
            <p>No subtasks yet.</p>
        @else
            <ul class="list-group">
                @foreach ($task->subtasks as $subtask)
                    <li class="list-group-item">
                        <form action="{{ route('subtasks.update', $subtask) }}" method="POST" class="d-flex justify-content-between align-items-center">
                            @csrf
                            @method('PUT')

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="completed"
                                    onchange="this.form.submit()"
                                    {{ $subtask->completed ? 'checked' : '' }}>

                                <label class="form-check-label" style="cursor: pointer;">
                                    {{ $subtask->description }}
                                </label>

                                @if ($subtask->content)
                                    <div class="mt-1 small text-muted">
                                        {{ $subtask->content }}
                                    </div>
                                @endif
                            </div>

                            <span class="badge bg-{{ $subtask->completed ? 'success' : 'secondary' }}">
                                {{ $subtask->completed ? 'Done' : 'Pending' }}
                            </span>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add a Subtask</h5>
            <form action="{{ route('subtasks.store', $task->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="description" class="form-label">Subtask Description</label>
                    <input type="text" name="description" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Details (optional)</label>
                    <textarea name="content" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Add Subtask</button>
            </form>
        </div>
    </div>
</div>
@endsection
