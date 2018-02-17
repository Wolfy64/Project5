<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param UploadedFile
     *
     * @return $filename
     */
    public function upload(UploadedFile $file) : string
    {
        $name = md5(uniqid());
        $extension = $file->guessExtension();

        if (!$extension) {
            // extension cannot be guessed
            $extension = 'bin';
        }

        $fileName = $name . '.' . $extension;
        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir(): string
    {
        return $this->targetDir;
    }
}
