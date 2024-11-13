<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\FornecedorRequest;
use App\Repositories\FornecedorRepository;

class FornecedorController extends Controller
{
    protected $fornecedorRepo;

    public function __construct(FornecedorRepository $fornecedorRepo)
    {
        $this->fornecedorRepo = $fornecedorRepo;
    }

    public function store(FornecedorRequest $request)
    {
        try {
            return response()->json(
                $this->fornecedorRepo->create($request->validated()),
                Response::HTTP_OK
             );
         } catch (\Exception $e) {
            return response()->json(
                $e->getMessage() . ' at ' . $e->getFile() . ' on line: ' . $e->getLine(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(FornecedorRequest $request, $id)
    {
        try {
            return response()->json(
                $this->fornecedorRepo->update($id, $request->validated()),
                Response::HTTP_OK
             );
         } catch (\Exception $e) {
            return response()->json(
                $e->getMessage() . ' at ' . $e->getFile() . ' on line: ' . $e->getLine(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy($id)
    {
        try {
            return response()->json(
                $this->fornecedorRepo->delete($id),
                Response::HTTP_OK
             );
         } catch (\Exception $e) {
            return response()->json(
                $e->getMessage() . ' at ' . $e->getFile() . ' on line: ' . $e->getLine(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['nome', 'documento', 'tipo_documento']);
            return response()->json(
                $this->fornecedorRepo->getAll($filters),
                Response::HTTP_OK
             );
         } catch (\Exception $e) {
            return response()->json(
                $e->getMessage() . ' at ' . $e->getFile() . ' on line: ' . $e->getLine(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
