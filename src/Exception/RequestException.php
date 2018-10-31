<?php

namespace GuzzleHttp\Exception;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;

class RequestException extends \RuntimeException implements RequestExceptionInterface
{
    /** @var RequestInterface */
    private $request;

    public function __construct(
        string $message,
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
     * @return RequestException
     */
    public static function wrapException(RequestInterface $request, \Exception $e): RequestException
    {
        return $e instanceof RequestException
            ? $e
            : new RequestException($e->getMessage(), $request, $e);
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
