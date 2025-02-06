<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddSlugColumnToIpcrSemestrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->string('slug')->after('pg_dept_head'); // Adjust column position if needed
        });

        foreach (DB::table('ipcr__semestrals')->get() as $row) {
            $random = Str::random(7 * 2);
            $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
            $slugBase = Str::slug($row->employee_name . '-' . $append . '-' . $row->sem . '-' . $row->year);

            $slug = $slugBase;
            // $count = 0;

            // Ensure uniqueness
            while (DB::table('ipcr__semestrals')->where('slug', $slug)->exists()) {
                $random = Str::random(7 * 2);
                $append = substr(preg_replace('/[^a-z1-3]/', '', $random), 0, 7);
                // if ($count > 1) {
                $slug = $slugBase . '-' . $append;
                // }
                // $count++;
            }

            // Update the row with the generated slug
            DB::table('ipcr__semestrals')
                ->where('id', $row->id)
                ->update(['slug' => $slug]);
        }

        // Now enforce the UNIQUE constraint
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_-semestrals', function (Blueprint $table) {
            //
        });
    }
}
