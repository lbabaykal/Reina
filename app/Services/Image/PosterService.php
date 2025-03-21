<?php

namespace App\Services\Image;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class PosterService extends AbstractImage
{
    private $image;

    public function __construct()
    {
        $this->setFileField('poster');
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
                    ->scale(width: 400)
                    ->toWebp(80)
                    ->toFilePointer();
                break;
            case 'avif':
                $this->image = ImageManager::gd()
                    ->read(request()->file($this->fileField))
                    ->scale(width: 400)
                    ->toAvif(80)
                    ->toFilePointer();
                break;
            case 'jpeg':
                $this->image = ImageManager::gd()
                    ->read(request()->file($this->fileField))
                    ->scale(width: 400)
                    ->toJpeg(80)
                    ->toFilePointer();
                break;
            case 'png':
                $this->image = ImageManager::gd()
                    ->read(request()->file($this->fileField))
                    ->scale(width: 400)
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
