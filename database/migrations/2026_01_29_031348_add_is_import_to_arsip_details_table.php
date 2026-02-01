<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('arsip_details', function (Blueprint $table) {
            $table->boolean('is_import')
                  ->default(false)
                  ->after('baris');
        });
    }

    public function down(): void
    {
        Schema::table('arsip_details', function (Blueprint $table) {
            $table->dropColumn('is_import');
        });
    }
};

