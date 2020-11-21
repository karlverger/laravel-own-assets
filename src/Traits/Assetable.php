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
 * Trait Favoriteable.
 *
 * @property \Illuminate\Database\Eloquent\Collection $asseters
 * @property \Illuminate\Database\Eloquent\Collection $assets
 */
trait Assetable
{
    /**
     * @return bool
     */
    public function isAssetedBy(Model $user)
    {
        if (\is_a($user, config('auth.providers.users.model'))) {
            if ($this->relationLoaded('asseters')) {
                return $this->asseters->contains($user);
            }

            return ($this->relationLoaded('assets') ? $this->assets : $this->assets())
                    ->where(\config('ownassets.user_foreign_key'), $user->getKey())->count() > 0;
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function assets()
    {
        return $this->morphMany(config('ownassets.asset_model'), 'assetable');
    }

    /**
     * Return asseters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function asseters()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('ownassets.favorites_table'),
            'assetable_id',
            config('ownassets.user_foreign_key')
        )
            ->where('assetable_type', $this->getMorphClass());
    }

}
