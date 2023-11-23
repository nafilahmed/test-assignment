<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','description','strengths','soft_skills'];

    /**
     * Get the contact associated with the company.
     */
    public function contact(): HasOne
    {
        return $this->hasOne(ContactCandidate::class, 'candidate_id', 'id');
    }

}
