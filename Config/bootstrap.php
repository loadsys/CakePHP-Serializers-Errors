<?php
// Load BaseSerializerException class for other plugins
App::uses('BaseSerializerException', 'SerializersErrors.Error');

// Load the SerializerExceptionRenderer Class to render exceptions for a Serializable API
App::uses('SerializerExceptionRenderer', 'SerializersErrors.Error');
