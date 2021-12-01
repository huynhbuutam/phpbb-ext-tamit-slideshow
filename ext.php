<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tamit\slideshow;

class ext extends \phpbb\extension\base
{
	const MAX_NAME_LENGTH = 255;
	
	/**
	 * {@inheritdoc}
	 *
	 * Require phpBB 3.2.1 due to use of $event->update_subarray()
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
	}
}
