<!doctype html>
<html>
    </head>
    <body>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <form method="POST" action="/submit-form">
            @csrf

            name: <input type="text" required>
            <br>
            Email: <input type="email" required>
            <br>
            subject: <input type="text" required>
            <br>
            content:
            <br>
            <textarea required></textarea>
            <br>
            <button type="submit">
        </form>
    </body>
</html>
