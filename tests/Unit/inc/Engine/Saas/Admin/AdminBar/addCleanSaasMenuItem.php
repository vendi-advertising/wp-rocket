<?php

namespace WP_Rocket\Tests\Unit\inc\Engine\Saas\Admin\AdminBar;

use Mockery;
use Brain\Monkey\Functions;
use WP_Admin_Bar;
use WP_Rocket\Admin\Options_Data;
use WP_Rocket\Engine\Common\Context\ContextInterface;
use WP_Rocket\Engine\Saas\Admin\AdminBar;
use WP_Rocket\Tests\Unit\TestCase;

/**
 * @covers \WP_Rocket\Engine\Saas\Admin\AdminBar::add_clean_saas_menu_item
 * @group  Saas
 */
class Test_AddCleanSaasMenuItem extends TestCase {
	private $admin_bar;
	private $options;
	private $rucss_url_context;
	private $wp_admin_bar;

	public static function setUpBeforeClass(): void {
		parent::setUpBeforeClass();

		require_once WP_ROCKET_TESTS_FIXTURES_DIR . '/WP_Admin_Bar.php';
	}

	protected function setUp(): void {
		parent::setUp();

		$this->options           = Mockery::mock( Options_Data::class );
		$this->rucss_url_context = Mockery::mock( ContextInterface::class );
		$this->admin_bar         = new AdminBar( $this->options, $this->rucss_url_context, '' );
		$this->wp_admin_bar      = new WP_Admin_Bar();

		$this->stubTranslationFunctions();
	}

	/**
	 * @dataProvider configTestData
	 */
	public function testShouldDoExpected( $config, $expected ) {
		Functions\when( 'rocket_valid_key' )
			->justReturn( $config['rocket_valid_key'] );
		Functions\when( 'wp_get_environment_type' )
			->justReturn( $config['environment'] );
		Functions\when( 'is_admin' )
			->justReturn( $config['is_admin'] );

		$this->options->shouldReceive( 'get' )
			->with( 'remove_unused_css', 0 )
			->andReturn( $config['remove_unused_css'] );

		Functions\when( 'current_user_can' )
			->justReturn( $config['current_user_can'] );

		Functions\when( 'wp_nonce_url' )->alias(
			function ( $url ) {
				return str_replace( '&', '&amp;', "{$url}&_wpnonce=123456" );
			}
		);

		Functions\when( 'admin_url' )->alias(
			function ( $path ) {
				return "http://example.org/wp-admin/{$path}";
			}
		);

		$this->admin_bar->add_clean_saas_menu_item( $this->wp_admin_bar );

		$node = $this->wp_admin_bar->get_node( 'clean-saas' );

		if ( null === $expected ) {
			$this->assertNull( $node );
			return;
		}

		$this->assertSame(
			$expected['id'],
			$node->id
		);

		$this->assertSame(
			$expected['title'],
			$node->title
		);
	}
}
