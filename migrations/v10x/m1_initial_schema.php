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

/**
* Migration stage 1: Initial schema
*/
class m1_initial_schema extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'slideshow');
	}

	/**
	 * {@inheritDoc}
	 */
	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v316');
	}

	/**
	 * Add the slideshow table schema to the database:
	 *	slideshow:
	 *		slide_id
	 *		slide_title
	 *		slide_description
	 *		slide_image
	 *		slide_link
	 *		slide_position
	 *		slide_enabled
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'slideshow'	=> array(
					'COLUMNS'	=> array(
						'slide_id'				=> array('UINT', null, 'auto_increment'),
						'slide_title'			=> array('STEXT_UNI', ''),
						'slide_description'		=> array('MTEXT_UNI', ''),
						'slide_image'			=> array('STEXT_UNI', ''),
						'slide_link'			=> array('STEXT_UNI', ''),
						'slide_position'		=> array('USINT', 0),
						'slide_enabled'			=> array('BOOL', 0)
					),
					'PRIMARY_KEY'				=> 'slide_id'
				)
			)
		);
	}

	/**
	 * Drop the slideshow table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'slideshow',
			)
		);
	}
}
