<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;

class MenuCollectionTest extends PHPUnit_Framework_TestCase
{
	public function makeCollection()
	{
		return new \anlutro\Menu\Collection(new \anlutro\Menu\Builder());
	}

	public function testAddedItemsAreStored()
	{
		return;
		$coll = $this->makeCollection();
		$coll->addItem('Item 1 Title', '/url-1');
		$coll->addItem('Item 2 Title', '/url-2');

		$items = $coll->getItems();
		$this->assertEquals(2, count($items));
		$this->assertEquals('Item 1 Title', $items[0]->getTitle());
		$this->assertEquals('Item 1 Title', $items[1]->getUrl());
	}

	public function testGetMenuItemById()
	{
		$coll = $this->makeCollection();
		$coll->addItem('Test Item', '/foo-bar');
		$coll->addItem('Second Item', '/bar-baz');

		$item = $coll->getItem('test-item');
		$this->assertInstanceOf('anlutro\Menu\Nodes\AnchorNode', $item);
		$this->assertEquals('/foo-bar', $item->getUrl());

		$item = $coll->getItem('second-item');
		$this->assertInstanceOf('anlutro\Menu\Nodes\AnchorNode', $item);
		$this->assertEquals('/bar-baz', $item->getUrl());

		$this->assertEquals(null, $coll->getItem('nonexistant'));
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

	public function testCanRemoveItem()
	{
		$coll = $this->makeCollection();
		$coll->addItem('First Item', '/foo', [], 20);
		$coll->addItem('Second Item', '/foo', [], 10);
		$coll->removeItem('first-item');

		$this->assertNull($coll->getItem('first-item'));
		$this->assertNotNull($coll->getItem('second-item'));

		$str = $coll->render();
		$this->assertSame(false, strpos($str, 'First Item'));
		$this->assertNotSame(false, strpos($str, 'Second Item'));
	}
}
