<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Traits\FileUpload;
use Illuminate\Http\Request;
use App\Models\User_photo;

class UserPhotoController extends Controller
{
    use FileUpload;
    private $user_photo;
    public function __construct(User_photo $up)
    {
        $this->user_photo = $up;
    }

    public function update(Request $req, int $id){
        $data[] = $req->file('photo');
        try {
            $photo  = $this->user_photo->findOrFail($id);
            $photoUploaded = $this->UploadPhoto($data);
            $photo->update($photoUploaded[0]);
            return response()->json(['data' => ['Foto atualizada com sucesso!']], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function destroy(int $id){

        try {
            $photo = $this->user_photo->findOrFail($id);
            $photo->delete();
            return response()->json(['data' => ['Foto excluida!']], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }


    }


}
