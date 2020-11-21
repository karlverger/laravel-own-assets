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

        config(['auth.providers.users.model' => User::class]);
    }

    public function testBasicFeatures()
    {
        $user = User::create(['name' => 'karl verger']);
        $post = Post::create(['title' => 'Hello world!']);

        $user->asset($post);


        $post->assetable->addAssetProperty("clef","value");

        Event::assertDispatched(Asseted::class, function ($event) use ($user, $post) {
            return $event->asset->assetable instanceof Post
                && $event->asset->user instanceof User
                && $event->asset->user->id === $user->id
                && $event->asset->assetable->id === $post->id;
        });

        $this->assertTrue(  count($post->assetProperties()->get()) >0  );
        $this->assertTrue($user->hasAsseted($post));
        $this->assertTrue($post->isAssetedBy($user));

        $user->unasset($post);

        Event::assertDispatched(Unasseted::class, function ($event) use ($user, $post) {
            return $event->asset->assetable instanceof Post
                && $event->asset->user instanceof User
                && $event->asset->user->id === $user->id
                && $event->asset->assetable->id === $post->id;
        });
    }

}
