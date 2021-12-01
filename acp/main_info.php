<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tamit\slideshow\acp;

class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\tamit\slideshow\acp\main_module',
			'title'		=> 'ACP_TAMIT_SLIDESHOW_TITLE',
			'modes'		=> array(
				'manage'	=> array(
					'title'	=> 'ACP_MANAGE_SLIDES_TITLE',
					'auth'	=> 'ext_tamit/slideshow && acl_a_board',
					'cat'	=> array('ACP_TAMIT_SLIDESHOW_TITLE')
				),
				'settings'	=> array(
					'title'	=> 'ACP_SLIDESHOW_SETTINGS_TITLE',
					'auth'	=> 'ext_tamit/slideshow && acl_a_board',
					'cat'	=> array('ACP_TAMIT_SLIDESHOW_TITLE')
				),
			),
		);
	}
}
