<?php


namespace Infrastructure\Session;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionPersistenceInterface;

class SessionMiddleware implements MiddlewareInterface
{

    public const SESSION_ATTRIBUTE = 'session';

    /** @var SessionInterface */
    protected $session;

    /**
     * @var SessionPersistenceInterface
     */
    private $persistence;

    /**
     * SessionMiddleware constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session, SessionPersistenceInterface $persistence)
    {
        $this->persistence = $persistence;

        $this->session = $session;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request->withAttribute(self::SESSION_ATTRIBUTE, $this->session));
        return $this->persistence->persistSession($this->session, $response);
    }
}