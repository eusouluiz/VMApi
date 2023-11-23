<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aluno extends BaseModel
{
    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'cgm',
        'nome',
        'turma_id',
    ];

    /**
     * Get the turma for the aluno.
     *
     * @return BelongsTo<Turma, Aluno>
     */
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }

    /*
    * Get the canais for the aluno.
    *
    * @return HasMany<Canal>
    */
    public function canais(): HasMany
    {
        return $this->hasMany(Canal::class);
    }

    /*
    * Get the responsaveis for the aluno.
    *
    * @return BelongsToMany<Responsavel>
    */
    public function responsaveis(): BelongsToMany
    {
        return $this->belongsToMany(Responsavel::class);
    }
}
