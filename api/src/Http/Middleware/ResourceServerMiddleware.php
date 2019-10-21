<?php

declare(strict_types=1);

namespace Api\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Exception;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;

class ResourceServerMiddleware implements MiddlewareInterface
{
    /**
     * @var ResourceServer
     */
    private $server;

    /**
     * @param ResourceServer $server
     */
    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }
    
    /**
     * @param ServerRequestInterface    $request
     * @param RequestHandlerInterface   $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $request = $this->server->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($handler->handle($request));
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse($handler->handle($request));
            // @codeCoverageIgnoreEnd
        }

        // Pass the request and response on to the next responder in the chain
        return $handler->handle($request);
    }
}
