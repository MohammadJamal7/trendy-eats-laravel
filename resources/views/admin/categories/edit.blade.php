@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @method('PUT')
        @include('admin.categories._form', ['category' => $category, 'buttonText' => 'Update Category'])
    </form>
</div>
@endsection 