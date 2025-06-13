<?php

namespace App\Services\Image;

use App\Enums\S3\DiskEnum;
use App\Enums\S3\FolderEnum;
use Intervention\Image\Interfaces\ImageInterface;

class PosterService extends ImageService
{
    public function __construct()
    {
        parent::__construct();

        $this->setFolder(FolderEnum::POSTERS);
        $this->setKeyFileInRequest('poster');
    }

    protected function configureImage(ImageInterface $image): ImageInterface
    {
        return $image->scale(width: 400);
    }

    public function saveForAnime(): ?string
    {
        return $this->setDisk(DiskEnum::ANIMES)->save();
    }

    public function saveForDorama(): ?string
    {
        return $this->setDisk(DiskEnum::DORAMAS)->save();
    }

    public function deleteForAnime(string $filePath): void
    {
        $this->setDisk(DiskEnum::ANIMES)->delete($filePath);
    }

    public function deleteForDorama(string $filePath): void
    {
        $this->setDisk(DiskEnum::DORAMAS)->delete($filePath);
    }
}
