<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Slider;
use App\Http\Resources\Slider as SliderResource;
   
class SliderController extends BaseController
{
    public function index()
    {
        $slider = Slider::all();
        return $this->sendResponse(SliderResource::collection($slider), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
     

        $validator = Validator::make($input, [
            'image' => 'required',
        ],
        [
            'image.required' => 'Fotoğraf boş olamaz. ',


        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $slider = Slider::create($input);
        return $this->sendResponse(new SliderResource($slider), 'Post created.', 201);
    }
   
    public function show($id)
    {
        $slider = Slider::find($id);
        if (is_null($slider)) {
            return $this->sendError('Slider does not exist.');
        }
        return $this->sendResponse(new SliderResource($slider), 'Slider fetched.');
    }
    
    public function update(Request $request, Slider $slider)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'image' => 'required',
        ],
        [
            'image.required' => 'Fotoğraf boş olamaz',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        
        $slider->cover_text = $input['cover_text'];
        $slider->link = $input['link'];
        $slider->content = $input['content'];
        $slider->image = $input['image'];

        $slider->save();
        
        return $this->sendResponse(new SliderResource($slider), 'Slider updated.');
    }
   
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return $this->sendResponse([], 'Slider deleted.');
    }
}