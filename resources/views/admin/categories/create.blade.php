@extends('admin.layouts.app')

@section('title', 'Add New Category')
@section('page-title', 'Add Category')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @include('admin.categories._form', ['buttonText' => 'Create Category'])
    </form>
</div>
@endsection 