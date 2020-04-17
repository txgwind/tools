<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        input, select {
            height: 30px;
        }
        textarea {
            width: 800px;
            height: 60px;
        }
    </style>
    <script src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
</head>
<body>

<form action="/tools/parseSql" method="post">
    <textarea onblur="getMethod(this)" style="width:80%;height:500px" name="doc"></textarea><br><br>
    <input name="act" value="parse" type="hidden">
    @csrf
    <p>转成：<select name="types">
            <option value="1">dto</option>
            <option value="2" >model</option>
        </select>
    </p>
    <p>path: <input name="path" style="width:90%"/></p>
<input id="submit" type="submit" />
</form>
</body>
</html>
