<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Fornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class FornecedorApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_fornecedor()
    {

        $response = $this->postJson('/api/fornecedores', [
            'nome' => 'Empresa Teste',
            'documento' => '19131243000197', 
            'tipo_documento' => 'CNPJ',
            'contato' => 'email@teste.com',
            'endereco' => 'Endereço Teste',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_update_fornecedor()
    {
        Http::fake([
            'https://brasilapi.com.br/api/cnpj/v1/*' => Http::response(['message' => 'Success'], 200),
        ]);

        $fornecedor = Fornecedor::factory()->create();

        $response = $this->putJson("/api/fornecedores/{$fornecedor->id}", [
            'nome' => 'Empresa Teste Atualizada',
            'documento' => '12345678000195',
            'tipo_documento' => 'CNPJ',
            'contato' => 'contato@teste.com',
            'endereco' => 'Novo Endereço',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();

        $response = $this->deleteJson("/api/fornecedores/{$fornecedor->id}");

        $response->assertStatus(200);
    }

    public function test_can_list_fornecedores()
    {
        Fornecedor::factory()->count(10)->create();

        $response = $this->getJson('/api/fornecedores');

        $response->assertStatus(200);
    }
}
