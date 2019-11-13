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
    <p style="height: 30px;line-height: 30px">post/get：<select name="method">
            <option  value="post">post</option>
            <option selected="selected" value="get" >get</option>
            <option value="PUT" >PUT</option>
        </select></p>
    <p>类型：<select name="types">
            <option value="1">dao</option>
            <option value="2" >文档</option>
            <option value="3" >postman</option>
            <option value="4" >url</option>
            <option value="5" >chareles</option>
            <option value="6" >json</option>
        </select>
    </p>
    <p>接口地址：<input style="width:50%" name="api" value="http://api.17k.com/sns/discover/index?clientType=1&cpsOpid=0&_filterData=1&channel=0&_versions=1020&merchant=17Kbdsz&appKey=4037465544&cpsSource=0&platform=2"></p>
    <p>必要参数：<input id="ctname" style="width:50%" name="params" value="&appKey=4037461542&accessToken=4322&__flush_cache=1"></p>
    <input id="submit" type="submit" />
</form>
</body>
</html>
