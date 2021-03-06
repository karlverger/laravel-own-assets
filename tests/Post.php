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
use Karlverger\LaravelOwnAsset\Traits\Assetable;

/**
 * Class Post.
 */
class Post extends Model
{
    use Assetable;

    protected $fillable = ['title'];
}
