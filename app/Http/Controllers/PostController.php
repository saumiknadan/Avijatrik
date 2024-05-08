<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Post;
use Auth;

use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Post::where('user_id', Auth::id());

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereDate('created_at', '<=', $endDate);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id(); 

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . '_' . $image->getClientOriginalName();
            $post->image = $image->storeAs('post', $filename);
        }

        $post->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.blog.show', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.blog.edit', compact('post'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validating image file (optional)
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id(); 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            $filename = time() . '_' . $image->getClientOriginalName();
            $destination = public_path('storage/' . $post->image);
            if(File::exists($destination)) {
                File::delete($destination);
            }
    
            $post->image = $image->storeAs('post', $filename);
        }

        $post->save();

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $destination = public_path('storage/' . $post->image);
            if(File::exists($destination)) {
                File::delete($destination);
            }
            
            $post->delete();

            session()->flash('success', 'Content deleted successfully');
            return redirect()->back();
        
    }
}
