<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class ImageStorageException extends Exception
{
    public function report(): void {}

    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'errors' => [
                'storage' => [
                    $this->getMessage(),
                ],
            ],
        ], 422);
    }

    public static function imageSaving(): self
    {
        return new self('Ошибка сохранения изображения.');
    }

    public static function imageService(): self
    {
        return new self('Ошибка сервиса сохранения изображений.');
    }
}
