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
	'SLIDE_SETTINGS'					=> 'Cài đặt trang chiếu',
	'SLIDE_STATUS'						=> 'Trạng thái',
	'SLIDE_TITLE'						=> 'Tiêu đề trang chiếu',
	'SLIDE_TITLE_EXPLAIN'				=> 'Nhập tiêu đề trang chiếu ở đây.',
	'SLIDE_ENABLED'						=> 'Bật trang chiếu',
	'SLIDE_ENABLED_EXPLAIN'				=> 'Nếu tắt, trang chiếu này sẽ không được hiển thị.',
	'SLIDE_DESCRIPTION'					=> 'Mô tả trang chiếu',
	'SLIDE_DESCRIPTION_EXPLAIN'			=> 'Nhập mô tả trang chiếu ở đây.',
	'SLIDE_IMAGE'						=> 'Hình ảnh trang chiếu',
	'SLIDE_IMAGE_EXPLAIN'				=> 'Nhập hình ảnh trang chiếu ở đây (địa chỉ liên kết).',
	'SLIDE_LINK'						=> 'Liên kết trang chiếu',
	'SLIDE_LINK_EXPLAIN'				=> 'Nhập liên kết trang chiếu ở đây (địa chỉ liên kết).',
	'SLIDE_SETTINGS_NOT_AFFECTED'		=> 'Chế độ <samp>Chủ đề mới nhất</samp> hiện đang được bật. Các cài đặt bên dưới sẽ được áp dụng sau khi tắt chế độ <samp>Chủ đề mới nhất</samp>.',
	// Upload
	'UPLOAD_IMAGE_LEGEND'				=> 'Tải lên hình ảnh',
	'UPLOAD_IMAGE'						=> 'Tải lên hình ảnh mới',
	'UPLOAD_IMAGE_UPLOADED'				=> 'Hình ảnh đã được tải lên. Liên kết đến hình ảnh đã được gửi đến trường hình ảnh trang chiếu.',
	'UPLOAD_IMAGE_EXPLAIN'				=> 'Bạn có thể tải lên hình ảnh ở định dạng JPG, GIF hoặc PNG. Hình ảnh sẽ được lưu trữ trong thư mục phpBB‘s <samp>images</samp> (tamit_slideshow) và một liên kết cho hình ảnh sẽ tự động được chèn vào trường hình ảnh trang chiếu. Xin lưu ý rằng, hình ảnh hiện có có cùng tên với tệp được tải lên thì sẽ bị ghi đè.',
	'UPLOAD_SUBMIT'						=> 'Tải lên',
	
	'SLIDE_ENABLE_TITLE'				=> array(
		0 => 'Nhấn chuột để bật',
		1 => 'Nhấn chuột để tắt',
	),
	
	'ACP_SLIDES_EMPTY'					=> 'Không có trang chiếu nào để hiển thị. Thêm một trang chiếu bằng cách sử dụng nút lệnh bên dưới.',
	'ACP_SLIDES_FIX_POSITION'			=> 'Sửa lại vị trí các trang chiếu',
	'ACP_SLIDES_ADD'					=> 'Thêm trang chiếu mới',
	'ACP_SLIDES_EDIT'					=> 'Chỉnh sửa trang chiếu',

	'SLIDE_TITLE_REQUIRED'				=> 'Tiêu đề thì phải có.',
	'SLIDE_TITLE_TOO_LONG'				=> 'Độ dài tiêu đề được giới hạn đến %d kí tự.',
	'SLIDE_LINK_INCORRECT'				=> 'Liên kết trang chiếu phải đúng định dạng địa chỉ liên kết',
	'SLIDE_IMAGE_INCORRECT'				=> 'Hình ảnh trang chiếu phải đúng định dạng địa chỉ liên kết',
	'NO_FILE_SELECTED'					=> 'Không có tệp nào được chọn.',
	'CANNOT_CREATE_DIRECTORY'			=> 'Thư mục <samp>tamit_slideshow</samp> không thể được tạo. Vui lòng đảm bảo rằng thư mục <samp>/images</samp> là được phép ghi dữ liệu.',
	'FILE_MOVE_UNSUCCESSFUL'			=> 'Không thể chuyển tệp đến <samp>images/tamit_slideshow</samp>.',
	'ACP_SLIDE_DOES_NOT_EXIST'			=> 'Trang chiếu không tồn tại.',
	'ACP_SLIDE_ADD_SUCCESS'				=> 'Trang chiếu đã được thêm thành công.',
	'ACP_SLIDE_EDIT_SUCCESS'			=> 'Trang chiếu đã được cập nhật thành công.',
	'ACP_SLIDE_DELETE_SUCCESS'			=> 'Trang chiếu đã được xóa thành công.',
	'ACP_SLIDE_DELETE_ERRORED'			=> 'Có lỗi xảy ra trong quá trình xóa trang chiếu.',
	'ACP_SLIDE_ENABLE_SUCCESS'			=> 'Trang chiếu đã được bật thành công.',
	'ACP_SLIDE_ENABLE_ERRORED'			=> 'Có lỗi xảy ra trong quá trình bật trang chiếu.',
	'ACP_SLIDE_DISABLE_SUCCESS'			=> 'Trang chiếu đã được tắt thành công.',
	'ACP_SLIDE_DISABLE_ERRORED'			=> 'Có lỗi xảy ra trong quá trình tắt trang chiếu.',
	'ACP_SLIDE_MOVEUP_SUCCESS'			=> 'Trang chiếu đã được chuyển lên thành công.',
	'ACP_SLIDE_MOVEUP_ERRORED'			=> 'Có lỗi xảy ra trong quá trình chuyển trang chiếu lên.',
	'ACP_SLIDE_MOVEDOWN_SUCCESS'		=> 'Trang chiếu đã được chuyển xuống thành công.',
	'ACP_SLIDE_MOVEDOWN_ERRORED'		=> 'Có lỗi xảy ra trong quá trình chuyển trang chiếu xuống.',
	'ACP_FIX_POSITION_SUCCESS'			=> 'Đã sửa lại tất cả vị trí các trang chiếu.',
	'ACP_FIX_POSITION_ERRORED'			=> 'Có lỗi xảy ra trong quá trình sửa lại vị trí các trang chiếu.',

	// Slideshow settings
	'SLIDESHOW_APPEARENCE'				=> 'Diện mạo khung trình chiếu',
	'SLIDESHOW_BOX'						=> 'Sử dụng hộp',
	'SLIDESHOW_BOX_EXPLAIN'				=> 'Bao bọc khung trình chiếu bằng khung chứa của giao diện.',
	'SLIDESHOW_NAVIGATOR'				=> 'Trình điều hướng',
	'SLIDESHOW_NAVIGATOR_EXPLAIN'		=> 'Chọn trình điều hướng để hiển thị.',
	'SLIDESHOW_SLIDE_HEIGHT'			=> 'Chiều cao hình ảnh trang chiếu',
	'SLIDESHOW_SLIDE_HEIGHT_EXPLAIN'	=> 'Chỉ định chiều cao của hình ảnh trang chiếu.',
	'SLIDESHOW_IMAGE_NAV_SIZE'			=> 'Kích thước điều hướng bằng hình ảnh',
	'SLIDESHOW_IMAGE_NAV_SIZE_EXPLAIN'	=> 'Chỉ định kích thước của điều hướng bằng hình ảnh.',
	
	'CAT_NAV_IMAGE'						=> 'Điều hướng bằng hình ảnh',
	'CAT_NAV_DOT'						=> 'Điều hướng bằng nút chấm',
	
	'SLIDESHOW_TARGET_LEGEND'			=> 'Mục tiêu trình chiếu',
	'SLIDESHOW_TARGET'					=> 'Trang mục tiêu',
	'SLIDESHOW_TARGET_EXPLAIN'			=> 'Chọn các trang để hiển thị khung trình chiếu.',

	'CAT_TARGET_INDEX'					=> 'Trang chính',
	'CAT_TARGET_VIEWFORUM'				=> 'Xem diễn đàn',
	'CAT_TARGET_VIEWTOPIC'				=> 'Xem chủ đề',
	
	'SLIDESHOW_DURATION'				=> 'Thời lượng',
	'SLIDESHOW_DURATION_EXPLAIN'		=> 'Mỗi trang chiếu sẽ được hiển thị trong bao lâu? (tính bằng mi-li giây)',
	
	'SLIDESHOW_MODE'								=> 'Chế độ trình chiếu',
	'SLIDESHOW_MODE_TOPICS'							=> 'Chủ đề mới nhất',
	'SLIDESHOW_MODE_TOPICS_EXPLAIN'					=> 'Đặt chủ đề mới nhất như là các trang chiếu.',
	'SLIDESHOW_TOPIC_MAX_LENGTH'					=> 'Độ dài tối đa',
	'SLIDESHOW_TOPIC_MAX_LENGTH_EXPLAIN'			=> 'Độ dài tối đa của nội dung bài viết để hiển thị trong phần mô tả. Đặt là 0 nếu bạn muốn ẩn nội dung bài viết.',
	'SLIDESHOW_TOPIC_HIDE_PROTECTED_FORUM'			=> 'Ẩn các bài viết trong diễn đàn được bảo vệ bởi mật khẩu',
	'SLIDESHOW_TOPIC_HIDE_PROTECTED_FORUM_EXPLAIN'	=> 'Không hiển thị các bài viết trong diễn đàn được bảo vệ bởi mật khẩu.',
	'SLIDESHOW_TOPIC_COUNT'							=> 'Số lượng chủ đề',
	'SLIDESHOW_TOPIC_COUNT_EXPLAIN'					=> 'Số lượng chủ đề cần lấy.',
	'SLIDESHOW_TOPIC_HIDE_BBCODE'					=> 'Ẩn nội dung BBCode',
	'SLIDESHOW_TOPIC_HIDE_BBCODE_EXPLAIN'			=> 'Nếu bạn muốn ẩn nội dung của một vài BBCode, nhập mỗi tên BBCode ở đây, phân tách bởi dấu phẩy (,), không được chứa các dấu ngoặc vuông (ví dụ: <samp>url, code</samp>).',
	'SLIDESHOW_DEFAULT_IMAGE'						=> 'Hình ảnh mặc định',
	'SLIDESHOW_DEFAULT_IMAGE_EXPLAIN'				=> 'Nếu bài viết đầu tiên của chủ đề không chứa bất kì hình ảnh nào (bằng việc sử dụng BBcode IMG hoặc tệp đính kèm trong dòng đoạn văn), sử dụng hình ảnh mặc định để thay thế.',

	'ACP_SLIDE_SETTINGS_SAVED'						=> 'Các cài đặt Quản trị khung trình chiếu đã được lưu.'
));
