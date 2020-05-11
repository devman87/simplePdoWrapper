**Simple Pdo Wrapper**

**Installation**

```
composer require devman87/simple-pdo-wrapper
```

**Example config file**
```php
return [
    'default' => 'config1',
    'config1' => [
        'dsn' => 'mysql:host=localhost;dbname=testdb;charset=utf8mb4',
        'username' => 'test',
        'password' => 'test',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],
    'config2' => [
        'hostname' => "pgsql:dbname=testdb;host=localhost options='--client_encoding=UTF8';",
        'username' => 'test',
        'password' => 'test',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ]
];
```
**Usage example**
```php
use SimplePdoWrapper\DB;
// Indicate this only 1 time, at the beginning of the application
DB::setConfig('your-config.php');
DB::connection(); // connection default, you can explicitly specify. Example: DB::connection('config1') or DB::connection('config2');

// sql requests
DB::request('SELECT * FROM table WHERE id = ?', [$id])->fetchAll();
DB::request('INSERT INTO table (column1, column2) VALUES (?, ?)', ['John', 'Doe']);
```

Transaction
```php
try {
    DB::beginTransaction();

    if (DB::request('UPDATE table1 SET column = ? WHERE id = ?', [$value1, $id1])->rowCount() < 1) {
        return false;
    }

    if (DB::request('UPDATE table2 SET column = ? WHERE id = ?', [$value2, $id2])->rowCount() < 1) {
        return false;
    }

    DB::commit();
    return true;
} catch (\PDOException $e) {
    DB::rollBack();
}
```
Get pdo object
```php
$pdo = DB::getPdo();
```
You can use pdo methods
```php
DB::query('SELECT * FROM table')->fetchAll();
```
Multiple database connections
```php
// connect to config1.
DB::connection(); /* or DB::connection('config1'); */
DB::query('SELECT * FROM table')->fetchAll();

// connect to config2. Now all requests will be from config2
DB::connection('config2');
DB::query('SELECT * FROM table')->fetchAll();

/* We return to config1. Now all requests will be from config1. We have already connected to config1, for performance,
 the DB class stores all connections in array, so there will not reconnection to config1.*/
DB::connection(); /* or DB::connection('config1'); */
DB::query('SELECT * FROM table')->fetchAll();
```
