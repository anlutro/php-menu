<?php
namespace anlutro\Menu;

class Facade extends \Illuminate\Support\Facades\Facade
{
	protected static function getFacadeAccessor()
	{
		return 'anlutro\Menu\Builder';
	}
}
