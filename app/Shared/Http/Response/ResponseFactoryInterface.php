<?php

declare(strict_types=1);

namespace App\Shared\Http\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ResponseFactoryInterface
{
    public const HTTP_STATUS_OK = 200;

    public function createRedirectBackResponse(): RedirectResponse;

    /**
     * @param array|string[] $errors
     */
    public function createRedirectBackWithErrors(array $errors): RedirectResponse;

    /**
     * @param array|mixed[] $data
     */
    public function createJsonResponse(array $data, int $status = ResponseFactoryInterface::HTTP_STATUS_OK): JsonResponse;

    public function createFileResponse(string $path): BinaryFileResponse;

    public function createRedirectResponse(string $path): RedirectResponse;

    /**
     * @param array|string[] $errors
     */
    public function createRedirectResponseWithErrors(string $path, array $errors): RedirectResponse;
}
