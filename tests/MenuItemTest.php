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
		$this->assertEquals('id="foobar" data-foo="baz"', $item->renderAttributes());
	}

	public function testDefaultIdIsSetFromTitle()
	{
		$item = $this->makeItem('foo bar baz', '');
		$this->assertEquals('id="foo-bar-baz"', $item->renderAttributes());
	}

	public function testRenderGlyphicon()
	{
		$item = $this->makeItem('foo', 'bar', ['glyphicon' => 'baz']);
		$this->assertEquals('<span class="glyphicon glyphicon-baz"></span> foo', $item->renderTitle());
	}
}
