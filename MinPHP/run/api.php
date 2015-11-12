<?php
include('init.php');
include "../core/Snoopy.class.php";
$snoopy = new Snoopy;
$form = $_REQUEST;
unset($form["app"]);
unset($form["mod"]);
$act = $form["act"];
unset($form["act"]);

if(!$act) $act="token";

//include_once("api.php");
//include_once("squary.php");
//include_once("user.php");
//include_once("msg.php");
//include_once("bonus.php");
//include_once("act.php");

$app = $_REQUEST['app'];
$mod = $_REQUEST['mod'];
$fun = $_REQUEST['act'];
$url = "http://v2.jingqubao.com/index.php?app={$app}&mod={$mod}&act={$fun}";
$list = select("select * from api where isdel=0 and url='http://v2.jingqubao.com/index.php?app=".$app."&mod=".$mod."&act=".$fun."'");
$list = unserialize($list[0]['parameter']);
for($i=0;$i<count($list['name']);$i++) {
    $input[] = array(
        'name'=>$list['name'][$i],
        'default'=>$list['default'][$i],
        'title'=>$list['des'][$i],
        'must'=>$list['type'][$i]
    );
}
$api_name="/api_v2/".$mod.'/'.$fun;
$action = "http://".$_SERVER['HTTP_HOST'].'/api_v2/'.$mod.'/'.$fun;
$snoopy->submit($action, $form);//$formvars为提交的数组
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
    <script src="./MinPHP/res/jquery.min.js"></script>
    <script src="./MinPHP/res/js.js"></script>
    <link rel="stylesheet" href="./MinPHP/res/css.css">

</head>
<body>

<form method="post" action="<?php echo $url; ?>">

    <div class="main">

        <div class="title"><?= $title ?></div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="td1">当前接口：</td>
                <td><?=$api_name?></td>
            </tr>
            <tr>
                <td class="td1">选择接口:</td>
                <td>
                    <select class="select" name="act">
                        <option value="token" <?=$act=="token"?"selected":""?>>获取token</option>

                        <option value="api_get_sms" <?=$act=="api_get_sms"?"selected":""?>>用户注册-获取短信验证码--6/1更新</option>
                        <option value="api_do_reg" <?=$act=="api_do_reg"?"selected":""?>>-----注册用户-执行注册--6/1更新</option>
                        <option value="api_get_code" <?=$act=="api_get_code"?"selected":""?>>-----找回密码-获取验证码--6/1更新</option>
                        <option value="api_check_code" <?=$act=="api_check_code"?"selected":""?>>-----找回密码-校验验证码--6/1更新</option>
                        <option value="api_reset_pwd" <?=$act=="api_reset_pwd"?"selected":""?>>-----找回密码-重设密码--6/1更新</option>
                        <option value="register_notification" <?=$act=="register_notification"?"selected":""?>>-----注册极光推送--8/31更新</option>
                        <option value="get_jpush_alias" <?=$act=="get_jpush_alias"?"selected":""?>>-----获取极光别名--8/31更新</option>
                        <option value="get_user_account" <?=$act=="get_user_account"?"selected":""?>>-----获取自己的账户信息--8/31更新</option>
                        <option value="add_user_account_info" <?=$act=="add_user_account_info"?"selected":""?>>-----绑定用户支付账户信息--8/31更新</option>
                        <option value="withdraw_deposit" <?=$act=="withdraw_deposit"?"selected":""?>>-----提现--8/31更新</option>
                        <option value="get_account_logs" <?=$act=="get_account_logs"?"selected":""?>>-----获取全部提现历史--8/31更新</option>
                        <option value="get_account_log" <?=$act=="get_account_log"?"selected":""?>>-----获取某个提现历史--8/31更新</option>
                        <option value="get_ticket_bonus" <?=$act=="get_ticket_bonus"?"selected":""?>>获取景区门票红包--8/31更新</option>
                        <option value="pick_ticket_bonus" <?=$act=="pick_ticket_bonus"?"selected":""?>>领取景区门票红包--8/31更新</option>
                        <option value="pick_hour_bonus" <?=$act=="pick_hour_bonus"?"selected":""?>>领取整点红包--8/31更新</option>
                        <option value="create_group" <?=$act=="create_group"?"selected":""?>>创建位置共享分组--8/31更新</option>
                        <option value="join_group" <?=$act=="join_group"?"selected":""?>>加入位置共享分组--8/31更新</option>
                        <option value="get_user_groups" <?=$act=="get_user_groups"?"selected":""?>>获取用户所在群组--8/31更新</option>
                        <option value="exit_group" <?=$act=="exit_group"?"selected":""?>>退出位置共享分组--8/31更新</option>
                        <option value="get_rong_secret" <?=$act=="get_rong_secret"?"selected":""?>>获取融云Key_Secret--8/31更新</option>
                        <option value="get_group_user" <?=$act=="get_group_user"?"selected":""?>>获取分组用户--8/31更新</option>
                        <option value="share_user_geo" <?=$act=="share_user_geo"?"selected":""?>>分享地址位置给分组用户--8/31更新</option>
                        <option value="get_spot_info_by_ibeaconid" <?=$act=="get_spot_info_by_ibeaconid"?"selected":""?>>通过Ibeacon编号获取景点信息--8/31更新</option>
                        <option value="get_share_info" <?=$act=="get_share_info"?"selected":""?>>获取活动分享信息--8/31更新</option>
                        <option value="get_rongcloud_token" <?=$act=="get_rongcloud_token"?"selected":""?>>获取融云Token--8/31更新</option>
                        <option value="publis_message" <?=$act=="publis_message"?"selected":""?>>群组用户发送消息--8/31更新</option>
                        <option value="record_share_result" <?=$act=="record_share_result"?"selected":""?>>记录活动分享结果--8/31更新</option>
                        <option value="get_active_activites" <?=$act=="get_active_activites"?"selected":""?>>获取激活状态的活动--8/31更新</option>
                        <option value="get_audio_by_ibeaconid" <?=$act=="get_audio_by_ibeaconid"?"selected":""?>>通过ibeacon编号获取音频信息--8/31更新</option>
                        <option value="getMarkerNameForPacketByRid" <?=$act=="getMarkerNameForPacketByRid"?"selected":""?>>地图－－获取地图数据包对应的标记点名称（根据景区ID）</option>
                        <option value="getMarkerTypeIcon" <?=$act=="getMarkerTypeIcon"?"selected":""?>>地图－－获取地图icon模型离线包（根据主题ID）</option>

                        
                        <option value="squary_index" <?=$act=="squary_index"?"selected":""?>>旅图获取微博内容--9/10</option>
                        <option value="show" <?=$act=="show"?"selected":""?>>-----微博详情--9/10</option>
                        <option value="update" <?=$act=="update"?"selected":""?>>-----发布一条微博--9/10</option>
                        <option value="destroy" <?=$act=="destroy"?"selected":""?>>-----删除一条微博--9/10</option>
                        <option value="comment" <?=$act=="comment"?"selected":""?>>-----评论微博--9/10</option>
                        <option value="add_digg" <?=$act=="add_digg"?"selected":""?>>微博点赞--9/10</option>
                        <option value="digg_destroy" <?=$act=="digg_destroy"?"selected":""?>>-----微博点赞--取消--9/10</option>
                        <option value="digg_list" <?=$act=="digg_list"?"selected":""?>>-----赞的列表--9/10</option>
                        <option value="favorite_feed" <?=$act=="favorite_feed"?"selected":""?>>收藏列表--9/10</option>
                        <option value="favorite_create" <?=$act=="favorite_create"?"selected":""?>>-----微博收藏--9/10</option>
                        <option value="favorite_destroy" <?=$act=="favorite_destroy"?"selected":""?>>-----微博收藏--取消--9/10</option>
                        <option value="getSmile" <?=$act=="getSmile"?"selected":""?>>获取表情--9/10</option>
                        <option value="comments" <?=$act=="comments"?"selected":""?>>-----评论列表--9/10</option>
                        <option value="comment_destroy" <?=$act=="comment_destroy"?"selected":""?>>-----删除评论--9/10</option>
                        <option value="comments_by_me" <?=$act=="comments_by_me"?"selected":""?>>-----获取当前用户发出的评论--9/10</option>
                        <option value="comments_to_me_true" <?=$act=="comments_to_me_true"?"selected":""?>>-----获取当前用户收到的评论，不含自己的--9/10</option>
                        <option value="comments_to_me" <?=$act=="comments_to_me"?"selected":""?>>-----获取当前用户收到的评论，含自己的--9/10</option>

                        <option value="get_spots_by_region" <?=$act=="get_spots_by_region"?"selected":""?>>景点列表--6/5更新</option>
                        <option value="get_city_list" <?=$act=="get_city_list"?"selected":""?>>获取城市的列表（存在景区）--6/11更新</option>
                        <option value="save_feedback" <?=$act=="save_feedback"?"selected":""?>>意见反馈----6/11修正</option>
                        <option value="notify_sys" <?=$act=="notify_sys"?"selected":""?>>获取系统消息列表----6/12修正</option>
                        <option value="notify_sys_new" <?=$act=="notify_sys_new"?"selected":""?>>-----轮询请求查询是否有新通知----6/15修正</option>
                        <option value="one_foot_print" <?=$act=="one_foot_print"?"selected":""?>>用户足迹----6/15修正</option>
                        <option value="user_show" <?=$act=="user_show"?"selected":""?>>用户信息接口----6/15修正</option>
                        <option value="edit_user_info" <?=$act=="edit_user_info"?"selected":""?>>修改个人性别、昵称、简介、头像、密码、地址----6/15修正</option>

                        <option value="is_in_scenic" <?=$act=="is_in_scenic"?"selected":""?>>初始化请求（是否在景区）----6/29修正</option>
                        <option value="get_scenic_info" <?=$act=="get_scenic_info"?"selected":""?>>显示景区详情----6/23修正</option>
                        <option value="get_spot_list" <?=$act=="get_spot_list"?"selected":""?>>显示所有景点----6/23修正</option>
                        <option value="get_spot_info" <?=$act=="get_spot_info"?"selected":""?>>显示景点详情----6/23修正</option>
                        <option value="click_digg" <?=$act=="click_digg"?"selected":""?>>点赞----6/23修正</option>
                        <option value="delete_digg" <?=$act=="delete_digg"?"selected":""?>>点赞（取消）----6/23修正</option>
                        <option value="get_scenic_audios" <?=$act=="get_scenic_audios"?"selected":""?>>获取景区音频----6/23修正</option>
                        <option value="get_scenic_category_audios" <?=$act=="get_scenic_category_audios"?"selected":""?>>获取景区某分类下的音频列表----6/23修正</option>
                        <option value="get_scenic_audiocategories" <?=$act=="get_scenic_audiocategories"?"selected":""?>>获取景区音频分类----6/23修正</option>
                        <option value="set_audio_status" <?=$act=="set_audio_status"?"selected":""?>>统计音频</option>

                        <option value="search_scenic" <?=$act=="search_scenic"?"selected":""?>>搜索景区----7/7修正</option>
                        <option value="get_recommend_line" <?=$act=="get_recommend_line"?"selected":""?>>获取推荐线路</option>
                        <option value="qrcode" <?=$act=="qrcode"?"selected":""?>>扫码</option>
                        <option value="in_scenic" <?=$act=="in_scenic"?"selected":""?>>是否在景区---独立判断是否在景区内</option>
                        <option value="get_scenic_list" <?=$act=="get_scenic_list"?"selected":""?>>景区列表---独立获取</option>
                        <option value="destination_list" <?=$act=="destination_list"?"selected":""?>>目的地---独立获取</option>
                        <option value="qiniu_up_token" <?=$act=="qiniu_up_token"?"selected":""?>>七牛云存储---获取上传token</option>
                        <option value="set_jpush_info" <?=$act=="set_jpush_info"?"selected":""?>>设置第三方平台标识</option>
                        <option value="add_scenic" <?=$act=="add_scenic"?"selected":""?>>添加景区</option>
                        <option value="add_spot" <?=$act=="add_spot"?"selected":""?>>添加景点</option>
                        <option value="authorize_third_party" <?=$act=="authorize_third_party"?"selected":""?>>第三方登录</option>
                    </select>
                </td>
            </tr>
            <?php foreach ($input as $key => $val) { ?>
                <tr>
                    <td class="td1"><?= $val["name"] ?>:</td>
                    <td><input type="text" name="<?= $val["name"] ?>" value="<?= $val["default"] ?>"> 字段名称：<?= $val["title"] ?> 　<?= $val["must"]?"<b style='color:red;'>必填</b>":"<b style='color:gray;'>选填</b>" ?>　　<?= $val["notice"] ?></td>
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


        <div>
            <h3>备注接口</h3>
            <div class="update_log">
                2015-02-06更新：
                <br><a href="http://www.umeng.com/component_update" target="_blank">版本检测接口---用友盟的API</a>
                <br>
                2015-02-02更新：
                <br><a href="/public/token.php" target="_blank">七牛上传授权获取接口</a>
                <br>

            </div>
        </div>


        <script src="urchin.js" type="text/javascript">
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