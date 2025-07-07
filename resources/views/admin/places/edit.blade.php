@extends('admin.layouts.app')

@section('title', 'Edit Place')
@section('page-title', 'Edit Place')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.places.update', $place) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.places._form', ['place' => $place, 'buttonText' => 'Update Place'])
    </form>
</div>
@endsection 