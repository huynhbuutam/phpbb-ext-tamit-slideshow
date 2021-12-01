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

class m3_acp_module extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_TAMIT_SLIDESHOW_TITLE'";
		$result = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function depends_on()
	{
		return array('\tamit\slideshow\migrations\v10x\m1_initial_schema');
	}

	/**
	 * Add the ACP module
	 *
	 * @return array Array of data update instructions
	 */
	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_TAMIT_SLIDESHOW_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_TAMIT_SLIDESHOW_TITLE',
				array(
					'module_basename'	=> '\tamit\slideshow\acp\main_module',
					'modes'				=> array('manage')
				)
			)),
			array('module.add', array(
				'acp',
				'ACP_TAMIT_SLIDESHOW_TITLE',
				array(
					'module_basename'	=> '\tamit\slideshow\acp\main_module',
					'modes'				=> array('settings')
				)
			))
		);
	}
}
