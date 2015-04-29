<?php
// Load BaseSerializerException class for other plugins
App::import('Lib/Error', 'SerializersErrors.BaseSerializerException');

// Load the SerializerExceptionRenderer Class to render exceptions for a Serializable API
App::uses('SerializerExceptionRenderer', 'SerializersErrors.Lib/Error');
