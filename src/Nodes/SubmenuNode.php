<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Nodes;

use anlutro\Menu\Collection;

/**
 * A menu submenu item.
 */
class SubmenuNode extends AbstractNode implements NodeInterface
{
	/**
	 * The submenu items.
	 *
	 * @var \anlutro\Menu\Collection
	 */
	protected $submenu;

	/**
	 * @param string $title
	 * @param \anlutro\Menu\Collection $submenu
	 * @param array  $attributes
	 */
	public function __construct($title, Collection $submenu, array $attributes = array())
	{
		$this->title = $title;
		$this->submenu = $submenu;
		$this->attributes = $this->parseAttributes($attributes);
	}

	/**
	 * Get the item's submenu.
	 *
	 * @return \anlutro\Menu\Collection
	 */
	public function getSubmenu()
	{
		return $this->submenu;
	}

	public function getUrl()
	{
		return '#';
	}

	/**
	 * Forward missing method calls to the submenu collection if possible.
	 *
	 * @param  string $method
	 * @param  array $args
	 *
	 * @return mixed
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $args)
	{
		if (is_callable([$this->submenu, $method])) {
			return call_user_func_array([$this->submenu, $method], $args);
		}

		$class = get_class($this);
		throw new \BadMethodCallException("Call to undefined method $class::$method");
	}
}
