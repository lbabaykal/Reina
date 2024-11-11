<?php

namespace App\Services\Image;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService extends AbstractImage
{
    private $image;

    public function __construct()
    {
        $this->setFormat('webp');
        $this->setStorage('images');
    }

    public function save(): null|string
    {

        $this->disk = Storage::disk($this->storage);

        if (! request()->hasFile($this->fileField)) {
            return null;
        }

        switch ($this->format) {
            case 'webp':
                $this->image = ImageManager::gd()
                    ->read(request()->file($this->fileField))
                    ->toWebp(90)
                    ->toFilePointer();
                break;
            case 'jpeg':
                $this->image = ImageManager::gd()
                    ->read(request()->file($this->fileField))
                    ->toJpeg(90)
                    ->toFilePointer();
                break;
            case 'png':
                $this->image = ImageManager::gd()
                    ->read(request()->file($this->fileField))
                    ->toPng()
                    ->toFilePointer();
                break;
            default:
                return null;
        }

        try {
            $this->fileName = $this->generateUrl() . '.' . $this->format;
            $this->disk->put($this->fileName, $this->image);

            return $this->fileName;
        } catch (\Exception $e) {
            return null; //TODO Add Logging
        }

    }

}
