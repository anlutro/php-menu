<?php

class MenuBuilderTest extends PHPUnit_Framework_TestCase
{
	protected function makeBuilder(array $options = array())
	{
		return new anlutro\Menu\Builder($options);
	}

	public function testCreateMenuIsStored()
	{
		$builder = $this->makeBuilder();
		$this->assertFalse($builder->hasMenu('left'));
		$builder->createMenu('left');
		$this->assertTrue($builder->hasMenu('left'));
		$this->assertInstanceOf('anlutro\Menu\Collection', $builder->getMenu('left'));
	}

	public function testRenderSimpleMenu()
	{
		$builder = $this->makeBuilder();
		$builder->createMenu('left');
		$builder->getMenu('left')->addItem('Test Item 1', '/url-1', ['class' => 'foo-bar']);
		$builder->getMenu('left')->addItem('Test Item 2', '/url-2', ['data-foo' => 'bar']);
		$builder->getMenu('left')->addSubmenu('Test Submenu');
		$builder->getMenu('left')->getItem('test-submenu')->addItem('Test Item 3', '/url-3');
		$builder->getMenu('left')->getItem('test-submenu')->addItem('Test Item 4', '/url-4');
		$str = $builder->render('left');
		$expected = str_replace(["\n","\t"], '', '<ul id="menu-left" class="nav navbar-nav">
		<li><a href="/url-1" class="foo-bar" id="test-item-1">Test Item 1</a></li>
		<li><a href="/url-2" data-foo="bar" id="test-item-2">Test Item 2</a></li>
		<li><a href="#" class="dropdown-toggle" id="test-submenu" data-toggle="dropdown">
		Test Submenu <b class="caret"></b></a><ul class="dropdown-menu">
		<li><a href="/url-3" id="test-item-3">Test Item 3</a></li>
		<li><a href="/url-4" id="test-item-4">Test Item 4</a></li>
		</ul></li></ul>');
		$this->assertEquals($expected, $str);
	}

	/** @test */
	public function setDefaultClasses()
	{
		$builder = $this->makeBuilder([
			'topMenuClass' => 'custom-top-class',
			'subMenuClass' => 'custom-sub-class',
			'subMenuToggleClass' => 'custom-sub-toggle-class',
		]);
		$builder->createMenu('left');
		$builder->getMenu('left')->addItem('Test Item 1', '/url-1', ['class' => 'foo-bar']);
		$builder->getMenu('left')->addItem('Test Item 2', '/url-2', ['data-foo' => 'bar']);
		$builder->getMenu('left')->addSubmenu('Test Submenu');
		$builder->getMenu('left')->getItem('test-submenu')->addItem('Test Item 3', '/url-3');
		$builder->getMenu('left')->getItem('test-submenu')->addItem('Test Item 4', '/url-4');
		$str = $builder->render('left');
		$expected = str_replace(["\n","\t"], '', '<ul id="menu-left" class="custom-top-class">
		<li><a href="/url-1" class="foo-bar" id="test-item-1">Test Item 1</a></li>
		<li><a href="/url-2" data-foo="bar" id="test-item-2">Test Item 2</a></li>
		<li><a href="#" class="custom-sub-toggle-class" id="test-submenu" data-toggle="dropdown">
		Test Submenu <b class="caret"></b></a><ul class="custom-sub-class">
		<li><a href="/url-3" id="test-item-3">Test Item 3</a></li>
		<li><a href="/url-4" id="test-item-4">Test Item 4</a></li>
		</ul></li></ul>');
		$this->assertEquals($expected, $str);
	}
}
