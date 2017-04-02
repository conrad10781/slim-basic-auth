<?php

namespace Tuupola\Middleware\HttpBasicAuthentication;

use Slim\Http\Response as SlimResponse;
use Zend\Diactoros\Response as DiactorosResponse;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Nyholm\Psr7\Response as NyholmResponse;
use Interop\Http\Factory\ResponseFactoryInterface;

final class ResponseFactory implements ResponseFactoryInterface
{
    public function createResponse($code = 200)
    {
        if (class_exists(SlimResponse::class)) {
            return new SlimResponse($code);
        }

        if (class_exists(DiactorosResponse::class)) {
            return new DiactorosResponse("php://memory", $code);
        }

        if (class_exists(GuzzleResponse::class)) {
            return new GuzzleResponse($code);
        }

        if (class_exists(NyholmResponse::class)) {
            return new NyholmResponse($code);
        }

        throw new \RuntimeException("No PSR-7 implementation available");
    }
}
