<?php
/**
 * Created by PhpStorm.
 * User: Jun
 * Date: 2015/1/2
 * Time: 11:44
 */

include('./MinPHP/run/init.php');
include('./MinPHP/core/Snoopy.class.php');

$snoopy = new Snoopy;


$form = $_REQUEST;
//unset($form["app"]);
//$mod = $form["mod"];
//unset($form["mod"]);
//$act = $form["act"];
//unset($form["act"]);

$apiId = $form['api_id'];
unset($form['api_id']);

$sql = "SELECT * FROM api WHERE id={$apiId}";
$apiInfo = find($sql);
$mod = '';
$act = '';
$paramsUrl = explode("&", $apiInfo['url']);
$params = unserialize($apiInfo['parameter']);


foreach ($paramsUrl as $param) {
    $paramDetails = explode("=", $param);
    if ($paramDetails[0] == 'mod') {
        $mod = $paramDetails[1];
    } else if ($paramDetails[0] == 'act') {
        $act = $paramDetails[1];
    }
}
if ($act == '') {
    $paramsUrl = explode("/", $apiInfo['url']);
    $mod = $paramsUrl[count($paramsUrl) - 2];
    $act = $paramsUrl[count($paramsUrl) - 1];
}

if(!$act) $act="token";

$api_name="/api_v3/".$mod.'/'.$act;//"index.php?app=api_v2&mod=" . $mod . "&act=" . $act;//接口
$action = "http://www.jqsnsv1.com/api_v3/".$mod.'/'.$act;//."/index.php?app=api_v2&mod=" . $mod . "&act=" . $act;//接口v2test.jingqubao.com

//获取提交的参数
$submit=array();
$get='';
if($apiInfo['type']=='GET'){
    foreach($params['name'] as $val){
        $get.='&'.$val.'='.$form[$val];
    }
    $get=ltrim($get,'&');
    $get='?'.$get;
    $action.=$get;
}else{
    foreach($params['name'] as $val){
        $submit[$val]=$form[$val];
    }
}

$snoopy->submit($action, $submit);//$formvars为提交的数组
$result = $snoopy->results;
?>
<!DOCTYPE html>
<html lang="zh_CN" style="overflow-x: hidden; ">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <script src="MinPHP/res/jquery.min.js"></script>
    <script src="MinPHP/testapi/js.js"></script>
    <link rel="stylesheet" href="MinPHP/testapi/css.css">

</head>
<body>

<form method="post" action="">

    <div class="main">

        <div class="title"><?= $title ?></div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="td1">当前接口：</td>
                <td><?=$api_name?></td>
            </tr>
            
            <?php for ($i=0;$i<count($params['name']);$i++) { ?>
                <tr>
                    <td class="td1"><?= $params['name'][$i] ?>:</td>
                    <td><input type="text" name="<?= $params['name'][$i] ?>" value="<?= $params['default'][$i] ?>"> 字段名称：<?= $params['desc'][$i] ?> 　<?= $params['type'][$i]=="Y"?"<b style='color:red;'>必填</b>":"<b style='color:gray;'>选填</b>" ?>　　<?= $params['default'][$i] ?></td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" value="提交">


        <div class="HeadersRow">
            <!-- <h3 id="HeaderSubTitle">JSON Formatter</h3>
            <div>Enter your JSON here</div> -->

            <textarea id="RawJson"> <?=$result?> </textarea>
        </div>
        <div id="ControlsRow">
            <input type="Button" value="Format" onclick="Process()">
  <span id="TabSizeHolder">
    tab size:
    <select id="TabSize" onchange="TabSizeChanged()">
        <option value="1">1</option>
        <option value="2" selected="true">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
  </span>
            <label for="QuoteKeys">
                <input type="checkbox" id="QuoteKeys" onclick="QuoteKeysClicked()" checked="true">
                Keys in Quotes
            </label>&nbsp;
            <a href="javascript:void(0);" onclick="SelectAllClicked()">select all</a>
            &nbsp;
  <span id="CollapsibleViewHolder">
      <label for="CollapsibleView">
          <input type="checkbox" id="CollapsibleView" onclick="CollapsibleViewClicked()" checked="true">
          Collapsible View
      </label>
  </span>
  <span id="CollapsibleViewDetail">
    <a href="javascript:void(0);" onclick="ExpandAllClicked()">expand all</a>
    <a href="javascript:void(0);" onclick="CollapseAllClicked()">collapse all</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(3)">level 2+</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(4)">level 3+</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(5)">level 4+</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(6)">level 5+</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(7)">level 6+</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(8)">level 7+</a>
    <a href="javascript:void(0);" onclick="CollapseLevel(9)">level 8+</a>
  </span>
        </div>
        <div id="Canvas" class="Canvas"><pre class="CodeContainer"></pre></div>


<!--        <div>
            <h3>备注接口</h3>
            <div class="update_log">
                2015-02-06更新：
                <br><a href="http://www.umeng.com/component_update" target="_blank">版本检测接口---用友盟的API</a>
                <br>
                2015-02-02更新：
                <br><a href="/public/token.php" target="_blank">七牛上传授权获取接口</a>
                <br>

            </div>
        </div>-->


        <script src="MinPHP/testapi/urchin.js" type="text/javascript">
        </script>
        <script type="text/javascript">
            _uacct = "UA-2223138-1";
            urchinTracker();

            function onLoad() {
                var version = getSilverlightVersion();
                if (version) { __utmSetVar(version); }
            }

            function getSilverlightVersion() {
                var version = 'No Silverlight';
                var container = null;
                try {
                    var control = null;
                    if (window.ActiveXObject) {
                        control = new ActiveXObject('AgControl.AgControl');
                    }
                    else {
                        if (navigator.plugins['Silverlight Plug-In']) {
                            container = document.createElement('div');
                            document.body.appendChild(container);
                            container.innerHTML= '<embed type="application/x-silverlight" src="data:," />';
                            control = container.childNodes[0];
                        }
                    }
                    if (control) {
                        if (control.isVersionSupported('5.0')) { version = 'Silverlight/5.0'; }
                        else if (control.isVersionSupported('4.0')) { version = 'Silverlight/4.0'; }
                        else if (control.isVersionSupported('3.0')) { version = 'Silverlight/3.0'; }
                        else if (control.isVersionSupported('2.0')) { version = 'Silverlight/2.0'; }
                        else if (control.isVersionSupported('1.0')) { version = 'Silverlight/1.0'; }
                    }
                }
                catch (e) { }
                if (container) {
                    document.body.removeChild(container);
                }
                return version;
            }
            onLoad();
        </script>

    </div>
</form>
<script type="text/javascript">
    $(function () {
        <?php foreach((array)$form as $key=>$val){?>
        $("input[name='<?=$key?>']").val("<?=$val?>");
        <?php }?>
        $(".select").change(function(){
           window.location= "?act="+$(this).val();
        })
    })
    Process();
</script>
</body>