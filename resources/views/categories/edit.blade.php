@extends('layouts.dashboard')
@section('title', 'Edit Category')

@section('content')



    <!-- <h1 class="mb-3">Edit Category</h1> -->

    <form action="{{ route('categoris.update',  $category->id) }}" method="POST">
        <input type="hidden" name="_method" value="put">
        @csrf
        @method('put')
        @include('categories._form')
    </form>
@endsection