# Menu Builder

Simple dynamic menu building system.

PHP framework agnostic. Uses Twitter Bootstrap 3 class names and is not very configurable in that regard (yet?).

## Installation

`composer require anlutro/menu` - pick the latest tag visible in the github tag list or on packagist.

#### Laravel 4

Add `anlutro\Menu\ServiceProvider` to the list of providers in app/config/app.php. Optionally, add an alias for `'Menu' => 'anlutro\Menu\Facade'` as well. The menu builder instance can be accessed via the facade or via automatic dependency injection by type hinting.

## Usage

Documentation is under construction.

```php
$builder = new anlutro\Menu\Builder;
$builder->createMenu('left');
$builder->getMenu('left')->addItem('Foo Bar', URL::to('foo-bar'));
$builder->getMenu('left')->addItem('Bar Baz', URL::to('bar-baz'));
$builder->getMenu('left')->addSubmenu('Sub Menu');
$builder->getMenu('left')->getItem('sub-menu')->addItem('Baz Foo', URL::to('baz-foo'));
echo $builder->render('left');
```

## Contact

Open an issue on GitHub if you have any problems or suggestions.

## License

The contents of this repository is released under the [MIT license](http://opensource.org/licenses/MIT).