<?php

namespace App\Services\Image;

use App\Enums\S3\DiskEnum;
use App\Enums\S3\FolderEnum;

abstract class AbstractImage
{
    protected ?string $formatImage;

    protected ?string $keyFileInRequest = null;

    protected ?string $folder;

    protected ?string $filePath;

    protected string $disk;

    public function setDisk(DiskEnum $disk): AbstractImage
    {
        $this->disk = $disk->value;

        return $this;
    }

    /**
     * @param  string  $formatImage  Format Supported: webp, jpeg, png, avif.
     */
    public function setFormatImage(string $formatImage): AbstractImage
    {
        $this->formatImage = $formatImage;

        return $this;
    }

    public function setKeyFileInRequest(string $keyFileInRequest): AbstractImage
    {
        $this->keyFileInRequest = $keyFileInRequest;

        return $this;
    }

    public function setFolder(FolderEnum $folder): AbstractImage
    {
        $this->folder = $folder->value;

        return $this;
    }
}
