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
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:51200', // 50MB max
        ]);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('community_media', 'public');
            $mimeType = $file->getMimeType();

            if (str_starts_with($mimeType, 'image/')) {
                $mediaType = 'image';
            }
            elseif (str_starts_with($mimeType, 'video/')) {
                $mediaType = 'video';
            }
        }

        CommunityPost::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
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

    public function toggleLike(CommunityPost $post)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($post->isLikedBy($user)) {
            $post->likes()->detach($user->id);
            return back()->with('success', 'Post unliked');
        }
        else {
            $post->likes()->attach($user->id);
            return back()->with('success', 'Post liked');
        }
    }
}
