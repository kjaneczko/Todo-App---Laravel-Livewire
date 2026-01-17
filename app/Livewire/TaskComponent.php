<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Task;
use App\Services\TaskPriorityService;
use Livewire\Component;

class TaskComponent extends Component
{
    public array $task;

    public function updatedTaskName(string $name): void
    {
        $this->task['name'] = $name;

        $this->validate([
            'task.name' => Task::nameValidationRules(),
        ]);

        Task::whereKey($this->task['id'])
            ->update(['name' => $name])
        ;
    }

    public function toggle(TaskPriorityService $priority): void
    {
        $this->task['completed'] = !$this->task['completed'];

        Task::whereKey($this->task['id'])
            ->update(['completed' => $this->task['completed']])
        ;

        if ($this->task['completed']) {
            $priority->moveToEnd($this->task['id'], $this->task['project_id']);
            $this->dispatch('handleTaskCompleted');
        }
    }

    public function delete(): void
    {
        Task::whereKey($this->task['id'])->delete();
        $this->dispatch('handleTaskDeleted');
    }

    public function submit(): void
    {

    }

    public function render()
    {
        return view('livewire.task-component');
    }
}
