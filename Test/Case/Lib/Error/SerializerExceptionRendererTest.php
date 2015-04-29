<?php
/**
 * Test the SerializerExceptionRenderer class
 *
 * @package SerializersErrors.Test.Case.Lib.Error
 */
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('SerializerExceptionRenderer', 'SerializersErrors.Error');
App::uses('ConnectionManager', 'Model');

/**
 * SerializerExceptionRendererTest
 */
class SerializerExceptionRendererTest extends CakeTestCase {

	/**
	 * setUp
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * tearDown
	 *
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();
	}

	public function testIncomplete() {
		$this->markTestIncomplete('Tests for SerializerExceptionRenderer Class are incomplete');
	}
}

