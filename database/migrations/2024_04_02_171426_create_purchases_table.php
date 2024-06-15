<?php


use App\Models\Bill;
use App\Models\Inventory;
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
            $table->foreignIdFor(Inventory::class)->nullable();
            $table->foreignIdFor(User::class,'created_by');
            $table->foreignIdFor(Vendor::class);
            $table->smallInteger('mark')->default(0);
            $table->smallInteger('level')->default(0);
            $table->integer('discount')->nullable();
            $table->string('note')->nullable();
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
