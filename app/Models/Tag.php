<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Data\Bundle\Reader\PhpBundleReader;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'slug'];

    public function projects()
    {
        return $this->belongsToMany(
            Project::class,     // Realated Model
            'project_tag',      // Pivote Table
            'tag_id',           // F.K For Current Model in Pivot table
            'project_id',       // F.K For Realated Model in Pivot table
            'id',               // current model key (P.K)
            'id',               // realated model key (P.K)
        );
    }
}
