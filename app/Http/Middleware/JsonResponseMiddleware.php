<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class JsonResponseMiddleware
{
    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    /**
     * @param ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response->getStatusCode() === 200) {
            $request->headers->set('Accept', 'application/json');
            if (!$response instanceof JsonResponse) {
                $response = $this->responseFactory->json($response->content(), $response->status(), $response->headers->all());
            }
        }
        return $response;
    }
}
