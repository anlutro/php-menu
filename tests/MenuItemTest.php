<?php

class MenuItemTest extends PHPUnit_Framework_TestCase
{
	public function makeItem($title, $url, array $attribs = array())
	{
		return new anlutro\Menu\Item($title, $url, $attribs);
	}

	public function testRenderTitleAndUrl()
	{
		$item = $this->makeItem('foo', 'bar');
		$this->assertEquals('foo', $item->renderTitle());
		$this->assertEquals('bar', $item->renderUrl());
	}

	public function testRenderAttributes()
	{
		$item = $this->makeItem('', '', ['id' => 'foobar', 'data-foo' => 'baz']);
		$this->assertEquals('id="menu-item--foobar" data-foo="baz"', $item->renderAttributes());
	}

	public function testDefaultIdIsSetFromTitle()
	{
		$item = $this->makeItem('foo bar baz', '');
		$this->assertEquals('id="menu-item--foo-bar-baz"', $item->renderAttributes());
	}

	public function testRenderGlyphicon()
	{
		$item = $this->makeItem('foo', 'bar', ['glyphicon' => 'baz']);
		$this->assertEquals('<a href="bar" id="menu-item--foo"><span class="glyphicon glyphicon-baz"></span> foo</a>', $item->render());
	}

	public function testRenderFAIcon()
	{
		$item = $this->makeItem('foo', 'bar', ['fa-icon' => 'baz']);
		$this->assertEquals('<a href="bar" id="menu-item--foo"><i class="fa fa-baz"></i> foo</a>', $item->render());

		$item = $this->makeItem('foo', 'bar', ['fa-icon' => 'baz 4x']);
		$this->assertEquals('<a href="bar" id="menu-item--foo"><i class="fa fa-baz fa-4x"></i> foo</a>', $item->render());
	}

	public function testCustomIconResolver()
	{
		\anlutro\Menu\Item::addIconResolvers(['custom' => 'CustomIcon']);
		$item = $this->makeItem('foo', 'bar', ['custom' => 'baz']);
		$this->assertEquals('<a href="bar" id="menu-item--foo">custom-icon foo</a>', $item->render());
		$item = $this->makeItem('foo', 'bar', ['custom' => 'baz', 'glyphicon' => 'baz']);
		$this->assertEquals('<a href="bar" id="menu-item--foo">custom-icon foo</a>', $item->render());
	}
}

class CustomIcon implements \anlutro\Menu\Icons\IconInterface
{
	public function render()
	{
		return 'custom-icon';
	}

	public static function createFromAttribute($attribute)
	{
		return new static;
	}
}
