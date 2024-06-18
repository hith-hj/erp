<?php

use App\Models\Currency;
use App\Models\Material;
use App\Models\Sale;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sale::class)->nullable();
            $table->foreignIdFor(Material::class)->nullable();
            $table->integer('quantity')->default(1);
            $table->foreignIdFor(Unit::class)->nullable();
            $table->integer('cost')->default(0);
            $table->foreignIdFor(Currency::class)->nullable();
            $table->double('rate')->nullable();
            $table->foreignIdFor(Currency::class,'rate_to')->nullable();
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
        Schema::dropIfExists('material_sale');
    }
}
