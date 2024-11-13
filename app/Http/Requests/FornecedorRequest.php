<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Fornecedor;

class FornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'nome' => 'required|string|max:255',
            'documento' => 'required|string',
            'tipo_documento' => 'required|in:CPF,CNPJ',
            'contato' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
        ];

        if ($this->getMethod() === 'POST') {
            $rules['documento'] = ['required', 'string', function ($attribute, $value, $fail) {
                $tipo = $this->input('tipo_documento');

                if ($tipo === 'CPF' && !Fornecedor::validarDocumento($value, $tipo)) {
                    $fail('O ' . $attribute . ' está inválido.');
                }

                if ($tipo === 'CNPJ' && !$this->verificarCnpjExistente($value)) {
                    $fail('O CNPJ informado não existe.');
                }
            }];
        } elseif ($this->getMethod() === 'PUT') {
            $rules['documento'] = ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value) {
                    $tipo = $this->input('tipo_documento');

                    if ($tipo === 'CPF' && !Fornecedor::validarDocumento($value, $tipo)) {
                        $fail('O ' . $attribute . ' está inválido.');
                    }

                    if ($tipo === 'CNPJ' && !$this->verificarCnpjExistente($value)) {
                        $fail('O CNPJ informado não existe.');
                    }
                }
            }];
        }

        return $rules;
    }

    /**
     * Verifica se o CNPJ existe usando a BrasilAPI.
     */
    private function verificarCnpjExistente($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");


        return $response->successful();
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'O nome do fornecedor é obrigatório.',
            'documento.required' => 'O CPF ou CNPJ do fornecedor é obrigatório.',
            'tipo_documento.required' => 'O tipo de documento (CPF ou CNPJ) é obrigatório.',
            'contato.required' => 'O contato do fornecedor é obrigatório.',
            'endereco.required' => 'O endereço do fornecedor é obrigatório.',
            'documento.unique' => 'Este CPF/CNPJ já está cadastrado.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
