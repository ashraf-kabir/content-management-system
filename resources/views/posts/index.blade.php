@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('posts.create') }}" class="btn btn-success">Add Post</a>
</div>

<div class="card card-default">
    <div class="card-header">Posts</div>
    <div class="card-body">
        @if ($posts->count() > 0)
        <table class="table">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>
                            {{-- <img src="{{$post->image}}" alt=""> --}}
                            <img src="{{ asset('storage/'.$post->image) }}" width="70" height="50">
                        </td>
                        <td>
                            {{ $post->title }}
                        </td>
                        <td>
                            <a href="{{ route('categories.edit', $post->category->id) }}">{{ $post->category->name }}</a>
                        </td>
                        @if ($post->trashed())
                        <td>
                            <form action="{{ route('restore-posts', $post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-info btn-sm text-white" type="submit">Restore</button>
                            </form>
                        </td>
                        @else
                        <td>
                            @if (auth()->user()->id == $post->user_id || auth()->user()->isAdmin())
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm text-white">Edit</a>
                            @endif
                        </td>
                        @endif
                        <td>
                            @if (auth()->user()->id == $post->user_id || auth()->user()->isAdmin())
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        {{ $post->trashed() ? 'Delete': 'Trash' }}
                                    </button>
                                </form>
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <h3 class="text-center">No posts yet</h3>
        @endif
    </div>
</div>

@endsection