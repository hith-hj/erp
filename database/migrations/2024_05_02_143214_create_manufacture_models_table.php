<?php

use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufactureModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacture_models', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class,'manufactured_id')->nullable();
            $table->foreignIdFor(Material::class)->nullable();
            $table->foreignIdFor(Inventory::class)->nullable();
            $table->integer('quantity')->default(0);
            $table->foreignIdFor(Unit::class)->nullable();
            $table->integer('cost')->default(0);
            $table->foreignIdFor(Currency::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacture_models');
    }
}
