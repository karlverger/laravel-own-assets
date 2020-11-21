<?php

/*
 * This file is part of the karlverger/laravel-own-assets.
 *
 * (c) Karl Verger <karl.verger@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    /*
     * User tables foreign key name.
     */
    'user_foreign_key' => 'user_id',
    /*
     * Asset tables foreign key name.
     */    
    'asset_foreign_key'=> 'asset_id',

    /*
     * Table name for assets records.
     */
    'assets_table' => 'assets',
    /*
     * Table name for assets properties records.
     */    
    'assets_properties_table'=>'assets_properties',

    /*
     * Model name for asset record.
     */
    'asset_model' => 'Karlverger\LaravelOwnAsset\Asset',
    /*
     * Model name for property record.
     */    
    'property_model' => 'Karlverger\LaravelOwnAsset\AssetProperty',
];
