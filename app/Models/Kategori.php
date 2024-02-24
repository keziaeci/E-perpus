<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    use HasFactory , SoftDeletes;
    protected $guarded = ['id'];

    function bukus() : BelongsToMany {
        return $this->belongsToMany(Buku::class, 'kategori_buku', 'kategori_id' , 'buku_id');
    }
}
