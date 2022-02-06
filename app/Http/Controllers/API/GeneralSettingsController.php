<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\GeneralSettings;
use App\Http\Resources\GeneralSettings as GeneralSettingsResource;
   
class GeneralSettingsController extends BaseController
{
    public function index()
    {
        $generalSettings = GeneralSettings::all();
        return $this->sendResponse(GeneralSettingsResource::collection($generalSettings), 'Posts fetched.');
    }
    
    public function update(Request $request, GeneralSettings $generalSettings)
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
        
        $generalSettings->content = $input['content'];
        $generalSettings->image = $input['image'];

        $generalSettings->save();
        return $this->sendResponse(new GeneralSettingsResource($generalSettings), 'Post updated.');
    }
   
   
}