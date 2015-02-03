<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Nodes;

/**
 * A menu item.
 */
class AnchorNode extends AbstractNode implements NodeInterface
{
	/**
	 * The URL the item links to.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * @param string $title
	 * @param string $url
	 * @param array  $attributes
	 */
	public function __construct($title, $url, array $attributes = array())
	{
		$this->title = $title;
		$this->url = $url;
		$this->attributes = $this->parseAttributes($attributes);
	}

	public function getUrl()
	{
		return $this->url;
	}
}
