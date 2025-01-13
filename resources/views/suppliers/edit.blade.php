<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
</head>
<body>
    <h1>Edit Supplier</h1>
    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $supplier->name }}" required><br>

        <label for="contact_info">Contact Info:</label>
        <input type="text" id="contact_info" name="contact_info" value="{{ $supplier->contact_info }}"><br>

        <button type="submit">Update Supplier</button>
    </form>
</body>
</html>
