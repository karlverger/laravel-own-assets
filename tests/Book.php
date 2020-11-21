<?php


/*
 * This file is part of the karlverger/laravel-own-assets.
 *
 * (c) Karl Verger <karl.verger@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */
namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

/**
 * Class Book.
 */
class Book extends Model
{
    use Favoriteable;

    protected $fillable = ['title'];
}
