<?php

namespace App\Models;

use App\Enums\PrioridadeAviso;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aviso extends BaseModel
{
    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'titulo',
        'texto',
        'arquivo',
        'data_publicacao',
        'data_expiracao',
        'prioridade',
        'funcionario_id',
        'canal_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'prioridade'      => PrioridadeAviso::class,
        'data_publicacao' => 'datetime',
        'data_expiracao'  => 'datetime',
    ];

    /**
     * Get the funcionario who created the aviso.
     *
     * @return BelongsTo<Funcionario, Aviso>
     */
    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    /**
     * Get the canal for the aviso.
     *
     * @return BelongsTo<Canal, Aviso>
     */
    public function canal(): BelongsTo
    {
        return $this->belongsTo(Canal::class);
    }

    /*
    * Get the lembretes for the aviso.
    *
    * @return HasMany<Lembrete>
    */
    public function lembretes(): HasMany
    {
        return $this->hasMany(Lembrete::class);
    }

    /*
    * Get the responsaveis for the aviso.
    *
    * @return BelongsToMany<Responsavel>
    */
    public function responsaveis(): BelongsToMany
    {
        return $this->belongsToMany(Responsavel::class);
    }

    /*
    * Get the turmas for the aviso.
    *
    * @return BelongsToMany<Turma>
    */
    public function turmas(): BelongsToMany
    {
        return $this->belongsToMany(Turma::class);
    }
}
