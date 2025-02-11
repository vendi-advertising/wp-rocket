<?php
return [
	'testShouldCallSendToSaas' => [
		'config'   => [
			'wp_env' => 'production',
			'remove_unused_css' => 0,
			'is_allowed' => [1],
			'license_expired' => false,
			'links' => [
				'http://example.com/link1',
				'http://example.com/link2',
			],
		],
		'expected' => 2,
	],
	'testShouldNotCallSendToSaasWhenLicenseExpired' => [
		'config'   => [
			'wp_env' => 'production',
			'remove_unused_css' => 0,
			'is_allowed' => [1],
			'license_expired' => true,
			'links' => [
				'http://example.com/link1',
				'http://example.com/link2',
			],
		],
		'expected' => 0,
	],
	'testShouldNotCallSendToSaasWhenLocalEnv' => [
		'config'   => [
			'wp_env' => 'local',
			'remove_unused_css' => 0,
			'is_allowed' => [1],
			'license_expired' => false,
			'links' => [
				'http://example.com/link1',
				'http://example.com/link2',
			],
		],
		'expected' => 0,
	],
	'testShouldNotCallSendToSaasWhenRemoveUnusedCssEnabled' => [
		'config'   => [
			'wp_env' => 'production',
			'remove_unused_css' => 1,
			'license_expired' => false,
			'is_allowed' => [1],
			'links' => [
				'http://example.com/link1',
				'http://example.com/link2',
			],
		],
		'expected' => 0,
	],
	'testShouldNotCallSendToSaasWhenNotAllowed' => [
		'config'   => [
			'wp_env' => 'production',
			'remove_unused_css' => 0,
			'license_expired' => false,
			'is_allowed' => [],
			'links' => [
				'http://example.com/link1',
				'http://example.com/link2',
			],
		],
		'expected' => 0,
	],
];
