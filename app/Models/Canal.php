<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Canal extends BaseModel
{
    protected $table = 'canais';

    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'nome',
        'descricao',
    ];

    /*
    * Get the aluno associated with the canal.
    *
    * @return BelongsTo<Aluno>
    */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }

    /**
     * Get the avisos for the canal.
     *
     * @return HasMany<Aviso>
     */
    public function avisos(): HasMany
    {
        return $this->hasMany(Aviso::class);
    }

    /*
    * Get the mensagens for the canal.
    *
    * @return HasMany<Mensagem>
    */
    public function mensagens(): HasMany
    {
        return $this->hasMany(Mensagem::class);
    }

    /*
    * Get the cargos for the canal.
    *
    * @return BelongsToMany<Cargo>
    */
    public function cargos(): BelongsToMany
    {
        return $this->belongsToMany(Cargo::class);
    }
}
