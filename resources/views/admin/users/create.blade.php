@extends('admin.layouts.app')

@section('title', 'Add New User')
@section('page-title', 'Add User')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @include('admin.users._form', ['buttonText' => 'Create User'])
    </form>
</div>
@endsection 