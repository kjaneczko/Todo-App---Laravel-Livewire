<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectEditComponent extends Component
{
    public int $id;
    public array $project = ['name' => ''];

    public function submit(): void
    {
        $this->validate(['project.name' => [
            'required',
            'string',
            'min:1',
            'max:255',
            Rule::unique('projects', 'name')->ignore($this->id, 'id'),
        ]]);

        Project::whereKey($this->id)->update(['name' => $this->project['name']]);

        $this->dispatch('closeEditProjectModal');
        $this->dispatch('handleEditProject');
    }

    public function getProject(): void
    {
        $this->resetValidation();

        $project = Project::find($this->id);
        if ($project) {
            $this->project = $project->toArray();
        }
    }

    public function deleteProject(): void
    {
        $project = Project::find($this->id);
        if ($project) {
            $project->delete();
        }

        $this->dispatch('closeEditProjectModal');
        $this->dispatch('handleDeleteProject');
    }

    #[On('resetEditProjectForm')]
    public function resetForm(): void
    {
        $this->reset('project');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.project-edit-component');
    }
}
