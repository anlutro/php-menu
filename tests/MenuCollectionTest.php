<?php

use Mockery as m;

class MenuCollectionTest extends PHPUnit_Framework_TestCase
{
	public function makeCollection()
	{
		return new anlutro\Menu\Collection(new \anlutro\Menu\Builder());
	}

	public function testAddedItemsAreStored()
	{
		return;
		$coll = $this->makeCollection();
		$coll->addItem('Item 1 Title', '/url-1');
		$coll->addItem('Item 2 Title', '/url-2');

		$items = $coll->getItems();
		$this->assertEquals(2, count($items));
		$this->assertEquals('Item 1 Title', $items[0]->renderTitle());
		$this->assertEquals('Item 1 Title', $items[1]->renderUrl());
	}

	public function testGetMenuItemById()
	{
		$coll = $this->makeCollection();
		$coll->addItem('Test Item', '/foo-bar');
		$coll->addItem('Second Item', '/bar-baz');

		$item = $coll->getItem('test-item');
		$this->assertInstanceOf('anlutro\Menu\Item', $item);
		$this->assertEquals('/foo-bar', $item->renderUrl());

		$item = $coll->getItem('second-item');
		$this->assertInstanceOf('anlutro\Menu\Item', $item);
		$this->assertEquals('/bar-baz', $item->renderUrl());

		$this->assertEquals(null, $coll->getItem('nonexistant'));
	}

	public function testSimpleRender()
	{
		$coll = $this->makeCollection();
		$coll->addItem('Test Item', '/foo-bar');
		$coll->addItem('Second Item', '/bar-baz');

		$str = $coll->render();
		$this->assertContains('Test Item', $str);
		$this->assertContains('Second Item', $str);
		$this->assertContains('<a href="/foo-bar', $str);
		$this->assertContains('<a href="/bar-baz', $str);
		$this->assertContains('id="menu-item--test-item"', $str);
		$this->assertContains('id="menu-item--second-item"', $str);
	}

	public function testAddWithPriorities()
	{
		$coll = $this->makeCollection();
		$coll->addItem('First Item', '/foo', [], 20);
		$coll->addItem('Second Item', '/foo', [], 10);

		$str = $coll->render();
		$this->assertTrue(strpos($str, 'First Item') > strpos($str, 'Second Item'),
			'Second Item should come before First Item.'.PHP_EOL.$str);
	}
}
