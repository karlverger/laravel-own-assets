Laravel Own Assets
---

❤️ User assets feature for Laravel Application.

![CI](https://github.com/karlverger/laravel-own-assets/workflows/CI/badge.svg)


## Installing

```shell
$ composer require karlverger/laravel-own-asset
```

### Configuration

This step is optional

```php
$ php artisan vendor:publish --provider="Karlverger\\LaravelOwnAsset\\AssetServiceProvider" --tag=config
```

### Migrations

This step is also optional, if you want to custom favorites table, you can publish the migration files:

```php
$ php artisan vendor:publish --provider="Karlverger\\LaravelOwnAsset\\AssetServiceProvider" --tag=migrations
```


## Usage

### Traits

#### `Karlverger\LaravelOwnAsset\Traits\Asseter`

```php

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Karlverger\LaravelOwnAsset\Traits\Asseter;

class User extends Authenticatable
{
    use Asseter;
    
    <...>
}
```

#### `Karlverger\LaravelOwnAsset\Traits\Assetable`

```php
use Illuminate\Database\Eloquent\Model;
use Karlverger\LaravelOwnAsset\Traits\Assetable;

class Post extends Model
{
    use Assetable;

    <...>
}
```

### API

```php
$user = User::find(1);
$post = Post::find(2);

$user->asset($post);
$user->unasset($post);
$user->toggleAsset($post);
$user->getAssetItems(Post::class)

$user->hasAsseted($post); 
$post->isAssetedBy($user); 
```

#### Get object asseters:

```php
foreach($post->asseters as $user) {
    // echo $user->name;
}
```

#### Get Asset Model from User.
Used Asseter Trait Model can easy to get Assetable Models to do what you want.
*note: this method will return a `Illuminate\Database\Eloquent\Builder` *
```php
$user->getAssetItems(Post::class);

// Do more
$assetPosts = $user->getAssetItems(Post::class)->get();
$assetPosts = $user->getAssetItems(Post::class)->paginate();
$assetPosts = $user->getAssetItems(Post::class)->where('title', 'Laravel-Favorite')->get();
```

### Aggregations

```php
// all
$user->assets()->count(); 

// with type
$user->assets()->withType(Post::class)->count(); 

// favoriters count
$post->asseters()->count();
```

List with `*_count` attribute:

```php
$users = User::withCount('assets')->get();

foreach($users as $user) {
    echo $user->assets_count;
}
```

### Events

| **Event** | **Description** |
| --- | --- |
|  `Karlverger\LaravelOwnAsset\Events\Asseted` | Triggered when the relationship is created. |
|  `Karlverger\LaravelOwnAsset\Events\Unasseted` | Triggered when the relationship is deleted. |


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/karlverger/laravel-own-assets/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/karlverger/laravel-own-assets/issues).
3. Contribute new features or update the wiki.


## License

MIT (c) Karl Verger <karl.verger@gmail.com>
