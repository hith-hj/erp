<?php

use App\Models\Bill;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('cost');
            $table->integer('discount')->nullable();
            $table->string('note')->nullable();
            $table->smallInteger('mark')->default(0);
            $table->smallInteger('level')->default(0);
            $table->foreignIdFor(Currency::class,'rate_to')->nullable();
            $table->foreignIdFor(Unit::class)->nullable();
            $table->foreignIdFor(Currency::class)->nullable();
            $table->foreignIdFor(Material::class)->nullable();
            $table->foreignIdFor(Inventory::class)->nullable();
            $table->foreignIdFor(Bill::class)->nullable();
            $table->foreignIdFor(User::class,'created_by');
            $table->foreignIdFor(Vendor::class);
            $table->softDeletes();
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
        Schema::dropIfExists('purchases');
    }
}
