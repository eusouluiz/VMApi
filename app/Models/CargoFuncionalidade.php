<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CargoFuncionalidade extends BaseModel
{

    protected $table = 'cargo_funcionalidade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'cargo_id',
        'funcionalidade_id',
    ];

    /**
     * Get the cargo associated with the CargoFuncionalidade.
     *
     * @return BelongsTo<Cargo>
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    /**
     * Get the funcionalidade associated with the CargoFuncionalidade.
     *
     * @return BelongsTo<Funcionalidade>
     */
    public function funcionalidade(): BelongsTo
    {
        return $this->belongsTo(Funcionalidade::class, 'funcionalidade_id');
    }
}
