<?php

use App\Models\Bill;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('cost');
            $table->integer('discount')->nullable();
            $table->string('note')->nullable();
            $table->smallInteger('mark')->default(0);
            $table->smallInteger('level')->default(0);
            $table->foreignIdFor(Inventory::class);
            $table->foreignIdFor(Material::class);
            $table->foreignIdFor(Unit::class);
            $table->foreignIdFor(Bill::class);
            $table->foreignIdFor(User::class,'created_by');
            $table->foreignIdFor(Currency::class);
            $table->foreignIdFor(Currency::class,'rate_to');
            $table->foreignIdFor(Client::class,);
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
        Schema::dropIfExists('sales');
    }
}
