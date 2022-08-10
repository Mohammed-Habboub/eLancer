@extends('layouts.dashboard')



@section('title')

Categories <a href="{{ route('categoris.create') }}">Create</a>
@endsection
@section('content')
    
    
<x-flash-message />
<div class="alert alert-success" role="alert" >
  <h4 class="alert-heading" style="color: red;">Whatch out!</h4>
  <p>I would like to inform you, dear, that this is a control panel for the site that I created, and also this warning is for developers only because it is temporary because the site is under development and working. Therefore, you may encounter some errors and unavailable pages.</p>
  <p>Don't worry, the site is under development and when I'm done I will upload it again and this alert hasn't appeared yet.</p>
  <hr>
  <p class="mb-0">A glimpse of this site that I created. I advise you to visit the link : <e> https://github.com/Mohammed-Habboub</e>
    <span style="color: red;" > ( wish you the best. )</span></p>
</div>

    <div class="table-responsive"></div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent ID</th>
                <th>Create At</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('categoris.show', ['category' => $category->id]) }}">{{ $category->name }}</a></td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent_name }}</td>
                <td>{{ $category->created_at }}</td>
                <td><a href="{{ route('categoris.edit', [$category->id]) }}" class="btn btn-sm btn-dark">Edit</a></td>
                <td><form action="{{ route('categoris.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form></td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    {{$categories->withQueryString()->links()}}
    
@endsection