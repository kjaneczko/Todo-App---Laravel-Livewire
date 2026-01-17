<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskPriorityService
{
    public function newTaskPriority(Project $project): int
    {
        return ((int) ($project->tasks()->max('priority') ?? 0)) + 1;
    }

    public function reorderProjectTasks(int $projectId, array $orderedIds): void
    {
        DB::transaction(function () use ($projectId, $orderedIds) {
            foreach ($orderedIds as $idx => $taskId) {
                Task::query()
                    ->where('project_id', $projectId)
                    ->whereKey($taskId)
                    ->update(['priority' => $idx + 1])
                ;
            }
        });
    }

    public function moveToEnd(int $taskId, int $projectId): void
    {
        DB::transaction(function () use ($taskId, $projectId) {
            $max = Task::query()
                ->where('project_id', $projectId)
                ->max('priority')
            ;

            Task::query()
                ->where('project_id', $projectId)
                ->whereKey($taskId)
                ->update(['priority' => ($max ?? 0) + 1])
            ;
        });
    }
}
