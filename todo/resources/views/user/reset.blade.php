@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
@if(!$errors->isEmpty())
    <div class="mt-4 alert alert-danger alert-dismissible fade show" role="alert">
       <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
       </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h1 class="mt-5 mb-4">Reset Password</h1>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Reset Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="pwd" class="form-label">Password</label>
                            <input type="password" class="form-control" id="pwd" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="pwd_confirmation" class="form-label">Password Confirmation</label>
                            <input type="password" class="form-control" id="pwd_confirmation" name="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection