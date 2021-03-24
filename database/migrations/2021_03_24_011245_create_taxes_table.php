<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tax_type_id')->unsigned();
            $table->foreign('tax_type_id')->references('id')->on('tax_types');
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->bigInteger('estimate_id')->unsigned()->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->bigInteger('invoice_product_id')->unsigned()->nullable();
            $table->foreign('invoice_product_id')->references('id')->on('invoice_products')->onDelete('cascade');
            $table->bigInteger('estimate_product_id')->unsigned()->nullable();
            $table->foreign('estimate_product_id')->references('id')->on('estimate_products')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('name');
            $table->bigInteger('amount')->unsigned();
            $table->decimal('percent', 5, 2);
            $table->tinyInteger('compound_tax')->default(0);
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
        Schema::dropIfExists('taxes');
    }
}
