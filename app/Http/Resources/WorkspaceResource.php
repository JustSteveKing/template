<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property Workspace $resource */
final class WorkspaceResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'identifier' => $this->resource->identifier,
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
            'projects' => ProjectResource::collection(
                resource: $this->whenLoaded(
                    relationship: 'projects',
                ),
            ),
        ];
    }
}
