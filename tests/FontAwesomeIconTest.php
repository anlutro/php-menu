<?php
namespace anlutro\Menu\Tests;

use anlutro\Menu\Icons\FontAwesomeIcon as Icon;
use anlutro\Menu\Icons\FontAwesomeStack as Stack;
use PHPUnit_Framework_TestCase;
use Mockery as m;

class FontAwesomeIconTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function simpleRender()
	{
		$icon = new Icon('baz');
		$this->assertEquals('<i class="fa fa-baz"></i>', $icon->render());
		$icon = new Icon('baz 4x');
		$this->assertEquals('<i class="fa fa-baz fa-4x"></i>', $icon->render());
	}

	/** @test */
	public function stackRender()
	{
		$icons = [new Icon('foo stack-2x'), new Icon('baz stack-1x')];
		$stack = new Stack($icons, 'lg');
		$this->assertEquals('<span class="fa-stack fa-lg"><i class="fa fa-foo fa-stack-2x"></i><i class="fa fa-baz fa-stack-1x"></i></span>', $stack->render());
	}
}
