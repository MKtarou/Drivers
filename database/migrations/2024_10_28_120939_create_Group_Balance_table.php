<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_balances', function (Blueprint $table) {
            $table->increments('balance_id');
            $table->unsignedInteger('group_id');
            $table->integer('income');
            $table->integer('expenditure');
            $table->year('year');
            $table->tinyInteger('month');
            $table->timestamps();

            $table->foreign('group_id')->references('group_id')->on('groups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_balances');
    }
};
