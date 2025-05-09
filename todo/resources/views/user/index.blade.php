@extends('layouts.app')
@section('title', 'Users')
@section('content')
<h1 class="mt-5 mb-4">Users</h1>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">Users</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Users</th>
                                <th>Tasks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>
                                    <ul>
                                        @forelse($user->tasks as $task)
                                        <li>{{ $task->title }}</li>
                                        @empty
                                        <li class="text-danger">There is no task to list!</li>
                                        @endforelse
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users}}
                </div>
            </div>
        </div>
    </div>
@endsection