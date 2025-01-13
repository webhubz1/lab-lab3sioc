<!DOCTYPE html>
<html>
<head>
    <title>Create Supplier</title>
</head>
<body>
    <h1>Create New Supplier</h1>
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="contact_info">Contact Info:</label>
        <input type="text" id="contact_info" name="contact_info"><br>

        <button type="submit">Create Supplier</button>
    </form>
</body>
</html>
