<?php

namespace App\Services\Image;

use App\Enums\S3\DiskEnum;
use App\Enums\S3\FolderEnum;

class CoverService extends ImageService
{
    public function __construct()
    {
        parent::__construct();

        $this->setFolder(FolderEnum::COVERS);
        $this->setKeyFileInRequest('cover');
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
