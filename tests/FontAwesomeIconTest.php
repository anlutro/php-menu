<?php
namespace anlutro\Menu\Tests;

use PHPUnit_Framework_TestCase;
use anlutro\Menu\Icons\FontAwesomeIcon as Icon;
use anlutro\Menu\Icons\FontAwesomeStack as Stack;

class FontAwesomeIconTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function simpleRender()
	{
		$icon = Icon::createFromAttribute('baz');
		$this->assertEquals('<i class="fa fa-baz"></i>', $icon->render());
		$icon = Icon::createFromAttribute('baz 4x');
		$this->assertEquals('<i class="fa fa-baz fa-4x"></i>', $icon->render());
	}

	/** @test */
	public function stackRender()
	{
		$icons = [Icon::createFromAttribute('foo stack-2x'), Icon::createFromAttribute('baz stack-1x')];
		$stack = Stack::createFromAttribute(['lg', $icons]);
		$this->assertEquals('<span class="fa-stack fa-lg"><i class="fa fa-foo fa-stack-2x"></i><i class="fa fa-baz fa-stack-1x"></i></span>', $stack->render());
	}
}
