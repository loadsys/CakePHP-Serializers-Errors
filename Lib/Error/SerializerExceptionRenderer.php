<?php
/**
 * Ensures that all fatal errors are rendered as JSON.
 */
App::uses('ExceptionRenderer', 'Error');

/**
 * StatelessAuthExceptionRenderer
 */
class SerializerExceptionRenderer extends ExceptionRenderer {

	/**
	 * construct a new instance of this class
	 *
	 * @param Exception $exception the exception being thrown
	 */
	public function __construct(Exception $exception) {
		parent::__construct($exception);
	}

	/**
	 * render the Exception to the end user, if the Exception is an instance of
	 * BaseSerializerException call our custom renderer else, call the parent
	 * render method
	 *
	 * @return void
	 */
	public function render() {
		if ($this->error instanceof ValidationBaseSerializerException) {
			return $this->renderValidationSerializerException($this->error);
		} elseif ($this->error instanceof BaseSerializerException) {
			return $this->renderSerializerException($this->error);
		} elseif ($this->error instanceof CakeException) {
			return $this->renderCakeException($this->error);
		} elseif ($this->error instanceof HttpException) {
			return $this->renderHttpException($this->error);
		}

		return parent::render();
	}

	/**
	 * render exceptions of type HttpException
	 *
	 * @param HttpException $error the HttpException error to render
	 * @return void
	 */
	protected function renderHttpException(HttpException $error) {
		if ($this->isJsonApiRequest()) {
			return $this->renderHttpAsJsonApi($error);
		}

		if ($this->isJsonRequest()) {
			return $this->renderHttpAsJson($error);
		}

		return $this->defaultHttpRender($error);
	}

	/**
	 * render exceptions of type CakeException
	 *
	 * @param CakeException $error the CakeException error to render
	 * @return void
	 */
	protected function renderCakeException(CakeException $error) {
		if ($this->isJsonApiRequest()) {
			return $this->renderCakeAsJsonApi($error);
		}

		if ($this->isJsonRequest()) {
			return $this->renderCakeAsJson($error);
		}

		return $this->defaultCakeRender($error);
	}

	/**
	 * render exceptions of type BaseSerializerException
	 *
	 * @param BaseSerializerException $error the BaseSerializerException error to render
	 * @return void
	 */
	protected function renderSerializerException(BaseSerializerException $error) {
		if ($this->isJsonApiRequest()) {
			return $this->renderSerializerAsJsonApi($error);
		}

		if ($this->isJsonRequest()) {
			return $this->renderSerializerAsJson($error);
		}

		return $this->defaultSerializerRender($error);
	}

	/**
	 * render exceptions of type ValidationBaseSerializerException
	 *
	 * @param ValidationBaseSerializerException $error the ValidationBaseSerializerException error to render
	 * @return void
	 */
	protected function renderValidationSerializerException(ValidationBaseSerializerException $error) {
		if ($this->isJsonApiRequest()) {
			return $this->renderValidationSerializerAsJsonApi($error);
		}

		if ($this->isJsonRequest()) {
			return $this->renderValidationSerializerAsJson($error);
		}

		return $this->defaultValidationSerializerRender($error);
	}

	/**
	 * render the HttpException for a JSON request
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	protected function renderHttpAsJson(HttpException $error) {
		// Set the view class as json and render as json
		$this->controller->viewClass = 'Json';
		$this->controller->response->type('json');

		$url = $this->controller->request->here();
		$code = ($error->getCode() >= 400 && $error->getCode() < 506) ? $error->getCode() : 500;
		$this->controller->response->statusCode($code);
		$this->controller->set(array(
			'code' => $code,
			'name' => h(get_class($error)),
			'message' => h($error->getMessage()),
			'url' => h($url),
			'error' => $error,
			'_serialize' => array('code', 'name', 'message', 'url')
		));
		$this->_outputMessage($this->template);
	}

	/**
	 * render the HttpException for a JSON API request
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	protected function renderHttpAsJsonApi(HttpException $error) {
		// Add a response type for JSON API
		$this->controller->response->type(array('jsonapi' => 'application/vnd.api+json'));
		// Set the controller to response as JSON API
		$this->controller->response->type('jsonapi');
		// Set the correct Status Code
		$this->controller->response->statusCode($error->getCode());

		// set the errors object to match JsonApi's standard
		$errors = array(
			'errors' => array(
				'id' => null,
				'href' => null,
				'status' => h($error->getCode()),
				'code' => h(get_class($error)),
				'title' => h($error->getMessage()),
				'detail' => h($error->getMessage()),
				'links' => array(),
				'paths' => array(),
			),
		);
		// json encode the errors
		$jsonEncodedErrors = json_encode($errors);

		// set the body to the json encoded errors
		$this->controller->response->body($jsonEncodedErrors);
		return $this->controller->response->send();
	}

	/**
	 * render the HttpException in the general case
	 *
	 * @param HttpException $error an instance of HttpException
	 * @return void
	 */
	protected function defaultHttpRender(HttpException $error) {
		$url = $this->controller->request->here();
		$code = ($error->getCode() >= 400 && $error->getCode() < 506) ? $error->getCode() : 500;
		$this->controller->response->statusCode($code);
		$this->controller->set(array(
			'code' => $code,
			'name' => h(get_class($error)),
			'message' => h($error->getMessage()),
			'url' => h($url),
			'error' => $error,
			'_serialize' => array('code', 'name', 'message', 'url')
		));
		$this->_outputMessage("error400");
	}

	/**
	 * render the CakeException for a JSON request
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	protected function renderCakeAsJson(CakeException $error) {
		// Set the view class as json and render as json
		$this->controller->viewClass = 'Json';
		$this->controller->response->type('json');

		$url = $this->controller->request->here();
		$code = ($error->getCode() >= 400 && $error->getCode() < 506) ? $error->getCode() : 500;
		$this->controller->response->statusCode($code);
		$this->controller->set(array(
			'code' => $code,
			'name' => h(get_class($error)),
			'message' => h($error->getMessage()),
			'url' => h($url),
			'error' => $error,
			'_serialize' => array('code', 'name', 'message', 'url')
		));
		$this->controller->set($error->getAttributes());
		$this->_outputMessage($this->template);
	}

	/**
	 * render the CakeException for a JSON API request
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	protected function renderCakeAsJsonApi(CakeException $error) {
		// Add a response type for JSON API
		$this->controller->response->type(array('jsonapi' => 'application/vnd.api+json'));
		// Set the controller to response as JSON API
		$this->controller->response->type('jsonapi');
		// Set the correct Status Code
		$this->controller->response->statusCode($error->getCode());

		// set the errors object to match JsonApi's standard
		$errors = array(
			'errors' => array(
				'id' => null,
				'href' => null,
				'status' => h($error->getCode()),
				'code' => h(get_class($error)),
				'title' => h($error->getMessage()),
				'detail' => h($error->getAttributes()),
				'links' => array(),
				'paths' => array(),
			),
		);
		// json encode the errors
		$jsonEncodedErrors = json_encode($errors);

		// set the body to the json encoded errors
		$this->controller->response->body($jsonEncodedErrors);
		return $this->controller->response->send();
	}

	/**
	 * render the CakeException in the general case
	 *
	 * @param CakeException $error an instance of CakeException
	 * @return void
	 */
	protected function defaultCakeRender(CakeException $error) {
		$url = $this->controller->request->here();
		$code = ($error->getCode() >= 400 && $error->getCode() < 506) ? $error->getCode() : 500;
		$this->controller->response->statusCode($code);
		$this->controller->set(array(
			'code' => $code,
			'name' => h(get_class($error)),
			'message' => h($error->getMessage()),
			'url' => h($url),
			'error' => $error,
			'_serialize' => array('code', 'name', 'message', 'url')
		));
		$this->controller->set($error->getAttributes());
		$this->_outputMessage("error500");
	}

	/**
	 * render the BaseSerializerException in the general case
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	protected function defaultSerializerRender(BaseSerializerException $error) {
		$this->controller->response->statusCode($error->status());

		// set the errors object to match JsonApi's expectations
		$this->controller->set('id', $error->id());
		$this->controller->set('href', $error->href());
		$this->controller->set('status', $error->status());
		$this->controller->set('code', $error->code());
		$this->controller->set('title', $error->title());
		$this->controller->set('detail', $error->detail());
		$this->controller->set('links', $error->links());
		$this->controller->set('paths', $error->paths());
		$this->controller->set('error', $error);

		$this->controller->set('url', $this->controller->request->here());

		if (empty($template)) {
			$template = "SerializersErrors./Errors/serializer_exception";
		}

		$this->controller->render($template);
		$this->controller->afterFilter();
		return $this->controller->response->send();
	}

	/**
	 * render the BaseSerializerException for a JSON request
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	protected function renderSerializerAsJson(BaseSerializerException $error) {
		// Set the view class as json and render as json
		$this->controller->viewClass = 'Json';
		$this->controller->response->type('json');
		$this->controller->response->statusCode($error->status());

		// set all the values we have from our exception to populate the json object
		$this->controller->set('id', h($error->id()));
		$this->controller->set('href', h($error->href()));
		$this->controller->set('status', h($error->status()));
		$this->controller->set('code', h($error->code()));
		$this->controller->set('title', h($error->title()));
		$this->controller->set('detail', h($error->detail()));
		$this->controller->set('links', h($error->links()));
		$this->controller->set('paths', h($error->paths()));

		$this->controller->set('_serialize', array(
			'id', 'href', 'status', 'code', 'title ', 'detail', 'links', 'paths'
		));

		if (empty($template)) {
			$template = "SerializersErrors./Errors/serializer_exception";
		}

		$this->controller->render($template);
		$this->controller->afterFilter();
		return $this->controller->response->send();
	}

	/**
	 * render the BaseSerializerException for a JSON API request
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	protected function renderSerializerAsJsonApi(BaseSerializerException $error) {
		// Add a response type for JSON API
		$this->controller->response->type(array('jsonapi' => 'application/vnd.api+json'));
		// Set the controller to response as JSON API
		$this->controller->response->type('jsonapi');
		// Set the correct Status Code
		$this->controller->response->statusCode($error->status());

		// set the errors object to match JsonApi's standard
		$errors = array(
			'errors' => array(
				'id' => h($error->id()),
				'href' => h($error->href()),
				'status' => h($error->status()),
				'code' => h($error->code()),
				'title' => h($error->title()),
				'detail' => h($error->detail()),
				'links' => h($error->links()),
				'paths' => h($error->paths()),
			),
		);
		// json encode the errors
		$jsonEncodedErrors = json_encode($errors);

		// set the body to the json encoded errors
		$this->controller->response->body($jsonEncodedErrors);
		return $this->controller->response->send();
	}

	/**
	 * render the ValidationBaseSerializerException in the general case
	 *
	 * @param ValidationBaseSerializerException $error an instance of ValidationBaseSerializerException
	 * @return void
	 */
	protected function defaultValidationSerializerRender(ValidationBaseSerializerException $error) {
		$this->addHttpCodes();
		$this->controller->response->statusCode($error->status());

		// set the errors object to match JsonApi's expectations
		$this->controller->set('title', $error->title());
		$this->controller->set('validationErrors', $error->validationErrors());
		$this->controller->set('status', $error->status());
		$this->controller->set('error', $error);

		$this->controller->set('url', $this->controller->request->here());

		if (empty($template)) {
			$template = "SerializersErrors./Errors/validation_serializer_exception";
		}

		$this->controller->render($template);
		$this->controller->afterFilter();
		return $this->controller->response->send();
	}

	/**
	 * render the ValidationBaseSerializerException for a JSON request
	 *
	 * @param ValidationBaseSerializerException $error an instance of ValidationBaseSerializerException
	 * @return void
	 */
	protected function renderValidationSerializerAsJson(ValidationBaseSerializerException $error) {
		// Set the view class as json and render as json
		$this->controller->viewClass = 'Json';
		$this->controller->response->type('json');
		$this->addHttpCodes();
		$this->controller->response->statusCode($error->status());

		// set the errors object to match JsonApi's standard
		$errors = array(
			'errors' => $error->validationErrors(),
		);

		// json encode the errors
		$jsonEncodedErrors = json_encode($errors);

		// set the body to the json encoded errors
		$this->controller->response->body($jsonEncodedErrors);
		return $this->controller->response->send();
	}

	/**
	 * render the ValidationBaseSerializerException for a JSON API request
	 *
	 * @param ValidationBaseSerializerException $error an instance of ValidationBaseSerializerException
	 * @return void
	 */
	protected function renderValidationSerializerAsJsonApi(ValidationBaseSerializerException $error) {
		// Add a response type for JSON API
		$this->controller->response->type(array('jsonapi' => 'application/vnd.api+json'));
		// Set the controller to response as JSON API
		$this->controller->response->type('jsonapi');
		$this->addHttpCodes();
		$this->controller->response->statusCode($error->status());

		// set the errors object to match JsonApi's standard
		$errors = array(
			'errors' => array(
				'id' => h($error->id()),
				'href' => h($error->href()),
				'status' => h($error->status()),
				'code' => h($error->code()),
				'title' => h($error->title()),
				'detail' => h($error->validationErrors()),
				'links' => h($error->links()),
				'paths' => h($error->paths()),
			),
		);

		// json encode the errors
		$jsonEncodedErrors = json_encode($errors);

		// set the body to the json encoded errors
		$this->controller->response->body($jsonEncodedErrors);
		return $this->controller->response->send();
	}

	/**
	 * add additional HTTP codes to the CakeResponse Object
	 *
	 * @return void
	 */
	protected function addHttpCodes() {
		$defaultCodes = array(
			422 => 'Unprocessable Entity',
		);
		$this->controller->response->httpCodes($defaultCodes);
	}

	/**
	 * is this request a JsonApi style request
	 *
	 * @return bool returns true if JsonApi media request, false otherwise
	 */
	protected function isJsonApiRequest() {
		return $this->controller->request->accepts('application/vnd.api+json');
	}

	/**
	 * is this request for Json
	 *
	 * @return bool returns true if Json media request, false otherwise
	 */
	protected function isJsonRequest() {
		return $this->controller->request->accepts('application/json');
	}

}
