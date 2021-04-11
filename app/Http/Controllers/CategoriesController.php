<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $category;
    public function __construct(Category $c)
    {
        $this->category = $c;
    }

    public function index(){

        $categories = $this->category->paginate(10);

        return response()->json($categories, 200);
    }

    public function show(int $id){
        try {
            $category = $this->category->findOrFail($id);
            return response()->json(['data' => [$category] ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function store(Request $req){
        $data   = $req->all();
        try {
            $category = $this->category->create($data);
            return response()->json(['data' => ['Categoria criada com sucesso!']],200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }

    }
    public function update(Request $req, int $id){
        try {
            $data = $req->all();
            $category = $this->category->findOrFail($id);
            $category->update($data);
            return response()->json(['data' => ['Categoria atualizada com sucesso!']], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function destroy(int $id){

        try {
            $category = $this->category->findOrFail($id);
            $category->delete();
            return response()->json(['data' => ['Receita excluida!']], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }


    }


}
