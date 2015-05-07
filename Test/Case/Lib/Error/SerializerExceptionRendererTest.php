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
	public function renderHttpAsJson(HttpException $error) {
		return parent::renderHttpAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	public function renderHttpAsJsonApi(HttpException $error) {
		return parent::renderHttpAsJsonApi($error);
	}

	/**
	 * calls parent method
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	public function defaultHttpRender(HttpException $error) {
		return parent::defaultHttpRender($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	public function renderCakeAsJson(CakeException $error) {
		return parent::renderCakeAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	public function renderCakeAsJsonApi(CakeException $error) {
		return parent::renderCakeAsJsonApi($error);
	}

	/**
	 * calls parent method
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	public function defaultCakeRender(CakeException $error) {
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
	 * @param ValidationBaseSerializerException $error an instance of ValidationBaseSerializerException
	 * @return void
	 */
	public function defaultValidationSerializerRender(ValidationBaseSerializerException $error) {
		return parent::defaultValidationSerializerRender($error);
	}

	/**
	 * calls parent method
	 *
	 * @param ValidationBaseSerializerException $error an instance of ValidationBaseSerializerException
	 * @return void
	 */
	public function renderValidationSerializerAsJson(ValidationBaseSerializerException $error) {
		return parent::renderValidationSerializerAsJson($error);
	}

	/**
	 * calls parent method
	 *
	 * @param ValidationBaseSerializerException $error an instance of ValidationBaseSerializerException
	 * @return void
	 */
	public function renderValidationSerializerAsJsonApi(ValidationBaseSerializerException $error) {
		return parent::renderValidationSerializerAsJsonApi($error);
	}

	/**
	 * calls parent method
	 *
	 * @return void
	 */
	public function addHttpCodes() {
		return parent::addHttpCodes();
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
	 * test the render method, in all the various cases
	 *
	 * @return void
	 */
	public function testRender() {
		$exception = new BaseSerializerException();
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('renderSerializerException'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('renderSerializerException')
			->with($exception)
			->will($this->returnValue("renderSerializerException"));
		$mockRenderer->error = $exception;

		$this->assertEquals(
			"renderSerializerException",
			$mockRenderer->render($exception),
			"render did not return our mocked value `renderSerializerException` for a BaseSerializerException"
		);

		$exception = new CakeException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('renderCakeException'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('renderCakeException')
			->with($exception)
			->will($this->returnValue("renderCakeException"));
		$mockRenderer->error = $exception;

		$this->assertEquals(
			"renderCakeException",
			$mockRenderer->render($exception),
			"render did not return our mocked value `renderCakeException` for a CakeException"
		);

		$exception = new HttpException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('renderHttpException'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('renderHttpException')
			->with($exception)
			->will($this->returnValue("renderHttpException"));
		$mockRenderer->error = $exception;

		$this->assertEquals(
			"renderHttpException",
			$mockRenderer->render($exception),
			"render did not return our mocked value `renderHttpException` for a HttpException"
		);

		$exception = new Exception();
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('render'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('render')
			->will($this->returnValue("render"));
		$mockRenderer->error = $exception;

		$this->assertEquals(
			"render",
			$mockRenderer->render($exception),
			"render did not return our mocked value `render` for a Exception"
		);
	}

	/**
	 * test the renderHttpException method when calling renderHttpAsJsonApi
	 *
	 * @return void
	 */
	public function testRenderHttpExceptionJsonApiRequest() {
		$httpException = new HttpException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'renderHttpAsJsonApi'),
			array($httpException)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(true));
		$mockRenderer->expects($this->once())
			->method('renderHttpAsJsonApi')
			->with($httpException)
			->will($this->returnValue("renderHttpAsJsonApi"));

		$this->assertEquals(
			"renderHttpAsJsonApi",
			$mockRenderer->renderHttpException($httpException),
			"renderHttpException did not return our mocked value"
		);
	}

	/**
	 * test the renderHttpException method when calling renderHttpAsJson
	 *
	 * @return void
	 */
	public function testRenderHttpExceptionJsonRequest() {
		$httpException = new HttpException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'isJsonRequest', 'renderHttpAsJson'),
			array($httpException)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('isJsonRequest')
			->will($this->returnValue(true));
		$mockRenderer->expects($this->once())
			->method('renderHttpAsJson')
			->with($httpException)
			->will($this->returnValue("renderHttpAsJson"));

		$this->assertEquals(
			"renderHttpAsJson",
			$mockRenderer->renderHttpException($httpException),
			"renderHttpException did not return our mocked value"
		);
	}

	/**
	 * test the renderHttpException method when calling defaultHttpRender
	 *
	 * @return void
	 */
	public function testRenderHttpExceptionDefaultRequest() {
		$httpException = new HttpException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'isJsonRequest', 'defaultHttpRender'),
			array($httpException)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('isJsonRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('defaultHttpRender')
			->with($httpException)
			->will($this->returnValue("defaultHttpRender"));

		$this->assertEquals(
			"defaultHttpRender",
			$mockRenderer->renderHttpException($httpException),
			"renderHttpException did not return our mocked value"
		);
	}

	/**
	 * test the renderCakeException method when calling renderCakeAsJsonApi
	 *
	 * @return void
	 */
	public function testRenderCakeExceptionJsonApiRequest() {
		$exception = new CakeException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'renderCakeAsJsonApi'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(true));
		$mockRenderer->expects($this->once())
			->method('renderCakeAsJsonApi')
			->with($exception)
			->will($this->returnValue("renderCakeAsJsonApi"));

		$this->assertEquals(
			"renderCakeAsJsonApi",
			$mockRenderer->renderCakeException($exception),
			"renderCakeException did not return our mocked value"
		);
	}

	/**
	 * test the renderCakeException method when calling renderCakeAsJson
	 *
	 * @return void
	 */
	public function testRenderCakeExceptionJsonRequest() {
		$exception = new CakeException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'isJsonRequest', 'renderCakeAsJson'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('isJsonRequest')
			->will($this->returnValue(true));
		$mockRenderer->expects($this->once())
			->method('renderCakeAsJson')
			->with($exception)
			->will($this->returnValue("renderCakeAsJson"));

		$this->assertEquals(
			"renderCakeAsJson",
			$mockRenderer->renderCakeException($exception),
			"renderCakeException did not return our mocked value"
		);
	}

	/**
	 * test the renderCakeException method when calling defaultCakeRender
	 *
	 * @return void
	 */
	public function testRenderCakeExceptionDefaultRequest() {
		$exception = new CakeException("Message", 400);
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'isJsonRequest', 'defaultCakeRender'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('isJsonRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('defaultCakeRender')
			->with($exception)
			->will($this->returnValue("defaultCakeRender"));

		$this->assertEquals(
			"defaultCakeRender",
			$mockRenderer->renderCakeException($exception),
			"renderCakeException did not return our mocked value"
		);
	}

	/**
	 * test the renderSerializerException method when calling renderSerializerAsJsonApi
	 *
	 * @return void
	 */
	public function testRenderSerializerExceptionJsonApiRequest() {
		$exception = new BaseSerializerException();
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'renderSerializerAsJsonApi'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(true));
		$mockRenderer->expects($this->once())
			->method('renderSerializerAsJsonApi')
			->with($exception)
			->will($this->returnValue("renderSerializerAsJsonApi"));

		$this->assertEquals(
			"renderSerializerAsJsonApi",
			$mockRenderer->renderSerializerException($exception),
			"renderSerializerException did not return our mocked value"
		);
	}

	/**
	 * test the renderSerializerException method when calling renderCakeAsJson
	 *
	 * @return void
	 */
	public function testRenderSerializerExceptionJsonRequest() {
		$exception = new BaseSerializerException();
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'isJsonRequest', 'renderSerializerAsJson'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('isJsonRequest')
			->will($this->returnValue(true));
		$mockRenderer->expects($this->once())
			->method('renderSerializerAsJson')
			->with($exception)
			->will($this->returnValue("renderSerializerAsJson"));

		$this->assertEquals(
			"renderSerializerAsJson",
			$mockRenderer->renderSerializerException($exception),
			"renderSerializerException did not return our mocked value"
		);
	}

	/**
	 * test the renderSerializerException method when calling defaultCakeRender
	 *
	 * @return void
	 */
	public function testRenderSerializerExceptionDefaultRequest() {
		$exception = new BaseSerializerException();
		$mockRenderer = $this->getMock('TestSerializerExceptionRenderer',
			array('isJsonApiRequest', 'isJsonRequest', 'defaultSerializerRender'),
			array($exception)
		);
		$mockRenderer->expects($this->once())
			->method('isJsonApiRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('isJsonRequest')
			->will($this->returnValue(false));
		$mockRenderer->expects($this->once())
			->method('defaultSerializerRender')
			->with($exception)
			->will($this->returnValue("defaultSerializerRender"));

		$this->assertEquals(
			"defaultSerializerRender",
			$mockRenderer->renderSerializerException($exception),
			"renderSerializerException did not return our mocked value"
		);
	}

	/**
	 * test the defaultHttpRender method
	 *
	 * @return void
	 */
	public function testDefaultHttpRender() {
		$httpException = new HttpException("Message", 400);
		$exceptionRenderer = $this->returnRenderer('text/html', $httpException);

		$response = $exceptionRenderer->defaultHttpRender($httpException);

		$this->assertEquals(
			"400",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 400"
		);
		$this->assertEquals(
			'text/html',
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal text/html"
		);
		$this->assertArrayHasKey(
			"code",
			$exceptionRenderer->controller->viewVars,
			"We do not have an code viewVars"
		);
		$this->assertArrayHasKey(
			"name",
			$exceptionRenderer->controller->viewVars,
			"We do not have an name viewVars"
		);
		$this->assertArrayHasKey(
			"message",
			$exceptionRenderer->controller->viewVars,
			"We do not have an message viewVars"
		);
		$this->assertArrayHasKey(
			"url",
			$exceptionRenderer->controller->viewVars,
			"We do not have an url viewVars"
		);
		$this->assertArrayHasKey(
			"error",
			$exceptionRenderer->controller->viewVars,
			"We do not have an error viewVars"
		);
		$this->assertSame(
			null,
			$response,
			"Our response does not match null"
		);
	}

	/**
	 * test the renderHttpAsJson method
	 *
	 * @return void
	 */
	public function testRenderHttpAsJson() {
		$httpException = new HttpException("Message", 400);
		$exceptionRenderer = $this->returnRenderer('application/json', $httpException);

		$response = $exceptionRenderer->renderHttpAsJson($httpException);

		$this->assertEquals(
			"400",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 400"
		);
		$this->assertEquals(
			"application/json",
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal application/json"
		);
		$this->assertArrayHasKey(
			"code",
			$exceptionRenderer->controller->viewVars,
			"We do not have an code viewVars"
		);
		$this->assertArrayHasKey(
			"name",
			$exceptionRenderer->controller->viewVars,
			"We do not have an name viewVars"
		);
		$this->assertArrayHasKey(
			"message",
			$exceptionRenderer->controller->viewVars,
			"We do not have an message viewVars"
		);
		$this->assertArrayHasKey(
			"url",
			$exceptionRenderer->controller->viewVars,
			"We do not have an url viewVars"
		);
		$this->assertArrayHasKey(
			"error",
			$exceptionRenderer->controller->viewVars,
			"We do not have an error viewVars"
		);
		$this->assertSame(
			null,
			$response,
			"Our response does not match null"
		);
	}

	/**
	 * test the renderHttpAsJsonApi method
	 *
	 * @return void
	 */
	public function testRenderHttpAsJsonApi() {
		$httpException = new HttpException("Message", 400);
		$exceptionRenderer = $this->returnRenderer('application/vnd.api+json', $httpException);

		$response = $exceptionRenderer->renderHttpAsJsonApi($httpException);

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
			'{"errors":{"id":null,"href":null,"status":"400","code":"HttpException","title":"Message","detail":"Message","links":[],"paths":[]}}',
			$exceptionRenderer->controller->response->body(),
			"Our body does not match the expected string"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
	}

	/**
	 * test the defaultCakeRender method
	 *
	 * @return void
	 */
	public function testDefaultCakeRender() {
		$cakeException = new CakeException("Message");
		$exceptionRenderer = $this->returnRenderer('text/html', $cakeException);

		$response = $exceptionRenderer->defaultCakeRender($cakeException);

		$this->assertEquals(
			"500",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 500"
		);
		$this->assertEquals(
			'text/html',
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal text/html"
		);
		$this->assertArrayHasKey(
			"code",
			$exceptionRenderer->controller->viewVars,
			"We do not have an code viewVars"
		);
		$this->assertArrayHasKey(
			"name",
			$exceptionRenderer->controller->viewVars,
			"We do not have an name viewVars"
		);
		$this->assertArrayHasKey(
			"message",
			$exceptionRenderer->controller->viewVars,
			"We do not have an message viewVars"
		);
		$this->assertArrayHasKey(
			"url",
			$exceptionRenderer->controller->viewVars,
			"We do not have an url viewVars"
		);
		$this->assertArrayHasKey(
			"error",
			$exceptionRenderer->controller->viewVars,
			"We do not have an error viewVars"
		);
		$this->assertSame(
			null,
			$response,
			"Our response does not match null"
		);
	}

	/**
	 * test the renderCakeAsJson method
	 *
	 * @return void
	 */
	public function testRenderCakeAsJson() {
		$cakeException = new CakeException("Message");
		$exceptionRenderer = $this->returnRenderer('application/json', $cakeException);

		$response = $exceptionRenderer->renderCakeAsJson($cakeException);

		$this->assertEquals(
			"500",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 500"
		);
		$this->assertEquals(
			"application/json",
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal application/json"
		);
		$this->assertArrayHasKey(
			"code",
			$exceptionRenderer->controller->viewVars,
			"We do not have an code viewVars"
		);
		$this->assertArrayHasKey(
			"name",
			$exceptionRenderer->controller->viewVars,
			"We do not have an name viewVars"
		);
		$this->assertArrayHasKey(
			"message",
			$exceptionRenderer->controller->viewVars,
			"We do not have an message viewVars"
		);
		$this->assertArrayHasKey(
			"url",
			$exceptionRenderer->controller->viewVars,
			"We do not have an url viewVars"
		);
		$this->assertArrayHasKey(
			"error",
			$exceptionRenderer->controller->viewVars,
			"We do not have an error viewVars"
		);
		$this->assertSame(
			null,
			$response,
			"Our response does not match null"
		);
	}

	/**
	 * test the renderCakeAsJsonApi method
	 *
	 * @return void
	 */
	public function testRenderCakeAsJsonApi() {
		$cakeException = new CakeException("Message");
		$exceptionRenderer = $this->returnRenderer('application/vnd.api+json', $cakeException);

		$response = $exceptionRenderer->renderCakeAsJsonApi($cakeException);

		$this->assertEquals(
			"500",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 500"
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
			'{"errors":{"id":null,"href":null,"status":"500","code":"CakeException","title":"Message","detail":[],"links":[],"paths":[]}}',
			$exceptionRenderer->controller->response->body(),
			"Our body does not match the expected string"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
	}

	/**
	 * test the defaultSerializerRender method
	 *
	 * @return void
	 */
	public function testDefaultSerializerRender() {
		$baseSerializerException = new BaseSerializerException();
		$exceptionRenderer = $this->returnRenderer('text/html', $baseSerializerException);

		$response = $exceptionRenderer->defaultSerializerRender($baseSerializerException);

		$this->assertEquals(
			"400",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 400"
		);
		$this->assertEquals(
			'text/html',
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal text/html"
		);
		$this->assertArrayHasKey(
			"id",
			$exceptionRenderer->controller->viewVars,
			"We do not have an id viewVars"
		);
		$this->assertArrayHasKey(
			"href",
			$exceptionRenderer->controller->viewVars,
			"We do not have an href viewVars"
		);
		$this->assertArrayHasKey(
			"status",
			$exceptionRenderer->controller->viewVars,
			"We do not have an status viewVars"
		);
		$this->assertArrayHasKey(
			"code",
			$exceptionRenderer->controller->viewVars,
			"We do not have an code viewVars"
		);
		$this->assertArrayHasKey(
			"url",
			$exceptionRenderer->controller->viewVars,
			"We do not have an url viewVars"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
	}

	/**
	 * test the renderSerializerAsJson method
	 *
	 * @return void
	 */
	public function testRenderSerializerAsJson() {
		$baseSerializerException = new BaseSerializerException();
		$exceptionRenderer = $this->returnRenderer('application/json', $baseSerializerException);

		$response = $exceptionRenderer->renderSerializerAsJson($baseSerializerException);

		$this->assertEquals(
			"400",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 400"
		);
		$this->assertEquals(
			"application/json",
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal application/json"
		);
		$this->assertArrayHasKey(
			"id",
			$exceptionRenderer->controller->viewVars,
			"We do not have an id viewVars"
		);
		$this->assertArrayHasKey(
			"href",
			$exceptionRenderer->controller->viewVars,
			"We do not have an href viewVars"
		);
		$this->assertArrayHasKey(
			"status",
			$exceptionRenderer->controller->viewVars,
			"We do not have an status viewVars"
		);
		$this->assertArrayHasKey(
			"code",
			$exceptionRenderer->controller->viewVars,
			"We do not have an code viewVars"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
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
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
	}

	/**
	 * test the defaultValidationSerializerRender method
	 *
	 * @return void
	 */
	public function testDefaultValidationSerializerRender() {
		$validationErrors = array(
			'username' => array(
				"Username can not be empty",
				"Username can only be alphanumeric",
			),
			'first_name' => array(
				"First Name can only be alphanumeric and not empty",
			),
		);
		$validationBaseSerializerException = new ValidationBaseSerializerException("User Failed Validation", $validationErrors);
		$exceptionRenderer = $this->returnRenderer('text/html', $validationBaseSerializerException);

		$response = $exceptionRenderer->defaultValidationSerializerRender($validationBaseSerializerException);

		$this->assertEquals(
			"422",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal `422`"
		);
		$this->assertEquals(
			'text/html',
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal `text/html`"
		);
		$this->assertArrayHasKey(
			"title",
			$exceptionRenderer->controller->viewVars,
			"We do not have an `title` viewVars"
		);
		$this->assertArrayHasKey(
			"validationErrors",
			$exceptionRenderer->controller->viewVars,
			"We do not have an `validationErrors` viewVars"
		);
		$this->assertArrayHasKey(
			"status",
			$exceptionRenderer->controller->viewVars,
			"We do not have an `status` viewVars"
		);
		$this->assertArrayHasKey(
			"error",
			$exceptionRenderer->controller->viewVars,
			"We do not have an `error` viewVars"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
	}

	/**
	 * test the renderValidationSerializerAsJson method
	 *
	 * @return void
	 */
	public function testRenderValidationSerializerAsJson() {
		$validationErrors = array(
			'username' => array(
				"Username can not be empty",
				"Username can only be alphanumeric",
			),
			'first_name' => array(
				"First Name can only be alphanumeric and not empty",
			),
		);
		$validationBaseSerializerException = new ValidationBaseSerializerException("User Failed Validation", $validationErrors);
		$exceptionRenderer = $this->returnRenderer('application/json', $validationBaseSerializerException);

		$response = $exceptionRenderer->renderValidationSerializerAsJson($validationBaseSerializerException);

		$this->assertEquals(
			"422",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 422"
		);
		$this->assertEquals(
			"application/json",
			$exceptionRenderer->controller->response->type(),
			"Our Response Type does not equal application/json"
		);
		$this->assertArrayHasKey(
			"title",
			$exceptionRenderer->controller->viewVars,
			"We do not have an title viewVars"
		);
		$this->assertArrayHasKey(
			"validationErrors",
			$exceptionRenderer->controller->viewVars,
			"We do not have an validationErrors viewVars"
		);
		$this->assertArrayHasKey(
			"status",
			$exceptionRenderer->controller->viewVars,
			"We do not have an status viewVars"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
		);
	}

	/**
	 * test the renderValidationSerializerAsJsonApi method
	 *
	 * @return void
	 */
	public function testRenderValidationSerializerAsJsonApi() {
		$validationErrors = array(
			'username' => array(
				"Username can not be empty",
				"Username can only be alphanumeric",
			),
			'first_name' => array(
				"First Name can only be alphanumeric and not empty",
			),
		);
		$validationBaseSerializerException = new ValidationBaseSerializerException("User Failed Validation", $validationErrors);
		$exceptionRenderer = $this->returnRenderer('application/vnd.api+json', $validationBaseSerializerException);

		$response = $exceptionRenderer->renderValidationSerializerAsJsonApi($validationBaseSerializerException);

		$this->assertEquals(
			"422",
			$exceptionRenderer->controller->response->statusCode(),
			"Our Controller Response Status Code does not equal 422"
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
			'{"errors":{"username":["Username can not be empty","Username can only be alphanumeric"],"first_name":["First Name can only be alphanumeric and not empty"]}}',
			$exceptionRenderer->controller->response->body(),
			"Our body does not match the expected string"
		);
		$this->assertSame(
			'cake-response-send',
			$response,
			"Our response does not match the expected string"
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

	/**
	 * test the isJsonRequest method when returns false
	 *
	 * @return void
	 */
	public function testAddHttpCodes() {
		$httpCodesAdded = array(422 => 'Unprocessable Entity');

		$mockController = $this->getMock('Controller', array('render', 'here'));
		$mockController->request = new CakeRequest();
		$mockController->response = $this->getMock('CakeResponse');
		$mockController->response->expects($this->once())
			->method('httpCodes')
			->with($httpCodesAdded)
			->will($this->returnValue(null));

		$exceptionRenderer = new TestSerializerExceptionRenderer(new Exception());
		$exceptionRenderer->controller = $mockController;

		$this->assertEquals(
			null,
			$exceptionRenderer->addHttpCodes(),
			"::addHttpCodes should have returned void"
		);
	}

}

