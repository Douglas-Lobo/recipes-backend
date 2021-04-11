<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Traits\FileUpload;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    use FileUpload;
    private $user;
    public function __construct(User $u)
    {
        $this->user = $u;
    }

    public function index(){
        try {
            $users = $this->user->paginate(8);

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function show(int $id){
        try {
            $user = $this->user->findOrFail($id);

            return response()->json(['data' => [$user] ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function store(Request $req){
        $data   = $req->all();
        dd($data);
        try {
            $user = $this->user->create($data);

            if ($req->hasFile('photo')) {
                $photo[] = $req->file('photo');
                $photoUploaded = $this->UploadPhoto($photo); //utilizando metodo da trait
                $user->User_photo()->create($photoUploaded[0]);
            }
            return response()->json([ 'data' => ['Usuario criado com sucesso!'] ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }
    public function update(Request $req, int $id){
        $data = $req->all();
        try {
            $user = $this->user->findOrFail($id);

            if ($req->hasFile('photo')) {
                $photo[] = $req->file('photo');
                $photoUploaded = $this->UploadPhoto($photo); //utilizando metodo da trait
                $user->User_photo()->create($photoUploaded[0]);
            }

            $user->update($data);
            return response()->json(['data' => ['Usuario atualizado com sucesso!']],200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }
    }
    public function destroy(int $id){

        try {

            $user = $this->user->findOrFail($id);
            $photo = $user->User_photo();

            if ($photo) {
               $photo->delete();
            }
            $user->delete();
            return response()->json(['data' => ['Usuario excluido!']],200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }


    }


}
