<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Title</title>
    <style>
        input, select {
            height: 30px;
        }

        a {
            color: lightsteelblue;
        }

        textarea {
            width: 800px;
            height: 60px;
        }

        .confluenceTable, .table-wrap {
            margin: 10px 0 0 0;
            overflow-x: auto;
        }

        .confluenceTh, .confluenceTd {
            border: 1px solid #ddd;
            padding: 7px 10px;
            vertical-align: top;
            text-align: left;
        }

        .panel, .alertPanel, .infoPanel {
            color: #333;
            padding: 0;
            margin: 10px 0;
            border: 1px solid #ddd;
            overflow: hidden;
            border-radius: 3px;
        }

        .wiki-content table.wysiwyg-macro {
            border: 5px solid #f0f0f0;
            background-color: #fff;
            background-repeat: no-repeat;
            padding: 0;
        }

        .wiki-content table.wysiwyg-macro {
            border-collapse: separate;
        }

        .wysiwyg-macro {
            width: 99.46%;
        }

        .wiki-content .wysiwyg-macro {
            width: 100%;
            padding: 24px 2px 2px 2px;
        }

        p + table.wysiwyg-macro, table.wysiwyg-macro + p {
            margin-top: 10px;
        }

        .wysiwyg-macro {
            background-color: #f0f0f0;
            background-repeat: no-repeat;
            background-position: 0 0;
            border: 1px solid #ddd;
        }

        user agent stylesheet
        table {
            display: table;
            border-collapse: separate;
            border-spacing: 2px;
            border-color: grey;
        }

    </style>
    <script src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('js/clipboard.js')}}"></script>
</head>
<body>
<form id="myform"   action="{{$api}}"  method="@if($method == 'PUT'){{"post"}}@else{{$method}}@endif" target="_blank">
    <table>
        @if(!empty($code))
            @foreach($code as $key=>$item)
                <tr>
                    <td>{{$item[0]}}</td>
                    @if($types != 8)
                    <td><input style="width:500px"  value="{{$item[1]}}"/></td>
                        @else
                    <td><input type="file" style="width:500px"  value=""/></td>
                    @endif
                </tr>
            @endforeach
        @endif

        <tr>
            <td> @if($method == 'PUT')<input type="hidden" name="_method" value="PUT">@endif<input
                    type="submit"/>
                <input type="button" onclick="toSubmit()" value="onjs"/>
                <input type="button" ck="0" onclick="fetchApi(this)" value="微服务接口抓取"/>
            </td>
        </tr>
    </table>
</form>

<div class="table-wrap">
    <table class="confluenceTable">
        <tbody>
        <tr>
            <th class="confluenceTh"><span>参数名称</span></th>
            <th class="confluenceTh"><span>类型</span></th>
            <th class="confluenceTh"><span>是否必须</span></th>
            <th class="confluenceTh"><span>描述</span></th>
        </tr>

        @if(!empty($code))
            @foreach($code as $key=>$item)
                <tr>
                    <td class="confluenceTd"><span>{{$item[0]}}</span></td>
                    <td class="confluenceTd"><span>{{$item[2]}}</span></td>
                    <td class="confluenceTd"><span>是</span></td>
                    <td class="confluenceTd"><span>{{$item[0]}}</span></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
</body>
<script>
    function toSubmit() {
        var url = $("#myform").attr("action");
        var method = $("#myform").attr("method");
        var data = $("#myform").serializeArray();

        $.ajax({
            type: "POST",
            url: url,/*url写异域的请求地址*/
            data: data,
            dataType: "jsonp",/*加上datatype*/
            jsonpCallback: "cb",/*设置一个回调函数，名字随便取，和下面的函数里的名字相同就行*/
            success: function (msg) {
                console.log(JSON.stringify(msg));
            }
        });
    }

    function fetchApi(obj) {
        var num = $(obj).attr("ck");
        if (num == "0") {
            var url = $("#myform").attr("action");
            var method = $("#myform").attr("method");
            $("#myform").attr("action", "/tools/fetchApi").attr("method", "get");
            $("#myform").append("<input name='api_url' value='" + url + "' />");
            $("#myform").append("<input name='api_method' value='" + method + "' />");
            $(obj).attr("ck","1");
        }
        $("#myform").submit();
    }

</script>
</html>
