<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvisoResponsavel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aviso_responsavel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aviso_id',
        'responsavel_id',
        'ind_visualizacao',
    ];

    /**
     * Get the aviso associated with the aviso_responsavel.
     */
    public function aviso()
    {
        return $this->belongsTo(Aviso::class, 'aviso_id');
    }

    /**
     * Get the responsavel associated with the aviso_responsavel.
     */
    public function responsavel()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }
}
