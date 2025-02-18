<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property Project $resource */
final class ProjectResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
            'workspace' => new WorkspaceResource(
                resource: $this->whenLoaded(
                    relationship: 'workspace',
                ),
            ),
        ];
    }
}
