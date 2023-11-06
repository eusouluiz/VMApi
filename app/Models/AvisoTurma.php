<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvisoTurma extends BaseModel
{
    protected $table = 'aviso_turma';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aviso_id',
        'turma_id',
    ];

    /**
     * Get the aviso associated with the AvisoTurma.
     *
     * @return BelongsTo<Aviso>
     */
    public function aviso(): BelongsTo
    {
        return $this->belongsTo(Aviso::class, 'aviso_id');
    }

    /**
     * Get the turma associated with the AvisoTurma.
     *
     * @return BelongsTo<Turma>
     */
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }
}
