<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;

class MenuSubmenuItemTest extends PHPUnit_Framework_TestCase
{
	public function makeItem($title, $submenu = null, array $attributes = array())
	{
		return new \anlutro\Menu\Nodes\SubmenuNode($title, $submenu ?: $this->makeCollection(), $attributes);
	}

	public function makeCollection()
	{
		return new \anlutro\Menu\Collection(new \anlutro\Menu\Builder());
	}

	public function testItemStoresCollection()
	{
		$coll = $this->makeCollection();
		$coll->addItem('Test Item 1', '/url-1');
		$coll->addItem('Test Item 2', '/url-2');
		$item = $this->makeItem('Submenu', $coll);
		$this->assertSame($coll, $item->getSubmenu());
	}
}
