<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResultTypeIdToResultTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('result_titles', function (Blueprint $table) {
            $table->foreignId('result_type_id')->nullable()->after('region_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('result_titles', function (Blueprint $table) {
            $table->dropForeign(['result_type_id']);
            $table->dropColumn('result_type_id');
        });
    }
}
