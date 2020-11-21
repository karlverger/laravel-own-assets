<?php

/*
 * This file is part of the karlverger/laravel-own-assets.
 * (c) Karl Verger <karl.verger@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Karlverger\LaravelOwnAsset;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


use Karlverger\LaravelOwnAsset\Events\Asseted;
use Karlverger\LaravelOwnAsset\Events\Unasseted;

/**
 * Class AssetProperty.
 *
 * @property \Illuminate\Database\Eloquent\Model $user
 * @property \Illuminate\Database\Eloquent\Model $asseter
 * @property \Illuminate\Database\Eloquent\Model $assetable
 */
class AssetProperty extends Model
{


    public function __construct(array $attributes = [])
    {
        $this->table = \config('ownassets.assets_properties_table');

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($assetProperty) {
            $assetForeignKey = \config('ownassets.asset_foreign_key');
            $assetProperty->{$assetForeignKey} = $assetProperty->{$assetForeignKey} ;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset()
    {
        return $this->belongsTo(\config('ownassets.asset_model'), \config('ownassets.asset_foreign_key'));
    }
}
