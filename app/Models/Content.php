<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
  static $rules = [
    'content_type' => 'required',
    'title' => 'required',
  ];

  protected $fillable = ['content_category_id', 'title', 'body', 'file', 'file_dir', 'extra', 'created_by'];

  public function contentFiles()
  {
    return $this->hasMany('App\Models\ContentFile', 'content_id', 'id');
  }

  public function contentCategory()
  {
    return $this->hasOne('App\Models\contentCategory', 'id', 'content_category_id');
  }
}
