<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tamit\slideshow\migrations\v10x;

class m4_initial_data extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public static function depends_on()
	{
		return array('\tamit\slideshow\migrations\v10x\m1_initial_schema');
	}

	/**
	 * Add config
	 *
	 * @return array Array of data update instructions
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('tamit_slideshow_slide_height', 250)),
			array('config.add', array('tamit_slideshow_image_nav_width', 150)),
			array('config.add', array('tamit_slideshow_image_nav_height', 80))
		);
	}
}
