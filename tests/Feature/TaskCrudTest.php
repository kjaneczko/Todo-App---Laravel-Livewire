<?php

use App\Livewire\TaskAddComponent;
use App\Livewire\TaskComponent;
use App\Models\Project;
use App\Models\Task;
use Livewire\Livewire;

it('creates a task via TaskAddComponent with next priority and dispatches event', function () {
    $project = Project::factory()->create();

    Task::factory()->create(['project_id' => $project->id, 'priority' => 1, 'completed' => false]);
    Task::factory()->create(['project_id' => $project->id, 'priority' => 2, 'completed' => false]);

    Livewire::test(TaskAddComponent::class, ['projectId' => $project->id])
        ->set('name', 'Do something')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('handleNewTask');

    $task = Task::query()
        ->where('project_id', $project->id)
        ->where('name', 'Do something')
        ->first();

    expect($task)->not->toBeNull();
    expect((int)$task->priority)->toBe(3);
    expect((bool)$task->completed)->toBeFalse();
});

it('validates task name: required|min:1', function () {
    $project = Project::factory()->create();

    Livewire::test(TaskAddComponent::class, ['projectId' => $project->id])
        ->set('name', '')
        ->call('submit')
        ->assertHasErrors(['name' => 'required']);
});

it('changes task name via TaskComponent', function () {
    $task = Task::factory()->create(['name' => 'Old', 'completed' => false]);

    Livewire::test(TaskComponent::class, ['task' => $task->toArray()])
        // v0.94: name is persisted via updatedTaskName hook (wire:model.lazy)
        ->set('task.name', 'New')
        ->assertHasNoErrors();

    expect($task->fresh()->name)->toBe('New');
});

it('rejects empty name on update via TaskComponent', function () {
    $task = Task::factory()->create(['name' => 'Old', 'completed' => false]);

    Livewire::test(TaskComponent::class, ['task' => $task->toArray()])
        // v0.94: validation happens during the update hook
        ->set('task.name', '')
        ->assertHasErrors(['task.name' => 'required']);
});


it('deletes a task via TaskComponent and dispatches event', function () {
    $task = Task::factory()->create();

    Livewire::test(TaskComponent::class, ['task' => $task->toArray()])
        ->call('delete')
        ->assertDispatched('handleTaskDeleted');

    expect(Task::query()->whereKey($task->id)->exists())->toBeFalse();
});
