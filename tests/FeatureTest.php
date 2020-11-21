<?php


/*
 * This file is part of the karlverger/laravel-own-assets.
 *
 * (c) Karl Verger <karl.verger@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Tests;

use Illuminate\Support\Facades\Event;
use Karlverger\LaravelOwnAsset\Events\Asseted;
use Karlverger\LaravelOwnAsset\Events\Unasseted;
use Karlverger\LaravelOwnAsset\Asset;

/**
 * Class FeatureTest.
 */
class FeatureTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Event::fake();

        config(['ownassets.providers.users.model' => User::class]);
    }

    public function testBasicFeatures()
    {
        $user = User::create(['name' => 'overtrue']);
        $post = Post::create(['title' => 'Hello world!']);


    }

}
