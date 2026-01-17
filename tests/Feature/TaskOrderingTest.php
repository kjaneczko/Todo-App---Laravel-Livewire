<?php

use App\Livewire\TaskComponent;
use App\Livewire\TaskListComponent;
use App\Models\Project;
use App\Models\Task;
use Livewire\Livewire;

it('toggles task to completed, moves it to end (priority), and dispatches handleTaskCompleted', function () {
    $project = Project::factory()->create();

    $t1 = Task::factory()->create(['project_id' => $project->id, 'priority' => 1, 'completed' => false]);
    Task::factory()->create(['project_id' => $project->id, 'priority' => 2, 'completed' => false]);
    Task::factory()->create(['project_id' => $project->id, 'priority' => 3, 'completed' => false]);

    Livewire::test(TaskComponent::class, ['task' => $t1->toArray()])
        ->call('toggle')
        ->assertDispatched('handleTaskCompleted'); // brak taskId w evencie w v0.91

    $t1Fresh = $t1->fresh();
    expect((bool) $t1Fresh->completed)->toBeTrue();

    // max priority było 3, więc po moveToEnd powinno być 4
    expect((int) $t1Fresh->priority)->toBe(4);
});

it('toggles task back to not completed and does NOT move it to end (priority) and does NOT dispatch handleTaskCompleted', function () {
    $project = Project::factory()->create();

    $t1 = Task::factory()->create(['project_id' => $project->id, 'priority' => 1, 'completed' => true]);
    Task::factory()->create(['project_id' => $project->id, 'priority' => 2, 'completed' => false]);

    Livewire::test(TaskComponent::class, ['task' => $t1->toArray()])
        ->call('toggle')
        ->assertNotDispatched('handleTaskCompleted');

    $t1Fresh = $t1->fresh();
    expect((bool) $t1Fresh->completed)->toBeFalse();

    // w v0.91 przy odznaczeniu NIE ma moveToEnd, więc priorytet zostaje bez zmian
    expect((int) $t1Fresh->priority)->toBe(1);
});


it('reorders tasks within a project via TaskListComponent::reorderTasks', function () {
    $project = Project::factory()->create();

    $a = Task::factory()->create(['project_id' => $project->id, 'priority' => 1, 'completed' => false]);
    $b = Task::factory()->create(['project_id' => $project->id, 'priority' => 2, 'completed' => false]);
    $c = Task::factory()->create(['project_id' => $project->id, 'priority' => 3, 'completed' => false]);

    // Desired order: c, a, b
    Livewire::test(TaskListComponent::class)
        ->call('handleProjectChange', $project->id)
        ->call('reorderTasks', [$c->id, $a->id, $b->id])
        ->assertHasNoErrors();

    expect((int)$c->fresh()->priority)->toBe(1);
    expect((int)$a->fresh()->priority)->toBe(2);
    expect((int)$b->fresh()->priority)->toBe(3);
});

it('reorderTasks ignores invalid ids (non-int / null) and still reorders valid ones', function () {
    $project = Project::factory()->create();

    $a = Task::factory()->create(['project_id' => $project->id, 'priority' => 1, 'completed' => false]);
    $b = Task::factory()->create(['project_id' => $project->id, 'priority' => 2, 'completed' => false]);

    Livewire::test(TaskListComponent::class)
        ->call('handleProjectChange', $project->id)
        ->call('reorderTasks', ['x', null, (string)$b->id, (string)$a->id])
        ->assertHasNoErrors();

    expect((int)$b->fresh()->priority)->toBe(1);
    expect((int)$a->fresh()->priority)->toBe(2);
});
