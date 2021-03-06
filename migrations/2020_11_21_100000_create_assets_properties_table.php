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

class CreateAssetsPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('ownassets.assets_properties_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger(config('ownassets.asset_foreign_key'))->index()->comment('asset_id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();

            $table->foreign(config('ownassets.asset_foreign_key'))->references("id")->on(config('ownassets.assets_table'))->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('ownassets.assets_properties_table'));
    }
}
