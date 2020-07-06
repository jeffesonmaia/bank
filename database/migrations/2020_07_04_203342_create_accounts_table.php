<?php

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->tinyInteger('status')->default(Account::STATUS_ACTIVE);
            $table->string('password');
            $table->timestamps();

            $table->uuid('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies');

            $table->uuid('holder_id');
            $table->foreign('holder_id')->references('id')->on('holders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
