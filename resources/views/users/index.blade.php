@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">Users</div>
    <div class="card-body">
        @if ($users->count() > 0)
        <table class="table">
            <thead>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <img src="{{ Gravatar::src($user->email) }}" width="40" height="40" style="border-radius: 50%;">
                            {{-- <img src="{{$post->image}}" alt=""> --}}
                            {{-- <img src="{{ asset('storage/'.$post->image) }}" width="50" height="50"> --}}
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            @if (!$user->isAdmin())
                                <form action="{{ route('users.make-admin', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm float-right">Make Admin</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if (!$user->isAdmin())
                                <form action="{{ route('users.destroy', $user->id) }}" method="DELETE">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm float-left">Delete User</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <h3 class="text-center">No users yet</h3>
        @endif
    </div>
</div>

@endsection
