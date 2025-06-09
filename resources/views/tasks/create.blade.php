@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Task</h2>

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

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Short Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Task Type</label>
            <select name="type" class="form-select" required>
                <option value="work" {{ old('type') == 'work' ? 'selected' : '' }}>Work</option>
                <option value="study" {{ old('type') == 'study' ? 'selected' : '' }}>Study</option>
                <option value="refactor" {{ old('type') == 'refactor' ? 'selected' : '' }}>Refactor</option>
                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" class="form-select" required>
                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="documentation" class="form-label">Documentation</label>
            <textarea name="documentation" class="form-control" rows="6">{{ old('documentation') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Task</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
