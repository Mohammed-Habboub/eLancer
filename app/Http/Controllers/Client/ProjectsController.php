<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // $projects = Project::with('category')->where('user_id', '=', '$user->id')->paginate();
        $projects = $user->projects()->with('category.parent', 'tags')->paginate();

        return view('client.projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.projects.create', [
            'project' => new Project(),
            'types' => Project::typs(), 
            'categories' => $this->categories(),
            'tags' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
       

        $user = $request->user();

        // $request->merge([
        //     'user_id' => $user->id, //Auth::id
        // ]);
        // $project = Project::create( $request->all() );

        $data = $request->except('attachments');
        $data['attachments'] = $this->uploadAttachments($request);


        $project = $user->projects()->create( $data );

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);

        return redirect()
                ->route('client.projects.index')
                ->with('success', 'Project Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        return view('client.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        return view('client.projects.edit', [
            'project' => $project,
            'types' => Project::typs(),
            'categories' => $this->categories(),
            'tags' => $project->tags()->pluck('name')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        $data = $request->except('attachments');
        $data['attachments'] = array_merge(($project->attachemnts ?? [] ), $this->uploadAttachments($request));

        $project->update($data);
        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);

        return redirect()
                ->route('client.projects.index')
                ->with('success', 'Project Update');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Project::where('user_id', Auth::id())
        //     ->where('id', $id)
        //     ->delete();


        // Same Above Code where the dwon useing relation  
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);
        $project->delete();

        foreach ($project->attachements as $file) {
            //unlink(storage_path('app/public/' . $file));
            Storage::disk('public')->delete($file);
        }

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project Deleted');
    }

    protected function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    protected function uploadAttachments(Request $request)
    {

        $data = $request->except('attachments');
        if (!$request->hasFile('attachments')) {
            return;
        }
            $files = $request->file('attachments');
            $attachments = [];
            foreach ($files as $file) {
                if ($file->isValid()) {
                    // $file->getClientOriginalName;
                    // $file->getClientOriginalExtension;
                    // $file->getMTime;
                    // $file->getSize;

                    $path = $file->store('/attachments', [
                        'disk' => 'uploads',
                    ]);
                    $attachments[] = $path;
                }
            }
                return $attachments;
        }
        
}
