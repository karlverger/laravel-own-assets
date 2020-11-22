Laravel Own Assets
---

❤️ User assets feature for Laravel Application.



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

This step is also optional, if you want to custom assets table, you can publish the migration files:

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
$car = Car::find(2);

\Karlverger\LaravelOwnAsset\Asset  $asset = $user->asset($car);
$asset->addAssetProperty("clef 1","new value 1");

$user->unasset($car);
$user->toggleAsset($car);
$user->getAssetItems(Car::class)

$user->hasAsseted($car); 
$car->isAssetedBy($user); 
```

#### Get object asseters:

```php
foreach($car->asseters as $user) {
    // echo $user->name;
}
```



#### Get Asset Model from User.
Used Asseter Trait Model can easy to get Assetable Models to do what you want.
*note: this method will return a `Illuminate\Database\Eloquent\Builder` *
```php
$user->getAssetItems(Car::class);

// Do more
$assetCars = $user->getAssetItems(Car::class)->get();
$assetCars = $user->getAssetItems(Car::class)->paginate();
$assetCars = $user->getAssetItems(Car::class)->where('make', 'Jaguar')->get();
```

#### Get Asset Model relation pivot:

```php
\Karlverger\LaravelOwnAsset\Asset $asset = $car->assets()
  ->where("assetable_type",Car::class)
  ->where("assetable_id",$car->id)
  ->where("user_id",$user->id)->first();
```

### Aggregations

```php
// all
$user->assets()->count(); 

// with type
$user->assets()->withType(Car::class)->count(); 

// asseters count
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
