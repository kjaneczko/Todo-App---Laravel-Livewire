<div>
    @if ($id != 0)
        <button type="button" wire:click="getProject" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editProjectModal" id="btnGroupAddon">
            Edit
        </button>

        <div wire:ignore.self class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
            <form wire:submit.prevent="submit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editProjectModalLabel">Edit project</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input
                                id="editProjectName"
                                aria-describedby="editProjectNameFeedback"
                                type="text"
                                class="form-control @error('project.name') is-invalid @enderror"
                                placeholder="project name"
                                wire:model="project.name"
                            />
                            <div id="editProjectNameFeedback" class="invalid-feedback">
                                @error('project.name') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" wire:click="deleteProject">Delete</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
