<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Nodes;

class DividerNode implements NodeInterface
{
	protected $id;

	public function __construct($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return '';
	}

	public function getAttributes()
	{
		return [];
	}

	public function getUrl()
	{
		return '';
	}

	public function getIcon()
	{
		return null;
	}
}
