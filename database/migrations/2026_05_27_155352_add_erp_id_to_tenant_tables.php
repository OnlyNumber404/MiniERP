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
        // Add erp_id to tables
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('erp_id')->nullable()->constrained('erps')->onDelete('cascade');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('erp_id')->nullable()->constrained('erps')->onDelete('cascade');
        });
        Schema::table('crypto_assets', function (Blueprint $table) {
            $table->foreignId('erp_id')->nullable()->constrained('erps')->onDelete('cascade');
        });

        $firstUser = \App\Models\User::first();
        if ($firstUser) {
            $erp = \App\Models\Erp::firstOrCreate(
                ['user_id' => $firstUser->id],
                ['name' => $firstUser->name."'s ERP"]
            );

            \Illuminate\Support\Facades\DB::table('categories')->whereNull('erp_id')->update(['erp_id' => $erp->id]);
            \Illuminate\Support\Facades\DB::table('transactions')->whereNull('erp_id')->update(['erp_id' => $erp->id]);
            \Illuminate\Support\Facades\DB::table('crypto_assets')->whereNull('erp_id')->update(['erp_id' => $erp->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crypto_assets', function (Blueprint $table) {
            $table->dropForeign(['erp_id']);
            $table->dropColumn('erp_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['erp_id']);
            $table->dropColumn('erp_id');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['erp_id']);
            $table->dropColumn('erp_id');
        });
    }
};
