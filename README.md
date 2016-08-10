# laravel-model-settings
Simple yet flexible settings for your Laravel models.

_Note: I will be updating this plugin in the bear future to better match the API of the new `cache()` helper method that has been introduced in Laravel 5.3_

## Installation
##### 1.) Install via composer
```
composer require cklmercer/laravel-model-settings
```

##### 2.) Add a JSON settings field to your model's migration.
_create_users_table.php_ 
```
Schema::create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->json('settings');
    $table->rememberToken();
    $table->timestamps();
});
```

##### 3.) Use the trait `Cklmercer\ModelSettings\HasSettings` within your model.
_User.php_
```
use Cklmercer\ModelSettings\HasSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use HasSettings;
     
    // truncated for brevity..
}
```

## Usage
##### 1.) Get all of the model's settings.
```
$user = App\User::first();

$user->settings()->all(); // Returns an array of the user's settings.
$user->settings()->get(); // Returns an array of the user's settings.
```

##### 2.) Get a specific setting.
```
$user = App\User::first();

$user->settings()->get('some.setting');
$user->settings()->get('some.setting', $defaultValue); // With a default value.
$user->settings('some.setting'); // Quicker access.
```

##### 3.) Add or update a setting.
```
$user = App\User::first();

$user->settings()->set('some.setting', 'new value');
$user->settings()->update('some.setting', 'new value');
```

##### 4.) Determine if the model has a specific setting.
```
$user = App\User::first();

$user->settings()->has('some.setting');
```

##### 5.) Remove a setting from a model.
```
$user = App\User::first();

$user->settings()->delete('some.setting');
$user->settings()->forget('some.setting');
```

##### 6.) Set the default settings for a new model.

If you define `$defaultSettings` as an array property on your model, we will use its value as the default settings for 
any new models that are created *without* settings.

_User.php_
```
use Cklmercer\ModelSettings\HasSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use HasSettings;

    /**
     * The model's default settings.
     * 
     * @var array
     */
    protected $defaultSettings = [
    	'homepage' => '/profile'
    ];

    // truncated for brevity..
}
```

##### 7.) Specify the settings that are allowed.

If you define `$allowedSettings` as an array property then only settings which match a value within 
the `$allowedSettings` array will be saved on the model.

_User.php_
```
use Cklmercer\ModelSettings\HasSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use HasSettings;

    /**
     * The model's allowed settings.
     * 
     * @var array
     */
    protected $allowedSettings = ['homepage'];

    // truncated for brevity..
}
```

## License
[MIT](http://opensource.org/licenses/MIT)
