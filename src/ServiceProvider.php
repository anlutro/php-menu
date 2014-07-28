<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->app->bindShared('anlutro\Menu\Builder', function($app) {
			return new Builder();
		});
	}

	public function provides()
	{
		return array('anlutro\Menu\Builder');
	}
}
