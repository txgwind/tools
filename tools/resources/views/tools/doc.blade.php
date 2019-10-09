<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        input, select {
            height: 30px;
        }
        a{
            color:lightsteelblue;
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
        p+table.wysiwyg-macro, table.wysiwyg-macro+p {
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
<form action="/index.php" method="post">
    <table>
        <tr>
            <td>api 地址: <select name="api" onchange="setapi(this)">
                    @foreach($api as $key=>$item)
                        <option replace="{{$item['replace']}}" end="{{$item['end']}}">{{$item['name']}}</option>
                    @endforeach
                </select></td>
            <td>接口预设: <input style="width:90%;" type="text"
                             value="        '{{$code['method']}}' => '{{$code['address']}}',  //{{$code['title']}}"
                             id="api" name="data['api']"/>
            </td><td>
                <input type="hidden" name="apiline" value="{{$api[0]['end']}}"/>
                <a href="javascript:insertCode('api');">插入api文件</a>
            </td>
        </tr>
        <tr>
            <td>路由文件：<select id="rote" name="data['rote']" onchange="setRote(this)">
                    @foreach($rote as $key=>$item)
                        <option v={{ implode(",",$item) }} value="{{$key}}">{{$key}}</option>
                    @endforeach
                </select></td>
            <td>
                控制文件：<select name="data['ctl']" id="controller_name" name="conttroller" onchange="useRote(this)">
                    <option value="">请选择控制器</option>
                </select> 接口预设: <input style="width:700px" type="text" name="rote_set"
                                       value="    $route_dispatch->addRoute('{{$code['params']}}', '{{$code['api_address']}}', 'AdController{{'@'}}{{$code['method']}}');"/>
</td><td>
                <a style="display:none" href="javascript:insertCode('rote');">插入rote文件</a></td>
        </tr>
        <tr><td>文件地址：</td><td><textarea name="config" style="height:80px;width:{{$width}}" id="config">
"api":"",
"rote":"",
"controller":"",
"dao":"",
"impl":""
                </textarea></td></tr>

        @if(!empty($code['code']['need']))
        <tr>
            <td>controller:</td>
            <td>  <textarea style="height:280px;width:{{$width}}" id="controller" name="data['controller']">
    //{{$code['title']}}
    public function {{$code['method']}}Validator()
    {
        // 获取必传参数
        $input = getInputAllData();
        @if(!empty($code['code']['need']))$rules = [
        @foreach($code['code']['need'] as $key=>$item)
   '{{trim($item[4])}}'=>'required',
        @endforeach];
        @endif
@if(!empty($code['code']['need']))$messages = [
        @foreach($code['code']['need'] as $key=>$item)
  '{{trim($item[4])}}.required' => 10016,
        @endforeach];
        @endif
return MobileValidator::check($input, $rules, $messages);
    }
    </textarea></td><td><a href="javascript:insertCode('controller');">插入controller文件</a></td></td>
        </tr>
        @endif

        <tr>
            <td>dao:</td>
            <td>  <textarea id="dao" style="height:280px;width:{{$width}}" name="data['dao']">
    //{{$code['title']}}
     public function {{$code['method']}}()
    {
        //分页
        $page = getInputData('page',1);
        //每页条数
        $num = getInputData('count',20);
        // 获取必传参数
        @if(!empty($code['code']['need']))
@foreach($code['code']['need'] as $key=>$item)
$search['{{$item[4]}}'] = getInputData('{{$item[4]}}',null,@if( strtolower($item[2])=="int" ) true @else false @endif);
        @endforeach
@endif @if(!empty($code['code']['noneed']))

        // 获取非必传参数
        @foreach($code['code']['noneed'] as $key=>$item)
$search['{{$item[4]}}'] = getInputData('{{$item[4]}}',null,{{ strtolower($item[2])=="int"?true:false}});
        @endforeach
        @endif
        //调用model获取微服务数据
        $rs = $this->client->{{$code['method']}}($search,$page, $num);
        //判断接口返回值非异常
        if (!is_array($rs)) {
            return Common::showError($rs);
        }
        return Common::showSucc('succ', $rs);
    }
    </textarea><td><a href="javascript:insertCode('dao');">插入dao文件</a></td></td>
        </tr>

        <tr>
            <td>map:</td>
            <td>  <textarea id="map" style="height:180px;width:{{$width}}" name="data['map']">


    public $fields_map = [
@if(!empty($code['code']['need']))
        @foreach($code['code']['need'] as $key=>$item)
        '{{$item[4]}}' => '{{$item[1]}}',{{$item[5]}}
        @endforeach
        @endif
@if(!empty($code['code']['noneed']))
@foreach($code['code']['noneed'] as $key=>$item)
'{{$item[4]}}' => '{{$item[1]}}',{{$item[5]}}
                @endforeach
                    @endif

    ]
                  </textarea>
            </td>
        </tr>
        <tr>
            <td>model:</td>
            <td><textarea id="impl" style="height:180px;width:{{$width}}"  name="data['impl']">
    //{{$code['title']}}
    public function {{$code['method']}}($search, $page = 1, $num = 20)
    {
        $search['offset'] = ($page - 1) * $num;
        $search['num'] = $num;
        return $this->getData('{{$code['params']}}', '{{$code['method']}}',$search);
    }
                </textarea></td><td><a href="javascript:insertCode('impl');">插入model文件</a></td></td>
        </tr>

        <tr>
            <td colspan="3"><input id="act" name="act" value="" type="hidden">
                {{ csrf_field() }}
                <input id="root" name="root" value="{{$root}}" type="hidden">
                接口示例: <a target="_blank"
                        v="@if(!empty($code['code']['need']))@foreach($code['code']['need'] as $key=>$item){{$item[4]}}={{$key}}&@endforeach @endif @if(!empty($code['code']['noneed']))@foreach($code['code']['noneed'] as $key=>$item){{$item[4]}}={{$key}}&@endforeach @endif"
                        id="api_test" ></a>
                </td>
        </tr>
    </table>
</form>
<?php echo $doc; ?>
</body>
<script>
    function setapi(obj) {
        var end = $(obj).find("option:selected").attr("end");
        $(":input[name='apiline']").val(end);
        var config = $("#config").val();
        var arr = config.split(",");
        arr[0] = arr[0].split(":")[0]+":"+end;
        $("#config").val(arr.join(","));

    }
    function insetApi() {

    }
    function insertCode(act) {

        $('#act').val(act);
        var config = "{"+$('#config').val()+"}"
        var code = $("#"+act).val();
        var path = $('#root').val();
        var token = $(":input[name='_token']").val();
        $.post('/tools/insterCode',{config:config,act:act,code:code,path:path,_token:token},function(msg){
            alert(msg);
        });
        
    }
    function setRote(obj) {
        var data = $(obj).find("option:selected").attr("v");
        var name  = $(obj).find("option:selected").val();
        var arr = data.split(",");
        var html = '<option value="">请选择控制器</option>';
        $.each(arr, function (i, m) {
            html += "<option value='" + m + "'>" + m + "</option>"
        })
        $("#controller_name").html(html);

        var config = $("#config").val();
        var arr = config.split(",");

        arr[1] = arr[1].split(":")[0]+":\""+name+"\"";
        $("#config").val(arr.join(","));
        var link = "http://api.17k.com/"+$('#rote').find("option:selected").text().replace(".php","")+"{{$code['api_address']}}?"+ $('#api_test').attr('v')+"&appKey=4037461542&accessToken=4322&__flush_cache=1";
        $('#api_test').attr("href",link).text(link);
    }
    function useRote(obj) {
        var data = $(obj).val();
        var name = $(obj).find("option:selected").text();
        var rote = $(":input[name='rote_set']").val();
        var replace = "$1'" + data + "@$3";
        rote = rote.replace(/(.*)'(\w+)@(.*)/ig, replace);
        $(":input[name='rote_set']").val(rote);

        var config = $("#config").val();
        var arr = config.split(",");
        var filename = $('#rote').find("option:selected").text().replace(".php","");
        arr[2] = arr[2].split(":")[0]+":\"/app/controller/"+filename+"/"+name+".php\"";
        arr[3] = arr[3].split(":")[0]+":\"/"+filename+"/dao/"+name.replace("Controller","Dao.php")+"\"";
        arr[4] = arr[4].split(":")[0]+":\"/"+filename+"/impl/"+name.replace("Controller","Model.php")+"\"";

        $("#config").val(arr.join(","));
    }


    var s= $('#maindoc').html();
    var clipboard = new Clipboard('#tocopy', {
        text: function() {
            return s;
        }
    });
    clipboard.on('success', function(e) {
        alert("复制成功");
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>
</html>