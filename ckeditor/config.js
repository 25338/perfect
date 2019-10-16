/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
   config.skin = 'moonocolor';	
   
   config.filebrowserBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=flash';
   config.removePlugins = 'save,forms,about';

   config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'NewPage,Print,Find,SelectAll,Replace,Scayt,CreateDiv,Language,PageBreak,Preview,Templates,Styles';
};