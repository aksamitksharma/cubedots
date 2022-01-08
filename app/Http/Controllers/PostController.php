<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(empty($request->get('tag'))){
            $data['posts'] = Post::orderBy('id','desc')->paginate(6);
        }else{
            $data['posts'] = Post::where('tags', 'LIKE', '%'.$request->get('tag').'%')->orderBy('id','desc')->paginate(6);
        }
        $data['tags'] = Tag::get();
        return view('post.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
       
        if($request->file('fImage'))
        $imagename = $this->resizeImagePost($request->file('fImage'));
        else
        $imagename="";

        $postObj = new Post;
        $postObj->user_id =  Auth::id();
        $postObj->slug = $this->createSlug(Str::slug($request->title));
        $postObj->title = $request->title;
        $postObj->description = $request->description;
        $postObj->tags = $request->tags;
        $postObj->featured_image = $imagename;

        if($postObj->save()){
            $this->saveTags($request->tags);
            return Redirect::to('posts')
            ->with('success','Greate! posts created successfully.');
        }else{
            return Redirect::to('posts')
            ->with('success','Oops! posts not created, try again');
        }
    
       
    }

    public function saveTags($tags){

        $tagArr = explode(',', $tags);
        
        foreach($tagArr as $tag){
            $tagsData = Tag::select('*')->where('tags', 'LIKE', '%'.trim($tag).'%')->get();
            echo $tag.'<br>';
            if($tagsData->isEmpty()){
                $ta = new Tag;
                $ta->tags = $tag;
                $ta->save();
            }
        }
    }

    public function resizeImagePost($image)
    {
        $imagename = time().'.'.$image->getClientOriginalExtension();
     
   
        $destinationPath = public_path('\thumbnail');
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath.'/'.$imagename);


        $destinationPath = public_path('\images');
        $image->move($destinationPath, $imagename);

        return $imagename;
    }

    public function createSlug($slug)
    {
        $allSlugs = $this->getRelatedSlugs($slug);
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }

    protected function getRelatedSlugs($slug)
    {
        return Post::select('slug')->where('slug', 'like', $slug.'%')
        ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data['post'] = Post::where('slug', 'like', $slug.'%')
        ->with('user')
        ->first();
        return view('post.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['post'] = Post::find($id);
        return view('post.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = Post::find($id);
        $post->slug = $this->createSlug(Str::slug($request->title));
        $post->title = $request->title;
        $post->tags = $request->tags;
        $post->description = $request->description;
   
        $post->update();
    
        return Redirect::to('posts')
       ->with('success','Great! posts updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return back()->with('success', 'Post Deleted successfully');
    }
}
