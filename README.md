# Silhouette

![](https://img.shields.io/badge/packagist-v1.0.1-informational?style=flat&logo=<LOGO_NAME>&logoColor=white&color=2bbc8a) ![](https://img.shields.io/badge/license-MIT-informational?style=flat&logo=<LOGO_NAME>&logoColor=white&color=2bbc8a)

Is a simple configuration management library that supports multiple configuration file formats.

## Features
1. Supports php array and json format.
2. Facade implementation to beautifully access your configuration data.
3. Easy integration with other frameworks or even without framework at all.

## Installation
1. You can install via composer.
```
composer require jameslevi/silhouette
```
2. Include the autoloader at the upper part of your code.
```php
require_once __DIR__.'/vendor/autoload.php';
```

## Getting Started
1. Import the config class into your project.
```php
use Graphite\Component\Silhouette\Config;
```
2. Create a new config file in php or json. But for this example let's try a php file that returns an array.
```php
<?php

return [
  'enable'      => true,
  'port'        => 3306,
  'host'        => 'localhost',
  'username'    => 'root',
  'password'    => 'abcd',
  'database'    => 'users',
  'max-rows'    => 10000,
];
```
3. Instantiate a new config object.
```php
$db = new Config(__DIR__ . "/config/db.php");
```
4. You can now get data using "get" method.
```php
$db->get('enable'); // This will return true.
```
You can also get data using object keys.
```php
$db->username; // This will return "root".
```
5. You can also set add new value into your config.
```php
$db->add('charset', 'utf-8'); // This will add "charset" as new config data.
```
6. You can edit config data using "set" method.
```php
$db->set('database', 'photos'); // This will change the value of the key database.
```
You can also set data using object keys.
```php
$db->database = 'photos'; // This will change the value of database from "users" to "photos".
```
7. You can check if keyword exists using "has" method.
```php
$db->has('password'); // Returns true.
```
8. You can remove a configuration data using "remove" method.
```php
$db->remove('enable'); // This will remove "enable" from your configuration object.
```
9. You can return your configuration data in array.
```php
$db->toArray();
```
10. You can also return json format of your configuration data.
```php
$db->toJson();
```
## Config Injection
You can also make a config object without loading a config file.
```php
$db = new Config([
  'enable'      => true,
  'port'        => 3306,
  'host'        => 'localhost',
  'username'    => 'root',
  'password'    => 'abcd',
  'database'    => 'users',
  'max-rows'    => 10000,
]);
```

## Facade
1. Create a class that extends silhouette facade class then override the parent constructor by passing the config path.
```php
<?php

namespace App\Config;

use Graphite\Component\Silhouette\Facade;

class DB extends Facade
{
    public function __construct()
    {
        parent::__construct('config/db.php');
    }
}
```
2. You can now get each configurations by calling it's static methods.
```php
DB::enable() // Returns the value of enable property.
```
You must call properties that are in snake case to camel case.
```php
DB::maxRows() // Returns the value 10000.
```
3. You can edit configuration value by providing the first argument of the method called.
```php
DB::enable(false) // Change the value of "enable" to false.
```
4. You can add, edit or delete configuration data using config "context".
```php
DB::context()->add('min_rows', 100); // This will add new configuration property.
DB::context()->set('min_rows', 110); // This will set the value of "min_rows".
DB::context()->remove('min-rows'); // This will remove "min_rows" from the data object.
```

## Muted Configuration Object
Configuration objects that only returns data.
```php
// Create a new database configuration object.
$config = new Config(__DIR__ . '/config/db.php', true);

// You cannot add new data to your muted configuration.
$config->add('driver', 'mysql');
```
You can also mute config object in facade.
```php
<?php

namespace App\Config;

use Graphite\Component\Silhouette\Facade;

class DB extends Facade
{
    public function __construct()
    {
        parent::__construct('config/db.php', true);
    }
}
```
## Contribution
For issues, concerns and suggestions, you can email James Crisostomo via nerdlabenterprise@gmail.com.

## License
This package is an open-sourced software licensed under [MIT](https://opensource.org/licenses/MIT) License.
