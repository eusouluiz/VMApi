<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvisoResponsavel extends BaseModel
{
    protected $table = 'aviso_responsavel';

    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'aviso_id',
        'responsavel_id',
        'ind_visualizacao',
    ];

    /**
     * Get the aviso associated with the AvisoResponsavel.
     *
     * @return BelongsTo<Aviso>
     */
    public function aviso(): BelongsTo
    {
        return $this->belongsTo(Aviso::class, 'aviso_id');
    }

    /**
     * Get the responsavel associated with the AvisoResponsavel.
     *
     * @return BelongsTo<Responsavel>
     */
    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }
}
