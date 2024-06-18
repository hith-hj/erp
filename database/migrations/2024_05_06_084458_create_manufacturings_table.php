<?php

use App\Models\Bill;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class);
            $table->foreignIdFor(Inventory::class);
            $table->foreignIdFor(Unit::class);
            $table->integer('quantity');
            $table->integer('cost');
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
        Schema::dropIfExists('manufacturings');
    }
}
