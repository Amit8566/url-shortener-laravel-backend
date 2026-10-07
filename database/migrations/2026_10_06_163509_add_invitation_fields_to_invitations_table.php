<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            //
             $table->foreignId('company_id')
                ->after('id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('invited_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('email');
            $table->string('role');
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at');
            $table->timestamp('accepted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            //
             $table->dropForeign(['company_id']);
            $table->dropForeign(['invited_by']);

            $table->dropColumn([
                'company_id',
                'invited_by',
                'email',
                'role',
                'token',
                'expires_at',
                'accepted_at',
            ]);
        });
    }
};
