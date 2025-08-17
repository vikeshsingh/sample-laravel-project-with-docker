<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Document extends Model {
    use SoftDeletes;
    protected $fillable = ['title','s3_path','mime_type','size_bytes'];
    protected $appends = ['url'];
    public function getUrlAttribute(): ?string {
        return Storage::disk('s3')->url($this->s3_path);
    }
}
