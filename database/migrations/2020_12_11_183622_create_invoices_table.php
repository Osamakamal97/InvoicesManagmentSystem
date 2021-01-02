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
            $table->string('invoice_number'); //
            $table->date('invoice_date'); //
            $table->date('due_date'); //
            $table->unsignedBigInteger('product_id'); //
            $table->unsignedBigInteger('section_id'); //
            $table->decimal('collection_amount', 8, 2)->nullable();
            $table->decimal('commission_amount', 8, 2);
            $table->decimal('discount', 8, 2); //
            $table->decimal('rate_vat', 8, 2); //
            $table->decimal('value_vat', 8, 2); //
            $table->decimal('total', 8, 2); //
            $table->unsignedTinyInteger('status')->default(0);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
