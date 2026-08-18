<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistrictIdToSchoolsTable extends Migration
{
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->foreignId('district_id')->nullable()->after('region_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropColumn('district_id');
        });
    }
}
