<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;
   
class BlogController extends BaseController
{
    public function index()
    {
     
        $blogs = Blog::all();
        return $this->sendResponse(BlogResource::collection($blogs), 'Posts fetched.');
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
        $blog = Blog::create($input);
        return $this->sendResponse(new BlogResource($blog), 'Post created.', 201);
    }
   
    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }
    
    public function update(Request $request, Blog $blog)
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

        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->content = $input['content'];
        $blog->image = $input['image'];
        $blog->tags = $input['tags'];
        $blog->save();
        
        return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }
   
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}