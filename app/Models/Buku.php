<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Buku extends Model
{
    use HasFactory, SoftDeletes,LogsActivity;
    protected $guarded = ['id'];
    protected $with = ['kategoris', 'images'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
    function images() : MorphMany {
        return $this->morphMany(Image::class, 'imageable');
    }

    function kategoris() : BelongsToMany {
        return $this->belongsToMany(Kategori::class, 'kategori_buku', 'buku_id', 'kategori_id');
    }
    
    function penerbit() : BelongsTo {
        return $this->belongsTo(Penerbit::class);
    }
    function pengarang() : BelongsTo {
        return $this->belongsTo(Pengarang::class);
    }

    function komentars() : HasMany {
        return $this->hasMany(Komentar::class);
    }

    function peminjamans() : HasMany {
        return $this->hasMany(Peminjaman::class);
    }

    function scopeFilter($query , $search) {
        return $query->where('judul' , 'like' , "%{$search}%")
            ->orWhere('deskripsi' , 'like' , "%{$search}%")
            ->orWhereHas('penerbit', function ($query) use ($search) {
                $query->where('nama' , 'like' , "%{$search}%");
            })
            ->orWhereHas('pengarang', function ($query) use ($search) {
                $query->where('nama' , 'like' , "%{$search}%");
            })
            ->orWhereHas('kategoris', function ($query) use ($search) {
                $query->where('nama' , 'like' , "%{$search}%");
            });
    }

    // FIXME skema pertama : pending saat stok buku 0 ,
    function checkStok()  {
        if ($this->stok == 0 || empty($this->stok) || is_null($this->stok)) {
            return Peminjaman::STATUS['Pending'];
        }
        return Peminjaman::STATUS['Borrow'];
    }

    // FIXME skema kedua : button disable saat stok buku 0
    function isNotAvailable()  {
        if ($this->stok == 0 || empty($this->stok) || is_null($this->stok)) {
            return true;
        }
        return false;
    }
    
    function stockOut()  {
        return $this->stok -= 1;
    }

    function stockIn()  {
        return $this->stok += 1;
    }
}
