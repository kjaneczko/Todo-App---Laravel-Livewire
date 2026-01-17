<div class="mt-4">
    @if($projectId != 0)
        <livewire:task-add-component :projectId="$projectId" />
    @endif

    <div
        class="mt-4"
        id="tasks-sortable"
        wire:key="task-list-{{ $projectId }}"
    >
        @foreach($tasks as $task)
            <div
                class="task-row"
                data-task-id="{{ $task['id'] }}"
                wire:key="task-row-{{ $projectId }}-{{ $task['id'] }}"
            >
                <livewire:task-component
                    :task="$task"
                    :wire:key="'task-'.$projectId.'-'.$task['id']"
                />
            </div>
        @endforeach
    </div>
</div>
