<?php

/*
 * This file is part of the karlverger/laravel-own-assets.
 * (c) Karl Verger <karl.verger@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Karlverger\LaravelOwnAsset\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait Asseter.
 *
 * @property \Illuminate\Database\Eloquent\Collection $assets
 */
trait Asseter
{
    public function asset(Model $object)
    {
        /* @var \Karlverger\LaravelOwnAsset\Traits\Assetable $object */
        if (!$this->hasAsseted($object)) {
            $asset = app(config('ownassets.asset_model'));
            $asset->{config('ownassets.user_foreign_key')} = $this->getKey();

            $object->assets()->save($asset);
        }
    }

    public function unasset(Model $object)
    {
        /* @var \Karlverger\LaravelOwnAsset\Traits\Assetable $object */
        $relation = $object->assets()
            ->where('assetable_id', $object->getKey())
            ->where('assetable_type', $object->getMorphClass())
            ->where(config('ownassets.user_foreign_key'), $this->getKey())
            ->first();

        if ($relation) {
            $relation->delete();
        }
    }

    public function toggleAsset(Model $object)
    {
        $this->hasAsseted($object) ? $this->unasset($object) : $this->asset($object);
    }

    /**
     * @return bool
     */
    public function hasAsseted(Model $object)
    {
        return ($this->relationLoaded('assets') ? $this->assets : $this->assets())
            ->where('assetable_id', $object->getKey())
            ->where('assetable_type', $object->getMorphClass())
            ->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->hasMany(config('ownassets.favorite_model'), config('ownassets.user_foreign_key'), $this->getKeyName());
    }

    /**
     * Get Query Builder for assets
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getAssetItems(string $model)
    {
        return app($model)->whereHas(
            'asseters',
            function ($q) {
                return $q->where(config('ownassets.user_foreign_key'), $this->getKey());
            }
        );
    }
}
