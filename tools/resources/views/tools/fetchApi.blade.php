<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .ar{
            height:400px;
            width: 400px;
        }
        .ar2{
            height:400px;
            width: 300px;
        }
        table{border-collapse: collapse;width:100%;}
        tr{}
        td{border: 1px solid #936943;height:40px;}
    </style>
</head>
<body>

<div class="table-wrap">
    @if(isset($url))<h5><a target="_blank" href="{{$url}}">{{$url}}</a></h5>@endif
    @if(isset($handler))<h5>{{$handler}}</h5>@endif
    <table class="confluenceTable">
        <tbody>
        <tr>
            <th class="confluenceTh"><span>接口名称</span></th>
            <th class="confluenceTh"><span>接口地址</span></th>
            <th class="confluenceTh"><span>类型</span></th>
            <th class="confluenceTh"><span>耗时</span></th>
            <th class="confluenceTh"><span>返回值</span></th>
            <th class="confluenceTh"><span>post参数</span></th>
        </tr>
        @if(!empty($data))
            @foreach($data as $key=>$item)
                <tr>
                    <td class="confluenceTd">{{$item['api_doc']}}</td>
                    <td class="confluenceTd"><a alter="{{$item['url']}}"  href="{{$item['url']}}" target="_blank">{{substr($item['url'],0,60)}}</a></td>
                    <td class="confluenceTd">{{$item['method']}}</td>
                    <td class="confluenceTd">{{$item['run_time']}}</td>
                    <td class="confluenceTd"><textarea class="ar">@if(is_string($item['response'])){{print_r(json_decode($item['response'],true),true)}}@else{{print_r($item['response'],true)}}@endif</textarea></td>
                    <td class="confluenceTd"><textarea class="ar2">{{isset($item['args']['post'])?print_r($item['args']['post'],true):""}}
                        @if(isset($item['params'])){{print_r(json_decode($item['params'],true),true)}}@endif
                        </textarea></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
</body>
</html>
