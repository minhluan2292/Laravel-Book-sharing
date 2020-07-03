<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('ad_id')->nullable();
            $table->string('list_id')->nullable();
            $table->boolean('company_ad')->default(0);
            $table->string('phone')->nullable()->unique();

            $table->string('list_time')->nullable();
            $table->string('date')->nullable();
            $table->string('account_id')->nullable();
            $table->string('account_oid')->nullable();
            $table->string('account_name')->nullable();
            $table->text('subject')->nullable();
            $table->integer('category')->nullable();
            $table->integer('area')->nullable();
            $table->string('area_name')->nullable();
            $table->integer('region')->nullable();
            $table->string('region_name')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('price')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
