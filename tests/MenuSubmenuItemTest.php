<?php

use Mockery as m;

class MenuSubmenuItemTest extends PHPUnit_Framework_TestCase
{
	public function makeItem($title, $submenu = null, array $attributes = array())
	{
		return new anlutro\Menu\SubmenuItem($title, $submenu ?: $this->makeCollection(), $attributes);
	}

	public function makeCollection()
	{
		return new anlutro\Menu\Collection();
	}

	public function testItemStoresCollection()
	{
		$coll = $this->makeCollection();
		$coll->addItem('Test Item 1', '/url-1');
		$coll->addItem('Test Item 2', '/url-2');
		$item = $this->makeItem('Submenu', $coll);
		$this->assertSame($coll, $item->getSubmenu());
	}

	public function testRenderCallsSubmenuRender()
	{
		$coll = m::mock('anlutro\Menu\Collection');
		$coll->shouldReceive('render')->once()->andReturn('foo bar baz');
		$item = $this->makeItem('Submenu', $coll);
		$str = $item->render();
		$this->assertContains('foo bar baz', $str);
		m::close();
	}

	public function testSimpleRender()
	{
		$item = $this->makeItem('Submenu');
		$item->addItem('Test Item 1', '/url-1');
		$item->addItem('Test Item 2', '/url-2');
		$str = $item->render();
		$this->assertContains('<ul', $str);
		$this->assertContains('Test Item 1', $str);
		$this->assertContains('Test Item 2', $str);
	}
}
