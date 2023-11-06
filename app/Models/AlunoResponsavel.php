<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlunoResponsavel extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'aluno_responsavel';

    protected $fillable = [
        'aluno_id',
        'responsavel_id',
    ];

    /**
     * Get the aluno associated with the AlunoResponsavel.
     *
     * @return BelongsTo<Aluno>
     */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    /**
     * Get the responsavel associated with the AlunoResponsavel.
     *
     * @return BelongsTo<Responsavel>
     */
    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }
}
