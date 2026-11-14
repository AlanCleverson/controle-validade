<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'categoria',
        'quantidade',
        'data_validade',
        'descricao',
    ];

    protected function casts(): array
    {
        return [
            'data_validade' => 'date',
            'quantidade' => 'integer',
        ];
    }
}