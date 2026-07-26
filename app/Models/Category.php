<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    private const PALETTE = [
        ['icon' => 'bi-droplet-half', 'from' => '#d9a441', 'to' => '#8a5a15'],
        ['icon' => 'bi-disc', 'from' => '#d0464c', 'to' => '#7a1418'],
        ['icon' => 'bi-lightning-charge-fill', 'from' => '#3d7bf5', 'to' => '#1a3f8c'],
        ['icon' => 'bi-circle-half', 'from' => '#5b6774', 'to' => '#22282f'],
        ['icon' => 'bi-stars', 'from' => '#2fab9c', 'to' => '#166158'],
        ['icon' => 'bi-nut-fill', 'from' => '#8a6bff', 'to' => '#432f99'],
        ['icon' => 'bi-gear-wide-connected', 'from' => '#e0912b', 'to' => '#8f5313'],
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function visual(): array
    {
        $slug = $this->slug ?? '';

        $keywordMap = [
            'oli' => 0,
            'pelumas' => 0,
            'rem' => 1,
            'listrik' => 2,
            'kelistrikan' => 2,
            'ban' => 3,
            'roda' => 3,
            'aksesoris' => 4,
            'variasi' => 4,
            'kaki' => 5,
            'suspensi' => 5,
            'cvt' => 6,
            'transmisi' => 6,
        ];

        foreach ($keywordMap as $keyword => $index) {
            if (str_contains($slug, $keyword)) {
                return self::PALETTE[$index];
            }
        }

        return self::PALETTE[$this->id % count(self::PALETTE)];
    }
}
