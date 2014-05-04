<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu;

use Illuminate\Support\Str;

/**
 * A menu submenu item.
 */
class SubmenuItem extends AbstractItem implements ItemInterface
{
	/**
	 * The submenu items.
	 *
	 * @var \anlutro\Menu\Collection
	 */
	protected $submenu;

	/**
	 * The submenu's affix.
	 *
	 * @var string
	 */
	protected $affix;

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
	 * {@inheritdoc}
	 */
	protected function parseAttributes(array $in)
	{
		if (isset($in['affix'])) {
			$this->affix = $in['affix'];
		}

		$out = parent::parseAttributes($in);

		return $out;
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

	/**
	 * {@inheritdoc}
	 */
	public function renderUrl()
	{
		return '#';
	}

	/**
	 * {@inheritdoc}
	 */
	public function renderTitle()
	{
		$affix = $this->affix ? ' '.$this->affix : '';
		return parent::renderTitle() . $affix;
	}

	/**
	 * {@inheritdoc}
	 */
	public function render()
	{
		return parent::render() . $this->submenu->render();
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
