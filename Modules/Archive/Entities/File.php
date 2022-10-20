<?php

namespace Modules\Archive\Entities;


use Illuminate\Http\UploadedFile;

class File extends base\File
{
    public static function upload(UploadedFile $file): File
    {
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store("", "public");

        $fileModel = new File();
        $fileModel->name = $originalName;
        $fileModel->path = $filePath;
        $fileModel->save();

        return $fileModel;
    }
}
