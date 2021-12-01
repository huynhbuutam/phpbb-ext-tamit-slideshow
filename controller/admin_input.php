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

use tamit\slideshow\ext;

class admin_input
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \tamit\slideshow\core\upload_image */
	protected $upload_image;

	/** @var array Form validation errors */
	protected $errors = array();

	/**
	 * Constructor
	 *
	 * @param \phpbb\user							$user			User object
	 * @param \phpbb\language\language				$language		Language object
	 * @param \phpbb\request\request				$request		Request object
	 * @param \tamit\slideshow\core\upload_image	$upload_image	Image upload object
	 */
	public function __construct(\phpbb\user $user, \phpbb\language\language $language, \phpbb\request\request $request, \tamit\slideshow\core\upload_image $upload_image)
	{
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->upload_image = $upload_image;

		add_form_key('tamit_slideshow');
	}

	/**
	 * Gets all errors
	 *
	 * @return	array	Errors
	 */
	public function get_errors()
	{
		return $this->errors;
	}

	/**
	 * Returns number of errors.
	 *
	 * @return	int		Number of errors
	 */
	public function has_errors()
	{
		return count($this->errors);
	}

	/**
	 * Get form data.
	 *
	 * @return	array	Form data
	 */
	public function get_form_data()
	{
		$data = array(
			'slide_title'         	=> $this->request->variable('slide_title', '', true),
			'slide_description'     => $this->request->variable('slide_description', '', true),
			'slide_image'         	=> $this->request->variable('slide_image', '', true),
			'slide_link'         	=> $this->request->variable('slide_link', '', true),
			'slide_position'       	=> $this->request->variable('slide_position', 0),
			'slide_enabled'      	=> $this->request->variable('slide_enabled', 0)
		);

		if (!check_form_key('tamit_slideshow'))
		{
			$this->errors[] = 'FORM_INVALID';
		}

		// Validate properties through its validator
		foreach ($data as $prop_name => $prop_val)
		{
			$method = 'validate_' . $prop_name;
			if (method_exists($this, $method))
			{
				$data[$prop_name] = $this->{$method}($prop_val);
			}
		}

		return $data;
	}

	/**
	 * Upload image then update the slide image field.
	 *
	 * @param	 string		$slide_image			Current slide image
	 * @return	 string		\phpbb\json_response	Ajax response or updated slide image.
	 */
	public function upload_image($slide_image)
	{
		try
		{
			$this->upload_image->create_storage_dir();
			$realname = $this->upload_image->upload();

			$image_link = generate_board_url() . '/images/tamit_slideshow/' . $realname;

			if ($this->request->is_ajax())
			{
				$this->send_ajax_response(true, $image_link);
			}

			$slide_image = $image_link;
		}
		catch (\phpbb\exception\runtime_exception $e)
		{
			$this->upload_image->remove();

			if ($this->request->is_ajax())
			{
				$this->send_ajax_response(false, $this->language->lang($e->getMessage()));
			}

			$this->errors[] = $this->language->lang($e->getMessage());
		}

		return $slide_image;
	}

	/**
	 * Validate slide title
	 *
	 * Slide title must be less than 255 characters.
	 *
	 * @param	string		$slide_title	Slide title
	 * @return	string						Slide title
	 */
	protected function validate_slide_title($slide_title)
	{
		if (truncate_string($slide_title, ext::MAX_NAME_LENGTH) !== $slide_title)
		{
			$this->errors[] = $this->language->lang('SLIDE_TITLE_TOO_LONG', ext::MAX_NAME_LENGTH);
		}

		return $slide_title;
	}

	/**
	 * Validate slide link
	 *
	 * Slide link must be in the correct format and less than 255 characters.
	 *
	 * @param	string		$slide_link		Slide link
	 * @return	string						Slide link
	 */
	protected function validate_slide_link($slide_link)
	{
		// Allow blank
		if (strlen(trim($slide_link)) == 0) return '';
		
		if (filter_var($slide_link, FILTER_VALIDATE_URL) === FALSE) {
			$this->errors[] = 'SLIDE_LINK_INCORRECT';
		}

		if (truncate_string($slide_link, ext::MAX_NAME_LENGTH) !== $slide_link)
		{
			$this->errors[] = $this->language->lang('SLIDE_TITLE_TOO_LONG', ext::MAX_NAME_LENGTH);
		}

		return $slide_link;
	}

	/**
	 * Validate slide image
	 *
	 * Slide image must be in the correct format and less than 255 characters.
	 *
	 * @param	string		$slide_image	Slide image
	 * @return	string						Slide image
	 */
	protected function validate_slide_image($slide_image)
	{
		if (filter_var($slide_image, FILTER_VALIDATE_URL) === FALSE) {
			$this->errors[] = 'SLIDE_IMAGE_INCORRECT';
		}

		if (truncate_string($slide_image, ext::MAX_NAME_LENGTH) !== $slide_image)
		{
			$this->errors[] = $this->language->lang('SLIDE_TITLE_TOO_LONG', ext::MAX_NAME_LENGTH);
		}

		return $slide_image;
	}

	/**
	 * Send ajax response
	 *
	 * @param	bool		$success		Is request successful?
	 * @param	string		$text			Text to return
	 */
	protected function send_ajax_response($success, $text)
	{
		$json_response = new \phpbb\json_response;
		$json_response->send(array(
			'success'	=> $success,
			'title'		=> $this->language->lang('INFORMATION'),
			'text'		=> $text,
		));
	}
}
