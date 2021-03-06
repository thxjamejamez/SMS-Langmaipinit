<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'font_path' => base_path('public/fonts/'),
	'font_data' => [
		'examplefont' => [
			'R'  => 'thsarabunnew-webfont.ttf',    // regular font
			'B'  => 'thsarabunnew_bold-webfont.ttf',       // optional: bold font
			'I'  => 'thsarabunnew_italic-webfont.ttf',     // optional: italic font
			'BI' => 'thsarabunnew_bolditalic-webfont.ttf' // optional: bold-italic font
			//'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			//'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
];
