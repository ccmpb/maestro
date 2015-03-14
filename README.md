# maestro
Maestro the Composer reflection library.

## Use Maestro to get composer information about your project

### Get project name
```php
    $maestro = new Maestro(PROJECT_ROOT);
    $name = $maestro->getName();
```

### Get project authors 
```php
    $maestro = new Maestro(PROJECT_ROOT);
    $name = $maestro->getAuthors();
```

### Get composer option that does not have a convenience function for it 
```php
    $maestro = new Maestro(PROJECT_ROOT);
    $license = $maestro->getConfigValue('license');
```
