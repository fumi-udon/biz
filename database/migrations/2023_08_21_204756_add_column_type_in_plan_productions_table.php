<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeInPlanProductionsTable extends Migration
{
    public function up()
    {
        Schema::table('plan_productions', function (Blueprint $table) {
            $table->tinyInteger('mon')->default(0);
            $table->tinyInteger('tue')->default(0);
            $table->tinyInteger('wed')->default(0);
            $table->tinyInteger('thu')->default(0);
            $table->tinyInteger('fri')->default(0);
            $table->tinyInteger('sat')->default(0);
            $table->tinyInteger('sun')->default(0);
        });
    }

    public function down()
    {
        Schema::table('plan_productions', function (Blueprint $table) {
            $table->dropColumn(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']);
        });
    }

}
