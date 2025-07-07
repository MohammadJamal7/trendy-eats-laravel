@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @method('PUT')
        @include('admin.users._form', ['user' => $user, 'buttonText' => 'Update User'])
    </form>
</div>
@endsection 