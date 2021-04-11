<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Traits\FileUpload;
use App\Repository\AbstractRepository;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class RecipesController extends Controller
{
    use FileUpload; //importando trait para upload de imagens

    private $recipe;
    private $userId;
    public function __construct(Recipe $r)
    {
        $this->recipe = $r;
        $this->userId =  auth()->user()->id;
    }

    public function index(Request $req){
        try {
            $recipe = $this->recipe;
            $recipeRepository = new AbstractRepository($recipe);

            if ( $req->filled('s') ) {
                $recipeRepository->selectSearch($req->query('s'));
            }
            return response()->json($recipeRepository->getResult()->where('user_id', $this->userId)->paginate(8), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function show(int $id){

        try {
            $recipe = $this->recipe->where('user_id', $this->userId)->findOrFail($id);
            return response()->json(['data' => [ $recipe ] ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function store(Request $req){
        $data   = $req->all();

        try {
            $recipe = $this->recipe->create($data);

            $categories = $data['categories'];
            $recipe->Categories()->sync($categories);

            if ($req->hasFile('photos')) {
                $photosUploaded = $this->UploadPhoto($req->file('photos')); //utilizando metodo da trait
                $recipe->Photos()->createMany($photosUploaded);
            }

            return response()->json( ['data' => ['Receita criada com sucesso!'] ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }
    public function update(Request $req, $id){
        try {
            $data = $req->all();
            $recipe = $this->recipe->where('user_id', $this->userId)->findOrFail($id);

            $categories = $data['categories'];
            $recipe->Categories()->sync($categories);

            if ($req->hasFile('photos')) {
                $photosUploaded = $this->UploadPhoto($req->file('photos'));
                $recipe->Photos()->createMany($photosUploaded);
            }

            $recipe->update($data);
            return response()->json( ['data' => ['Receita atualizada com sucesso!'] ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function destroy(int $id){

        try {

            $recipe = $this->recipe->where('user_id', $this->userId)->findOrFail($id);
            $recipe->categories()->detach();
            $photos = $recipe->Photos();

            if ($photos) {
               $photos->delete();
            }

            $recipe->delete();

            return response()->json( ['data' => ['Receita excluida com sucesso!'] ], 200);

        } catch (\Exception $e) {
            return response()->json( [ 'error' => $e->getMessage() ], 401);
        }
    }

    public function relatedCategories (Request $req){

        try {
            $recipeId = $req->input('recipe_id');
            $categories = $req->input('categories');
            $recipes = $this->recipe->join('categories_recipes', 'recipes.id', '=', 'categories_recipes.recipe_id')
                                           ->join('categories', 'categories.id', '=', 'categories_recipes.category_id')
                                           ->select('recipes.*')
                                           ->where('recipes.user_id', $this->userId)
                                           ->where('recipes.id', '<>', $recipeId)
                                           ->whereIn('categories.id', $categories)
                                           ->distinct()
                                           ->paginate(4);

            return response()->json( $recipes, 200);

        } catch (\Exception $e) {
            return response()->json( [ 'error' => $e->getMessage() ], 401);
        }


    }


}
