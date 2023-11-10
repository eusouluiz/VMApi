<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CanalResponsavel extends BaseModel
{

    protected $table = 'canal_responsavel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'canal_id',
        'responsavel_id',
    ];

    /**
     * Get the canal associated with the CanalResponsavel.
     *
     * @return BelongsTo<Canal>
     */
    public function canal(): BelongsTo
    {
        return $this->belongsTo(Canal::class, 'canal_id');
    }

    /**
     * Get the responsavel associated with the CanalResponsavel.
     *
     * @return BelongsTo<Responsavel>
     */
    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }
}
