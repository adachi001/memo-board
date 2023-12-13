<?php

// database/migrations/xxxx_xx_xx_create_likes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            $table->unique(['user_id', 'post_id']); // 同じユーザーが同じ投稿に複数回いいねできないようにするためのユニーク制約
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
