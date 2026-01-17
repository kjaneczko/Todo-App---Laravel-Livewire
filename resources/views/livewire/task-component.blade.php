<div>
    <div class="input-group d-flex align-items-start mt-1">
        <span class="input-group-text drag-handle" style="cursor: grab;">☰</span>

        <div class="input-group-text d-flex align-items-center">
            <input
                class="form-check-input m-1"
                type="checkbox"
                value="{{ $task['id'] }}"
                wire:change="toggle"
                @checked($task['completed'])
            />
        </div>

        <input
            id="editTaskName-{{ $task['id'] }}"
            aria-describedby="editTaskNameFeedback-{{ $task['id'] }}"
            type="text"
            class="form-control @error('task.name') is-invalid @enderror"
            placeholder="task name"
            wire:model.lazy="task.name"
            wire:keydown.enter.prevent
            @disabled($task['completed'])
        />

        <button type="button" class="btn btn-danger" wire:click="delete">Delete</button>
    </div>

    @error('task.name')
        <div id="editTaskNameFeedback-{{ $task['id'] }}" class="invalid-feedback d-block">
             {{ $message }}
        </div>
    @enderror
</div>
