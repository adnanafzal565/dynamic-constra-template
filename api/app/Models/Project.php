<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $table = "projects";
    public $timestamps = true;

    public function images()
    {
        return $this->hasMany("App\Models\ProjectImage", "project_id", "id");
    }
}
