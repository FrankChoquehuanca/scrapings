<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
    <title>Documents Csv</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('export') }}">Export CSV</a></li>
            </ul>
        </nav>
        <form method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
            <h3>Import CSV</h3>
            @csrf
            <input type="file" name="document_csv"/>
            <input type="submit" value="import CSV"/>
        </form>
    </header>
    <main>
        @forelse ($products as $product)
            <article>
                <head>
                    {{ $product->name }}
                </head>
                {{ $product->description }}
                <footer>
                    {{ $product->price }}
                </footer>
            </article>
        @empty
            <p>No Data</p>
        @endforelse
    </main>
</body>

</html>
