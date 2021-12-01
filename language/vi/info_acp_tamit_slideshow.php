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
	'ACP_TAMIT_SLIDESHOW_TITLE'			=> 'Quản trị khung trình chiếu',
	'ACP_MANAGE_SLIDES_TITLE'			=> 'Quản lí các trang chiếu',
	'ACP_SLIDESHOW_SETTINGS_TITLE'		=> 'Cài đặt khung trình chiếu',

	'ACP_TAMIT_SLIDESHOW_ADD_LOG'		=> '<strong>Trang chiếu đã được thêm</strong><br />» %s',
	'ACP_TAMIT_SLIDESHOW_EDIT_LOG'		=> '<strong>Trang chiếu đã được cập nhật</strong><br />» %s',
	'ACP_TAMIT_SLIDESHOW_DELETE_LOG'	=> '<strong>Trang chiếu đã được xóa</strong><br />» %s',
	'ACP_TAMIT_SLIDESHOW_SETTINGS_LOG'	=> '<strong>Đã cập nhật các cài đặt Quản trị khung trình chiếu</strong><br />» %s'
));
