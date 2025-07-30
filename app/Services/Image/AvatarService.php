<?php

namespace App\Services\Image;

use App\Enums\S3\DiskEnum;
use App\Enums\S3\FolderEnum;
use Intervention\Image\Interfaces\ImageInterface;

class AvatarService extends ImageService
{
    public function __construct()
    {
        parent::__construct();

        $this->setDisk(DiskEnum::IMAGES);
        $this->setKeyFileInRequest('avatar');
    }

    protected function configureImage(ImageInterface $image): ImageInterface
    {
        return $image->scale(width: 240);
    }

    public function saveAvatar(): ?string
    {
        return $this->setFolder(FolderEnum::AVATARS)->save();
    }

    public function deleteAvatar(string $filePath): void
    {
        $this->delete($filePath);
    }

}
