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
        Schema::create('stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('project_id');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('name');
            $table->string('detail')->nullable();
            $table->string('head')->nullable();
            $table->decimal('value', 12, 2)->nullable();
            $table->string('color')->nullable();
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
        Schema::dropIfExists('stages');
    }
};
