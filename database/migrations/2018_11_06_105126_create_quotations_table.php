<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('title');
            $table->string('place')->nullable();
            $table->string('quotation_day')->nullable();
            $table->string('period_before');
            $table->string('period_after');
            $table->string('payment_term');
            $table->string('expiration_date')->nullable();
            $table->string('staffs')->nullable();
            $table->string('which_document');
            $table->string('which_company');
            $table->text('remark');
            $table->timestamps();
            $table->string('sub_total');
            $table->string('total_tax');
            $table->string('total');
            $table->string('profit');
            $table->string('profit_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
