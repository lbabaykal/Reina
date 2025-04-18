<?php

namespace App\Services\Image;

use App\Services\Image\Interfaces\ImageInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class AbstractImage implements ImageInterface
{
    public string|null $storage;
    public string|null $format;
    public string|null $fileField;
    public string|null $fileName;
    public $disk;

    public function setStorage($storage): ImageInterface
    {
        $this->storage = $storage;
        return $this;
    }

    public function setFormat($format): ImageInterface
    {
        $this->format = $format;
        return $this;
    }

    public function setFileField($field): ImageInterface
    {
        $this->fileField = $field;
        return $this;
    }

    abstract public function save();

    protected function generateUrl(): string
    {
        return $this->fileField . '/' . date('m-Y') . '/' . Str::random(40);
    }

}
