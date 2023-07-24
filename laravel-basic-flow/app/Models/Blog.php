<?php

namespace App\Models;

use App\Notifications\NewBlogNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Blog extends Model implements HasMedia

{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $fillable = [
        'title',
        'category_id',
        'body',
        'author',
        'image'

    ];


    public function image() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('image') ?: null
        );

    }


    public function category() :BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    protected static function boot() {
        parent::boot();
        static::created(function(Blog $blog){

            $users = User::where('is_subscribed',1)->get();
            foreach($users as $user){
                $user->notify(new NewBlogNotification($blog));
            }
        });

    }
}