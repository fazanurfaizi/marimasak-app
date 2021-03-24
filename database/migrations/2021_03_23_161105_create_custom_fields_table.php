<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('label');
            $table->string('model_type');
            $table->string('type');
            $table->string('placeholder')->nullable();
            $table->json('options')->nullable();
            $table->boolean('boolean_answer')->nullable();
            $table->date('date_answer')->nullable();
            $table->time('time_answer')->nullable();
            $table->text('string_answer')->nullable();
            $table->bigInteger('number_answer')->unsigned()->nullable();
            $table->dateTime('date_time_answer')->nullable();
            $table->boolean('is_required')->default(false);
            $table->bigInteger('order')->unsigned()->default(1);
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('SET NULL');
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
        Schema::dropIfExists('custom_fields');
    }
}
