<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends BaseModel
{
    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'user_id',
        'cargo_id',
    ];

    /*
    * Get the user associated with the funcionario.
    *
    * @return BelongsTo<User>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    * Get the cargo of the funcionario.
    *
    * @return BelongsTo<Cargo>
    */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Get the avisos created by the funcionario.
     *
     * @return HasMany<Aviso>
     */
    public function avisos(): HasMany
    {
        return $this->hasMany(Aviso::class);
    }
}
