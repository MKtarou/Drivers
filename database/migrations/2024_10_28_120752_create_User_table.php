<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->unsignedInteger('group_id');
            $table->string('u_name', 20);
            $table->string('u_pass', 10);
            $table->integer('u_goal')->nullable();
            $table->timestamps();

            $table->foreign('group_id')->references('group_id')->on('groups')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}

?>