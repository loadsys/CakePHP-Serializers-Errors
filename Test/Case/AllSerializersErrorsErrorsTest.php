<?php
/**
 * Custom test suite to execute all SerializersErrors Plugin Error tests.
 *
 * @package SerializersErrors.Test.Case
 */

/**
 * AllSerializersErrorsErrorsTest
 */
class AllSerializersErrorsErrorsTest extends PHPUnit_Framework_TestSuite {

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Serializers Errors Plugin Error Tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__) . '/Lib/Error/');
		return $suite;
	}
}
