<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CommunityPost;
use App\Models\CommunityComment;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = CommunityPost::with('user', 'comments.user')->latest()->get();
        return view('community.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        CommunityPost::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Post created successfully!');
    }

    public function comment(Request $request, CommunityPost $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        CommunityComment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added!');
    }
}
