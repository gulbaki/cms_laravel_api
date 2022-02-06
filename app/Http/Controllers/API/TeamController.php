<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Team;
use App\Http\Resources\Team as TeamResource;
   
class TeamController extends BaseController
{
    public function index()
    {
     
        $team = Team::all();
        return $this->sendResponse(TeamResource::collection($team), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;

        $validator = Validator::make($input, [
            'name' => 'required ',
            'degree' => 'required ',
        ],
        [
            'name.required' => 'Ad boş olamaz ',
            'degree.required' => 'Görevi boş olamaz ',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $team = Team::create($input);
        return $this->sendResponse(new TeamResource($team), 'Post created.', 201);
    }
   
    public function show($id)
    {
        $team = Team::find($id);
        if (is_null($team)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new TeamResourc($team), 'Post fetched.');
    }
    
    public function update(Request $request, Team $team)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required ',
            'degree' => 'required ',
        ],
        [
            'name.required' => 'Ad boş olamaz ',
            'degree.required' => 'Görevi boş olamaz ',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $team->title = $input['title'];
        $team->description = $input['description'];
        $team->content = $input['content'];
        $team->image = $input['image'];
        $team->tags = $input['tags'];
        $team->save();
        
        return $this->sendResponse(new TeamResource($team), 'team updated.');
    }
   
    public function destroy(Team $team)
    {
        $team->delete();
        return $this->sendResponse([], 'team deleted.');
    }
}