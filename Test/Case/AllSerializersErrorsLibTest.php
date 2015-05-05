<?php
/**
 * Custom test suite to execute all SerializersErrors Plugin Lib tests.
 *
 * @package SerializersErrors.Test.Case
 */

/**
 * AllSerializersErrorsLibTest
 */
class AllSerializersErrorsLibTest extends PHPUnit_Framework_TestSuite {

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Serializers Errors Plugin Lib Tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__) . '/Lib/');
		return $suite;
	}
}
