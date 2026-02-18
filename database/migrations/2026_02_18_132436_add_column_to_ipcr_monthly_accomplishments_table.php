<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnToIpcrMonthlyAccomplishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_monthly_accomplishments', function (Blueprint $table) {
            $table->string('employee_code')->nullable()->after('status');
            $table->string('immediate_id')->nullable()->after('employee_code');
            $table->string('next_higher')->nullable()->after('immediate_id');
            $table->string('position')->nullable()->after('next_higher');
            $table->string('department_code')->nullable()->after('position');
            $table->string('department_name')->nullable()->after('department_code');
            $table->string('division_name')->nullable()->after('department_name');
            $table->string('pg_dept_head')->nullable()->after('division_name');
            $table->string('allow_month_backtrack')->nullable()->after('pg_dept_head')
            ->comment('Allow month backtrack for IPCR, 0 -not allowed; 1 - allowed');
        });

        /**
         * Copy values from ipcr_semestrals to ipcr_monthly_accomplishments
         * Includes soft-deleted rows (no deleted_at filter).
         */
        DB::statement("
            UPDATE ipcr_monthly_accomplishments m
            INNER JOIN ipcr__semestrals s
                ON s.id = m.ipcr_semestral_id
            SET
                m.employee_code = s.employee_code,
                m.immediate_id = s.immediate_id,
                m.next_higher = s.next_higher,
                m.position = s.position,
                m.department_code = s.department_code,
                m.department_name = s.department_name,
                m.division_name = s.division_name,
                m.pg_dept_head = s.pg_dept_head,
                m.allow_month_backtrack = '0'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_monthly_accomplishments', function (Blueprint $table) {
            //
        });
    }
}
