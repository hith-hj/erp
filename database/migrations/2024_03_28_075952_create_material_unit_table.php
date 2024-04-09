<?php

use App\Models\Material;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_unit', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_default')->default(0);
            $table->timestamps();
            $table->foreignIdFor(Unit::class)->nullable();
            $table->foreignIdFor(Material::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_unit');
    }
}
