<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('node_id');
            $table->string('name');
            $table->string('details')->nullable();
            $table->string('head')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->decimal('value', 12, 2)->nullable();
            $table->enum('status', ['open', 'closed']);
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
        Schema::dropIfExists('items');
    }
};
