<?php
namespace App\Http\Middleware;


use Illuminate\Http\Response;

class ResponseMiddleware
{
    public function handle($request, \Closure $next) {
        $response = $next($request);

        switch (true) {
            case ($response->exception instanceof \Exception):
                $statusCode = 1;
                $data = [];
                break;
            default:
                $statusCode = 0;
                $data = $response->getContent();
        }

        $response->setContent([
            'status_code' => $statusCode,
            'data' => $data,
        ]);
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(Response::HTTP_OK);


        return $response;
    }
}
