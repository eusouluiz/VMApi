<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends BaseModel
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

    /*
    * Get the funcionarios for the cargo.
    *
    * @return HasMany<Funcionario>
    */
    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class);
    }

    /*
    * Get the funcionalidades for the cargo.
    *
    * @return BelongsToMany<Funcionalidade>
    */
    public function funcionalidades(): BelongsToMany
    {
        return $this->belongsToMany(Funcionalidade::class);
    }

    /*
    * Get the canais for the cargo.
    *
    * @return BelongsToMany<Canal>
    */
    public function canais(): BelongsToMany
    {
        return $this->belongsToMany(Canal::class);
    }
}
