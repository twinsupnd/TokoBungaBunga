<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing columns to events table safely (only if they're not present)
        if (! Schema::hasTable('events')) {
            return; // nothing to do
        }

        Schema::table('events', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'nama_acara')) {
                $table->string('nama_acara')->nullable()->after('id');
            }

            if (! Schema::hasColumn('events', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('nama_acara');
            }

            if (! Schema::hasColumn('events', 'waktu_mulai')) {
                $table->time('waktu_mulai')->nullable()->after('tanggal');
            }

            if (! Schema::hasColumn('events', 'waktu_selesai')) {
                $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
            }

            if (! Schema::hasColumn('events', 'tempat')) {
                $table->string('tempat')->nullable()->after('waktu_selesai');
            }

            if (! Schema::hasColumn('events', 'kategori')) {
                $table->string('kategori')->nullable()->after('tempat');
            }

            // created_by intentionally not added here --- final schema will not include created_by
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('events')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'created_by')) {
                // drop constraint first
                $connection = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
                // In many DBs dropping the column will remove the FK, but we'll just drop column safely
                $table->dropColumn('created_by');
            }

            if (Schema::hasColumn('events', 'kategori')) {
                $table->dropColumn('kategori');
            }

            if (Schema::hasColumn('events', 'tempat')) {
                $table->dropColumn('tempat');
            }

            if (Schema::hasColumn('events', 'waktu_selesai')) {
                $table->dropColumn('waktu_selesai');
            }

            if (Schema::hasColumn('events', 'waktu_mulai')) {
                $table->dropColumn('waktu_mulai');
            }

            if (Schema::hasColumn('events', 'tanggal')) {
                $table->dropColumn('tanggal');
            }

            if (Schema::hasColumn('events', 'nama_acara')) {
                $table->dropColumn('nama_acara');
            }
        });
    }
};
