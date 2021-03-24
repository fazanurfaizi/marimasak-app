<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('invoice_number');
            $table->string('reference_number')->nullable();
            $table->enum('status', ['draft', 'onProgress', 'completed', 'failed'])->nullable()->default('draft');
            $table->enum('paid_status', ['paid', 'unpaid'])->nullable()->default('unpaid');
            $table->string('tax_per_item');
            $table->string('discount_per_item');
            $table->text('notes')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->bigInteger('discount_val')->unsigned()->nullable();
            $table->bigInteger('sub_total')->unsigned();
            $table->bigInteger('total')->unsigned();
            $table->bigInteger('tax')->unsigned();
            $table->bigInteger('due_amount')->unsigned();
            $table->boolean('sent')->default(false);
            $table->boolean('viewed')->default(false);
            $table->string('unique_hash')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->bigInteger('invoice_template_id')->unsigned()->nullable();
            $table->foreign('invoice_template_id')->references('id')->on('invoice_templates')->onDelete('SET NULL');
            $table->bigInteger('creator_id')->unsigned()->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
