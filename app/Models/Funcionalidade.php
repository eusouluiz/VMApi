<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Funcionalidade extends BaseModel
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
    * Get the cargos for the funcionalidade.
    *
    * @return BelongsToMany<Cargo>
    */
    public function cargos(): BelongsToMany
    {
        return $this->belongsToMany(Cargo::class);
    }
}
