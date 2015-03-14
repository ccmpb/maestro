# Maestro
Maestro, the Composer reflection library.
Use Maestro to get composer information about your project

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
