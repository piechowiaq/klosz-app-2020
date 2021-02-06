<?php

declare(strict_types=1);

namespace App\Shared\Http\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseFactory implements ResponseFactoryInterface
{
    private Redirector $redirector;

    public function __construct(Redirector $redirector)
    {
        $this->redirector = $redirector;
    }

    public function createRedirectBackResponse(): RedirectResponse
    {
        return $this->redirector->back();
    }

    /**
     * @inheritDoc
     */
    public function createRedirectBackWithErrors(array $errors): RedirectResponse
    {
        return $this->redirector->back()->withErrors($errors);
    }

    /**
     * @inheritDoc
     */
    public function createJsonResponse(array $data, int $status = ResponseFactoryInterface::HTTP_STATUS_OK): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    public function createFileResponse(string $path): BinaryFileResponse
    {
        return new BinaryFileResponse($path);
    }

    public function createRedirectResponse(string $path): RedirectResponse
    {
        return $this->redirector->to($path);
    }

    /**
     * @inheritDoc
     */
    public function createRedirectResponseWithErrors(string $path, array $errors): RedirectResponse
    {
        return $this->redirector->to($path)->withErrors($errors);
    }
}
