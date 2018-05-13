<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script src="/js/contact-page.js"></script>
    </head>
    <body>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="col-md-3"></div>
        <div class="col-md-6" style="float: none; margin: 0 auto">
            <form id="contact-form">
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

        @if( ! empty($data))
            <br><br><br>

            <div class="col-md-6" style="float: none; margin: 0 auto">
                <h3>contact tickets</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Content</th>
                            <th>actions</th>
                        </tr>
                    </thead>

                    @foreach ($data as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->content }}</td>
                            <td><a href="#" class="deleteContact" data-id="{{ $contact->id }}">Delete</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

        <div class="col-md-3"></div>
    </body>
</html>
