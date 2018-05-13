<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="col-md-3"></div>
        <div class="col-md-6" style="float: none; margin: 0 auto">
            <form method="POST" action="/submit-form">
                @csrf

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" name="subject" id="subject" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="subject">Content:</label>
                    <textarea name="content" id="content" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </body>
</html>
