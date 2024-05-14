<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDefaultColumnToInvntoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( ! Schema::hasColumn('inventories','is_default') ){
            Schema::table('invntories', function (Blueprint $table) {
                $table->boolean('is_default')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if( Schema::hasColumn('inventories','is_default') ){
            Schema::table('invntories', function (Blueprint $table) {
                $table->dropColumn('is_default');
            });
        }
    }
}
