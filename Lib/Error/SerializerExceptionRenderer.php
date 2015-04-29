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
		if ($this->error instanceof BaseSerializerException) {
			$this->renderSerializerException($this->error);
		} else {
			parent::render();
		}
	}

	/**
	 * render exceptions of type BaseSerializerException
	 *
	 * @param BaseSerializerException $error the BaseSerializerException error to render
	 * @return void
	 */
	public function renderSerializerException(BaseSerializerException $error) {
		if ($this->isJsonApiRequest()) {
			return $this->renderAsJsonApi($error);
		}

		if ($this->isJsonRequest()) {
			return $this->renderAsJson($error);
		}

		return $this->defaultRender($error);
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

	/**
	 * render the BaseSerializerException in the general case
	 *
	 * @param BaseSerializerException $error an instance of BaseSerializerException
	 * @return void
	 */
	protected function defaultRender(BaseSerializerException $error) {
		$this->controller->response->statusCode($error->status);

		// set the errors object to match JsonApi's expectations
		$this->controller->set('id', $error->id);
		$this->controller->set('href', $error->href);
		$this->controller->set('status', $error->status);
		$this->controller->set('code', $error->code);
		$this->controller->set('title', $error->title);
		$this->controller->set('detail', $error->detail);
		$this->controller->set('links', $error->links);
		$this->controller->set('paths', $error->paths);
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
	protected function renderAsJson(BaseSerializerException $error) {
		// Set the view class as json and render as json
		$this->controller->viewClass = 'Json';
		$this->controller->response->type('json');
		$this->controller->response->statusCode(h($error->status));

		// set all the values we have from our exception to populate the json object
		$this->controller->set('id', h($error->id));
		$this->controller->set('href', h($error->href));
		$this->controller->set('status', h($error->status));
		$this->controller->set('code', h($error->code));
		$this->controller->set('title', h($error->title));
		$this->controller->set('detail', h($error->detail));
		$this->controller->set('links', h($error->links));
		$this->controller->set('paths', h($error->paths));

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
	protected function renderAsJsonApi(BaseSerializerException $error) {
		// Add a response type for JSON API
		$this->controller->response->type(array('jsonapi' => 'application/vnd.api+json'));
		// Set the controller to response as JSON API
		$this->controller->response->type('jsonapi');
		// Set the correct Status Code
		$this->controller->response->statusCode($error->status);

		// set the errors object to match JsonApi's standard
		$errors = array(
			'errors' => array(
				'id' => h($error->id),
				'href' => h($error->href),
				'status' => h($error->status),
				'code' => h($error->code),
				'title' => h($error->title),
				'detail' => h($error->detail),
				'links' => h($error->links),
				'paths' => h($error->paths),
			),
		);
		// json encode the errors
		$jsonEncodedErrors = json_encode($errors);

		// set the body to the json encoded errors
		$this->controller->response->body($jsonEncodedErrors);
		return $this->controller->response->send();
	}

}
