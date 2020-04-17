<?php
/* Smarty version 3.1.34-dev-7, created on 2020-04-16 10:12:17
  from '/Volumes/datas/www/mytools/tools/resources/views/tools/dtoview.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e982f81179374_57401047',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa9835aac2229f619d65d72318ba881d9b33bdf8' => 
    array (
      0 => '/Volumes/datas/www/mytools/tools/resources/views/tools/dtoview.tpl',
      1 => 1586847719,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e982f81179374_57401047 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Title</title>
    <?php echo '<script'; ?>
 src="<?php ob_start();
echo asset('js/jquery-1.9.1.min.js');
$_prefixVariable1 = ob_get_clean();
echo $_prefixVariable1;?>
"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php ob_start();
echo asset('js/clipboard.js');
$_prefixVariable2 = ob_get_clean();
echo $_prefixVariable2;?>
"><?php echo '</script'; ?>
>
</head>
<form id="myform" action="/tools/downDto" method="POST" target="_blank">
<textarea name="code"  style="width:100%;height:300px">
<?php if ($_smarty_tpl->tpl_vars['types']->value == 1) {?>
package <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['package'];
$_prefixVariable3 = ob_get_clean();
echo $_prefixVariable3;?>
;

import lombok.Data;
import java.io.Serializable;
import java.util.Date;
import io.swagger.annotations.ApiModelProperty;
import lombok.experimental.Accessors;


/**
 * Created by txg
 * Email: tangxg@col.com
 * DateTime: <?php ob_start();
echo date("Y.m.d");
$_prefixVariable4 = ob_get_clean();
echo $_prefixVariable4;?>

 */
@Data
@Accessors(chain = true)
public class <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['cla'];
$_prefixVariable5 = ob_get_clean();
echo $_prefixVariable5;?>
 implements Serializable {

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['fileds'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
/**
    * <?php if ($_smarty_tpl->tpl_vars['item']->value[6] != "NULL") {
ob_start();
echo str_replace("'",'',$_smarty_tpl->tpl_vars['item']->value[6]);
$_prefixVariable6 = ob_get_clean();
echo $_prefixVariable6;?>

    <?php }?>
*/
    @ApiModelProperty(value = "<?php ob_start();
echo str_replace("'",'',$_smarty_tpl->tpl_vars['item']->value[6]);
$_prefixVariable7 = ob_get_clean();
echo $_prefixVariable7;?>
")
    @Column
    private <?php if ($_smarty_tpl->tpl_vars['item']->value[3] == "int") {?>Integer<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "float") {?>Long<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[2] == "datetime") {?>Date<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "varchar" || $_smarty_tpl->tpl_vars['item']->value[3] == "char") {?>String<?php }?> <?php ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable8 = ob_get_clean();
echo $_prefixVariable8;?>
 ;

    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

}
<?php } else { ?>

package <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['package'];
$_prefixVariable9 = ob_get_clean();
echo $_prefixVariable9;?>
;;

import com.chineseall.orm.ModelObject;
import com.chineseall.orm.annotations.*;
import lombok.Data;
import java.util.Date;

/**
* Created by txg
* Email: tangxg@col.com
* DateTime: <?php ob_start();
echo date("Y.m.d");
$_prefixVariable10 = ob_get_clean();
echo $_prefixVariable10;?>

*/
@Data
@Database(name = "misc-master")
@Table(name = "<?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['table'];
$_prefixVariable11 = ob_get_clean();
echo $_prefixVariable11;?>
", engine = ModelEngineType.MYSQL_OBJECT)
public class <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['cla'];
$_prefixVariable12 = ob_get_clean();
echo $_prefixVariable12;?>
 extends ModelObject<<?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['cla'];
$_prefixVariable13 = ob_get_clean();
echo $_prefixVariable13;?>
> {


<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['fileds'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
@Column
    private <?php if ($_smarty_tpl->tpl_vars['item']->value[3] == "int") {?>Integer <?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "float") {?>Long <?php } elseif ($_smarty_tpl->tpl_vars['item']->value[2] == "datetime") {?>Date <?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "varchar" || $_smarty_tpl->tpl_vars['item']->value[3] == "char") {?>String <?php }
ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable14 = ob_get_clean();
echo $_prefixVariable14;?>
  ;<?php if ($_smarty_tpl->tpl_vars['item']->value[6] != "NULL") {?>//<?php ob_start();
echo str_replace("'",'',$_smarty_tpl->tpl_vars['item']->value[6]);
$_prefixVariable15 = ob_get_clean();
echo $_prefixVariable15;?>

<?php } else { ?>
    //
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>


<?php }?>
</textarea>
    <p>api interface:</p>
    <textarea style="width:100%;height:300px">
package <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['package'];
$_prefixVariable16 = ob_get_clean();
echo $_prefixVariable16;?>
;

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
public interface I<?php echo $_smarty_tpl->tpl_vars['data']->value['cla_name'];?>
Service {
     /**
     * ?????
     * @return
     * @throws Exception
     */
    @RequestMapping(value = "????", method = RequestMethod.GET)
    ReturnMsg<Page<<?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
>> <?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
Lists(
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['fileds'], 'item', false, 'key', 'list', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['total'];
?>
@RequestParam(value = "<?php ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable17 = ob_get_clean();
echo $_prefixVariable17;?>
", required = false, defaultValue = "0") Integer <?php ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable18 = ob_get_clean();
echo $_prefixVariable18;
if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last'] : null)) {?>,
<?php }?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    ) throws Exception;
    }
    </textarea>
    <p>controller:</p>
    <textarea style="width:100%;height:300px">
package <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['package'];
$_prefixVariable19 = ob_get_clean();
echo $_prefixVariable19;?>
;

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
public class <?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['cla_name'];
$_prefixVariable20 = ob_get_clean();
echo $_prefixVariable20;?>
Controller implements I<?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['cla_name'];
$_prefixVariable21 = ob_get_clean();
echo $_prefixVariable21;?>
ApiService {
     /**
     * ?????
     * @return
     * @throws Exception
     */
    @Override
    public ReturnMsg<Page<<?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
>> <?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
Lists(<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['fileds'], 'item', false, 'key', 'list', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['total'];
if ($_smarty_tpl->tpl_vars['item']->value[3] == "int") {?>Integer<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "float") {?>Long<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[2] == "datetime") {?>Date<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "varchar" || $_smarty_tpl->tpl_vars['item']->value[3] == "char") {?>String<?php }?> <?php ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable22 = ob_get_clean();
echo $_prefixVariable22;
if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last'] : null)) {?>,<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        ) throws Exception{
        Page<<?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
> <?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
 = <?php echo $_smarty_tpl->tpl_vars['data']->value['cla'];?>
ServcieLogic.chapterLists(<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['fileds'], 'item', false, 'key', 'list', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['total'];
ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable23 = ob_get_clean();
echo $_prefixVariable23;
if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_list']->value['last'] : null)) {?>,<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>);
        return new ReturnMsg<>(hadoopDistributionChapterDTO);
        };
    }
    </textarea>
    <textarea style="width:100%;height:300px">
       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['fileds'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
.set<?php ob_start();
echo ucfirst($_smarty_tpl->tpl_vars['item']->value[1]);
$_prefixVariable24 = ob_get_clean();
echo $_prefixVariable24;?>
(<?php if ($_smarty_tpl->tpl_vars['item']->value[3] == "int") {?>Integer.parseInt(x.get("<?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
").toString())<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[3] == "float") {?>Long.parseLong(x.get("<?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
").toString())<?php } elseif ($_smarty_tpl->tpl_vars['item']->value[2] == "datetime") {?>DateUtil.date((Date)x.get("<?php ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable25 = ob_get_clean();
echo $_prefixVariable25;?>
")) <?php } else { ?> x.get("<?php ob_start();
echo $_smarty_tpl->tpl_vars['item']->value[1];
$_prefixVariable26 = ob_get_clean();
echo $_prefixVariable26;?>
").toString() <?php }?>)
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        ;
    </textarea>
文件：<input name="path" style="width:90%" id="path" value="<?php ob_start();
echo $_smarty_tpl->tpl_vars['path']->value;
$_prefixVariable27 = ob_get_clean();
echo $_prefixVariable27;?>
/<?php ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['cla'];
$_prefixVariable28 = ob_get_clean();
echo $_prefixVariable28;?>
.java" />
<?php echo csrf_field();?>

</form>
<p><a onclick="submit()" href="javascript:void(0)">生成文件</a> <a onclick="submit2()" href="javascript:void(0)">下载文件</a></p>
<?php echo '<script'; ?>
>
    function submit(){
        var data = $('#myform').serializeArray();
        $.post("/tools/createDTO",data,function (msg) {
                alert("成功");
        });
    }
    function submit2() {
        $('#myform').submit();
    }
<?php echo '</script'; ?>
>
</body>
</html>

<?php }
}
