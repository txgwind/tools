<!-- View stored in resources/views/greeting.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Title</title>
</head>
<body>
<form action="/tools/doServer" method="get" enctype="multipart/form-data" >
    <textarea style="width:80%;height: 500px" name="curl">

    </textarea>
    {{ csrf_field() }}
    <br/>
    <input type="submit" />
</form>
</body>
</html>
