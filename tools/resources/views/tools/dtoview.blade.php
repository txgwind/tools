<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Title</title>
    <script src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('js/clipboard.js')}}"></script>
</head>
<form id="myform">
<textarea name="code"  style="width:100%;height:300px">
@if($types == 1)
package {{$data['package']}};

import lombok.Data;
import java.io.Serializable;
import java.util.Date;
import io.swagger.annotations.ApiModelProperty;
import lombok.experimental.Accessors;


/**
 * Created by txg
 * Email: tangxg@col.com
 * DateTime: {{date("Y.m.d")}}
 */
@Data
@Accessors(chain = true)
public class {{$data['cla']}} implements Serializable {

@foreach($data['fileds'] as $key=>$item)
    /**
    * @if($item[6]!="NULL"){{str_replace("'","",$item[6])}}
@endif
    */
    @ApiModelProperty(value = "{{str_replace("'","",$item[6])}}")
    private @if( $item[3]=="int"||$item[3]=="bigint" )Integer @elseif($item[3]=="float" )Long @elseif( $item[2]=="datetime" )Date @elseif( $item[3]=="varchar"||$item[3]=="char" )String @endif{{$item[1]}}  ;

@endforeach

}
    @else

package {{$data['package']}};;

import com.chineseall.orm.ModelObject;
import com.chineseall.orm.annotations.*;
import lombok.Data;
import java.util.Date;

/**
* Created by txg
* Email: tangxg@col.com
* DateTime: {{date("Y.m.d")}}
*/
@Data
@Database(name = "misc-master")
@Table(name = "{{$data['table']}}", engine = ModelEngineType.MYSQL_OBJECT)
public class {{$data['cla']}} extends ModelObject<{{$data['cla']}}> {


@foreach($data['fileds'] as $key=>$item)    @Column
    private @if( $item[3]=="int" )Integer @elseif($item[3]=="float" )Long @elseif( $item[2]=="datetime" )Date @elseif( $item[3]=="varchar"||$item[3]=="char" )String @endif{{$item[1]}}  ;@if($item[6]!="NULL")//{{str_replace("'","",$item[6])}}
@else
    //
@endif
@endforeach

}


@endif
</textarea>
    <textarea style="width:100%;height:300px">
        @foreach($data['fileds'] as $key=>$item)
        @RequestParam(value = "{{$item[1]}}", required = false, defaultValue = "0") Integer {{$item[1]}},
        @endforeach
    </textarea>
    <textarea style="width:100%;height:300px">
        @foreach($data['fileds'] as $key=>$item)
.set{{ucfirst($item[1])}}(@if($item[3]=="int")Integer.parseInt(x.get("{{$item[1]}}").toString())@elseif($item[3]=="float")Long.parseLong(x.get("{{$item[1]}}").toString())@elseif( $item[2] == "datetime" )DateUtil.date((Date)x.get("{{$item[1]}}")) @else x.get("{{$item[1]}}").toString() @endif)
        @endforeach
        ;
    </textarea>
文件：<input name="path" style="width:90%" id="path" value="{{$path}}/{{$data['cla']}}.java" />
@csrf
</form>
<p><a onclick="submit()" href="javascript:void(0)">生成文件</a></p>
<script>
    function submit(){
        var data = $('#myform').serializeArray();
        $.post("/tools/createDTO",data,function (msg) {
                alert("成功");
        });
    }
</script>
</body>
</html>

