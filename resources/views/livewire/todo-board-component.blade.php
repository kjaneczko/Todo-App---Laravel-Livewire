<div class="mx-auto p-2 mt-5" style="width: 600px;">

    <livewire:project-list-component />

    <livewire:task-list-component />

    <script>
        function initTasksSortable() {
            const list = document.getElementById('tasks-sortable');
            if (!list) return;
            if (list._sortable) return;

            list._sortable = new Sortable(list, {
                animation: 150,
                handle: '.drag-handle',
                draggable: '.task-row',
                forceFallback: true,
                fallbackOnBody: true,
                fallbackTolerance: 3,
                onEnd: function () {
                    const ids = Array.from(list.querySelectorAll(':scope > .task-row'))
                        .map(el => el.getAttribute('data-task-id'));

                    const wireRoot = list.closest('[wire\\:id]');
                    const wireId = wireRoot?.getAttribute('wire:id');
                    if (!wireId) return;

                    Livewire.find(wireId).call('reorderTasks', ids);
                }
            });
        }

        document.addEventListener('livewire:init', () => {
            initTasksSortable();

            Livewire.hook('morph.added', ({ el }) => {
                if (el?.id === 'tasks-sortable' || el?.querySelector?.('#tasks-sortable')) {
                    initTasksSortable();
                }
            });

            Livewire.hook('morph.updated', ({ el }) => {
                if (el?.id === 'tasks-sortable' || el?.querySelector?.('#tasks-sortable')) {
                    initTasksSortable();
                }
            });

            function hide(id) {
                const el = document.getElementById(id);
                if (!el) return;
                const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modal.hide();
            }

            Livewire.on('closeAddProjectModal', () => hide('addProjectModal'));
            Livewire.on('closeEditProjectModal', () => hide('editProjectModal'));

            document.addEventListener('hidden.bs.modal', (e) => {
                const id = e.target?.id;

                if (id === 'addProjectModal') {
                    Livewire.dispatch('resetAddProjectForm');
                }

                if (id === 'editProjectModal') {
                    Livewire.dispatch('resetEditProjectForm');
                }
            });
        });
    </script>
</div>
