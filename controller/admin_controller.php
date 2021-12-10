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

class admin_controller
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \tamit\slideshow\core\manager */
	protected $manager;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \tamit\slideshow\controller\admin_input */
	protected $input;

	/** @var \tamit\slideshow\controller\helper */
	protected $helper;

	/** @var string		Custom form action */
	protected $u_action;
	
	/** @var array		Form data */
	protected $data = array();

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template					$template	Template object
	 * @param \phpbb\language\language					$language	Language object
	 * @param \phpbb\request\request					$request	Request object
	 * @param \tamit\slideshow\core\manager				$manager	Slideshow manager object
	 * @param \phpbb\config\config						$config		Config object
	 * @param \tamit\slideshow\controller\admin_input	$input		Admin input object
	 * @param \tamit\slideshow\controller\helper		$helper		Helper object
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\language\language $language, \phpbb\request\request $request, \tamit\slideshow\core\manager $manager, \phpbb\config\config $config, \tamit\slideshow\controller\admin_input $input, \tamit\slideshow\controller\helper $helper)
	{
		$this->template = $template;
		$this->language = $language;
		$this->request = $request;
		$this->manager = $manager;
		$this->config = $config;
		$this->input = $input;
		$this->helper = $helper;

		$this->language->add_lang('acp', 'tamit/slideshow');
	}

	/**
	 * Set page url
	 *
	 * @param	string	$u_action	Custom form action
	 * @return	void
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

	/**
	 * Get ACP page title for Slideshow module
	 *
	 * @return	string		Language string for Slideshow ACP module
	 */
	public function get_page_title()
	{
		return $this->language->lang('ACP_TAMIT_SLIDESHOW_TITLE');
	}

	/**
	 * Process user request for Settings mode
	 *
	 * @return	void
	 */
	public function mode_settings()
	{
		if ($this->request->is_set_post('submit'))
		{
			if (check_form_key('tamit_slideshow'))
			{
				$this->config->set('tamit_slideshow_page_index', $this->request->variable('slideshow_page_index', 0));
				$this->config->set('tamit_slideshow_page_viewforum', $this->request->variable('slideshow_page_viewforum', 0));
				$this->config->set('tamit_slideshow_page_viewtopic', $this->request->variable('slideshow_page_viewtopic', 0));
				$this->config->set('tamit_slideshow_box', $this->request->variable('slideshow_box', 0));
				$this->config->set('tamit_slideshow_nav_image', $this->request->variable('slideshow_nav_image', 0));
				$this->config->set('tamit_slideshow_nav_dot', $this->request->variable('slideshow_nav_dot', 0));
				$this->config->set('tamit_slideshow_mode', $this->request->variable('slideshow_mode', 0));
				$this->config->set('tamit_slideshow_topic_max_length', $this->request->variable('slideshow_topic_max_length', 0));
				$this->config->set('tamit_slideshow_topic_hide_protected_forum', $this->request->variable('slideshow_topic_hide_protected_forum', 0));
				$this->config->set('tamit_slideshow_topic_count', $this->request->variable('slideshow_topic_count', 0));
				$this->config->set('tamit_slideshow_topic_hide_bbcode', $this->request->variable('slideshow_topic_hide_bbcode', ''));
				$this->config->set('tamit_slideshow_default_image', $this->request->variable('slideshow_default_image', ''));

				$this->helper->add_log('SETTINGS', $this->language->lang('ACP_SLIDESHOW_SETTINGS_TITLE'));
				$this->success('ACP_SLIDE_SETTINGS_SAVED');
			}

			$this->error('FORM_INVALID');
		}

		$this->template->assign_vars(array(
			'U_ACTION'          					=> $this->u_action,
			'SLIDESHOW_PAGE_INDEX' 					=> $this->config['tamit_slideshow_page_index'],
			'SLIDESHOW_PAGE_VIEWFORUM' 				=> $this->config['tamit_slideshow_page_viewforum'],
			'SLIDESHOW_PAGE_VIEWTOPIC' 				=> $this->config['tamit_slideshow_page_viewtopic'],
			'SLIDESHOW_BOX' 						=> $this->config['tamit_slideshow_box'],
			'SLIDESHOW_NAV_IMAGE' 					=> $this->config['tamit_slideshow_nav_image'],
			'SLIDESHOW_NAV_DOT' 					=> $this->config['tamit_slideshow_nav_dot'],
			'SLIDESHOW_MODE' 						=> $this->config['tamit_slideshow_mode'],
			'SLIDESHOW_TOPIC_MAX_LENGTH' 			=> $this->config['tamit_slideshow_topic_max_length'],
			'SLIDESHOW_TOPIC_HIDE_PROTECTED_FORUM' 	=> $this->config['tamit_slideshow_topic_hide_protected_forum'],
			'SLIDESHOW_TOPIC_COUNT' 				=> $this->config['tamit_slideshow_topic_count'],
			'SLIDESHOW_TOPIC_HIDE_BBCODE' 			=> $this->config['tamit_slideshow_topic_hide_bbcode'],
			'SLIDESHOW_DEFAULT_IMAGE'				=> $this->config['tamit_slideshow_default_image']
		));
	}

	/**
	 * Process user request for Manage slides mode
	 *
	 * @return	void
	 */
	public function mode_manage()
	{
		// Used by upload_image() for errors
		$this->language->add_lang('posting');
		// Custom Ajax callback
		$this->template->assign_var('S_TAMIT_SLIDESHOW', true);
		$this->template->assign_var('S_TAMIT_SLIDESHOW_MODE_TOPICS', $this->config['tamit_slideshow_mode']);
		
		// Trigger specific action
		$action = $this->request->variable('action', '');
		if (in_array($action, array('add', 'edit', 'enable', 'disable', 'moveup', 'movedown', 'delete', 'fix_positions')))
		{
			$this->{'action_' . $action}();
		}
		else
		{
			// Otherwise just list all slides, and assign some variables to the template
			$this->list_slides();
		}
	}

	/**
	 * Fix all slide positions
	 *
	 * @return	void
	 */
	protected function action_fix_positions()
	{
		$this->fix_positions();
	}

	/**
	 * Add a slide
	 *
	 * @return	void
	 */
	protected function action_add()
	{
		$action = $this->get_submitted_action();
		if ($action !== false)
		{
			$this->data = $this->input->get_form_data();
			$this->{$action}();
			$this->helper->assign_data($this->data, $this->input->get_errors());
		}

		$this->template->assign_vars(array(
			'S_ADD_SLIDE'			=> true,
			'U_BACK'				=> $this->u_action,
			'U_ACTION'				=> "{$this->u_action}&amp;action=add"
		));
	}

	/**
	 * Edit a slide
	 *
	 * @return	void
	 */
	protected function action_edit()
	{
		$slide_id = $this->request->variable('id', 0);
		$action = $this->get_submitted_action();
		if ($action !== false)
		{
			$this->data = $this->input->get_form_data();
			$this->{$action}();
		}
		else
		{
			$this->data = $this->manager->get_slide($slide_id);
			if (empty($this->data))
			{
				$this->error('ACP_SLIDE_DOES_NOT_EXIST');
			}
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'S_EDIT_SLIDE'			=> true,
			'EDIT_ID'				=> $slide_id,
			'U_BACK'				=> $this->u_action,
			'U_ACTION'				=> "{$this->u_action}&amp;action=edit&amp;id=$slide_id"
		));
		$this->helper->assign_data($this->data, $this->input->get_errors());
	}

	/**
	 * Enable a slide
	 *
	 * @return	void
	 */
	protected function action_enable()
	{
		$this->slide_enable(true);
	}

	/**
	 * Disable a slide
	 *
	 * @return	void
	 */
	protected function action_disable()
	{
		$this->slide_enable(false);
	}
	
	/**
	 * Move a slide up
	 *
	 * @return	void
	 */
	protected function action_moveup()
	{
		$this->slide_move(true);
	}

	/**
	 * Move a slide down
	 *
	 * @return	void
	 */
	protected function action_movedown()
	{
		$this->slide_move(false);
	}

	/**
	 * Delete a slide
	 *
	 * @return	void
	 */
	protected function action_delete()
	{
		$slide_id = $this->request->variable('id', 0);
		if ($slide_id)
		{
			if (confirm_box(true))
			{
				// Get slide data so that we can log slide title
				$slide_data = $this->manager->get_slide($slide_id);

				$success = $this->manager->delete_slide($slide_id);

				if ($success)
				{
					$this->helper->add_log('DELETE', $slide_data['slide_title']);
					// Show message only when NOT using Ajax
					if (!$this->request->is_ajax())
					{
						$this->success('ACP_SLIDE_DELETE_SUCCESS');
					}
				}
				else
				{
					$this->error('ACP_SLIDE_DELETE_ERRORED');
				}
			}
			else
			{
				confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
					'id'     => $slide_id,
					'i'      => $this->request->variable('i', ''),
					'mode'   => $this->request->variable('mode', ''),
					'action' => 'delete',
				)));

				$this->list_slides();
			}
		}
	}

	/**
	 * Display the list of all slides
	 *
	 * @return	void
	 */
	protected function list_slides()
	{
		foreach ($this->manager->get_all_slides() as $row)
		{
			$slide_enabled = (int) $row['slide_enabled'];

			$this->template->assign_block_vars('slides', array(
				'TITLE'        => $row['slide_title'],
				'S_ENABLED'    => $slide_enabled,
				'U_ENABLE'     => $this->u_action . '&amp;action=' . ($slide_enabled ? 'disable' : 'enable') . '&amp;id=' . $row['slide_id'],
				'U_MOVEUP'     => $this->u_action . '&amp;action=moveup&amp;id=' . $row['slide_id'],
				'U_MOVEDOWN'   => $this->u_action . '&amp;action=movedown&amp;id=' . $row['slide_id'],
				'U_EDIT'       => $this->u_action . '&amp;action=edit&amp;id=' . $row['slide_id'],
				'U_DELETE'     => $this->u_action . '&amp;action=delete&amp;id=' . $row['slide_id'],
			));
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'U_ACTION_ADD'				=> $this->u_action . '&amp;action=add',
			'U_ACTION_FIX_POSITIONS'	=> $this->u_action . '&amp;action=fix_positions'
		));
	}

	/**
	 * Get submitted action from user.
	 *
	 * @return	string|false	Action name or false when no action was submitted
	 */
	protected function get_submitted_action()
	{
		$actions = array('submit_upload_image', 'submit_add', 'submit_edit');
		foreach ($actions as $action)
		{
			if ($this->request->is_set_post($action))
			{
				return $action;
			}
		}

		return false;
	}

	/**
	 * Fix slide positions
	 *
	 * @return	void
	 */
	protected function fix_positions()
	{
		$success = $this->manager->fix_positions();

		if ($success)
		{
			$this->success('ACP_FIX_POSITION_SUCCESS');
		}
		else
		{
			$this->error('ACP_FIX_POSITION_ERRORED');
		}
	}

	/**
	 * Enable/disable a slide
	 *
	 * @param	bool	$enable		Enable or disable the slide?
	 * @return	void
	 */
	protected function slide_enable($enable)
	{
		$slide_id = $this->request->variable('id', 0);

		$success = $this->manager->toggle_slide($slide_id, $enable);

		// If AJAX was used, show user a result message
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'text'  => $this->language->lang($enable ? 'ENABLED' : 'DISABLED'),
				'title' => $this->language->lang('SLIDE_ENABLE_TITLE', (int) $enable)
			));
		}

		// Otherwise, show traditional infobox
		if ($success)
		{
			$this->success($enable ? 'ACP_SLIDE_ENABLE_SUCCESS' : 'ACP_SLIDE_DISABLE_SUCCESS');
		}
		else
		{
			$this->error($enable ? 'ACP_SLIDE_ENABLE_ERRORED' : 'ACP_SLIDE_DISABLE_ERRORED');
		}
	}

	/**
	 * Move slide (position) up/down
	 *
	 * @param	bool	$up		Move the slide up (true) or down (false)?
	 * @return	void
	 */
	protected function slide_move($up)
	{
		$slide_id = $this->request->variable('id', 0);
		
		$success = $this->manager->move_slide($slide_id, $up);

		// If AJAX was used, show user a result message
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success'	=> $success
			));
		}

		// Otherwise, show traditional infobox
		if ($success)
		{
			$this->success($up ? 'ACP_SLIDE_MOVEUP_SUCCESS' : 'ACP_SLIDE_MOVEDOWN_SUCCESS');
		}
		else
		{
			$this->error($up ? 'ACP_SLIDE_MOVEUP_ERRORED' : 'ACP_SLIDE_MOVEDOWN_ERRORED');
		}
	}

	/**
	 * Submit action "submit_upload_image".
	 * Upload image and place it to the slide image.
	 *
	 * @return	void
	 */
	protected function submit_upload_image()
	{
		$this->data['slide_image'] = $this->input->upload_image($this->data['slide_image']);
	}

	/**
	 * Submit action "submit_add".
	 * Add new slide.
	 *
	 * @return	void
	 */
	protected function submit_add()
	{
		if (!$this->input->has_errors())
		{
			$slide_id = $this->manager->insert_slide($this->data);

			$this->helper->add_log('ADD', $this->data['slide_title']);

			$this->success('ACP_SLIDE_ADD_SUCCESS');
		}
	}

	/**
	 * Submit action "submit_edit".
	 * Edit slide.
	 *
	 * @return	void
	 */
	protected function submit_edit()
	{
		$slide_id = $this->request->variable('id', 0);
		if ($slide_id && !$this->input->has_errors())
		{
			$old_data = $this->manager->get_slide($slide_id);
			$success = $this->manager->update_slide($slide_id, $this->data);
			if ($success)
			{
				$this->helper->add_log('EDIT', $this->data['slide_title']);

				$this->success('ACP_SLIDE_EDIT_SUCCESS');
			}

			$this->error('ACP_SLIDE_DOES_NOT_EXIST');
		}
	}

	/**
	 * Print success message.
	 *
	 * @param	string	$msg	Message language key
	 */
	protected function success($msg)
	{
		trigger_error($this->language->lang($msg) . adm_back_link($this->u_action));
	}

	/**
	 * Print error message.
	 *
	 * @param	string	$msg	Message language key
	 */
	protected function error($msg)
	{
		trigger_error($this->language->lang($msg) . adm_back_link($this->u_action), E_USER_WARNING);
	}
}
