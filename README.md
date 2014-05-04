# Menu Builder

Simple dynamic menu building system.

PHP framework agnostic. Uses Twitter Bootstrap 3 class names and is not very configurable in that regard (yet?).

## Installation

`composer require anlutro/menu` - pick the latest tag visible in the github tag list or on packagist.

#### Laravel 4

Add `anlutro\Menu\ServiceProvider` to the list of providers in app/config/app.php. Optionally, add an alias for `'Menu' => 'anlutro\Menu\Facade'` as well. The menu builder instance can be accessed via the facade or via automatic dependency injection by type hinting.

Do `artisan config:publish anlutro/menu` to change the default Bootstrap 3-specific settings.

## Usage

Set up a shared instance of Menu\Builder. Create the menus you need.

```php
$builder = new anlutro\Menu\Builder;
$menu = $builder->createMenu('left');
```

By default, Bootstrap 3-specific classes are used. If you want to use something else, pass an array of custom data into the Builder's constructor. You can see what the default settings look like [here](https://github.com/anlutro/php-menu/blob/master/src/config/config.php).

If you're using Laravel 4, you can use `Menu::` instead of `$builder->` provided you set up an alias as shown in the installation instructions above.

From here, you can add items to your menus from anywhere.

```php
$menu->addItem('Item 1', '/my-uri');

// you can add custom html attributes to your items
$menu->addItem('Item 2', '/my-uri', ['class' => 'custom-class']);

// use priorities to push items to the top or bottom of your menu
// items have priority 0 by default.
$menu->addItem('First item', '/my-uri', [], -50);
$menu->addItem('Last item', '/my-uri', [], 50);
```

Adding submenus works similarly.

```php
$submenu = $menu->addSubmenu('Sub Menu');
$submenu->addItem('Sub item 1', '/my-uri');
```

When you want to render a menu, call render($menu) and echo it.

```php
echo $builder->render('left');
```

## Contact

Open an issue on GitHub if you have any problems or suggestions.

## License

The contents of this repository is released under the [MIT license](http://opensource.org/licenses/MIT).
