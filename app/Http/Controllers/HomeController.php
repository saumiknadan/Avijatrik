<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $userId = $request->input('user_id');

            $query = Post::query();
            if ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $query->whereDate('created_at', '>=', $startDate);
            }
        

            if ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->whereDate('created_at', '<=', $endDate);
            }
        
            if ($userId) {
                $query->where('user_id', $userId);
            }
        
            $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        
            $users = User::all();

            return view('admin.all.index', compact('posts', 'startDate', 'endDate', 'users', 'userId'));
        }catch (\Exception $e){
            session()->flash('error','Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
