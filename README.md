# laravel-model-settings
Simple yet flexible settings for your Laravel models.

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

##### 3.) Use the "HasSettings.php" trait within your model.
_User.php_
```
use Cklmercer/ModelSettings/HasSettings;
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
_User.php_
```
use Cklmercer/ModelSettings/HasSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use HasSettings;

    /**
     * Set the model's default settings.
     *
     * @return void
     */
    protected function setDefaultSettings() 
    {
    	$this->settings = [
    		'some' => [
    			'setting' => true
    		]
    	];
    }

    // truncated for brevity..
}

## License
[MIT](http://opensource.org/licenses/MIT)