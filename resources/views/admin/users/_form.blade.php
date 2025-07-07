@csrf
<div class="mb-4">
    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
</div>
<div class="mb-4">
    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
</div>
<div class="mb-4">
    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ isset($user) ? '' : 'required' }}>
    @if (isset($user))
        <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password.</p>
    @endif
</div>
<div class="mb-4">
    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>
<div class="mb-4">
    <label for="is_admin" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
    <select name="is_admin" id="is_admin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <option value="0" {{ old('is_admin', $user->is_admin ?? 0) == 0 ? 'selected' : '' }}>User</option>
        <option value="1" {{ old('is_admin', $user->is_admin ?? 0) == 1 ? 'selected' : '' }}>Admin</option>
    </select>
</div>
<div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        {{ $buttonText ?? 'Create' }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
        Cancel
    </a>
</div> 