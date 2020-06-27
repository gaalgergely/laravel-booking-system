<?php

namespace App;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    protected $fillable = ['id', 'content', 'rating'];

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    protected static function boot()
    {
        /**
         * @todo fix this temporary hotfix for adding name
         */
        $faker = Faker::create();

        parent::boot();

        static::creating(function($review) use ($faker) {
            $review->name = $faker->name;
        });
    }
}
