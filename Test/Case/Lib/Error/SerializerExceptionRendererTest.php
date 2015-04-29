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
 * TestSerializerExceptionRenderer - used to override protected methods and
 * call directly
 */
class TestSerializerExceptionRenderer extends SerializerExceptionRenderer {

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error the BaseSerializerException error to render
	 * @return void
	 */
	public function renderSerializerException(BaseSerializerException $error) {
		return parent::renderSerializerException($error);
	}

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	public function defaultRender(BaseSerializerException $error) {
		return parent::defaultRender($error);
	}

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	public function renderAsJson(BaseSerializerException $error) {
		return parent::renderAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	public function renderAsJsonApi(BaseSerializerException $error) {
		return parent::renderAsJsonApi($error);
	}

	/**
	 * calls parent method
	 *
	 * @return bool returns true if JsonApi media request, false otherwise
	 */
	public function isJsonApiRequest() {
		return parent::isJsonApiRequest();
	}

	/**
	 * calls parent method
	 *
	 * @return bool returns true if Json media request, false otherwise
	 */
	public function isJsonRequest() {
		return parent::isJsonRequest();
	}
}

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

	/**
	 * test the isJsonApiRequest method
	 *
	 * @return void
	 */
	public function testIsJsonApiRequest() {
		$Controller = $this->getMock('Controller', array('render'));
		$Controller->request = $this->getMock('CakeRequest');
    $Controller->request->expects($this->once())
    	->method('accepts')
    	->with('application/vnd.api+json')
    	->will($this->returnValue(true));
		$Controller->response = new CakeResponse();

		$Renderer = new TestSerializerExceptionRenderer(new Exception());
		$Renderer->controller = $Controller;

		$this->assertEquals(
			true,
			$Renderer->isJsonApiRequest(),
			"::isJsonApiRequest should have returned true, when we have the accepts header returning true"
		);

		$Controller = $this->getMock('Controller', array('render'));
		$Controller->request = $this->getMock('CakeRequest');
    $Controller->request->expects($this->once())
    	->method('accepts')
    	->with('application/vnd.api+json')
    	->will($this->returnValue(false));
		$Controller->response = new CakeResponse();

		$Renderer = new TestSerializerExceptionRenderer(new Exception());
		$Renderer->controller = $Controller;

		$this->assertEquals(
			false,
			$Renderer->isJsonApiRequest(),
			"::isJsonApiRequest should have returned false, when we have the accepts header returning false"
		);
	}

	/**
	 * test the isJsonRequest method
	 *
	 * @return void
	 */
	public function testIsJsonRequest() {
		$Controller = $this->getMock('Controller', array('render'));
		$Controller->request = $this->getMock('CakeRequest');
    $Controller->request->expects($this->once())
    	->method('accepts')
    	->with('application/json')
    	->will($this->returnValue(true));
		$Controller->response = new CakeResponse();

		$Renderer = new TestSerializerExceptionRenderer(new Exception());
		$Renderer->controller = $Controller;

		$this->assertEquals(
			true,
			$Renderer->isJsonRequest(),
			"::isJsonRequest should have returned true, when we have the accepts header returning true"
		);

		$Controller = $this->getMock('Controller', array('render'));
		$Controller->request = $this->getMock('CakeRequest');
    $Controller->request->expects($this->once())
    	->method('accepts')
    	->with('application/json')
    	->will($this->returnValue(false));
		$Controller->response = new CakeResponse();

		$Renderer = new TestSerializerExceptionRenderer(new Exception());
		$Renderer->controller = $Controller;

		$this->assertEquals(
			false,
			$Renderer->isJsonRequest(),
			"::isJsonRequest should have returned false, when we have the accepts header returning false"
		);
	}
}

