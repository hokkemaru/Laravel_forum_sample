<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_kinds', function (Blueprint $table) {
            $table->unsignedInteger('kind');
            $table->string('name', 20);
            $table->timestamps();
            // 主キーの設定
            $table->primary(['kind']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_kinds');
    }
}
