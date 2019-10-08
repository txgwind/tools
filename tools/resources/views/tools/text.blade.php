<h2>+++++++++++++文档开始+++++++++++++</h2><a id="tocopy" href="javascript:void();">复制</a>
<div id="maindoc">
<h1>修改星球</h1>
<p><span> 基本信息：</span></p>
<div class="table-wrap">
    <table class="confluenceTable">
        <tbody>
        <tr>
            <td class="confluenceTd">请求地址</td>
            <td class="confluenceTd">{{$code['api_address']}}</td>
        </tr>
        <tr>
            <td class="confluenceTd">请求方法</td>
            <td class="confluenceTd">{{$code['params']}}</td>
        </tr>
        <tr>
            <td class="confluenceTd">版本协议</td>
            <td class="confluenceTd"></td>
        </tr>
        <tr>
            <td colspan="1" class="confluenceTd">接口描述</td>
            <td colspan="1" class="confluenceTd">{{$code['title']}}</td>
        </tr>
        </tbody>
    </table>
</div><p></p><p><strong>请求参数：</strong></p>
<div class="table-wrap">
    <table class="confluenceTable">
        <tbody>
        <tr>
            <th class="confluenceTh"><span>参数名称</span></th>
            <th class="confluenceTh"><span>类型</span></th>
            <th class="confluenceTh"><span>是否必须</span></th>
            <th class="confluenceTh"><span>描述</span></th>
        </tr>

        @if(!empty($code['code']['need']))
        @foreach($code['code']['need'] as $key=>$item)
            <tr>
                <td class="confluenceTd"><span>{{$item[4]}}</span></td>
                <td class="confluenceTd"><span>{{$item[2]}}</span></td>
                <td class="confluenceTd"><span>{{$item[3]}}</span></td>
                <td class="confluenceTd"><span>{{substr($item[5],2,100)}}</span></td>
            </tr>
        @endforeach
        @endif
        @if(!empty($code['code']['noneed']))
        @foreach($code['code']['noneed'] as $key=>$item)
            <tr>
                <td class="confluenceTd"><span>{{$item[4]}}</span></td>
                <td class="confluenceTd"><span>{{$item[2]}}</span></td>
                <td class="confluenceTd"><span>{{$item[3]}}</span></td>
                <td class="confluenceTd"><span>{{substr($item[5],2,100)}}</span></td>
            </tr>
        @endforeach
        @endif

        </tbody>
    </table>
</div><p>输出结果：</p>
<table class="wysiwyg-macro" data-macro-name="code" data-macro-parameters="collapse=true" style="background-image: url(/plugins/servlet/confluence/placeholder/macro-heading?definition=e2NvZGU6Y29sbGFwc2U9dHJ1ZX0&amp;locale=zh_CN&amp;version=2); background-repeat: no-repeat;" data-macro-body-type="PLAIN_TEXT"><tbody><tr><td class="wysiwyg-macro-body"><pre></pre></td></tr></tbody></table>
</div>
<h2>+++++++++++++文档结束+++++++++++++</h2>