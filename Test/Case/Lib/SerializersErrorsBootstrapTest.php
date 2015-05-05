<?php
/**
 * Verify SerializersErrors Bootstrap works correctly
 *
 * @package SerializersErrors.Test.Case.Lib
 */

/**
 * SerializersErrorsBootstrapTest
 */
class SerializersErrorsBootstrapTest extends CakeTestCase {

	/**
	 * There is nothing to test. This just completes code coverage.
	 */
	public function testBootstrap() {
		require_once APP . 'Plugin' . DS . 'SerializersErrors' . DS . 'Config' . DS . 'bootstrap.php';
		$baseSerializerException = new BaseSerializerException("New BaseSerializerException");
	}

}
