<?php
/**
 *
 * Slideshow Management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 Huynh Buu Tam <https://www.tamit.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_TAMIT_SLIDESHOW_TITLE'			=> 'Slideshow Management',
	'ACP_MANAGE_SLIDES_TITLE'			=> 'Manage slides',
	'ACP_SLIDESHOW_SETTINGS_TITLE'		=> 'Slideshow settings',

	'ACP_TAMIT_SLIDESHOW_ADD_LOG'		=> '<strong>Slide added</strong><br />» %s',
	'ACP_TAMIT_SLIDESHOW_EDIT_LOG'		=> '<strong>Slide edited</strong><br />» %s',
	'ACP_TAMIT_SLIDESHOW_DELETE_LOG'	=> '<strong>Slide deleted</strong><br />» %s',
	'ACP_TAMIT_SLIDESHOW_SETTINGS_LOG'	=> '<strong>Slideshow Management settings updated</strong><br />» %s'
));
