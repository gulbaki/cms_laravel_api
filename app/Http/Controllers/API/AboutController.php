<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\About;
use App\Http\Resources\About as AboutResource;
   
class AboutController extends BaseController
{
    public function index()
    {
        $about = About::all();
        return $this->sendResponse(AboutResource::collection($about), 'Posts fetched.');
    }
    
    public function update(Request $request, About $about)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'content' => 'required',
            'image' => 'required',
        ],
        [
            'content.required' => 'Açıklama boş olamaz ',
            'image.required' => 'Fotoğraf boş olamaz',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        
        $about->content = $input['content'];
        $about->image = $input['image'];

        $about->save();
        return $this->sendResponse(new AboutResource($about), 'Post updated.');
    }
   
   
}