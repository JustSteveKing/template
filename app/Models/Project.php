<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $workspace_id
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property Workspace $workspace
 */
final class Project extends AbstractTenant
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'workspace_id',
    ];
}
