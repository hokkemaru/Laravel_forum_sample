<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false);
            $table->unsignedInteger('kind');
            $table->unsignedInteger('sort');
            $table->string('name', 100);
            $table->timestamps();
            // 外部キーの設定
            $table->foreign('kind')->references('kind')->on('code_kinds');
            // 主キーの設定
            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codes');
    }
}
