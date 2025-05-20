@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Post Card --}}
    <div class="card mb-5 shadow-sm border-0">
        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top rounded-top" style="max-height: 100px; max-width:100px;" alt="{{ $post->title }}">
        <div class="card-body">
            <h2 class="card-title fw-bold">{{ $post->title }}</h2>
            <p class="card-text mt-3">{{ $post->content }}</p>
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="mb-5">
        <h4 class="mb-4 border-bottom pb-2">💬 Comments</h4>
        <div id="comments">
            @forelse($comments as $comment)
                <div class="d-flex mb-4">
                    <div class="me-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fs-4" 
                             style="width: 100px; height: 100px;">
                            {{ strtoupper(substr($comment->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <strong>{{ $comment->name }}</strong>
                        <p class="mb-1">{{ $comment->message }}</p>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </div>

    {{-- Comment Form --}}
    <div class="card p-4 shadow-sm border-0">
        <h5 class="mb-3">Add a Comment</h5>
        <form id="comment-form">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" placeholder="Your Name" class="form-control" required>
            </div>
            <div class="mb-3">
                <textarea name="message" placeholder="Your Comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
            <div id="comment-success" class="alert alert-success mt-3 d-none">
                ✅ Comment added successfully!
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('comment-form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    const res = await fetch('{{ route('posts.comment', $post) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
        },
        body: formData,
    });

    const data = await res.json();
    if (data.comment) {
        const commentHtml = `
            <div class="d-flex mb-4">
                <div class="me-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fs-4" 
                         style="width: 100px; height: 100px;">
                        ${data.comment.name.charAt(0).toUpperCase()}
                    </div>
                </div>
                <div class="flex-grow-1">
                    <strong>${data.comment.name}</strong>
                    <p class="mb-1">${data.comment.message}</p>
                    <small class="text-muted">Just now</small>
                </div>
            </div>
        `;

        document.getElementById('comments').insertAdjacentHTML('afterbegin', commentHtml);
        document.getElementById('comment-success').classList.remove('d-none');
        form.reset();
        setTimeout(() => {
            document.getElementById('comment-success').classList.add('d-none');
        }, 3000);
    }
});
</script>
@endsection
