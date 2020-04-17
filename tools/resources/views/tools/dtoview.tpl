<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Title</title>
    <script src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('js/clipboard.js')}}"></script>
</head>
<form id="myform" action="/tools/downDto" method="POST" target="_blank">
<textarea name="code"  style="width:100%;height:300px">
{if $types == 1}
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

    {foreach from=$data['fileds'] key=key item=item}
/**
    * {if $item[6]!="NULL"}{{str_replace("'","",$item[6])}}
    {/if}
*/
    @ApiModelProperty(value = "{{str_replace("'","",$item[6])}}")
    @Column
    private {if $item[3]=="int"}Integer{elseif $item[3]=="float" }Long{elseif $item[2]=="datetime" }Date{elseif $item[3]=="varchar"||$item[3]=="char" }String{/if} {{$item[1]}} ;

    {/foreach}

}
{else}

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


{foreach from=$data['fileds'] key=key item=item}
@Column
    private {if $item[3]=="int"}Integer {elseif $item[3]=="float" }Long {elseif $item[2]=="datetime" }Date {elseif $item[3]=="varchar"||$item[3]=="char" }String {/if}{{$item[1]}}  ;{if $item[6]!="NULL"}//{{str_replace("'","",$item[6])}}
{else}
    //
{/if}
{/foreach}


{/if}
</textarea>
    <p>api interface:</p>
    <textarea style="width:100%;height:300px">
package {{$data['package']}};

import com.chineseall.entity.page.Page;
import com.chineseall.k17.utils.ReturnMsg;
import com.chineseall.misc.entity.countlogs.HadoopDistributionBookDTO;
import com.chineseall.misc.entity.countlogs.HadoopDistributionChapterDTO;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;

import java.util.List;

/**
 * Created by wq
 * Email: tangxg@col.com
 * DateTime: 2020/4/8 14:42
 */
public interface I{$data['cla_name']}Service {
     /**
     * ?????
     * @return
     * @throws Exception
     */
    @RequestMapping(value = "????", method = RequestMethod.GET)
    ReturnMsg<Page<{$data['cla']}>> {$data['cla']}Lists(
        {foreach from=$data['fileds'] name=list key=key item=item}
@RequestParam(value = "{{$item[1]}}", required = false, defaultValue = "0") Integer {{$item[1]}}{if !$smarty.foreach.list.last},
{/if}
        {/foreach}
    ) throws Exception;
    }
    </textarea>
    <p>controller:</p>
    <textarea style="width:100%;height:300px">
package {{$data['package']}};

import com.chineseall.entity.page.Page;
import com.chineseall.k17.utils.ReturnMsg;
import com.chineseall.misc.api.IDistributionApiService;
import com.chineseall.misc.entity.countlogs.HadoopDistributionBookDTO;
import com.chineseall.misc.entity.countlogs.HadoopDistributionChapterDTO;
import com.chineseall.misc.logic.DistributionServcieLogic;
import org.springframework.web.bind.annotation.RestController;

import javax.annotation.Resource;
import java.util.List;

/**
 * Created by txg
 * Email: tangxg@col.com
 * DateTime: 2020.2020/4/8/008
 */
@RestController
public class {{$data['cla_name']}}Controller implements I{{$data['cla_name']}}ApiService {
     /**
     * ?????
     * @return
     * @throws Exception
     */
    @Override
    public ReturnMsg<Page<{$data['cla']}>> {$data['cla']}Lists({foreach from=$data['fileds'] key=key item=item name=list }{if $item[3]=="int"}Integer{elseif $item[3]=="float" }Long{elseif $item[2]=="datetime" }Date{elseif $item[3]=="varchar"||$item[3]=="char" }String{/if} {{$item[1]}}{if !$smarty.foreach.list.last},{/if}{/foreach}
        ) throws Exception{
        Page<{$data['cla']}> {$data['cla']} = {$data['cla']}ServcieLogic.chapterLists({foreach from=$data['fileds'] name=list key=key item=item}{{$item[1]}}{if !$smarty.foreach.list.last},{/if}{/foreach});
        return new ReturnMsg<>(hadoopDistributionChapterDTO);
        };
    }
    </textarea>
    <textarea style="width:100%;height:300px">
       {foreach from=$data['fileds'] key=key item=item}
.set{{ucfirst($item[1])}}({if $item[3]=="int"}Integer.parseInt(x.get("{$item[1]}").toString()){elseif $item[3]=="float"}Long.parseLong(x.get("{$item[1]}").toString()){elseif $item[2] == "datetime" }DateUtil.date((Date)x.get("{{$item[1]}}")) {else} x.get("{{$item[1]}}").toString() {/if})
        {/foreach}
        ;
    </textarea>
文件：<input name="path" style="width:90%" id="path" value="{{$path}}/{{$data['cla']}}.java" />
{csrf_field()}
</form>
<p><a onclick="submit()" href="javascript:void(0)">生成文件</a> <a onclick="submit2()" href="javascript:void(0)">下载文件</a></p>
<script>
    function submit(){
        var data = $('#myform').serializeArray();
        $.post("/tools/createDTO",data,function (msg) {
                alert("成功");
        });
    }
    function submit2() {
        $('#myform').submit();
    }
</script>
</body>
</html>

