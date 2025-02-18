<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\WorkspaceFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sprout\Contracts\Tenant;
use Sprout\Contracts\TenantHasResources;
use Sprout\Database\Eloquent\Concerns\HasTenantResources;
use Sprout\Database\Eloquent\Concerns\IsTenant;

/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $identifier
 * @property string $resource_key
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property Collection<int,User> $users
 * @property Collection<int,Project> $projects
 */
final class Workspace extends Model implements Tenant, TenantHasResources
{
    /** @use HasFactory<WorkspaceFactory> */
    use HasFactory;
    use HasTenantResources;
    use HasUlids;
    use IsTenant;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'identifier',
        'resource_key',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    public function projects(): HasMany
    {
        return $this->hasMany(
            related: Project::class,
            foreignKey: 'workspace_id',
        );
    }
}
