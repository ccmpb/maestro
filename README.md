# Maestro
Maestro, the Composer reflection library.
Use Maestro to get information about your project from
[Composer](https://getcomposer.org)

### Installation via composer
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/colincode/maestro.git"
    }
]
```
```json
    "maestro": "dev-master"
```

### Create a new Maestro object
```php
    $maestro = new Maestro(PROJECT_ROOT);
```

### Get project name
```php
    $name = $maestro->getName();
```

### Get project authors 
```php
    $authors = $maestro->getAuthors();
```

### Get composer option that does not have a convenience function for it 
```php
    $license = $maestro->getConfigValue('license');
```

### Get composer PSR4 autoload mapping info
```php 
    $psr4 = $maestro->getAutoloadPsr4();
```

### Get the base directory of a namespace
```php
    $base = $maestro->getBaseDir(__NAMESPACE__);
```
