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

class m2_initial_data extends \phpbb\db\migration\migration
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
			array('config.add', array('tamit_slideshow_page_index', 1)),
			array('config.add', array('tamit_slideshow_page_viewforum', 0)),
			array('config.add', array('tamit_slideshow_page_viewtopic', 0)),
			array('config.add', array('tamit_slideshow_duration', 10000)),
			array('config.add', array('tamit_slideshow_box', 1)),
			array('config.add', array('tamit_slideshow_nav_image', 1)),
			array('config.add', array('tamit_slideshow_nav_dot', 1)),
			array('config.add', array('tamit_slideshow_mode', 0)),
			array('config.add', array('tamit_slideshow_topic_max_length', 200)),
			array('config.add', array('tamit_slideshow_topic_hide_protected_forum', 1)),
			array('config.add', array('tamit_slideshow_topic_count', 10)),
			array('config.add', array('tamit_slideshow_topic_hide_bbcode', '')),
			array('config.add', array('tamit_slideshow_default_image', ''))
		);
	}
}
