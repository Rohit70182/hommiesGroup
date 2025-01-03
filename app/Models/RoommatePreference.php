<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoommatePreference extends Model
{
    use HasFactory;

    protected $table = 'roommate_preferences';

    // SLEEP SCHEDULE
    const EARLY_BIRD = 1;
    const NIGHT_OWL = 2;

    //LIFESTYLE HABBITS 
    const SMOKING = 1;
    const DRINKING = 2;
    const DIETRY_PREFRENCE = 3;

    //SOCIAL PREFRENCE
    const FREQUENT_SOCIAL = 1;
    const INTERACTIONS = 2;
    const MORE_PRIVATE = 3;

    //PET
    const PET_FRIENDLY_YES = 1;
    const PET_FRIENDLY_NO = 2;

    //STUDY
    const STUDY_HABITS_YES = 1;
    const STUDY_HABITS_NO = 2;

    //COOKING 
    const COOKING_YES = 1;
    const COOKING_NO = 2;

    // Room book state_id
    const STATE_PENDING = 1;
    const STATE_BOOKED = 2;
    protected $fillable = [
        'sleep_schedule',
        'lifestyle_habits',
        'social_preferences',
        'pet_friendly',
        'study_habits',
        'cooking_kitchen_usage',
        'state_id',
    ];

    protected $casts = [
        'lifestyle_habits' => 'array',
        'social_preferences' => 'array',
    ];

    public function setLifestyleHabitsAttribute($value)
    {
        $this->attributes['lifestyle_habits'] = implode(',', $value);
    }

    public function getLifestyleHabitsAttribute($value)
    {
        return explode(',', $value);
    }

    public function setSocialPreferencesAttribute($value)
    {
        $this->attributes['social_preferences'] = implode(',', $value);
    }

    public function getSocialPreferencesAttribute($value)
    {
        return explode(',', $value);
    }
}
