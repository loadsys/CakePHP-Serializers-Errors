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
	 * @param HttpException $error the HttpException error to render
	 * @return void
	 */
	public function renderHttpException(HttpException $error) {
		return parent::renderHttpException($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error the CakeException error to render
	 * @return void
	 */
	public function renderCakeException(CakeException $error) {
		return parent::renderCakeException($error);
	}

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
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	protected function renderHttpAsJson(HttpException $error) {
		return parent::renderHttpAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	protected function renderHttpAsJsonApi(HttpException $error) {
		return parent::renderHttpAsJsonApi($error);
	}

	/**
	 * calls parent method
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	protected function defaultHttpRender(HttpException $error) {
		return parent::defaultHttpRender($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	protected function renderCakeAsJson(CakeException $error) {
		return parent::renderCakeAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	protected function renderCakeAsJsonApi(CakeException $error) {
		return parent::renderCakeAsJsonApi($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	protected function defaultCakeRender(CakeException $error) {
		return parent::defaultCakeRender($error);
	}

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	public function defaultSerializerRender(BaseSerializerException $error) {
		return parent::defaultSerializerRender($error);
	}

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	public function renderSerializerAsJson(BaseSerializerException $error) {
		return parent::renderSerializerAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	public function renderSerializerAsJsonApi(BaseSerializerException $error) {
		return parent::renderSerializerAsJsonApi($error);
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
	 * return a Render object with some properties
	 *
	 * @param string $acceptsMockReturn the accepts header to mock return true for
	 * @param Exception $exception the exception to build the ExceptionRenderer around
	 * @return TestSerializerExceptionRenderer with a mocked Controller->Request
	 */
	protected function returnRenderer($acceptsMockReturn, $exception) {
		$mockController = $this->getMock('Controller', array('render'));
		$mockController->expects($this->any())
			->method('render')
			->will($this->returnValue("cake-controller-render"));

		$mockController->request = $this->getMock('CakeRequest', array('accepts', 'here'));
		$mockController->request->expects($this->any())
			->method('accepts')
			->with($acceptsMockReturn)
			->will($this->returnValue(true));
		$mockController->request->expects($this->any())
			->method('here')
			->will($this->returnValue("/this/is/faked/url"));

		$mockController->response = $this->getMock('CakeResponse', array('send'));
		$mockController->response->expects($this->any())
			->method('send')
			->will($this->returnValue("cake-response-send"));

		$exceptionRenderer = new TestSerializerExceptionRenderer($exception);
		$exceptionRenderer->controller = $mockController;

		return $exceptionRenderer;
	}

	/**
	 * test the renderSerializerAsJsonApi method
	 *
	 * @return void
	 */
	public function testRenderSerializerAsJsonApi() {
		$baseSerializerException = new BaseSerializerException();
		$exceptionRenderer = $this->returnRenderer('application/vnd.api+json', $baseSerializerException);

		$response = $exceptionRenderer->renderSerializerAsJsonApi($baseSerializerException);

		$this->assertEquals(
			"400",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 400"
		);
		$this->assertEquals(
			"application/vnd.api+json",
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal application/vnd.api+json"
		);
		$this->assertInternalType(
			"string",
			$exceptionRenderer->controller->response->body(),
			"Our body is not a string"
		);
		$this->assertInstanceOf(
			"stdClass",
			json_decode($exceptionRenderer->controller->response->body()),
			"Our body is not a json_encoded array"
		);
		$this->assertSame(
			'{"errors":{"id":"","href":"","status":"400","code":"400","title":"Base Serializer Exception","detail":"Base Serializer Exception","links":"","paths":""}}',
			$exceptionRenderer->controller->response->body(),
			"Our body does not match the expected string"
		);
	}

	/**
	 * test the isJsonApiRequest method when returns true
	 *
	 * @return void
	 */
	public function testIsJsonApiRequestTrue() {
		$mockController = $this->getMock('Controller', array('render', 'here'));
		$mockController->request = $this->getMock('CakeRequest');
		$mockController->request->expects($this->once())
			->method('accepts')
			->with('application/vnd.api+json')
			->will($this->returnValue(true));
		$mockController->response = new CakeResponse();

		$exceptionRenderer = new TestSerializerExceptionRenderer(new Exception());
		$exceptionRenderer->controller = $mockController;

		$this->assertEquals(
			true,
			$exceptionRenderer->isJsonApiRequest(),
			"::isJsonApiRequest should have returned true, when we have the accepts header returning true"
		);
	}

	/**
	 * test the isJsonApiRequest method when returns false
	 *
	 * @return void
	 */
	public function testIsJsonApiRequestFalse() {
		$mockController = $this->getMock('Controller', array('render', 'here'));
		$mockController->request = $this->getMock('CakeRequest');
		$mockController->request->expects($this->once())
			->method('accepts')
			->with('application/vnd.api+json')
			->will($this->returnValue(false));
		$mockController->response = new CakeResponse();

		$exceptionRenderer = new TestSerializerExceptionRenderer(new Exception());
		$exceptionRenderer->controller = $mockController;

		$this->assertEquals(
			false,
			$exceptionRenderer->isJsonApiRequest(),
			"::isJsonApiRequest should have returned false, when we have the accepts header returning false"
		);
	}

	/**
	 * test the isJsonRequest method when returns true
	 *
	 * @return void
	 */
	public function testIsJsonRequestTrue() {
		$mockController = $this->getMock('Controller', array('render', 'here'));
		$mockController->request = $this->getMock('CakeRequest');
		$mockController->request->expects($this->once())
			->method('accepts')
			->with('application/json')
			->will($this->returnValue(true));
		$mockController->response = new CakeResponse();

		$exceptionRenderer = new TestSerializerExceptionRenderer(new Exception());
		$exceptionRenderer->controller = $mockController;

		$this->assertEquals(
			true,
			$exceptionRenderer->isJsonRequest(),
			"::isJsonRequest should have returned true, when we have the accepts header returning true"
		);
	}

	/**
	 * test the isJsonRequest method when returns false
	 *
	 * @return void
	 */
	public function testIsJsonRequestFalse() {
		$mockController = $this->getMock('Controller', array('render', 'here'));
		$mockController->request = $this->getMock('CakeRequest');
		$mockController->request->expects($this->once())
			->method('accepts')
			->with('application/json')
			->will($this->returnValue(false));
		$mockController->response = new CakeResponse();

		$exceptionRenderer = new TestSerializerExceptionRenderer(new Exception());
		$exceptionRenderer->controller = $mockController;

		$this->assertEquals(
			false,
			$exceptionRenderer->isJsonRequest(),
			"::isJsonRequest should have returned false, when we have the accepts header returning false"
		);
	}

}

