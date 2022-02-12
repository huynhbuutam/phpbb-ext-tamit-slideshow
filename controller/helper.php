<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tamit\slideshow\controller;

class helper
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \tamit\slideshow\core\manager */
	protected $manager;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user						$user			User object
	 * @param \phpbb\language\language			$language		Language object
	 * @param \phpbb\template\template			$template		Template object
	 * @param \phpbb\log\log					$log			The phpBB log system
	 * @param \tamit\slideshow\core\manager		$manager		Slideshow manager object
	 */
	public function __construct(\phpbb\user $user, \phpbb\language\language $language, \phpbb\template\template $template, \phpbb\log\log $log, \tamit\slideshow\core\manager $manager)
	{
		$this->user = $user;
		$this->language = $language;
		$this->template = $template;
		$this->log = $log;
		$this->manager = $manager;
	}

	/**
	 * Assign slide data to the template.
	 *
	 * @param	array	$data		Slide data
	 * @param	array	$errors		Validation errors
	 */
	public function assign_data($data, $errors)
	{
		$errors = array_map(array($this->language, 'lang'), $errors);
		$this->template->assign_vars(array(
			'S_ERROR'   => (bool) count($errors),
			'ERROR_MSG' => count($errors) ? implode('<br />', $errors) : '',

			'SLIDE_TITLE'			=> $data['slide_title'],
			'SLIDE_DESCRIPTION'		=> $data['slide_description'],
			'SLIDE_IMAGE'			=> $data['slide_image'],
			'SLIDE_LINK'			=> $data['slide_link'],
			'SLIDE_ENABLED'			=> $data['slide_enabled']
		));
	}

	/**
	 * Log action
	 *
	 * @param	string	$action			Performed action in uppercase
	 * @param	string	$slide_title	Slide name
	 * @return	void
	 */
	public function add_log($action, $slide_title)
	{
		// Encode Emoji
		$slide_title = $this->manager->string_entities($slide_title);
		
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_TAMIT_SLIDESHOW_' . $action . '_LOG', time(), array($slide_title));
	}
}
