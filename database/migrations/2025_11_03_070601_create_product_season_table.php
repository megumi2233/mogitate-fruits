<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_season', function (Blueprint $table) {
            $table->id(); // bigint unsigned, PK
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // products.id への外部キー
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();  // seasons.id への外部キー
            $table->timestamps(); // created_at, updated_at

            $table->unique(['product_id', 'season_id']); // 重複登録を防ぐ
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_season');
    }
}
