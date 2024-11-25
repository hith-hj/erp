<?php

use App\Models\Bill;
use App\Models\Cashier;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cashier::class);
            $table->foreignIdFor(Bill::class);
            $table->smallInteger('type')->default(1);
            $table->integer('amount')->default(0);
            $table->integer('remaining')->default(0);
            $table->boolean('is_payed')->default(false);
            $table->foreignIdFor(User::class,'created_by');
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
        Schema::dropIfExists('transactions');
    }
}
