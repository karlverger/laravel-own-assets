<?php
/*
 * This file is part of the karlverger/laravel-own-assets.
 *
 * (c) Karl Verger <karl.verger@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */
namespace Karlverger\LaravelOwnAsset\Events;


use Illuminate\Database\Eloquent\Model;

class Event
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $asset;

    /**
     * Event constructor.
     */
    public function __construct(Model $asset)
    {
        $this->asset = $asset;
    }
}
