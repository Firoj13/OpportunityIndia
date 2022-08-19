<?php
	return [
		'paymentsuccess'=>'http://dealer.franchiseindia.com/', //htttp://bizex.io/paymentsuccess
		'paymentcancelled'=>'http://dealer.franchiseindia.com/', //htttp://bizex.io/paymentcancelled
		'paymentfailure'=>'http://dealer.franchiseindia.com/', //htttp://bizex.io/paymentfailure
		"GST_RATE"=>18,
		"charges"=>[
			"OPTCRDC" => "2.06", 
			"OPTDBCRD" => "1.06", 
			"OPTNBK" => "2.12", 
			"OPTCASHC" => "0", 
			"OPTMOBP" => "0", 
			"OPTEMI" => "2.12", 
			"OPTWLT" => "0"
		],
		'hdfc'=>[
			'merchantKey' => '146311',
			'workingKey' => '3AC29CBF75955134A73E13D42C2CE53C', 
			'accessCode' => 'AVPC72EH82CN84CPNC',
			'CALLBACK_URL'=>'http://app.bizex.io/api/hdfc/callback',
		],
		'paytm'=>[
		    'ENVIRONMENT'  => 'PROD',
			'MERCHANT_KEY' => '5rhWKjQcFsNT5z_Y',
			'MERCHANT_MID' => 'Franch06162233000595',
			'MERCHANT_WEBSITE' => 'WEBPROD',
			'INDUSTRY_TYPE_ID' => 'Retail105',
			'REFUND_URL' => '',
			'STATUS_QUERY_URL' => 'https://securegw.paytm.in/merchant-status/getTxnStatus',
			'STATUS_QUERY_NEW_URL' => 'https://securegw.paytm.in/merchant-status/getTxnStatus',
			'TXN_URL' => 'https://securegw.paytm.in/theia/processTransaction',
			'CALLBACK_URL' => 'http://app.bizex.io/api/paytm/callback',
			'CALLBACK_URL_SERVICE' => 'http://bxapi.businessex.com/bexapi/paytmVerifyservicepayment'
		],
		'paymentStatus' => [
			'Initiated' => 'pending',
			'Success' => 'paid',
			'Failed' => 'failed',
			'Cancelled' => 'cancelled',
			'Declined' => 'declined'
		],
		'charges' => [
			'OPTCRDC' => "2.06",
			'OPTDBCRD' => "1.06",
			'OPTNBK' => "2.12",
			'OPTCASHC' => "0",
			'OPTMOBP' => "0",
			'OPTEMI' => "2.12",
			'OPTWLT' => "0",
			'Paytm' => '2.36'
		],
		"features"=>[
			"Top Slider Personalised Banner"=>[
				"Banner will be visible in the first fold of the portal",
			],
			"Top Premium Brands"=>[
				"Banner will be visible in the second fold of the portal along with the 4 other banners.",
			],
			"Top Super Brands"=>[
				"Banner will be visible in the second or third fold of the portal along with 8 other banners.",
			],
			"Featured Brands"=>[
				"Banner will be visible in the third or fourth fold of the portal along with 24 other banners.",
			],
			"Industry Page"=>[
				"Get sponsored ranking of your Company  under top two listings in the relevant master category.",
				"1000 Credit Points to Buy Investor Leads",
			],
			"Sector Page"=>[
				"Get sponsored ranking of your Company  under top two listings in the relevant sub category.",
				"500 additional Credit Points to Buy Investor Leads",
			],
			"Investment Page Listing in Industry Page"=>[
				"Get sponsored ranking of your Company on Investment wise search pages and Paid Listing on Industry Page",
				"Credit Points to Buy Investor Leads"
			],
			"Investment Page Listing in Sector Page"=>[
				"Get sponsored ranking of your Company  on Investment wise search pages and Paid Listing on Sector Page",
				"Credit Points to Buy Investor Leads",
			],
			"Location based listing in Industry Page"=>[
				"Get sponsored ranking of your Company  on Location wise search pages and Paid Listing on Industry Page",
				"1000 Credit Points to Buy Investor Leads",
			],
			"Location based listing in Sector Page"=>[
				"Get sponsored ranking of your Company  on Location wise search pages and Paid Listing on Sector Page",
				"1000 Credit Points to Buy Investor Leads"
			],
			"Industry Listing"=>[
				"Master Category listing with Company's Logo recognition",
				"Sub Category listing with Company's Logo Recognition",
				"Presence in search by Keyword & Category on www.Franchiseindia.com",
				"Presence in search by Investment and Location Result", 
				"Login Panel and Real Time Alert through email & SMS",
				"Access of Investors applications with their contact details", 
				"Option of Uploading 5 Banners for the effective presentation of your company profile",
				"Showcase upto 15 products with Product Image and description", 
				"1500 Credit Points to Buy Potential Investor Leads", 
			],
			"Sector Listing"=>[
				"Sub Category listing with Company's Logo Recognition",
				"Presence in search by Keyword & Category on www.Franchiseindia.com",
				"Presence in search by Investment and Location Result", 
				"Login Panel and Real Time Alert through email & SMS",
				"Access of Investors applications with their contact details", 
				"Option of Uploading 5 Banners for the effective presentation of your company profile",
				"Showcase upto 10 products with Product Image and description", 
				"1000 Credit Points to Buy Potential Investor Leads",
			]
		]
	];
?>
