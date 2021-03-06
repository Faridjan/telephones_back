<?php

declare(strict_types=1);

namespace App\Http\Middleware\Catchers;

use App\Helper\CamelToSnakeCaseHelper;
use App\Http\Response\JsonResponse;
use App\Infrastructure\Symfony\Validator\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationExceptionMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception) {
            return new JsonResponse(
                [
                    'errors' => self::errorsArray($exception->getViolations()),
                ],
                422
            );
        }
    }

    private static function errorsArray(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $errors[CamelToSnakeCaseHelper::transform($violation->getPropertyPath())] = $violation->getMessage();
        }
        return $errors;
    }
}
