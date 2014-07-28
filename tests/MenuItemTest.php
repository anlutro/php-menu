<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;

class MenuItemTest extends PHPUnit_Framework_TestCase
{
	public function makeItem($title, $url, array $attribs = array())
	{
		return new \anlutro\Menu\Nodes\AnchorNode($title, $url, $attribs);
	}

	public function testRenderTitleAndUrl()
	{
		$item = $this->makeItem('foo', 'bar');
		$this->assertEquals('foo', $item->getTitle());
		$this->assertEquals('bar', $item->getUrl());
	}

	public function testDefaultIdIsSetFromTitle()
	{
		$item = $this->makeItem('foo bar baz', '');
		$attribs = $item->getAttributes();
		$this->assertEquals('foo-bar-baz', $attribs['id']);
	}

	public function testCustomIconResolver()
	{
		\anlutro\Menu\Nodes\AbstractNode::addIconResolvers(['custom' => __NAMESPACE__.'\CustomIcon']);
		$item = $this->makeItem('foo', 'bar', ['custom' => 'baz']);
		$this->assertInstanceOf(__NAMESPACE__.'\CustomIcon', $item->getIcon());
		$item = $this->makeItem('foo', 'bar', ['custom' => 'baz', 'glyphicon' => 'baz']);
		$this->assertInstanceOf(__NAMESPACE__.'\CustomIcon', $item->getIcon());
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
