<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Service;
use App\Http\Resources\Service as ServiceResource;
   
class ServiceController extends BaseController
{
    public function index()
    {
        $services = Service::all();
        return $this->sendResponse(ServiceResource::collection($services), 'Posts fetched.');
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
            'title.required' => 'Başlık boş olamaz. ',
            'description.required' => 'Özet boş olamaz.',
            'content.required' => 'Açıklama boş olamaz. ',
            'image.required' => 'Fotoğraf boş olamaz. ',
            'title.max' => ' Başlık 255 karakterden fazla olamaz. ',
            'description.max' => ' Özet 1000 karakterden fazla olamaz. ',


        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $service = Service::create($input);
        return $this->sendResponse(new ServiceResource($service), 'Post created.', 201);
    }
   
    public function show($id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ServiceResource($service), 'Post fetched.');
    }
    
    public function update(Request $request, Service $service)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required | max:255',
            'description' => 'required | max:160',
            'content' => 'required',
            'image' => 'required',
        ],
        [
            'title.required' => 'Başlık boş olamaz ',
            'description.required' => 'Açıklama boş olamaz ',
            'content.required' => 'Açıklama boş olamaz ',
            'image.required' => 'Fotoğraf boş olamaz',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        
        $service->title = $input['title'];
        $service->description = $input['description'];
        $service->content = $input['content'];
        $service->image = $input['image'];
        $service->tags = $input['tags'];

        $service->save();
        
        return $this->sendResponse(new ServiceResource($service), 'Post updated.');
    }
   
    public function destroy(Service $service)
    {
        $service->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}