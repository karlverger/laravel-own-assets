<?php

/*
 * This file is part of the karlverger/laravel-own-assets.
 *
 * (c) Karl Verger <karl.verger@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('ownassets.assets_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger(config('ownassets.user_foreign_key'))->index()->comment('user_id');
            $table->morphs('assetable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('ownassets.favorites_table'));
    }
}
