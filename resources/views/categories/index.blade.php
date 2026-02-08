<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
</head>

<body>
    <h1>Category Test</h1>

    @if ($category->count())
        <ul>
            @foreach ($category as $cat)
                <li>
                    <strong>{{ $cat->name }}</strong>
                </li>
            @endforeach
        </ul>
    @else
        <p>No active category found.</p>
    @endif
</body>

</html>
