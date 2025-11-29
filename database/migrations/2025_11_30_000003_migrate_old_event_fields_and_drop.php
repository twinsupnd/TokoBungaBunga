<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('events')) {
            return;
        }

        // 1) copy data from legacy columns into the new columns (only when new columns are empty)
        // We perform this in DB statements so it works for large tables.

        // Copy title -> nama_acara
        if (Schema::hasColumn('events', 'title') && Schema::hasColumn('events', 'nama_acara')) {
            DB::table('events')
                ->whereNull('nama_acara')
                ->whereNotNull('title')
                ->update(['nama_acara' => DB::raw('title')]);
        }

        // If start_at exists, populate tanggal (date) and waktu_mulai (time) from it
        if (Schema::hasColumn('events', 'start_at')) {
            // Different DBs have different functions; try to use SQL compatible approach
            // Use DATE() and TIME() functions (MySQL/Postgres compatibility should work for common cases)
            if (Schema::hasColumn('events', 'tanggal')) {
                DB::table('events')
                    ->whereNull('tanggal')
                    ->whereNotNull('start_at')
                    ->update(['tanggal' => DB::raw('DATE(start_at)')]);
            }

            if (Schema::hasColumn('events', 'waktu_mulai')) {
                DB::table('events')
                    ->whereNull('waktu_mulai')
                    ->whereNotNull('start_at')
                    ->update(['waktu_mulai' => DB::raw('TIME(start_at)')]);
            }
        }

        // Copy end_at -> waktu_selesai
        if (Schema::hasColumn('events', 'end_at') && Schema::hasColumn('events', 'waktu_selesai')) {
            DB::table('events')
                ->whereNull('waktu_selesai')
                ->whereNotNull('end_at')
                ->update(['waktu_selesai' => DB::raw('TIME(end_at)')]);
        }

        // Copy description -> tempat (best-effort mapping)
        if (Schema::hasColumn('events', 'description') && Schema::hasColumn('events', 'tempat')) {
            DB::table('events')
                ->whereNull('tempat')
                ->whereNotNull('description')
                ->update(['tempat' => DB::raw('description')]);
        }

        // Copy category -> kategori
        if (Schema::hasColumn('events', 'category') && Schema::hasColumn('events', 'kategori')) {
            DB::table('events')
                ->whereNull('kategori')
                ->whereNotNull('category')
                ->update(['kategori' => DB::raw('category')]);
        }

        // 2) now that data is copied (best-effort), we can drop legacy columns safely
        // NOTE: Dropping columns requires doctrine/dbal for many DB drivers; ensure you have the package installed

        // Also remove any created_by column so final schema contains only the requested columns
        // Also remove any timestamps/created_by so final schema contains only the requested columns
        $toDrop = ['title', 'description', 'start_at', 'end_at', 'all_day', 'category', 'color', 'created_by', 'created_at', 'updated_at'];
        $existingToDrop = [];
        foreach ($toDrop as $col) {
            if (Schema::hasColumn('events', $col)) {
                $existingToDrop[] = $col;
            }
        }

        if (! empty($existingToDrop)) {
            Schema::table('events', function (Blueprint $table) use ($existingToDrop) {
                // If DB requires it you'll need doctrine/dbal when dropping columns.
                $table->dropColumn($existingToDrop);
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('events')) {
            return;
        }

        // re-create old columns if missing (best-effort). We'll restore only columns we previously dropped.
        Schema::table('events', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'title')) {
                $table->string('title')->nullable()->after('id');
            }

            if (! Schema::hasColumn('events', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (! Schema::hasColumn('events', 'start_at')) {
                $table->dateTime('start_at')->nullable()->after('description');
            }

            if (! Schema::hasColumn('events', 'end_at')) {
                $table->dateTime('end_at')->nullable()->after('start_at');
            }

            if (! Schema::hasColumn('events', 'all_day')) {
                $table->boolean('all_day')->default(false)->after('end_at');
            }

            if (! Schema::hasColumn('events', 'category')) {
                $table->string('category')->nullable()->after('all_day');
            }

            if (! Schema::hasColumn('events', 'color')) {
                $table->string('color')->nullable()->after('category');
            }

            if (! Schema::hasColumn('events', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('color');
            }

            if (! Schema::hasColumn('events', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('created_by');
            }

            if (! Schema::hasColumn('events', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });

        // Try to copy back data where appropriate
        // title <- nama_acara
        if (Schema::hasColumn('events', 'nama_acara') && Schema::hasColumn('events', 'title')) {
            DB::table('events')
                ->whereNull('title')
                ->whereNotNull('nama_acara')
                ->update(['title' => DB::raw('nama_acara')]);
        }

        // start_at <- combine tanggal + waktu_mulai if available
        if (Schema::hasColumn('events', 'tanggal') && Schema::hasColumn('events', 'waktu_mulai') && Schema::hasColumn('events', 'start_at')) {
            // This uses string concat and cast; some DBs may need specific functions. For common MySQL/Postgres this should be fine.
            DB::table('events')
                ->whereNull('start_at')
                ->whereNotNull('tanggal')
                ->whereNotNull('waktu_mulai')
                ->update(['start_at' => DB::raw("CONCAT( tanggal, ' ', waktu_mulai )")]);
        }

        // end_at <- tanggal + waktu_selesai
        if (Schema::hasColumn('events', 'tanggal') && Schema::hasColumn('events', 'waktu_selesai') && Schema::hasColumn('events', 'end_at')) {
            DB::table('events')
                ->whereNull('end_at')
                ->whereNotNull('tanggal')
                ->whereNotNull('waktu_selesai')
                ->update(['end_at' => DB::raw("CONCAT( tanggal, ' ', waktu_selesai )")]);
        }

        // description <- tempat
        if (Schema::hasColumn('events', 'tempat') && Schema::hasColumn('events', 'description')) {
            DB::table('events')
                ->whereNull('description')
                ->whereNotNull('tempat')
                ->update(['description' => DB::raw('tempat')]);
        }

        // category <- kategori
        if (Schema::hasColumn('events', 'kategori') && Schema::hasColumn('events', 'category')) {
            DB::table('events')
                ->whereNull('category')
                ->whereNotNull('kategori')
                ->update(['category' => DB::raw('kategori')]);
        }
    }
};
