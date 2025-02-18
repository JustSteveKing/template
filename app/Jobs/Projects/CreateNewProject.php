<?php

declare(strict_types=1);

namespace App\Jobs\Projects;

use App\Http\Payloads\Projects\NewProject;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

final class CreateNewProject implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly NewProject $payload,
        public readonly string $workspace,
    ) {}

    /** @throws Throwable */
    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn() => Project::query()->create(
                attributes: array_merge(
                    $this->payload->toArray(),
                    [
                        'workspace_id' => $this->workspace,
                    ],
                ),
            ),
            attempts: 3,
        );
    }
}
