<?php

declare(strict_types=1);

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\StoreRequest;
use App\Http\Responses\MessageResponse;
use App\Jobs\Projects\CreateNewProject;
use App\Models\Workspace;
use Illuminate\Contracts\Bus\Dispatcher;

use function Illuminate\Support\defer;

use Sprout\Attributes\CurrentTenant;
use Symfony\Component\HttpFoundation\Response;

final readonly class StoreController
{
    public function __construct(
        private Dispatcher $bus,
        #[CurrentTenant]
        private Workspace $workspace,
    ) {}

    public function __invoke(StoreRequest $request): MessageResponse
    {
        defer(
            callback: fn() => $this->bus->dispatch(
                command: new CreateNewProject(
                    payload: $request->payload(),
                    workspace: $this->workspace->id,
                ),
            ),
            name: 'create-new-project',
        );

        return new MessageResponse(
            message: 'We have accepted your request.',
            status: Response::HTTP_ACCEPTED,
        );
    }
}
