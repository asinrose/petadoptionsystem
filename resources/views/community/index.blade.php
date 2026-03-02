@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold">PetPal Community</h2>
                <p class="text-muted">Share your stories, ask questions, and connect with other pet lovers.</p>
            </div>

            <!-- Create Post -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex">
                        <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" 
                             class="rounded-circle me-3" width="50" height="50" alt="User" style="object-fit: cover;">
                        <div class="flex-grow-1">
                            <form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <textarea name="content" class="form-control border-0 bg-light rounded-3 mb-3" rows="3" 
                                          placeholder="What's on your mind? Share a story..." required></textarea>
                                @error('media')
                                    <div class="text-danger small mb-3">{{ $message }}</div>
                                @enderror
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label for="media_upload" class="btn btn-outline-secondary rounded-pill px-3 m-0" style="cursor: pointer;">
                                            <i class="fas fa-image me-1"></i> Add Photo/Video
                                        </label>
                                        <input type="file" id="media_upload" name="media" class="d-none" accept="image/*,video/*" onchange="document.getElementById('file-chosen').textContent = this.files[0].name">
                                        <span id="file-chosen" class="ms-2 small text-muted"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-paper-plane me-2"></i> Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Feed -->
            @foreach($posts as $post)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <!-- Post Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}" 
                                     class="rounded-circle me-3" width="45" height="45" alt="User" style="object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $post->user->name }}</h6>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <p class="{{ $post->media_path ? 'mb-3' : 'mb-4' }}">{{ $post->content }}</p>

                        <!-- Post Media -->
                        @if($post->media_path)
                            <div class="mb-4 rounded-4 overflow-hidden bg-light text-center border">
                                @if($post->media_type == 'image')
                                    <img src="{{ Storage::url($post->media_path) }}" class="img-fluid w-100" alt="Post Default Image" style="max-height: 600px; object-fit: contain; background: #f8f9fa;">
                                @elseif($post->media_type == 'video')
                                    <video controls class="w-100" style="max-height: 600px; background: #000;">
                                        <source src="{{ Storage::url($post->media_path) }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <button class="btn btn-link text-decoration-none text-muted p-0" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#comments-{{ $post->id }}">
                                <i class="far fa-comment me-2"></i> {{ $post->comments->count() }} Comments
                            </button>
                            <form action="{{ route('community.like', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none p-0 {{ $post->isLikedBy(auth()->user()) ? 'text-danger' : 'text-muted' }}">
                                    <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart me-2"></i> {{ $post->likes()->count() > 0 ? $post->likes()->count() : '' }} Like{{ $post->likes()->count() != 1 ? 's' : '' }}
                                </button>
                            </form>
                        </div>

                        <!-- Comments Section -->
                        <div class="collapse mt-3 {{ $post->comments->count() > 0 ? 'show' : '' }}" id="comments-{{ $post->id }}">
                            <div class="bg-light rounded-3 p-3">
                                @foreach($post->comments as $comment)
                                    <div class="d-flex mb-3">
                                        <img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" 
                                             class="rounded-circle me-2" width="30" height="30" alt="User" style="object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <div class="bg-white p-2 rounded-3 shadow-sm">
                                                <div class="d-flex justify-content-between">
                                                    <strong class="small">{{ $comment->user->name }}</strong>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-0 small">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Add Comment -->
                                <form action="{{ route('community.comment', $post->id) }}" method="POST" class="d-flex mt-2">
                                    @csrf
                                    <input type="text" name="content" class="form-control rounded-pill me-2" placeholder="Write a comment..." required>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-circle" style="width: 38px; height: 38px;">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
