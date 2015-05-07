<?php
/**
 * Tests the Base SerializerException Class to ensure it matches the expected
 * format
 *
 * @package SerializersErrors.Test.Case.Lib.Error
 */
App::import('Lib/Error', 'SerializersErrors.BaseSerializerException');

/**
 * BaseSerializerExceptionTest
 */
class BaseSerializerExceptionTest extends CakeTestCase {

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

	/**
	 * Confirm that the construct sets our values properly
	 *
	 * @return void
	 */
	public function testBaseConstructor() {
		$title = "New Title";
		$detail = "Custom detail message";
		$status = 406;
		$id = "13242134-456657-asdfasdf";
		$href = 'https://www.asdfasdfasdf.com/';
		$links = array('link' => 'link');
		$paths = array('something' => 'something');

		$testBaseSerializerException = new BaseSerializerException(
			$title,
			$detail,
			$status,
			$id,
			$href,
			$links,
			$paths
		);

		$this->assertInstanceOf('BaseSerializerException', $testBaseSerializerException);
		$this->assertInstanceOf('CakeException', $testBaseSerializerException);

		$this->assertEquals(
			$title,
			$testBaseSerializerException->title,
			"Title does not match {$title}"
		);
		$this->assertEquals(
			$detail,
			$testBaseSerializerException->detail,
			"Detail does not match {$detail}"
		);
		$this->assertEquals(
			$status,
			$testBaseSerializerException->status,
			"Status does not match {$status}"
		);
		$this->assertEquals(
			$status,
			$testBaseSerializerException->code,
			"Code does not match {$status}"
		);
		$this->assertEquals(
			$id,
			$testBaseSerializerException->id,
			"Id does not match {$id}"
		);
		$this->assertEquals(
			$href,
			$testBaseSerializerException->href,
			"Href does not match {$href}"
		);
		$this->assertEquals(
			$links,
			$testBaseSerializerException->links,
			"Links does not match our expectation"
		);
		$this->assertEquals(
			$paths,
			$testBaseSerializerException->paths,
			"Paths does not match expectation"
		);
	}

	/**
	 * test the __call method
	 *
	 * @return void
	 */
	public function testBaseMagicCallMethod() {
		$title = "New Title";
		$detail = "Custom detail message";
		$status = 406;
		$code = "Some Status Code";
		$id = "13242134-456657-asdfasdf";
		$href = 'https://www.asdfasdfasdf.com/';
		$links = array('link' => 'link');
		$paths = array('something' => 'something');

		$testBaseSerializerException = new BaseSerializerException(
			$title,
			$detail,
			$status,
			$code,
			$id,
			$href,
			$links,
			$paths
		);

		$this->assertEquals(
			$title,
			$testBaseSerializerException->title(),
			"BaseSerializerException::title() should match our passed in `title`: {$title}"
		);

		$this->assertEquals(
			$detail,
			$testBaseSerializerException->detail(),
			"BaseSerializerException::detail() should match our passed in `detail`: {$detail}"
		);

		$this->setExpectedException(
			'BadMethodCallException', "No method or property ::getSomething for this class"
		);
		$testBaseSerializerException->getSomething();
	}

	/**
	 * Confirm that the construct sets our values properly
	 *
	 * @return void
	 */
	public function testValidationConstructor() {
		$title = "New Title";
		$validationErrors = array(
			'username' => array(
				"Username can not be empty",
				"Username can only be alphanumeric",
			),
			'first_name' => array(
				"First Name can only be alphanumeric and not empty",
			),
		);
		$status = 422;

		$testValidationBaseSerializerException = new ValidationBaseSerializerException(
			$title,
			$validationErrors,
			$status
		);

		$this->assertInstanceOf('ValidationBaseSerializerException', $testValidationBaseSerializerException);
		$this->assertInstanceOf('CakeException', $testValidationBaseSerializerException);

		$this->assertEquals(
			$title,
			$testValidationBaseSerializerException->title,
			"Title does not match {$title}"
		);
		$this->assertEquals(
			$validationErrors,
			$testValidationBaseSerializerException->validationErrors,
			"Validation Errors does not match our input"
		);
		$this->assertEquals(
			$status,
			$testValidationBaseSerializerException->status,
			"Status does not match {$status}"
		);
	}

	/**
	 * test the __call method
	 *
	 * @return void
	 */
	public function testValidationMagicCallMethod() {
		$title = "New Title";
		$validationErrors = array(
			'username' => array(
				"Username can not be empty",
				"Username can only be alphanumeric",
			),
			'first_name' => array(
				"First Name can only be alphanumeric and not empty",
			),
		);
		$status = 422;

		$testValidationBaseSerializerException = new ValidationBaseSerializerException(
			$title,
			$validationErrors,
			$status
		);

		$this->assertEquals(
			$title,
			$testValidationBaseSerializerException->title(),
			"ValidationBaseSerializerException::title() should match our passed in `title`: {$title}"
		);

		$this->assertEquals(
			$status,
			$testValidationBaseSerializerException->status(),
			"ValidationBaseSerializerException::status() should match our passed in `status`: {$status}"
		);

		$this->assertEquals(
			$validationErrors,
			$testValidationBaseSerializerException->validationErrors(),
			"ValidationBaseSerializerException::validationErrors() should match our passed in `detail`"
		);

		$this->setExpectedException(
			'BadMethodCallException', "No method or property ::getSomething for this class"
		);
		$testValidationBaseSerializerException->getSomething();
	}
}
