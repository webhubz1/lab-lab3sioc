<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
    <h1>Categories List</h1>
    <a href="{{ route('categories.create') }}">Add New Category</a>
    <ul>
        @foreach ($categories as $category)
            <li>
                {{ $category->name }}
                - <a href="{{ route('categories.edit', $category->id) }}">Edit</a>
                - <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
