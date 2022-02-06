<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Reference;
use App\Http\Resources\Reference as ReferenceResource;
   
class ReferenceController extends BaseController
{
    public function index()
    {
     
        $references = Reference::all();
        return $this->sendResponse(ReferenceResource::collection($references), 'Reference fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;

        $validator = Validator::make($input, [
            'title' => 'required | max:255',
            'description' => 'required | max:1000',
            'content' => 'required',
            'image' => 'required',
        ],
        [
            'title.required' => 'Başlık boş olamaz ',
            'description.required' => 'Açıklama boş olamaz ',
            'content.required' => 'Açıklama boş olamaz ',
            'image.required' => 'Fotoğraf boş olamaz ',
            'title.max' => ' Başlık 255 karakterden fazla olamaz. ',
            'description.max' => ' Özet 1000 karakterden fazla olamaz. ',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $reference = Reference::create($input);
        return $this->sendResponse(new ReferenceResource($reference), 'Reference created.', 201);
    }
   
    public function show($id)
    {
        $reference = Reference::find($id);
        if (is_null($reference)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ReferenceResource($reference), 'Reference fetched.');
    }
    
    public function update(Request $request, Reference $reference)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required ',
            'explanation' => 'required | max:160',
        ],
        [
            'name.required' => 'Ad boş olamaz ',
            'explanation.required' => 'Açıklama boş olamaz ',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $reference->title = $input['title'];
        $reference->description = $input['description'];
        $reference->content = $input['content'];
        $reference->image = $input['image'];
        $reference->tags = $input['tags'];
        $reference->save();
        
        return $this->sendResponse(new ReferenceResource($reference), 'Reference updated.');
    }
   
    public function destroy(Reference $reference)
    {
        $reference->delete();
        return $this->sendResponse([], 'Reference deleted.');
    }
}