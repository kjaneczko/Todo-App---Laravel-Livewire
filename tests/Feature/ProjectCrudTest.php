<?php

use App\Livewire\ProjectAddComponent;
use App\Livewire\ProjectEditComponent;
use App\Models\Project;
use Livewire\Livewire;

it('creates a project via ProjectAddComponent and dispatches events', function () {
    Livewire::test(ProjectAddComponent::class)
        ->set('name', 'My Project')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('closeAddProjectModal')
        ->assertDispatched('handleNewProject');

    expect(Project::query()->where('name', 'My Project')->exists())->toBeTrue();
});

it('validates project name: required and unique', function () {
    Project::factory()->create(['name' => 'Dup']);

    Livewire::test(ProjectAddComponent::class)
        ->set('name', '')
        ->call('submit')
        ->assertHasErrors(['name' => 'required']);

    Livewire::test(ProjectAddComponent::class)
        ->set('name', 'Dup')
        ->call('submit')
        ->assertHasErrors(['name' => 'unique']);
});

it('edits a project via ProjectEditComponent and dispatches events', function () {
    $project = Project::factory()->create(['name' => 'Old']);

    Livewire::test(ProjectEditComponent::class, ['id' => $project->id])
        ->call('getProject')
        ->set('project.name', 'New')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('closeEditProjectModal')
        ->assertDispatched('handleEditProject');

    expect($project->fresh()->name)->toBe('New');
});

it('prevents renaming to an existing project name (unique ignore current)', function () {
    $p1 = Project::factory()->create(['name' => 'A']);
    $p2 = Project::factory()->create(['name' => 'B']);

    Livewire::test(ProjectEditComponent::class, ['id' => $p2->id])
        ->call('getProject')
        ->set('project.name', 'A')
        ->call('submit')
        ->assertHasErrors(['project.name' => 'unique']);

    // allowed: keep same name
    Livewire::test(ProjectEditComponent::class, ['id' => $p2->id])
        ->call('getProject')
        ->set('project.name', 'B')
        ->call('submit')
        ->assertHasNoErrors();
});

it('deletes a project via ProjectEditComponent and dispatches events', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectEditComponent::class, ['id' => $project->id])
        ->call('deleteProject')
        ->assertDispatched('closeEditProjectModal')
        ->assertDispatched('handleDeleteProject');

    expect(Project::query()->whereKey($project->id)->exists())->toBeFalse();
});
