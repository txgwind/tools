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
    <textarea style="width:80%;height: 500px" name="curl"></textarea>
    {{ csrf_field() }}
    <br/>
    <p>域名：<select name="ip">
        <option selected="selected" value="125.39.195.110">天津</option>
        <option selected="selected" value="192.168.2.67">天润67</option>
        <option value="39.105.177.97">线上</option>
    </select> 手动 ip: <input name="toip" value="" /></p>
    <input type="submit" />
</form>
</body>
</html>
