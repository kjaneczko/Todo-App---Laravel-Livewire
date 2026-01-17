<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectAddComponent extends Component
{
    public string $name = '';

    public function submit(): void
    {
        $this->validate(['name' => Project::nameValidationRules()]);

        $project = Project::create([
            'name' => $this->name,
        ]);

        $this->dispatch('closeAddProjectModal');
        $this->dispatch('handleNewProject', project: $project->toArray());
    }

    #[On('resetAddProjectForm')]
    public function resetForm(): void
    {
        $this->reset('name');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.project-add-component');
    }
}
