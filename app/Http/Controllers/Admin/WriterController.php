<?php

namespace App\Http\Controllers\Admin;

use Exception, Log;

use App\Models\NicheModel;
use App\Models\TagModel;
use App\Models\TemplateModel;
use App\Http\Controllers\Controller;
use App\Models\ObjectiveModel;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $niches = NicheModel::all();
        $data = [
            'page' => 'connections',
            'sub' => 'companies',
            'niches' => $niches,
        ];
        return view('app.admin.writer-dashboard', $data);

    }

    public function create(Request $request){
        try{
            if(!$request->name){
                $message = "Niche Name is required";
                return response()->json(['message' => $message], 400);
            }

            $niche = new NicheModel;
            $niche->name = $request->name;
            $niche->save();
            return response()->json([
                'message' => "Niche was saved successfully",
                'niche' => $niche

            ]);

        }catch(Exception $error){
            Log::info('WriterController@create error message: ' . $error->getMessage());
            $message = 'Unable to create Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 500,
                "message" => $message,
            ], 500);
        }
    }

    public function update(Request $request){
        try{
            if(!$request->name || !$request->id){
                $message = "Niche Details are required";
                return response()->json(['message' => $message], 400);
            }

            $niche = NicheModel::where('id', $request->id)->first();
            if (!$niche) {
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "Niche not found",
                ], 404);
            }

            $niche->name = $request->name;
            $niche->save();

            return response()->json([
                'error' => false,
                'niche' => $niche,
                'message' => "Niche was updated successfully"
            ], 200);
        }catch(Exception $error){
            Log::info('WriterController@update error message: ' . $error->getMessage());
            $message = 'Unable to update Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function delete(Request $request){
        try{
            $niche = NicheModel::where('id', $request->id)->first();
            if (!$niche) {
                $message = "Niche was not found";
                return response()->json(['message' => $message], 404);
            }

            $niche->delete();
            $message = "Niche deleted successfully";
            return response()->json(['message' => $message]);

        }catch(Exception $error){
            Log::info('WriterController@delete error message: ' . $error->getMessage());
            $message = 'Unable to delete Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function objectiveIndex($nicheId){
        $niche = NicheModel::where('id', $nicheId)->first();
        if(!$niche){
            abort(404);
        }

        $objectives = ObjectiveModel::where('niche_id', $nicheId)->get();
        $data = [
            'page' => 'connections',
            'sub' => 'companies',
            'niche' => $niche,
            'objectives' => $objectives
        ];
        return view('app.admin.writer-objectives', $data);

    }

    public function objectiveCreate(Request $request){
        try{
            if(!$request->name){
                $message = "Objective Name is required";
                return response()->json(['message' => $message], 400);
            }

            $niche = NicheModel::where('id', $request->niche_id)->first();
            if(!$niche){
                $message = "Niche not found";
                return response()->json(['message' => $message], 404);
            }

            $objective = new ObjectiveModel;
            $objective->name = $request->name;
            $objective->niche_id = $request->niche_id;
            $objective->save();
            return response()->json([
                'message' => "Objective was saved successfully",
                'objective' => $objective

            ]);

        }catch(Exception $error){
            Log::info('WriterController@objectiveCreate error message: ' . $error->getMessage());
            $message = 'Unable to create Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 500,
                "message" => $message,
            ], 500);
        }
    }

    public function objectiveUpdate(Request $request){
        try{
            if(!$request->name || !$request->id){
                $message = "Objective Details are required";
                return response()->json(['message' => $message], 400);
            }

            $objective = ObjectiveModel::where('id', $request->id)->first();
            if (!$objective) {
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "Objective not found",
                ], 404);
            }

            $objective->name = $request->name;
            $objective->save();

            return response()->json([
                'error' => false,
                'objective' => $objective,
                'message' => "Objective was updated successfully"
            ], 200);
        }catch(Exception $error){
            Log::info('WriterController@objectiveUpdate error message: ' . $error->getMessage());
            $message = 'Unable to update Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function objectiveDelete(Request $request){
        try{
            $objective = ObjectiveModel::where('id', $request->id)->first();
            if (!$objective) {
                $message = "Objective was not found";
                return response()->json(['message' => $message], 404);
            }

            $objective->delete();
            $message = "Objective deleted successfully";
            return response()->json(['message' => $message]);

        }catch(Exception $error){
            Log::info('WriterController@objectiveDelete error message: ' . $error->getMessage());
            $message = 'Unable to delete Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function templateIndex($objectiveId){
        $objective = ObjectiveModel::where('id', $objectiveId)->first();
        if(!$objective){
            abort(404);
        }

        $tags = TagModel::where('objective_id', $objectiveId)->get();

        $templates = TemplateModel::where('objective_id', $objectiveId)->get();
        $data = [
            'page' => 'connections',
            'sub' => 'companies',
            'objective' => $objective,
            'tags' => $tags,
            'templates' => $templates
        ];
        return view('app.admin.writer-templates', $data);
    }

    public function tagCreate(Request $request){
        try{
            if(!$request->name){
                $message = "Tag Name is required";
                return response()->json(['message' => $message], 400);
            }

            $objective = ObjectiveModel::where('id', $request->objective_id)->first();
            if(!$objective){
                $message = "Objective not found";
                return response()->json(['message' => $message], 404);
            }

            $tag = new TagModel();
            $tag->name = $request->name;
            $tag->objective_id = $request->objective_id;
            $tag->save();
            return response()->json([
                'message' => "Tag was saved successfully",
                'tag' => $tag

            ]);

        }catch(Exception $error){
            Log::info('WriterController@tagCreate error message: ' . $error->getMessage());
            $message = 'Unable to create Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 500,
                "message" => $message,
            ], 500);
        }
    }

    public function tagUpdate(Request $request){
        try{
            if(!$request->name || !$request->id){
                $message = "Tag Details are required";
                return response()->json(['message' => $message], 400);
            }

            $tag = TagModel::where('id', $request->id)->first();
            if (!$tag) {
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "Tag not found",
                ], 404);
            }

            $tag->name = $request->name;
            $tag->save();

            return response()->json([
                'error' => false,
                'tag' => $tag,
                'message' => "Tag was updated successfully"
            ], 200);
        }catch(Exception $error){
            Log::info('WriterController@tagUpdate error message: ' . $error->getMessage());
            $message = 'Unable to update Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function tagDelete(Request $request){
        try{
            $tag = TagModel::where('id', $request->id)->first();
            if (!$tag) {
                $message = "Tag was not found";
                return response()->json(['message' => $message], 404);
            }

            $tag->delete();
            $message = "Tag deleted successfully";
            return response()->json(['message' => $message]);

        }catch(Exception $error){
            Log::info('WriterController@tagDelete error message: ' . $error->getMessage());
            $message = 'Unable to delete Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function templateCreate(Request $request){
        try{
            if(!$request->name || !$request->template){
                $message = "Template details are required";
                return response()->json(['message' => $message], 400);
            }

            $objective = ObjectiveModel::where('id', $request->objective_id)->first();
            if(!$objective){
                $message = "Objective not found";
                return response()->json(['message' => $message], 404);
            }

            $template = new TemplateModel();
            $template->name = $request->name;
            $template->template = $request->template;
            $template->tags = json_decode($request->tags);
            $template->objective_id = $request->objective_id;
            $template->save();
            return response()->json([
                'message' => "Template was saved successfully",
                'template' => $template

            ]);

        }catch(Exception $error){
            Log::info('WriterController@templateCreate error message: ' . $error->getMessage());
            $message = 'Unable to create Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 500,
                "message" => $message,
            ], 500);
        }
    }

    public function templateUpdate(Request $request){
        try{
            if(!$request->name || !$request->id || !$request->template){
                $message = "Template Details are required";
                return response()->json(['message' => $message], 400);
            }

            $template = TemplateModel::where('id', $request->id)->first();
            if (!$template) {
                return response()->json([
                    'error' => true,
                    'status_code' => 404,
                    "message" => "Template not found",
                ], 404);
            }

            $template->name = $request->name;
            $template->template = $request->template;
            $template->tags = json_decode($request->tags);
            $template->save();

            return response()->json([
                'error' => false,
                'template' => $template,
                'message' => "Template was updated successfully"
            ], 200);
        }catch(Exception $error){
            Log::info('WriterController@templateUpdate error message: ' . $error->getMessage());
            $message = 'Unable to update Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    public function templateDelete(Request $request){
        try{
            $template = TemplateModel::where('id', $request->id)->first();
            if (!$template) {
                $message = "Template was not found";
                return response()->json(['message' => $message], 404);
            }

            $template->delete();
            $message = "Template deleted successfully";
            return response()->json(['message' => $message]);

        }catch(Exception $error){
            Log::info('WriterController@templateDelete error message: ' . $error->getMessage());
            $message = 'Unable to delete Resource. Encountered an error.';
            return response()->json([
                'error' => true,
                'status_code' => 404,
                "message" => $message,
            ], 500);
        }
    }

    private function handleError($message){
        Session::put('errorMessage', $message);
        return redirect()->back();
    }

}
