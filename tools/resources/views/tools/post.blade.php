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

<form action="/tools/postParse" method="post">
    <textarea onblur="getMethod(this)" style="width:80%;height:500px" name="doc"></textarea><br><br>
    <input name="act" value="parse" type="hidden">
    @csrf
    <p>接口地址：<input style="width:50%" name="api" value="http://api.17k.com/sns/thread/savethread"></p>
    <p>必要参数：<input id="ctname" style="width:50%" name="params" value="appKey=4037461542&accessToken=4322&__flush_cache=1"></p>
    <input id="submit" type="submit" />
</form>
</body>
</html>