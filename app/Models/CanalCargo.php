<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CanalCargo extends BaseModel
{
    protected $table = 'canal_cargo';

    protected $fillable = [
        'canal_id',
        'cargo_id',
    ];

    /**
     * Get the canal associated with the CanalCargo.
     *
     * @return BelongsTo<Canal>
     */
    public function canal(): BelongsTo
    {
        return $this->belongsTo(Canal::class, 'canal_id');
    }

    /**
     * Get the cargo associated with the CanalCargo.
     *
     * @return BelongsTo<Cargo>
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}
