<?php

$hashed = file_get_contents( WP_ROCKET_TESTS_FIXTURES_DIR . '/inc/Engine/Optimization/LazyRenderContent/Frontend/Controller/hashed.html' );
$expected = file_get_contents( WP_ROCKET_TESTS_FIXTURES_DIR . '/inc/Engine/Optimization/LazyRenderContent/Frontend/Controller/expected.html' );
$single_line_hashed = file_get_contents( WP_ROCKET_TESTS_FIXTURES_DIR . '/inc/Engine/Optimization/LazyRenderContent/Frontend/Controller/single-line-hashed.html' );
$single_line_expected = file_get_contents( WP_ROCKET_TESTS_FIXTURES_DIR . '/inc/Engine/Optimization/LazyRenderContent/Frontend/Controller/expected-single-line.html' );

return [
	'testShouldReturnEarlyWhenNoDbEntry' => [
		'config'   => [
			'has_lrc' => false,
			'below_the_fold' => '',
		],
		'html'     => '<html><head></head><body></body></html>',
		'expected' => '<html><head></head><body></body></html>',
	],
	'testShouldReturnEarlyWhenHashesNull' => [
		'config'   => [
			'has_lrc' => true,
			'below_the_fold' => '{ bar: "baz" }',
		],
		'html'     => '<html><head></head><body></body></html>',
		'expected' => '<html><head></head><body></body></html>',
	],
	'testShouldReturnEarlyWhenHashesNotArray' => [
		'config'   => [
			'has_lrc' => true,
			'below_the_fold' => json_encode( '123' ),
		],
		'html'     => '<html><head></head><body></body></html>',
		'expected' => '<html><head></head><body></body></html>',
	],
	'testShouldReturnUpdatedHtml' => [
		'config'   => [
			'has_lrc' => true,
			'below_the_fold' => json_encode( [ 'adc285f638b63c4110da1d803b711c40', 'd1f41b6001aa95d1577259dd681a9b19', 'fbfcccd11db41b93d3d0676c9e14fdc8' ] ),
		],
		'html'     => $hashed,
		'expected' => $expected,
	],
	'testShouldReturnUpdatedHtmlForSingleLine' => [
		'config'   => [
			'has_lrc' => true,
			'below_the_fold' => json_encode( [ '7b16eca0652d4703f83ba63e304f2030', '30c5235261141d2450dc033e5c78bbcc', 'b42afa69f728fcc707157eb61efa53cc' ] ),
		],
		'html'     => $single_line_hashed,
		'expected' => $single_line_expected,
	],
	'testShouldReturnEarlyWhenDBHasEmptyArray' => [
		'config'   => [
			'has_lrc' => true,
			'below_the_fold' => '[]',
		],
		'html'     => '<html><head></head><body><div data-rocket-location-hash="adc285f638b63c4110da1d803b711c40">hello here</div></body></html>',
		'expected' => '<html><head></head><body><div >hello here</div></body></html>',
	],
];
