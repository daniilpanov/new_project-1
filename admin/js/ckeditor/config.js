/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = 'http://localhost/new_project/admin/js/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = 'http://localhost/new_project/admin/js/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = 'http://localhost/new_project/admin/js/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = 'http://localhost/new_project/admin/js/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = 'http://localhost/new_project/admin/js/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = 'http://localhost/new_project/admin/js/kcfinder/upload.php?type=flash';
};