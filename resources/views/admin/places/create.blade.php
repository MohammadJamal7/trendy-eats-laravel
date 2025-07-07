@extends('admin.layouts.app')

@section('title', 'Add New Place')
@section('page-title', 'Add Place')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.places._form', ['buttonText' => 'Create Place'])
    </form>
</div>
@endsection 