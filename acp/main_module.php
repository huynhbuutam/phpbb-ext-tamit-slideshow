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

class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	/**
	 * Main ACP module
	 *
	 * @param	int			$id
	 * @param	string		$mode
	 * @return	void
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \tamit\slideshow\controller\admin_controller $admin_controller */
		$admin_controller = $phpbb_container->get('tamit.slideshow.admin.controller');

		// Send $u_action url to the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load template
		$this->tpl_name = $mode . '_slideshow';

		// Set page title
		$this->page_title = $admin_controller->get_page_title();

		// Switch mode
		$admin_controller->{'mode_' . $mode}();
	}
}
