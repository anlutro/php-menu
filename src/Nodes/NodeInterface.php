<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Nodes;

interface NodeInterface
{
	/**
	 * Get the unique ID string for the node.
	 *
	 * @return string
	 */
	public function getId();

	/**
	 * Get the title of the node.
	 *
	 * @return string
	 */
	public function getTitle();

	/**
	 * Get the node's attributes.
	 *
	 * @return array
	 */
	public function getAttributes();

	/**
	 * Get the node's URL.
	 *
	 * @return string
	 */
	public function getUrl();

	/**
	 * Get the node's icon.
	 *
	 * @return \anlutro\Menu\Icons\IconInterface|null
	 */
	public function getIcon();
}
