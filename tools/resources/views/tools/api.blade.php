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

<form action="/tools/apiresult" method="post">
    <textarea onblur="getMethod(this)" style="width:80%;height:500px" name="doc"></textarea><br><br>
    <input name="act" value="parse" type="hidden">
    {{ csrf_field() }}
    <p>　项目地址：<input style="width:50%" name="root" value="E:\\www\\server-spring-php-api\\config\\route"></p>
    <p>控制层名称：<input id="ctname" style="width:50%" name="ctname" value=""></p>
    <input id="submit" type="submit" disabled/>
</form>
</body>
<script>
    function getMethod(obj){
        var data = $(obj).val();
        arr = data.split(/\n/);
        var method = "";
        $.each(arr,function(i,n){
            if(n.indexOf("请求地址")!=-1){
                arr2 = n.split("/");
                for(var i=2;i<arr2.length;i++){
                    if(arr2[i].indexOf("{")==-1){
                        method += i==2?arr2[i]:arr2[i].substring(0, 1).toUpperCase() +arr2[i].substring(1).toLowerCase();
                    }
                }
            }
        });
        $('#ctname').val(method);
        $('#submit').removeAttr('disabled');
    }

</script>
</html>