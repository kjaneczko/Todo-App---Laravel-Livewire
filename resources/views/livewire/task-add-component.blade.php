<div>
    <form wire:submit.prevent="submit">
        <div class="d-flex align-items-start gap-2">
            <input
                id="newTaskName"
                aria-describedby="newTaskNameFeedback"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="enter task name"
                wire:model="name"
            />
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-danger" wire:click="clear">X</button>
        </div>
        @error('name')
            <div id="newTaskNameFeedback" class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </form>
</div>
