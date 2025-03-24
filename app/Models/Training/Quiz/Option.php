<?php

namespace App\Models\Training\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    //
    protected $fillable = ['question_id', 'option_text', 'is_correct', 'sequence_order'];

    /**
     * @return BelongsTo<Question, $this>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    // Relationship: An option can be selected in many user answers
    /**
     * @return HasMany<UserAnswer, $this>
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class, 'selected_option_id');
    }
}
