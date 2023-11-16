<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lembrete extends BaseModel
{
    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'titulo',
        'texto',
        'data_lembrete',
        'aviso_id',
    ];

    /*
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
    protected $casts = [
        'data_lembrete' => 'datetime',
    ];

    /*
    * Get the aviso for the lembrete.
    *
    * @return BelongsTo<Aviso>
    */
    public function aviso(): BelongsTo
    {
        return $this->belongsTo(Aviso::class);
    }
}
