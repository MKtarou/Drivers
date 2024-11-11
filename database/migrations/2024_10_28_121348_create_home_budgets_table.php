<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_budgets', function (Blueprint $table) {
            $table->increments('id');  // PK
            $table->unsignedInteger('group_id');  // 外部キー
            $table->unsignedInteger('user_id');   // 外部キー
            $table->date('date');                 // 日付
            $table->string('details');
            $table->unsignedInteger('category_id'); // カテゴリID (外部キー)
            $table->integer('price');             // 値段
            $table->timestamps();
        
            // 外部キー制約
            $table->foreign('group_id')->references('group_id')->on('groups')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_budgets');
    }
};
