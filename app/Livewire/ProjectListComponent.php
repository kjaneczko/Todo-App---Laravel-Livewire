<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectListComponent extends Component
{
    public int $selectedProjectId = 0;

    public array $projects = [];

    public function mount(): void
    {
        $this->getProjects();
    }

    #[On('handleNewProject')]
    public function handleNewProject(array $project): void
    {
        $this->selectedProjectId = $project['id'];
        $this->getProjects();
    }

    #[On('handleEditProject')]
    public function handleEditProject(): void
    {
        $this->getProjects();
    }

    #[On('handleDeleteProject')]
    public function handleDeleteProject(): void
    {
        $this->getProjects();
        $this->selectedProjectId = 0;
    }

    public function updatedSelectedProjectId(int $value): void
    {
        $this->selectedProjectId = $value;
        $this->dispatch('handleProjectChange', projectId: $value);
    }

    public function render()
    {
        return view('livewire.project-list-component');
    }

    private function getProjects(): void
    {
        $this->projects = Project::query()->orderBy('name')->get()->toArray();
    }
}
