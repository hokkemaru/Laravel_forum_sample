<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumPostReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_post_reactions', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('forum_post_id');
            $table->unsignedBigInteger('reaction_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            // 外部キーの設定
            $table->foreign('forum_post_id')->references('id')->on('forum_posts')->onDelete('cascade');
            $table->foreign('reaction_id')->references('id')->on('codes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_post_reactions');
    }
}
