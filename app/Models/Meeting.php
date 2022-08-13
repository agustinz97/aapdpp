<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['date', 'location', 'description'];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }


    /**
     * @param array $files the files to relate to the meeting
     * 
     * @return Meeting
     */
    public function storeFiles(array $files)
    {
        foreach ($files as $requestFile) {
            $file = File::storeFile($requestFile);
            $this->files()->save($file);
        }
        $this->load('files');
        return $this;
    }
}
