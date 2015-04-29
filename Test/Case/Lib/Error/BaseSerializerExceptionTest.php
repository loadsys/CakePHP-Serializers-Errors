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
	public function testConstructor() {
		$title = "New Title";
		$detail ="Custom detail message";
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

}
