<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    public function languageCountries(): HasMany
    {
        return $this->hasMany(LanguageCountry::class, 'language_id', 'id');
    }
}
