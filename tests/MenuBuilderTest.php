<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;

class MenuBuilderTest extends PHPUnit_Framework_TestCase
{
	protected function makeBuilder(array $options = array())
	{
		return new \anlutro\Menu\Builder($options);
	}

	public function testCreateMenuIsStored()
	{
		$builder = $this->makeBuilder();
		$this->assertFalse($builder->hasMenu('left'));
		$builder->createMenu('left');
		$this->assertTrue($builder->hasMenu('left'));
		$this->assertInstanceOf('anlutro\Menu\Collection', $builder->getMenu('left'));
	}

	public function testGetNested()
	{
		$builder = $this->makeBuilder();
		$this->assertFalse($builder->hasMenu('one.two.three'));
		$this->assertNull($builder->getMenu('one.two.three'));
		$menu = $builder->createMenu('one');
		$submenu1 = $menu->addSubmenu('two');
		$submenu2 = $submenu1->addSubmenu('three');
		$this->assertTrue($builder->hasMenu('one.two.three'));
		$this->assertSame($submenu2, $builder->getMenu('one.two.three'));
	}
}
