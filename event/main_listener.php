<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tamit\slideshow\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \tamit\slideshow\core\manager */
	protected $manager;

	/** @var string */
	protected $php_ext;

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup'				=> 'load_language_on_setup',
			'core.page_header_after'		=> array(array('setup_slides'), array('slideshow_target'))
		);
	}

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template				$template			Template object
	 * @param \phpbb\request\request				$request			Request object
	 * @param \phpbb\config\config					$config				Config object
	 * @param \tamit\slideshow\core\manager			$manager			Slideshow manager object
	 * @param string								$php_ext			PHP extension
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\request\request $request, \phpbb\config\config $config, \tamit\slideshow\core\manager $manager, $php_ext)
	{
		$this->template = $template;
		$this->request = $request;
		$this->config = $config;
		$this->manager = $manager;
		$this->php_ext = $php_ext;
	}

	/**
	 * Load common language file during user setup
	 *
	 * @param	\phpbb\event\data	$event		The event object
	 * @return	void
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'tamit/slideshow',
			'lang_set' => 'common'
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Displays slides
	 *
	 * @return	void
	 */
	public function setup_slides()
	{
		if ($this->config['tamit_slideshow_mode'] == 0)
		{
			$this->template->assign_var('SLIDESHOW_SLIDES', $this->manager->get_enabled_slides());
		}
		else
		{
			$forum_id = $this->request->variable('f', 0);
			
			if ($forum_id == 0)
			{
				$forum_id = $this->manager->get_forum_id($this->request->variable('t', 0), false);
			}
			
			if ($forum_id == 0)
			{
				$forum_id = $this->manager->get_forum_id($this->request->variable('p', 0), true);
			}
			
			$this->template->assign_var('SLIDESHOW_SLIDES', $this->manager->get_newest_topics($forum_id, $this->config['tamit_slideshow_topic_count']));
		}
	}

	/**
	 * Assign target page
	 *
	 * @return	void
	 */
	public function slideshow_target()
	{
		$this->template->assign_var('S_SLIDESHOW_PAGE_INDEX', $this->config['tamit_slideshow_page_index']);
		$this->template->assign_var('S_SLIDESHOW_PAGE_VIEWFORUM', $this->config['tamit_slideshow_page_viewforum']);
		$this->template->assign_var('S_SLIDESHOW_PAGE_VIEWTOPIC', $this->config['tamit_slideshow_page_viewtopic']);
		$this->template->assign_var('S_SLIDESHOW_DURATION', $this->config['tamit_slideshow_duration']);
		$this->template->assign_var('S_SLIDESHOW_BOX', $this->config['tamit_slideshow_box']);
		$this->template->assign_var('S_SLIDESHOW_NAV_IMAGE', $this->config['tamit_slideshow_nav_image']);
		$this->template->assign_var('S_SLIDESHOW_NAV_DOT', $this->config['tamit_slideshow_nav_dot']);
	}
}
