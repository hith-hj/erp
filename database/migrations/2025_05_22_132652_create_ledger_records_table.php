<?php

use App\Models\Currency;
use App\Models\Ledger;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ledger::class);
            $table->foreignIdFor(Currency::class);
            $table->foreignId('account_id');
            $table->string('type');
            $table->string('quantity');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('ledger_records');
    }
}
