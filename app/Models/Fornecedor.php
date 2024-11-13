<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{ 
    use HasFactory;

    protected $table  = 'fornecedores';
    protected $fillable = [
        'nome', 'documento', 'tipo_documento', 'contato', 'endereco'
    ];

    public static function validarDocumento($documento, $tipo)
    {
        if ($tipo === 'CNPJ') {
            return preg_match('/\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}/', $documento);
        } elseif ($tipo === 'CPF') {
            return preg_match('/\d{3}\.\d{3}\.\d{3}\-\d{2}/', $documento);
        }

        return false;
    }
}
