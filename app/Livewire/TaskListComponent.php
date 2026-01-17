<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Task;
use App\Services\TaskPriorityService;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskListComponent extends Component
{
    public int $projectId = 0;
    public array $tasks = [];

    #[On('handleProjectChange')]
    public function handleProjectChange(int $projectId): void
    {
        $this->projectId = $projectId;
        $this->getTasks();
    }

    #[On('handleNewProject')]
    public function handleNewProject(array $project): void
    {
        $this->projectId = $project['id'];
        $this->getTasks();
    }

    #[On('handleDeleteProject')]
    public function handleDeleteProject(): void
    {
        $this->projectId = 0;
        $this->reset('tasks');
    }

    #[On('handleNewTask')]
    public function handleNewTask(): void
    {
        $this->getTasks();
    }

    #[On('handleTaskDeleted')]
    public function handleTaskDeleted(): void
    {
        $this->getTasks();
    }

    #[On('handleTaskCompleted')]
    public function handleTaskCompleted(): void
    {
        $this->getTasks();
    }

    public function reorderTasks(array $orderedIds, TaskPriorityService $priority): void
    {
        if (0 === $this->projectId) {
            return;
        }

        $orderedIds = array_values(array_filter(array_map('intval', $orderedIds)));

        $priority->reorderProjectTasks($this->projectId, $orderedIds);

        $this->getTasks();
    }

    public function render()
    {
        return view('livewire.task-list-component');
    }

    private function getTasks(): void
    {
        $this->tasks = Task::where('project_id', $this->projectId)
            ->orderBy('completed')
            ->orderBy('priority')
            ->get()
            ->toArray()
        ;
    }
}
