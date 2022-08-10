<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    const TYPE_FIXED = 'fixed';
    const TYPE_HOURLY = 'hourly';

    // protected $guarded = [];

    protected $fillable = [
        'title', 'status', 'description', 'budget', 'category_id', 'user_id',
        'type', 'attachments',
    ];

    protected $casts = [
        'budget' => 'float',
        'attachments' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,      // Realated Model
            'project_tag',   // Pivote Table
            'project_id',    // F.K For Current Model in Pivot table
            'tag_id',        // F.K For Realated Model in Pivot table
            'id',            // current model key (P.K)
            'id',            // realated model key (P.K)
        );
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    
    public function propsedFreelancers()
    {
        return $this->belongsToMany(
            User::class, 
            'proposals', 
            'project_id',
            'freelancer_id',
        )->withPivot([
            'description', 'cost', 'duration', 'duration_unit', 'status',
        ]);
    }

    public function contractedFreelancers()
    {
        return $this->belongsToMany(
            User::class, 
            'contracts', 
            'project_id',
            'freelancer_id',
        )->withPivot([
            'proposal_id', 'cost',
            'type', 'start_on', 'end_on', 'completed_on', 'hours', 'status'
        ]);
    }

    // $project->type_name
    public function getTypeNameAttribute()
    {
        return ucfirst($this->type);
    }

    public static function typs()
    {
        return [
            self::TYPE_FIXED => 'Fixed',
            self::TYPE_HOURLY => 'Hourly',
        ];
    }

    public function syncTags(array $tags)
    {
        $tags_id = [];
        foreach ($tags as $tag_name) {
            $tag = Tag::firstOrCreate([
                'slug' => Str::slug($tag_name),
            ],[
                'name' => trim($tag_name),
            ]);

            $tags_id[] = $tag->id;
            
        }
        $this->tags()->sync($tags_id);
    }
}
