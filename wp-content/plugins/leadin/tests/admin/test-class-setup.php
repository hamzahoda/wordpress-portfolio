<?php
/**
 * Class LeadinUtilsTest
 *
 * @package Leadin
 */

use \Leadin\admin\Setup;
/**
 * Test leadin-utils.php
 */
class LeadinAdminTest extends WP_UnitTestCase {
	const TEST_PORTAL_ID = 12345;
	const TEST_DOMAIN    = 'my.test.domain';

	private $setup_obj;
	private $validate_method;

	public function setUp() {
		$this->setup_obj       = new Setup();
		$class                 = new ReflectionClass( '\Leadin\admin\Setup' );
		$this->validate_method = $class->getMethod( 'validate' );
		$this->validate_method->setAccessible( true );
	}

	public function tearDown() {
		delete_option( 'leadin_portalId' );
		delete_option( 'leadin_portal_domain' );
	}

	public function test_action() {
		$res = has_action( 'admin_init', array( $this->setup_obj, 'init' ) );
		$this->assertEquals( $res, true );
	}

	public function test_valid_options() {
		add_option( 'leadin_portalId', self::TEST_PORTAL_ID );
		$this->validate_method->invokeArgs( $this->setup_obj, array() );
		$this->assertEquals( get_option( 'leadin_portalId' ), self::TEST_PORTAL_ID );
		$this->assertEquals( get_option( 'leadin_portal_domain' ), false );

		add_option( 'leadin_portalId', strval( self::TEST_PORTAL_ID ) );
		$this->validate_method->invokeArgs( $this->setup_obj, array() );
		$this->assertEquals( get_option( 'leadin_portalId' ), strval( self::TEST_PORTAL_ID ) );
		$this->assertEquals( get_option( 'leadin_portal_domain' ), false );

		add_option( 'leadin_portal_domain', self::TEST_DOMAIN );
		$this->validate_method->invokeArgs( $this->setup_obj, array() );
		$this->assertEquals( get_option( 'leadin_portalId' ), self::TEST_PORTAL_ID );
		$this->assertEquals( get_option( 'leadin_portal_domain' ), self::TEST_DOMAIN );
	}

	public function test_invalid_portal_id() {
		add_option( 'leadin_portalId', 'foo' );
		add_option( 'leadin_portal_domain', self::TEST_DOMAIN );
		$this->validate_method->invokeArgs( $this->setup_obj, array() );
		$this->assertEquals( get_option( 'leadin_portalId' ), false );
		$this->assertEquals( get_option( 'leadin_portal_domain' ), false );
	}

	public function test_invalid_portal_domain() {
		add_option( 'leadin_portalId', self::TEST_PORTAL_ID );
		add_option( 'leadin_portal_domain', 'invalid domain' );
		$this->validate_method->invokeArgs( $this->setup_obj, array() );
		$this->assertEquals( get_option( 'leadin_portalId' ), self::TEST_PORTAL_ID );
		$this->assertEquals( get_option( 'leadin_portal_domain' ), false );
	}
}
