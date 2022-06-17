<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReportPatientIndificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_report_patient_indifications', function (Blueprint $table) {
            $table->id();
            $table->integer('report_id');
            $table->integer('patient_indification_id');
            $table->integer('user_id');
            $table->integer('qty')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_report_patient_indifications');
    }
}
