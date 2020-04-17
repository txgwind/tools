<?php
/* Smarty version 3.1.34-dev-7, created on 2020-04-13 09:48:48
  from '/Volumes/datas/www/mytools/tools/resources/views/tools/test.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e9435802bdf90_72068580',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cdd9905755faf48b4522e2d4249a1d9561f2bbb8' => 
    array (
      0 => '/Volumes/datas/www/mytools/tools/resources/views/tools/test.tpl',
      1 => 1586771301,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9435802bdf90_72068580 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['word']->value;?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['test']->value, 'list');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
?>
    <?php echo $_smarty_tpl->tpl_vars['list']->value;?>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</body>
</html>
<?php }
}
