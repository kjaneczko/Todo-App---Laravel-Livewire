<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Services\TaskPriorityService;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskAddComponent extends Component
{
    public int $projectId = 0;
    public string $name = '';

    public function submit(TaskPriorityService $priority): void
    {
        $this->validate([
            'projectId' => 'exists:projects,id',
            'name' => Task::nameValidationRules(),
        ]);

        $project = Project::find($this->projectId);

        if ($project) {
            Task::create([
                'project_id' => $this->projectId,
                'name' => $this->name,
                'priority' => $priority->newTaskPriority($project),
                'completed' => false,
            ]);

            $this->reset('name');
            $this->resetValidation();
            $this->dispatch('handleNewTask');
        }
    }

    #[On('handleProjectChange')]
    public function handleProjectChange(int $projectId): void
    {
        $this->projectId = $projectId;
        $this->dispatch('resetAddTaskForm');
    }

    #[On('handleNewProject')]
    public function handleNewProject(array $project): void
    {
        $this->projectId = $project['id'];
        $this->dispatch('resetAddTaskForm');
    }

    #[On('resetAddTaskForm')]
    public function resetForm(): void
    {
        $this->reset('name');
        $this->resetValidation();
    }

    public function clear(): void
    {
        $this->reset('name');
    }

    public function render()
    {
        return view('livewire.task-add-component');
    }
}
