<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'date', 'image', 'text', 'description', 'posted', 'type', 'category_id'];

    protected $casts = [
        // Para poder castear la fecha, darle un formato en la vista
        'date' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggables');
    }

    // Para acceder a la url de la imagen y mostrarla en la vista
    public function getImageUrl()
    {
        if ($this->image == null) {
            # code...
            return URL::asset("images/image.jpg");
        } else {
            # code...
            return URL::asset("images/post/".$this->image);
        }
    }
}
