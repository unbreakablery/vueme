<?php

return [
    'expiration_limit' => 2,
    'biller' => 'stripe',
    'product_default' => 'onetime_credits_500_500',
    'billers' => [
        'stripe' => 1,
        'ios' => 2,
        'android' => 3,
        'payeezy' => 4,
    ],
    'android_pub_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzA5EKnaGrlGokPDjTAfVqBw/940BikxmTCNEmDJebY/4QluxQ9VyRu5ZTey8WQ2JSK6rz7obukRDhbqT/1voyeE++kjwPjQSbdMA87Gwy4bDpqFn/QTOnk0hwTsTT99k8gyZfF9CJqr1eoqdgCWnJPW+nL+h89DrTXG39HAEhcOX2khUngWpo3SKpClE0BYmmsfWW7AczMSZ2xSvZ/0WuLPHQHQcXG4fCxdG/JCj8RDKfk5gzUG/hOCGKoeOPtlbjI7JIk+IPl7x6lVyhDNAqBvH01vRgcY0Y3FzAkm+zG6O0+4L6vGPXjNuy+DNe5DoBSEC5S/1saP6FZ/aZ7DgmwIDAQAB',
    'products' => [
        'onetime_credits_100_099' => [
            'amount'       => 0.99,
            'description'  => 'Purchase 100 credits for $0.99',
            'recur_amount' => 0,
        ],
        'onetime_credits_10_100' => [
            'amount'       => 1.00,
            'description'  => 'Purchase 100 credits for $1.00',
            'recur_amount' => 0,
        ],
        'onetime_credits_500_499' => [
            'amount'       => 4.99,
            'description'  => 'Purchase 500 credits for $4.99',
            'recur_amount' => 0,
        ],
        'onetime_credits_500_500' => [
            'amount'       => 5.00,
            'description'  => 'Purchase 500 credits for $5.00',
            'recur_amount' => 0,
        ],
        'onetime_credits_1000_999' => [
            'amount'       => 9.99,
            'description'  => 'Purchase 1000 credits for $9.99',
            'recur_amount' => 0,
        ],
        'onetime_credits_1000_1000' => [
	        'amount'       => 10.00,
	        'description'  => 'Purchase 1000 credits for $10.00',
	        'recur_amount' => 0,
        ],
        'onetime_credits_1500_1499' => [
	        'amount'       => 14.99,
	        'description'  => 'Purchase 1000 credits for $10.00',
	        'recur_amount' => 0,
        ],
        'onetime_credits_2500_2499' => [
            'amount'       => 24.99,
            'description'  => 'Purchase 1500 credits for $14.99',
            'recur_amount' => 0,
        ],
        'onetime_credits_5000_4999' => [
            'amount'       => 49.99,
            'description'  => 'Purchase 5000 credits for $49.99',
            'recur_amount' => 0,
        ],
        'renewable_credits_2500_2499' => [
	        'amount'       => 24.99,
	        'description'  => 'Purchase 25.00 credits for $24.99 with auto-renew',
	        'recur_amount' => 3.00,
        ],
        'renewable_credits_1500_1499' => [
	        'amount'       => 14.99,
	        'description'  => 'Purchase 15.00 credits for $14.99 with auto-renew',
	        'recur_amount' => 3.00,
        ],
        'renewable_credits_5000_4999' => [
	        'amount'       => 49.99,
	        'description'  => 'Purchase 50.00 credits for $49.99 with auto-renew',
	        'recur_amount' => 5.00,
        ],
        'renewable_credits_7500_7499' => [
	        'amount'       => 74.99,
	        'description'  => 'Purchase 75.00 credits for $74.99 with auto-renew',
	        'recur_amount' => 7.50,
        ],
        'onetime_credits_7500_7499' => [
	        'amount'       => 74.99,
	        'description'  => 'Purchase 75.00 credits for $74.99',
	        'recur_amount' => 7.50,
        ],
        'renewable_credits_10000_9999' => [
	        'amount'       => 99.99,
	        'description'  => 'Purchase 100.00 credits for $99.99 with auto-renew',
	        'recur_amount' => 10.00,
        ],
        'onetime_credits_10000_9999' => [
	        'amount'       => 99.99,
	        'description'  => 'Purchase 100.00 credits for $99.99',
	        'recur_amount' => 10.00,
        ],
        'renewable_credits_2500_2500' => [
	        'amount'       => 25.00,
	        'description'  => 'Purchase 25.00 credits for $25.00 with auto-renew',
	        'recur_amount' => 3.00,
        ],
        'onetime_credits_2500_2500' => [
	        'amount'       => 25.00,
	        'description'  => 'Purchase 25.00 credits for $25.00',
	        'recur_amount' => 3.00,
        ],
        'renewable_credits_3500_3500' => [
	        'amount'       => 35.00,
	        'description'  => 'Purchase 35.00 credits for $35.00 with auto-renew',
	        'recur_amount' => 3.50,
        ],
        'onetime_credits_3500_3500' => [
	        'amount'       => 35.00,
	        'description'  => 'Purchase 35.00 credits for $35.00',
	        'recur_amount' => 3.50,
        ],
        'renewable_credits_5000_5000' => [
	        'amount'       => 50.00,
	        'description'  => 'Purchase 50.00 credits for $50.00 with auto-renew',
	        'recur_amount' => 5.00,
        ],
        'onetime_credits_5000_5000' => [
	        'amount'       => 50.00,
	        'description'  => 'Purchase 50.00 credits for $50.00',
	        'recur_amount' => 5.00,
        ],

        'renewable_credits_10000_10000' => [
	        'amount'       => 100.00,
	        'description'  => 'Purchase 100.00 credits for $100.00 with auto-renew',
	        'recur_amount' => 10.00,
        ],
        'onetime_credits_10000_10000' => [
	        'amount'       => 100.00,
	        'description'  => 'Purchase 100.00 credits for $100.00',
	        'recur_amount' => 10.00,
        ],

        'renewable_credits_20000_20000' => [
	        'amount'       => 200.00,
	        'description'  => 'Purchase 200.00 credits for $200.00 with auto-renew',
	        'recur_amount' => 20.00,
        ],
        'onetime_credits_20000_20000' => [
	        'amount'       => 200.00,
	        'description'  => 'Purchase 200.00 credits for $200.00',
	        'recur_amount' => 20.00,
        ],

        'renewable_credits_30000_30000' => [
	        'amount'       => 300.00,
	        'description'  => 'Purchase 300.00 credits for $300.00 with auto-renew',
	        'recur_amount' => 30.00,
        ],
        'onetime_credits_30000_30000' => [
	        'amount'       => 300.00,
	        'description'  => 'Purchase 300.00 credits for $300.00',
	        'recur_amount' => 30.00,
        ],

        'renewable_credits_50000_50000' => [
	        'amount'       => 500.00,
	        'description'  => 'Purchase 500.00 credits for $500.00 with auto-renew',
	        'recur_amount' => 50.00,
        ],
        'onetime_credits_50000_50000' => [
	        'amount'       => 500.00,
	        'description'  => 'Purchase 500.00 credits for $500.00',
	        'recur_amount' => 50.00,
        ],

        'renewable_credits_75000_75000' => [
	        'amount'       => 750.00,
	        'description'  => 'Purchase 750.00 credits for $750.00 with auto-renew',
	        'recur_amount' => 50.00,
        ],
        'onetime_credits_75000_75000' => [
	        'amount'       => 750.00,
	        'description'  => 'Purchase 750.00 credits for $750.00',
	        'recur_amount' => 50.00,
        ],
        'renewable_credits_100000_100000' => [
	        'amount'       => 1000.00,
	        'description'  => 'Purchase 1000.00 credits for $1000.00 with auto-renew',
	        'recur_amount' => 50.00,
        ],
        'onetime_credits_100000_100000' => [
	        'amount'       => 1000.00,
	        'description'  => 'Purchase 1000.00 credits for $1000.00',
	        'recur_amount' => 50.00,
        ],

    ],
];
