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
	// Manage slides
	'SLIDE_SETTINGS'					=> 'Slide settings',
	'SLIDE_STATUS'						=> 'Status',
	'SLIDE_TITLE'						=> 'Slide title',
	'SLIDE_TITLE_EXPLAIN'				=> 'Enter the slide title here.',
	'SLIDE_ENABLED'						=> 'Enable slide',
	'SLIDE_ENABLED_EXPLAIN'				=> 'If disabled, this slide will not be displayed.',
	'SLIDE_DESCRIPTION'					=> 'Slide description',
	'SLIDE_DESCRIPTION_EXPLAIN'			=> 'Enter the slide description here.',
	'SLIDE_IMAGE'						=> 'Slide image',
	'SLIDE_IMAGE_EXPLAIN'				=> 'Enter the slide image here (URL).',
	'SLIDE_LINK'						=> 'Slide link',
	'SLIDE_LINK_EXPLAIN'				=> 'Enter the slide link here (URL).',
	'SLIDE_SETTINGS_NOT_AFFECTED'		=> 'The mode <samp>Newest topics</samp> is currently enabled. The settings below will be applied after disabling <samp>Newest topics</samp> mode.',
	// Upload
	'UPLOAD_IMAGE_LEGEND'				=> 'Upload image',
	'UPLOAD_IMAGE'						=> 'Upload new image',
	'UPLOAD_IMAGE_UPLOADED'				=> 'Image has been uploaded. The link to the image has been sent to the slide image field.',
	'UPLOAD_IMAGE_EXPLAIN'				=> 'You may upload an image in JPG, GIF or PNG format. The image will be stored in phpBB‘s <samp>images</samp> (tamit_slideshow) directory and a link for the image will automatically be inserted into the slide image field. Please note that existing image with the same filename of the uploaded image will be overwritten.',
	'UPLOAD_SUBMIT'						=> 'Upload',
	
	'SLIDE_ENABLE_TITLE'				=> array(
		0 => 'Click to enable',
		1 => 'Click to disable',
	),
	
	'ACP_SLIDES_EMPTY'					=> 'No slides to display. Add one using the button below.',
	'ACP_SLIDES_FIX_POSITION'			=> 'Fix slide positions',
	'ACP_SLIDES_ADD'					=> 'Add new slide',
	'ACP_SLIDES_EDIT'					=> 'Edit slide',

	'SLIDE_TITLE_REQUIRED'				=> 'Title is required.',
	'SLIDE_TITLE_TOO_LONG'				=> 'Title length is limited to %d characters.',
	'SLIDE_LINK_INCORRECT'				=> 'Slide link must be in a correct URL',
	'SLIDE_IMAGE_INCORRECT'				=> 'Slide image must be in a correct URL',
	'NO_FILE_SELECTED'					=> 'No file selected.',
	'CANNOT_CREATE_DIRECTORY'			=> 'The <samp>tamit_slideshow</samp> directory could not be created. Please make sure the <samp>/images</samp> directory is writable.',
	'FILE_MOVE_UNSUCCESSFUL'			=> 'Unable to move file to <samp>images/tamit_slideshow</samp>.',
	'ACP_SLIDE_DOES_NOT_EXIST'			=> 'The slide does not exist.',
	'ACP_SLIDE_ADD_SUCCESS'				=> 'Slide added successfully.',
	'ACP_SLIDE_EDIT_SUCCESS'			=> 'Slide edited successfully.',
	'ACP_SLIDE_DELETE_SUCCESS'			=> 'Slide deleted successfully.',
	'ACP_SLIDE_DELETE_ERRORED'			=> 'There was an error deleting the slide.',
	'ACP_SLIDE_ENABLE_SUCCESS'			=> 'Slide enabled successfully.',
	'ACP_SLIDE_ENABLE_ERRORED'			=> 'There was an error enabling the slide.',
	'ACP_SLIDE_DISABLE_SUCCESS'			=> 'Slide disabled successfully.',
	'ACP_SLIDE_DISABLE_ERRORED'			=> 'There was an error disabling the slide.',
	'ACP_SLIDE_MOVEUP_SUCCESS'			=> 'Slide moved up successfully.',
	'ACP_SLIDE_MOVEUP_ERRORED'			=> 'There was an error moving the slide up.',
	'ACP_SLIDE_MOVEDOWN_SUCCESS'		=> 'Slide moved down successfully.',
	'ACP_SLIDE_MOVEDOWN_ERRORED'		=> 'There was an error moving the slide down.',
	'ACP_FIX_POSITION_SUCCESS'			=> 'Fixed all slide positions.',
	'ACP_FIX_POSITION_ERRORED'			=> 'There was an error fixing the slide positions.',

	// Settings
	'SLIDESHOW_APPEARENCE'				=> 'Slideshow appearence',
	'SLIDESHOW_BOX'						=> 'Use box',
	'SLIDESHOW_BOX_EXPLAIN'				=> 'Wrapped the slideshow with style\'s container.',
	'SLIDESHOW_NAVIGATOR'				=> 'Navigator',
	'SLIDESHOW_NAVIGATOR_EXPLAIN'		=> 'Choose navigator to display.',
	'SLIDESHOW_SLIDE_HEIGHT'			=> 'Slide image height',
	'SLIDESHOW_SLIDE_HEIGHT_EXPLAIN'	=> 'Specify the height of the slide image.',
	'SLIDESHOW_IMAGE_NAV_SIZE'			=> 'Image navigator size',
	'SLIDESHOW_IMAGE_NAV_SIZE_EXPLAIN'	=> 'Specify the size of the image navigator.',
	
	'CAT_NAV_IMAGE'						=> 'Image navigator',
	'CAT_NAV_DOT'						=> 'Dot navigator',
	
	'SLIDESHOW_TARGET_LEGEND'			=> 'Slideshow target',
	'SLIDESHOW_TARGET'					=> 'Target page',
	'SLIDESHOW_TARGET_EXPLAIN'			=> 'Choose pages to display the slideshow.',

	'CAT_TARGET_INDEX'					=> 'Index',
	'CAT_TARGET_VIEWFORUM'				=> 'Viewforum',
	'CAT_TARGET_VIEWTOPIC'				=> 'Viewtopic',
	
	'SLIDESHOW_DURATION'				=> 'Duration',
	'SLIDESHOW_DURATION_EXPLAIN'		=> 'How long will each slide be displayed? (in milliseconds)',
	
	'SLIDESHOW_MODE'								=> 'Slideshow mode',
	'SLIDESHOW_MODE_TOPICS'							=> 'Newest topics',
	'SLIDESHOW_MODE_TOPICS_EXPLAIN'					=> 'Set newest topics as slides.',
	'SLIDESHOW_TOPIC_MAX_LENGTH'					=> 'Max length',
	'SLIDESHOW_TOPIC_MAX_LENGTH_EXPLAIN'			=> 'Maximum length of post content to display in the description. Set to 0 if you want to hide post content.',
	'SLIDESHOW_TOPIC_HIDE_PROTECTED_FORUM'			=> 'Hide posts from password protected forum',
	'SLIDESHOW_TOPIC_HIDE_PROTECTED_FORUM_EXPLAIN'	=> 'Don\'t show posts from password protected forum.',
	'SLIDESHOW_TOPIC_COUNT'							=> 'Topic count',
	'SLIDESHOW_TOPIC_COUNT_EXPLAIN'					=> 'Number of topics to get.',
	'SLIDESHOW_TOPIC_HIDE_BBCODE'					=> 'Hide BBCode content',
	'SLIDESHOW_TOPIC_HIDE_BBCODE_EXPLAIN'			=> 'If you want to hide the content of several BBCodes, enter each BBCode name here, separated by commas (,), do not include the brackets (e.g. <samp>url, code</samp>).',
	'SLIDESHOW_DEFAULT_IMAGE'						=> 'Default image',
	'SLIDESHOW_DEFAULT_IMAGE_EXPLAIN'				=> 'If the first post of the topic doesn\'t have any images (using BBcode IMG or In-line attachments), use the default image instead.',

	'ACP_SLIDE_SETTINGS_SAVED'						=> 'Slideshow Management settings saved.'
));
