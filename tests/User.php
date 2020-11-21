<?php

/*
 * This file is part of the overtrue/laravel-like.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Karlverger\LaravelOwnAsset\Traits\Asseter;

/**
 * Class User.
 */
class User extends Model
{
    use Asseter;

    protected $fillable = ['name'];
}
