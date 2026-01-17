<div class="d-flex align-items-start gap-2">
    <select
        class="form-select"
        wire:key="project-select-{{ count($projects) }}-{{ $selectedProjectId }}"
        wire:model.live="selectedProjectId"
    >
        <option value="0" >Select project</option>

        @foreach($projects as $project)
            <option
                value="{{ $project['id'] }}"
                wire:key="project-option-{{ $project['id'] }}"
            >
                {{ $project['name'] }}
            </option>
        @endforeach
    </select>

    @if($selectedProjectId != 0)
        <livewire:project-edit-component :id="$selectedProjectId" :wire:key="'edit-'.$selectedProjectId" />
    @endif

    <livewire:project-add-component />
</div>
