<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Responsavel extends BaseModel
{
    /*
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'responsaveis';

    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'user_id',
    ];

    /*
    * Get the user associated with the responsavel.
    *
    * @return BelongsTo<User>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    * Get the alunos for the responsavel.
    *
    * @return BelongsToMany<Aluno>
    */
    public function alunos(): BelongsToMany
    {
        return $this->belongsToMany(Aluno::class);
    }

    /*
    * Get the avisos for the responsavel.
    *
    * @return BelongsToMany<Aviso>
    */
    public function avisos(): BelongsToMany
    {
        return $this->belongsToMany(Aviso::class);
    }
}
