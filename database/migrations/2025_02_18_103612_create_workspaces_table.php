<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('workspaces', static function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('identifier')->unique();
            $table->string('resource_key')->unique();

            $table->timestamps();
        });

        Schema::table('users', static function (Blueprint $table): void {
            $table->foreignUlid('workspace_id')->index()->constrained('workspaces')->cascadeOnDelete();
            $table->dropUnique('users_email_unique');
            $table->unique(['workspace_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
