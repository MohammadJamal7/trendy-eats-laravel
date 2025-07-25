@csrf
<div class="mb-4">
    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
</div>
<div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        {{ $buttonText ?? 'Create' }}
    </button>
    <a href="{{ route('admin.categories.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
        Cancel
    </a>
</div> 