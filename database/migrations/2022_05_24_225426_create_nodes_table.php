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
        Schema::create('nodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('stage_id');
            $table->string('name');
            $table->string('details')->nullable();
            $table->uuid('from')->nullable();
            $table->uuid('to')->nullable();
            $table->date('start')->default(Carbon::now());
            $table->date('end')->default(Carbon::now());
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
        Schema::dropIfExists('nodes');
    }
};
