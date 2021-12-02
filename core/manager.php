<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tamit\slideshow\core;

class manager
{
	/** @var \phpbb\auth\auth */
	protected $auth;
	
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $slideshow_table;

	/**
	 * Constructor
	 *
	 * @param	\phpbb\auth\auth					$auth				Auth object
	 * @param	\phpbb\db\driver\driver_interface	$db					DB driver interface
	 * @param	\phpbb\config\config				$config				Config object
	 * @param	string								$php_ext			PHP extension
	 * @param	string								$phpbb_root_path	phpBB root path
	 * @param	string								$slideshow_table	Slideshow table
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, $php_ext, $phpbb_root_path, $slideshow_table)
	{
		$this->auth = $auth;
		$this->db = $db;
		$this->config = $config;
		$this->php_ext = $php_ext;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->slideshow_table = $slideshow_table;
	}

	/**
	 * Get specific slide
	 *
	 * @param	int		$slide_id	Slide ID
	 * @return	array				Array with slide data
	 */
	public function get_slide($slide_id)
	{
		$sql = 'SELECT *
			FROM ' . $this->slideshow_table . '
			WHERE slide_id = ' . (int) $slide_id;
		$result = $this->db->sql_query($sql);
		$data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		
		return $data !== false ? $data : array();
	}

	/**
	 * Get enabled slides.
	 *
	 * @return	array		List of enabled slides
	 */
	public function get_enabled_slides()
	{
		$sql = 'SELECT *
			FROM ' . $this->slideshow_table . '
			WHERE slide_enabled = 1
			ORDER BY slide_position ASC';
		$result = $this->db->sql_query($sql);
		$data = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $data;
	}

	/**
	 * Get all slides.
	 *
	 * @return	array		List of all slides
	 */
	public function get_all_slides()
	{
		$sql = 'SELECT *
			FROM ' . $this->slideshow_table . '
			ORDER BY slide_position ASC';
		$result = $this->db->sql_query($sql);
		$data = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $data;
	}
	
	/**
	 * Get forum id of a post or topic
	 *
	 * @param	int		$id				Topic id or post id
	 * @param	bool	$is_post		Topic id or post id
	 * @return	int						Forum id
	 */
	public function get_forum_id($id, $is_post)
	{
		$sql = 'SELECT forum_id
			FROM ' . ($is_post ? POSTS_TABLE : TOPICS_TABLE) . '
			WHERE ' . ($is_post ? 'post_id' : 'topic_id') . ' = ' . (int) $id;
		$result = $this->db->sql_query($sql);
		
		return (int) $this->db->sql_fetchrow($result);
	}
	
	/**
	 * Get newest topics
	 *
	 * @param	array	$forum_ids		Array of forum ids. We assume the maximum forum id is 500
	 * @param	int		$search_limit	Number of topics to take
	 * @return	array					Array with newest topics data
	 */
	public function get_newest_topics($forum_id, $search_limit = 10)
	{
		if ($forum_id == 0)
		{
			$forum_ids = range(1, 500);
		}
		else
		{
			$forum_ids = array($forum_id);
		}
		
		$forum_id_where = $this->create_where_clauses($forum_ids, 'forum');
		$forum_id_where = str_replace(array('WHERE ', 'forum_id'), array('', 't.forum_id'), $forum_id_where);
	
		// No forum/permission to read
		if (strlen($forum_id_where) == 0)
		{
			return array();
		}
	
		$posts_ary = array(
			'SELECT'	=> 'p.*, t.*',
			'FROM'		=> array(
				POSTS_TABLE     => 'p'
			),
			'LEFT_JOIN' => array(
				array(
					'FROM'  	=> array(TOPICS_TABLE => 't'),
					'ON'    	=> 't.topic_first_post_id = p.post_id'
				)
			),
			'WHERE'		=> (strlen($forum_id_where) > 0 ? $forum_id_where . ' AND ' : '') . '
							t.topic_status <> ' . ITEM_MOVED . '
							AND t.topic_visibility = 1',
			'ORDER_BY'  => 't.topic_id DESC'
		);
		
		$sql = $this->db->sql_build_query('SELECT', $posts_ary);
		$result = $this->db->sql_query_limit($sql, $search_limit);
		$data = array();
		while ($posts_row = $this->db->sql_fetchrow($result))
		{
			$topic_title = $posts_row['topic_title'];
			$topic_link = append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, array('f' => $posts_row['forum_id'], 't' => $posts_row['topic_id']));
			$post_text = $posts_row['post_text'];
			
			// Get slide image from config
			$post_image = $this->config['tamit_slideshow_default_image'];
			if (strlen($post_image) == 0)
			{
				$post_image = $this->phpbb_root_path . '/ext/tamit/slideshow/styles/all/theme/no-image.png';
			}
			// Get slide image from topic (url)
			$post_images = array();
			preg_match('/<IMG src="(.*?)"><s>\[img\]<\/s>/i', $post_text, $post_images);
			if (sizeof($post_images) > 0)
			{
				$post_image = $post_images[1];
			}
			// Get slide image from topic (inline attachment)
			preg_match('/<ATTACHMENT filename=".*?(?:\.jpg|\.png|\.jpeg|\.bmp|\.gif|\.svg)" index="([0-9]+)"><s>\[attachment=[0-9]+\]<\/s>/i', $post_text, $post_images);
			if (sizeof($post_images) > 0)
			{
				$sql2 = 'SELECT attach_id
						FROM ' . ATTACHMENTS_TABLE . '
						WHERE post_msg_id = ' . (int) $posts_row['post_id'] . '
						ORDER BY attach_id DESC';
				$result2 = $this->db->sql_query($sql2);
				$posts_row2 = $this->db->sql_fetchrowset($result2);
				$post_image = $posts_row2[$post_images[1]]['attach_id'];
				$post_image = $this->phpbb_root_path . 'download/file.php?id=' . $post_image . '&amp;mode=view';
				$this->db->sql_freeresult($result2);
			}
			// Hide BBCode content
			$bbcodes = $this->config['tamit_slideshow_topic_hide_bbcode'];
			if (strlen($bbcodes) > 0)
			{
				$bbcodeArr = explode(',', $bbcodes);
				foreach ($bbcodeArr as $bbcode)
				{
					$post_text = preg_replace('/(<' . preg_quote(trim($bbcode)) . '.*?' . preg_quote(trim($bbcode)) . '\]<\/e><\/' . preg_quote(trim($bbcode)) . '>)/i', '', $post_text);
				}
			}
			// Clean description
			strip_bbcode($post_text);
			censor_text($post_text);
			
			if (strlen($post_text) > 200)
			{
				$post_text = substr($post_text, 0, 200);
				$post_text = $post_text . '...';
			}

			$slide = array(
				'slide_title'		=> $topic_title,
				'slide_description'	=> $post_text,
				'slide_image'		=> $post_image,
				'slide_link'		=> $topic_link
			);
			array_push($data, $slide);
		}
		$this->db->sql_freeresult($result);

		return $data !== false ? $data : array();
	}

	/**
	 * Insert slide
	 *
	 * @param	array	$data	New slide data
	 * @return	int				New slide ID
	 */
	public function insert_slide($data)
	{
		$data = $this->intersect_slide_data($data);
		$sql = 'SELECT MAX(slide_position)+1 AS position FROM ' . $this->slideshow_table;
		$result = $this->db->sql_query($sql);
		// Make this as the last position
		$data['slide_position'] = (int) $this->db->sql_fetchfield('position');
		$this->db->sql_freeresult($result);
		
		// Correction for the first slide
		if ($data['slide_position'] <= 0)
		{
			$data['slide_position'] = 1;
		}
		
		// Encode Emoji
		$data['slide_title'] = $this->string_entities($data['slide_title']);
		$data['slide_description'] = $this->string_entities($data['slide_description']);

		// Add a row to slideshow table
		$sql = 'INSERT INTO ' . $this->slideshow_table . ' ' . $this->db->sql_build_array('INSERT', $data);
		$this->db->sql_query($sql);
		$slide_id = $this->db->sql_nextid();

		return $slide_id;
	}

	/**
	 * Update slide
	 *
	 * @param	int		$slide_id	Slide ID
	 * @param	array	$data		List of data to update in the database
	 * @return	int					Number of affected rows. Can be used to determine if any slide has been updated.
	 */
	public function update_slide($slide_id, $data)
	{
		$data = $this->intersect_slide_data($data);

		// Encode Emoji
		$data['slide_title'] = $this->string_entities($data['slide_title']);
		$data['slide_description'] = $this->string_entities($data['slide_description']);
		
		$sql = 'UPDATE ' . $this->slideshow_table . '
			SET ' . $this->db->sql_build_array('UPDATE', $data) . '
			WHERE slide_id = ' . (int) $slide_id;
		$this->db->sql_query($sql);

		return $this->db->sql_affectedrows();
	}

	/**
	 * Fix slide position
	 *
	 * @return	int		Number of affected rows. Can be used to determine if any slide has been updated.
	 */
	public function fix_positions()
	{
		$fixed = 0;
		$pos = 0;
		
		$sql = 'SELECT slide_id
			FROM ' . $this->slideshow_table . '
			ORDER BY slide_position ASC';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$pos++;
			$sql = 'UPDATE ' . $this->slideshow_table . ' 
				SET slide_position = ' . $pos . ' 
				WHERE slide_id = ' . (int) $row['slide_id'];
			$this->db->sql_query($sql);
			$fixed += $this->db->sql_affectedrows();
		}
		$this->db->sql_freeresult($result);
		
		return $fixed;
	}

	/**
	 * Delete slide
	 *
	 * @param	int		$slide_id	Slide ID
	 * @return	int					Number of affected rows. Can be used to determine if any slide has been deleted.
	 */
	public function delete_slide($slide_id)
	{
		$sql = 'DELETE FROM ' . $this->slideshow_table . '
			WHERE slide_id = ' . (int) $slide_id;
		$this->db->sql_query($sql);

		return $this->db->sql_affectedrows();
	}

	/**
	 * Enable/disable slide
	 *
	 * @param	int		$slide_id	Slide ID
	 * @param	bool	$enable		Enable or disable the slide?
	 * @return	int					Number of affected rows. Can be used to determine if any slide has been updated.
	 */
	public function toggle_slide($slide_id, $enable)
	{
		$sql = 'UPDATE ' . $this->slideshow_table . '
			SET slide_enabled = ' . (int) $enable . '
			WHERE slide_id = ' . (int) $slide_id;
		$this->db->sql_query($sql);

		return $this->db->sql_affectedrows();
	}
	
	/**
	 * Move slide up or down
	 *
	 * @param	int		$slide_id	Slide ID
	 * @return	int					Number of affected rows. Can be used to determine if any slide has been updated.
	 */
	public function move_slide($slide_id, $up)
	{
		$base_data = $this->get_slide($slide_id);
		
		$sql = 'SELECT *
			FROM ' . $this->slideshow_table;
		if ($up)
		{
			$sql .= ' WHERE slide_position < ' . (int) $base_data['slide_position'] . '
			ORDER BY slide_position DESC';
		}
		else
		{
			$sql .= ' WHERE slide_position > ' . (int) $base_data['slide_position'] . '
			ORDER BY slide_position ASC';
		}
		$result = $this->db->sql_query($sql);
		$target_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$success = 0;
		if ($target_data)
		{
			$sql = 'UPDATE ' . $this->slideshow_table . ' 
				SET slide_position = ' . $target_data['slide_position'] . ' 
				WHERE slide_id = ' . (int) $base_data['slide_id'];
			$this->db->sql_query($sql);
			$success += $this->db->sql_affectedrows();
			
			$sql = 'UPDATE ' . $this->slideshow_table . ' 
				SET slide_position = ' . $base_data['slide_position'] . ' 
				WHERE slide_id = ' . (int) $target_data['slide_id'];
			$this->db->sql_query($sql);
			$success += $this->db->sql_affectedrows();
		}
		return $success;
	}
	
	/**
	 * Keep only necessary slide data
	 *
	 * @param	array	$data	List of data
	 * @return	array			Necessary data that contain only valid keys
	 */
	protected function intersect_slide_data($data)
	{
		return array_intersect_key($data, array(
			'slide_title'			=> '',
			'slide_description'		=> '',
			'slide_image'			=> '',
			'slide_link'			=> '',
			'slide_position'		=> 0,
			'slide_enabled'			=> 0
		));
	}
	
	/**
	* Create where clauses
	*
	* @param	array	$gen_id		Array of forum id or topic id
	* @param	string	$type		Forum or topic
	* @return	string				An SQL WHERE statement for use when grabbing posts and topics
	*/
	// https://wiki.phpbb.com/Practical.Displaying_posts_and_topics_on_external_pages
	protected function create_where_clauses($gen_id, $type)
	{
		$size_gen_id = sizeof($gen_id);

		switch ($type)
		{
			case 'forum':
				$type = 'forum_id';
				break;
			case 'topic':
				$type = 'topic_id';
				break;
			default:
				return '';
		}

		// Set $out_where to nothing, this will be used of the gen_id
		// size is empty, in other words "grab from anywhere" with
		// no restrictions
		$out_where = '';

		if ($size_gen_id > 0 )
		{
			// Get a list of all forums the user has permissions to read
			$auth_f_read = array_keys($this->auth->acl_getf('f_read', true));

			if ($type == 'topic_id')
			{
				$sql = 'SELECT topic_id FROM ' . TOPICS_TABLE . '
						WHERE ' . $this->db->sql_in_set('topic_id', $gen_id) . '
						AND ' . $this->db->sql_in_set('forum_id', $auth_f_read);

				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					// Create an array with all acceptable topic ids
					$topic_id_list[] = $row['topic_id'];
				}

				unset($gen_id);

				$gen_id = $topic_id_list;
				$size_gen_id = sizeof($gen_id);
			}

			$j = 0;    

			for ($i = 0; $i < $size_gen_id; $i++)
			{
				$id_check = (int) $gen_id[$i];

				// If the type is topic, all checks have been made and the query can start to be built
				if ($type == 'topic_id')
				{
					$out_where .= ($j == 0) ? 'WHERE ' . $type . ' = ' . $id_check . ' ' : 'OR ' . $type . ' = ' . $id_check . ' ';
				}

				// If the type is forum, do the check to make sure the user has read permissions
				else if ($type == 'forum_id' && $this->auth->acl_get('f_read', $id_check))
				{
					$out_where .= ($j == 0) ? 'WHERE ' . $type . ' = ' . $id_check . ' ' : 'OR ' . $type . ' = ' . $id_check . ' ';
				}    

				$j++;
			}
		}

		return $out_where;
	}
	
	/**
	* String entities
	*
	* @param	string	$str		Input string
	* @return	string				Encoded string
	*/
	public function string_entities($str)
	{
		if (empty($str))
		{
			return "";
		}
		
		$stringBuilder = "";
		$offset = 0;

		while ($offset >= 0)
		{
			$decValue = $this->ord_utf8($str, $offset);
			
			if ($decValue >= 128)
			{
				$stringBuilder .= "&#" . $decValue . ";";
			}
			else
			{
				$stringBuilder .= mb_convert_encoding('&#' . intval($decValue) . ';', 'UTF-8', 'HTML-ENTITIES');
			}
		}

		return $stringBuilder;
	}
	
	/**
	* Binary value of a UTF-8 character
	*
	* @param	string	$str		Input string
	* @param	string	&$offset	Current offset
	* @return	int					Decimal value
	*/
	// http://php.net/manual/en/function.ord.php#109812
	protected function ord_utf8($str, &$offset)
	{
		$code = ord(substr($str, $offset,1));
		
		// If larger or equal to 4 bytes
		if ($code >= 128)
		{
			if ($code < 224)
			{
				$bytesnumber = 2;
			}
			else if ($code < 240)
			{
				$bytesnumber = 3;
			}
			else if ($code < 248)
			{
				$bytesnumber = 4;
			}
			
			$codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
			
			for ($i = 2; $i <= $bytesnumber; $i++)
			{
				$offset++;
				$code2 = ord(substr($str, $offset, 1)) - 128;
				$codetemp = $codetemp * 64 + $code2;
			}
			
			$code = $codetemp;
		}
		
		$offset += 1;
		
		if ($offset >= strlen($str)) $offset = -1;
		
		return $code;
	}
}
