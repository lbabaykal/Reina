<?php

namespace App\Services\Image;

use App\Enums\S3\DiskEnum;
use App\Enums\S3\FolderEnum;
use Intervention\Image\Interfaces\ImageInterface;

class PhotoService extends ImageService
{
    public function __construct()
    {
        parent::__construct();

        $this->setDisk(DiskEnum::IMAGES);
        $this->setKeyFileInRequest('photo');
    }

    protected function configureImage(ImageInterface $image): ImageInterface
    {
        return $image->scale(width: 240);
    }

    public function saveForCharacter(): ?string
    {
        return $this->setFolder(FolderEnum::CHARACTERS)->save();
    }

    public function saveForPerson(): ?string
    {
        return $this->setFolder(FolderEnum::PERSONS)->save();
    }

    public function deletePhoto(string $filePath): void
    {
        $this->delete($filePath);
    }

}
