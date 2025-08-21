<?php

namespace App\Exceptions;

use Exception;

/**
 * Base custom exception class
 */
class CustomException extends Exception
{
    protected $statusCode = 500;
    protected $errorCode = 'GENERIC_ERROR';

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }
}

/**
 * Authentication exception
 */
class AuthenticationException extends CustomException
{
    protected $statusCode = 401;
    protected $errorCode = 'AUTHENTICATION_FAILED';
}

/**
 * Authorization exception
 */
class AuthorizationException extends CustomException
{
    protected $statusCode = 403;
    protected $errorCode = 'AUTHORIZATION_FAILED';
}

/**
 * Validation exception
 */
class ValidationException extends CustomException
{
    protected $statusCode = 422;
    protected $errorCode = 'VALIDATION_FAILED';
    protected $errors = [];

    public function __construct($message = "", $errors = [], $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

/**
 * Not found exception
 */
class NotFoundException extends CustomException
{
    protected $statusCode = 404;
    protected $errorCode = 'RESOURCE_NOT_FOUND';
}

/**
 * School blocked exception
 */
class SchoolBlockedException extends CustomException
{
    protected $statusCode = 403;
    protected $errorCode = 'SCHOOL_BLOCKED';

    public function __construct($message = "Your school has been blocked. Please contact administrator.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * User blocked exception
 */
class UserBlockedException extends CustomException
{
    protected $statusCode = 403;
    protected $errorCode = 'USER_BLOCKED';

    public function __construct($message = "Your account has been blocked. Please contact administrator.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * Insufficient permission exception
 */
class InsufficientPermissionException extends CustomException
{
    protected $statusCode = 403;
    protected $errorCode = 'INSUFFICIENT_PERMISSION';

    public function __construct($message = "You don't have permission to perform this action.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * File upload exception
 */
class FileUploadException extends CustomException
{
    protected $statusCode = 400;
    protected $errorCode = 'FILE_UPLOAD_FAILED';
}

/**
 * Database exception
 */
class DatabaseException extends CustomException
{
    protected $statusCode = 500;
    protected $errorCode = 'DATABASE_ERROR';

    public function __construct($message = "A database error occurred. Please try again later.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * Business logic exception
 */
class BusinessLogicException extends CustomException
{
    protected $statusCode = 400;
    protected $errorCode = 'BUSINESS_LOGIC_ERROR';
}

/**
 * Class full exception
 */
class ClassFullException extends BusinessLogicException
{
    protected $errorCode = 'CLASS_FULL';

    public function __construct($message = "The selected class is already full.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * Session not found exception
 */
class SessionNotFoundException extends BusinessLogicException
{
    protected $errorCode = 'SESSION_NOT_FOUND';

    public function __construct($message = "Academic session not found. Please configure the session first.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * Duplicate entry exception
 */
class DuplicateEntryException extends BusinessLogicException
{
    protected $statusCode = 409;
    protected $errorCode = 'DUPLICATE_ENTRY';

    public function __construct($message = "This record already exists.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}