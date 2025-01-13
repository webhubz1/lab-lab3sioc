<!DOCTYPE html>
<html>
<head>
    <title>Suppliers</title>
</head>
<body>
    <h1>Suppliers List</h1>
    <a href="{{ route('suppliers.create') }}">Add New Supplier</a>
    <ul>
        @foreach ($suppliers as $supplier)
            <li>
                {{ $supplier->name }}
                - <a href="{{ route('suppliers.edit', $supplier->id) }}">Edit</a>
                - <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
