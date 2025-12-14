<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'category',
        'description',
        'price_per_item',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'is_available',
    ];

    protected $casts = [
        'price_per_item' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    protected $appends = ['main_image', 'images', 'formatted_price'];

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_item, 0, ',', '.');
    }

    // Accessor untuk gambar utama (image_1)
    public function getMainImageAttribute()
    {
        if ($this->image_1) {
            return asset('storage/' . $this->image_1);
        }
        return 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800';
    }

    // Accessor untuk semua gambar (array)
    public function getImagesAttribute()
    {
        $images = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image_{$i}";
            if ($this->$imageField) {
                $images[] = asset('storage/' . $this->$imageField);
            }
        }
        
        // Jika tidak ada gambar sama sekali, return default
        if (empty($images)) {
            return ['https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800'];
        }
        
        return $images;
    }

    // Relasi ke bookings
    public function bookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }

    // Scope untuk filter kategori
    public function scopeCategory($query, $category)
    {
        if ($category && $category !== 'all' && $category !== 'Semua') {
            return $query->where('category', $category);
        }
        return $query;
    }

    // Scope untuk filter ketersediaan
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope untuk cari nama
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }
}