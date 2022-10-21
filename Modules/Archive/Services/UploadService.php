<?php

namespace Modules\Archive\Services;

use Illuminate\Http\UploadedFile;
use Modules\Archive\Entities\base\File;
use Modules\Archive\Entities\base\Image;

class UploadService
{
  public function __invoke(UploadedFile $upload): File|Image
  {
      $name = $upload->getClientOriginalName();

      if (str_starts_with($upload->getMimeType(), 'image')) {
          $entity = new Image();
          $entity->path = $upload->store('images', 'public');
      } else {
          $entity = new File();
          $entity->path = $upload->store('files', 'public');
      }
      $entity->name = $name;
      $entity->save();

      return $entity;
  }
}