<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUpload;
use App\Models\Photo;
use App\Models\Recipe;

class PhotosController extends Controller
{
    use FileUpload;
    private $photo;
    public function __construct(Photo $p)
    {
        $this->photo = $p;
    }

    public function update(Request $req, int $id){
        $data[] = $req->file('photo');
        try {
            $photo  = $this->photo->findOrFail($id);
            $photoUploaded = $this->UploadPhoto($data);
            $photo->update($photoUploaded[0]);
            return response()->json(['data' => ['Foto atualizada com sucesso!']], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function destroy(int $id){

        try {
            $photo = $this->photo->findOrFail($id);
            $photo->delete();
            return response()->json(['data' => ['Foto excluida!']], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }


    }


}
