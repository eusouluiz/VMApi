<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turma extends BaseModel
{
    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'nome',
        'descricao',
    ];

    /**
     * Get the alunos for the turma.
     *
     * @return HasMany<Aluno>
     */
    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class);
    }

    /**
     * Get the avisos for the turma.
     *
     * @return BelongsToMany<Aviso>
     */
    public function avisos(): BelongsToMany
    {
        return $this->belongsToMany(Aviso::class);
    }
}
