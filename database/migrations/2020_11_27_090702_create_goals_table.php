<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_id')->index();
            $table->bigInteger('expense_tag_id')->nullable();
            $table->bigInteger('income_tag_id')->nullable();
            $table->string('period');
            $table->string('type')->default('expense');
            $table->double('amount');
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
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
        Schema::dropIfExists('goals');
    }
}
