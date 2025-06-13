<?php

namespace App\Services\Image;

use App\Enums\S3\DiskEnum;
use App\Enums\S3\FolderEnum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

class ImageService extends AbstractImage
{
    private ImageInterface $image;

    public function __construct()
    {
        $this->setDisk(DiskEnum::IMAGES);
        $this->setFolder(FolderEnum::IMAGES);
        $this->setFormatImage('webp');
    }

    public function save(): ?string
    {
        return $this->processImageSave();
    }

    protected function delete(string $filePath): void
    {
        Storage::disk($this->disk)->delete($filePath);
    }

    private function processImageSave(): ?string
    {
        if (! request()->hasFile($this->keyFileInRequest)) {
            return null;
        }

        $this->image = ImageManager::gd()->read(request()->file($this->keyFileInRequest));
        $this->image = $this->configureImage($this->image);

        try {
            $image = $this->encode();
            $this->filePath = $this->generateFilePath();
            Storage::disk($this->disk)->put($this->filePath, $image);

            return $this->filePath;
        } catch (\Exception $e) {
            // TODO Добавить логирование и переписать под будущее
            return redirect()->back()->with('message', 'Ошибка сохранения изображения.');
        }
    }

    protected function configureImage(ImageInterface $image): ImageInterface
    {
        return $image;
    }

    private function encode(): mixed
    {
        return match ($this->formatImage) {
            'webp' => $this->image->toWebp(80)->toFilePointer(),
            'jpeg' => $this->image->toJpeg(80)->toFilePointer(),
            'png' => $this->image->toPng()->toFilePointer(),
            'avif' => $this->image->toAvif(80)->toFilePointer(),
            default => throw new \RuntimeException("Unsupported format: {$this->formatImage}"),
        };
    }

    private function generateFilePath(): string
    {
        return $this->folder.'/'.date('m-Y').'/'.Str::random(40).'.'.$this->formatImage;
    }
}
