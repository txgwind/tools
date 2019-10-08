<!-- View stored in resources/views/greeting.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Title</title>
</head>
<body>
@if (empty($data))
<form action="/tools/parse" method="post" enctype="multipart/form-data" >
    <textarea style="width:80%;height: 500px" name="sql">

    </textarea>
    {{ csrf_field() }}
    <br/>
    <input type="submit" />
</form>
@else
    <h1><span> {{$data['name']}}<br></span></h1>
<table class="confluenceTable">
    <tr><th class="confluenceTh">新表名称</th><th class="confluenceTh">字段名</th><th class="confluenceTh">字段类型</th><th class="confluenceTh">默认值</th><th class="confluenceTh">备注</th></tr>
    @foreach($data['cloum'][0] as $key=>$cloum)
            @if ($key==0) <tr><td rowspan="{{count($data['cloum'][0])}}" class="confluenceTd">{{$data['table']}}</td>@endif
            <td class="confluenceTd">{{$data['cloum'][1][$key]}}</td><td class="confluenceTd">@if (!empty($data['cloum'][3][$key])){{$data['cloum'][3][$key]}}@else{{$data['cloum'][4][$key]}}@endif</td><td class="confluenceTh"></td><td class="confluenceTd">{{ str_replace("'","",$data['cloum'][6][$key])}}</td></tr>
    @endforeach
</table>
@endif
</body>
</html>