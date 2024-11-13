<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    /**
     * O nome da tabela associada ao modelo.
     */
    protected $model = Fornecedor::class;

    /**
     * Defina os dados fictícios para o fornecedor.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->company,  
            'documento' => $this->faker->unique()->numerify('########0001##'), 
            'tipo_documento' => 'CNPJ', 
            'contato' => $this->faker->phoneNumber, 
            'endereco' => $this->faker->address,    
        ];
    }
}
