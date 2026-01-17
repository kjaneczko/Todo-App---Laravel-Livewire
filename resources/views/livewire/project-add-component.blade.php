<div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal" id="btnGroupAddon">
        Add
    </button>

    <div wire:ignore.self class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <form wire:submit.prevent="submit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addProjectModalLabel">New project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input
                            id="newProjectName"
                            aria-describedby="newProjectNameFeedback"
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="project name"
                            wire:model="name"
                        />
                        <div id="newProjectNameFeedback" class="invalid-feedback">
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
