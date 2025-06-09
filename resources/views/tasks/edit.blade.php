@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('tasks.show', $task) }}" class="mb-4 btn btn-link">← Back to task</a>

    <h2>Edit Task</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Short Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Task Type</label>
            <select name="type" class="form-select" required>
                @foreach (['work', 'study', 'refactor', 'other'] as $type)
                    <option value="{{ $type }}" {{ old('type', $task->type) == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" class="form-select" required>
                @foreach (['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" {{ old('priority', $task->priority) == $priority ? 'selected' : '' }}>
                        {{ ucfirst($priority) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                @foreach (['pending', 'in_progress', 'done'] as $status)
                    <option value="{{ $status }}" {{ old('status', $task->status) == $status ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="documentation" class="form-label">Documentation</label>
            <textarea name="documentation" class="form-control" rows="6">{{ old('documentation', $task->documentation) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
