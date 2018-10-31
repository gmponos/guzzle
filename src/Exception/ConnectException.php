<?php

namespace GuzzleHttp\Exception;

use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Exception thrown when a connection cannot be established.
 *
 * Note that no response is present for a ConnectException
 */
class ConnectException extends \RuntimeException implements NetworkExceptionInterface
{
    /** @var RequestInterface */
    private $request;

    public function __construct(
        $message,
        RequestInterface $request,
        \Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->request = $request;
    }

    /**
     * Wrap non-RequestExceptions with a RequestException
     *
     * @param RequestInterface $request
     * @param \Exception $e
     *
     * @return ConnectException
     */
    public static function wrapException(RequestInterface $request, \Exception $e)
    {
        return $e instanceof ConnectException
            ? $e
            : new ConnectException($e->getMessage(), $request, $e);
    }

    /**
     * Get the request that caused the exception
     *
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
