<?php


/*
 * This file is part of the karlverger/laravel-own-assets.
 *
 * (c) Karl Verger <karl.verger@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Karlverger\LaravelOwnAsset;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Events\Favorited;
use Overtrue\LaravelFavorite\Events\Unfavorited;

/**
 * Class Favorite.
 *
 * @property \Illuminate\Database\Eloquent\Model $user
 * @property \Illuminate\Database\Eloquent\Model $favoriter
 * @property \Illuminate\Database\Eloquent\Model $favoriteable
 */
class Asset extends Model
{
    /**
     * @var string[]
     */
    protected $dispatchesEvents = [
        'created' => Favorited::class,
        'deleted' => Unfavorited::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = \config('ownassets.assets_table');

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($favorite) {
            $userForeignKey = \config('ownassets.user_foreign_key');
            $favorite->{$userForeignKey} = $favorite->{$userForeignKey} ?: auth()->id();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function assetable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\config('auth.providers.users.model'), \config('ownassets.user_foreign_key'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asseter()
    {
        return $this->user();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithType(Builder $query, string $type)
    {
        return $query->where('assetable_type', app($type)->getMorphClass());
    }
}
