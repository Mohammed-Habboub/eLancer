@extends('layouts.dashboard')

@section('title', 'Create Category')

@section('content')




    <!-- <h1 class="mb-3">Create Category</h1> -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif 

    <form action="{{ route('categoris.store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf

        @include('categories._form')
        
    </form>
@endsection