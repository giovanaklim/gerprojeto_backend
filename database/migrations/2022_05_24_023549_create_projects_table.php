<?php

use Carbon\Carbon;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('name');
            $table->date('due_date')->default(Carbon::now());
            $table->date('start')->default(Carbon::now());
            $table->date('end')->default(Carbon::now());
            $table->decimal('value')->nullable();
            $table->enum('status', ['aberto', 'concluído']);
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
        Schema::dropIfExists('projects');
    }
};
