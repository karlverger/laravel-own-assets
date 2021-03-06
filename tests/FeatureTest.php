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

        $asset = $user->asset($post);


        $assetPivot = $user->assets()
                            ->where("assetable_type",Post::class )
                            ->where("assetable_id",$post->id )->first();

        $assetItem = $user->getAssetItems(Post::class)->get();
        
        

        Event::assertDispatched(Asseted::class, function ($event) use ($user, $post) {
            return $event->asset->assetable instanceof Post
                && $event->asset->user instanceof User
                && $event->asset->user->id === $user->id
                && $event->asset->assetable->id === $post->id;
        });
    


        $this->assertTrue($asset->addAssetProperty("clef","value") != null);
        $this->assertTrue($asset->addAssetProperty("clef 2","value") != null);

        $asset->deleteAssetProperty("clef 2");
        $this->assertTrue($asset->getAssetProperty("clef 2") == null);

        $this->assertTrue($asset->asseter()->first()->name == $user->name);
        $this->assertTrue(  count($assetItem) >0  );
        $this->assertTrue(  count($assetPivot->assetProperties) >0  );
        $this->assertTrue(  $assetPivot->assetProperties[0]->key =="clef"  );


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
