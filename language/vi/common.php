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
	'SLIDESHOW_TITLE'				=> 'Khung trình chiếu'
));
