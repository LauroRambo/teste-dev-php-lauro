<?php

namespace App\Repositories;

use App\Models\Fornecedor;

class FornecedorRepository
{
    public function create(array $data)
    {
        return Fornecedor::firstOrCreate(['documento' => $data['documento']], $data);
    }

    public function update($id, array $data)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->update($data);
        return $fornecedor;
    }

    public function delete($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();
    }

    public function getAll($filters = [])
    {
        $query = Fornecedor::query();

        if (isset($filters['nome'])) {
            $query->where('nome', 'like', '%' . $filters['nome'] . '%');
        }

        if (isset($filters['documento'])) {
            $query->where('documento', $filters['documento']);
        }

        if (isset($filters['tipo_documento'])) {
            $query->where('tipo_documento', $filters['tipo_documento']);
        }
        
        $query->orderBy('created_at', 'desc');

        return $query->paginate(15); 
    }
}
