<?php
return [
	'languages'=>['en'=>'English'],
	'business_type'=>['Dealer','Distributor','Stockist','Resellers','Sales Agents','Traders'],
	'no_reply1'=>'no-reply@franchiseindia.com',
	'bucket_url'=>'https://oppindia.s3.ap-south-1.amazonaws.com/',
	'bucket_old_url'=>'https://franchiseindia.s3.ap-south-1.amazonaws.com/uploads/franchisor/',
	'ARTICLE_UPLOAD_PATH' => 'opp/article/english/images/',
	'ARTICLE_HINDI_UPLOAD_PATH' => 'opp/article/hindi/images/',

	 'IMAGE_UPLOAD_DIMENSIONS' => [
        "685X385" => [
            'WIDTH' => 685,
            'HEIGHT' => 385
        ],
        "125X70" => [
            'WIDTH' => 125,
            'HEIGHT' => 70
        ],
        "295X165" => [
            'WIDTH' => 295,
            'HEIGHT' => 165
        ],
    ],

    'LANGUAGE_TYPE' => [
        'HINDI' => 'hindi',
        'ENGLISH' => 'english',
    ],

    "CONTENT_TYPE" => [
        "ARTICLE" => 1,
        "NEWS" => 2
    ],

	'NEWS_UPLOAD_PATH' => 'opp/news/english/images/',
	'NEWS_HINDI_UPLOAD_PATH' => 'opp/news/hindi/images/',
	'IMAGE' => 'image',
	'IMAGE_DIMENSIONS' => [
		'MAIN_ARTICLE_NEWS_IMAGE' => [
			'WIDTH' => 1000,
			'HEIGHT' => 562
		]
	],
	'VISIBILITY' => [
		'PUBLIC'=> 'public'
	],
	'FILE_TYPES' => 'MAIN_ARTICLE_NEWS_IMAGE',
	'weightage'=>[
		'homepage_banner_paid'=>'111',
		'homepage_premium_paid'=>'112',
		'homepage_super_paid'=>'113',
		'homepage_featured_paid'=>'114',
		'homepage_banner_proxy'=>'116',
		'homepage_premium_proxy'=>'117',
		'homepage_super_proxy'=>'118',
		'homepage_featured_proxy'=>'119',

		'industry_sponsered'=>'219',
		'sector_sponsered'=>'229',

		'industry_paid'=>'319',
		'industry_paid_investment'=>'329',
		'industry_paid_location'=>'339',

		'sector_paid'=>'419',
		'sector_paid_investment'=>'429',
		'sector_paid_location'=>'439',

		'investment_proxy'=>'529',
		'location_proxy'=>'539',

		'email_marketing_pan_india'=>'819',
		'email_marketing_zonal'=>'829',
		'email_marketing_regional'=>'839',
		'email_marketing_banner'=>'849',
		'free'=>'899',
	],
];

