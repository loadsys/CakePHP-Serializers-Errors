<?php
/**
 * Custom test suite to execute all SerializersErrors Plugin tests.
 *
 * @package SerializersErrors.Test.Case
 */

/**
 * AllSerializersErrorsTest
 */
class AllSerializersErrorsTest extends PHPUnit_Framework_TestSuite {

	/**
	 * the suites to load
	 *
	 * @var array
	 */
	public static $suites = array(
		// Lib Folder
		'AllSerializersErrorsLibTest.php',
		'AllSerializersErrorsErrorsTest.php',
	);

	/**
	 * load the suites
	 *
	 * @return CakeTestSuite
	 */
	public static function suite() {
		$path = dirname(__FILE__) . '/';
		$suite = new CakeTestSuite('All SerializersErrors Tests');

		foreach (self::$suites as $file) {
			if (is_readable($path . $file)) {
				$suite->addTestFile($path . $file);
			}
		}
		return $suite;
	}

}
