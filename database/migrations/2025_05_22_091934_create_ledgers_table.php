<?php

use App\Models\Cashier;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cashier::class);
            $table->foreignIdFor(User::class,'created_by');
            $table->integer('start_balance');
            $table->integer('end_balance');
            $table->string('note')->nullable();
            $table->foreignId('serial')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->foreignId('project_id')->nullable();
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
        Schema::dropIfExists('ledgers');
    }
}
