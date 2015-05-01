<?php
/**
 * Custom Exceptions for Serializable style interface
 *
 * @package JsonApiExceptions.Lib.Error
 */

/**
 * BaseSerializerException
 *
 * Generic base exception for other plugins and userland code to extend from
 */
class BaseSerializerException extends CakeException {

	/**
	 * A short, human-readable summary of the problem. It SHOULD NOT change from
	 * occurrence to occurrence of the problem, except for purposes of
	 * localization.
	 *
	 * @var null
	 */
	public $title = 'Base Serializer Exception';

	/**
	 * A human-readable explanation specific to this occurrence of the problem.
	 *
	 * @var null
	 */
	public $detail = 'Base Serializer Exception';

	/**
	 * An application-specific error code, expressed as a string value.
	 *
	 * @var null
	 */
	public $code = 400;

	/**
	 * A URI that MAY yield further details about this particular occurrence
	 * of the problem.
	 *
	 * @var null
	 */
	public $href = null;

	/**
	 * A unique identifier for this particular occurrence of the problem.
	 *
	 * @var null
	 */
	public $id = null;

	/**
	 * The HTTP status code applicable to this problem, expressed as a string
	 * value.
	 *
	 * @var null
	 */
	public $status = null;

	/**
	 * Associated resources which can be dereferenced from the request document.
	 *
	 * @var null
	 */
	public $links = null;

	/**
	 * The relative path to the relevant attribute within the associated
	 * resource(s). Only appropriate for problems that apply to a single
	 * resource or type of resource.
	 *
	 * @var null
	 */
	public $path = null;

	/**
	 * Constructs a new instance of the base BaseJsonApiException
	 *
	 * @param string $title The title of the exception, passed to parent CakeException::__construct
	 * @param string $detail A human-readable explanation specific to this occurrence of the problem.
	 * @param int $status The http status code of the error, passed to parent CakeException::__construct
	 * @param string $id A unique identifier for this particular occurrence of the problem.
	 * @param string $href A URI that MAY yield further details about this particular occurrence of the problem.
	 * @param array $links An array of JSON Pointers [RFC6901] to the associated resource(s) within the request document [e.g. ["/data"] for a primary data object].
	 * @param array $paths An array of JSON Pointers to the relevant attribute(s) within the associated resource(s) in the request document. Each path MUST be relative to the resource path(s) expressed in the error object's "links" member [e.g. ["/first-name", "/last-name"] to reference a couple attributes].
	 */
	public function __construct(
		$title = 'Base Serializer Exception',
		$detail = 'Base Serializer Exception',
		$status = 400,
		$id = null,
		$href = null,
		$links = null,
		$paths = null
	) {
		// Set the passed in properties to the properties of the Object
		$this->title = $title;
		$this->detail = $detail;
		$this->status = $status;
		$this->id = $id;
		$this->href = $href;
		$this->links = $links;
		$this->paths = $paths;

		// construct the parent CakeException class
		parent::__construct($this->title, $this->status);
	}

}
