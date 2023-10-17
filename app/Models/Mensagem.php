<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensagem extends BaseModel
{
    /*
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'mensagens';

    /*
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'texto',
        'arquivo',
        'lida',
        'data_leitura',
        'data_envio',
        'user_id',
        'canal_id',
    ];

    /*
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
    protected $casts = [
        'data_leitura' => 'datetime',
        'data_envio'   => 'datetime',
    ];

    /*
    * Get the user who sent the mensagem.
    *
    * @return BelongsTo<User>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    * Get the canal for the mensagem.
    *
    * @return BelongsTo<Canal>
    */
    public function canal(): BelongsTo
    {
        return $this->belongsTo(Canal::class);
    }
}
