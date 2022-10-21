<?php if (!defined('SYSTEM_ROOT')) {
    die('Insufficient Permissions');
}
/*
Plugin Name: 每日签到结果qq推送
Version: 1.0
Plugin URL: https://github.com/weltolk/weltolk_sign_qq
Description: 每日用户签到结果qq推送，目前支持go-cqhttp的正向WebSocket和HTTP API，基于D丶L和quericy的版本重写
Author: Weltolk
Author Email: Null
Author URL: https://github.com/weltolk
For: V3.8+
*/
function weltolk_sign_qq_setting()
{
    $is_open = option::uget('weltolk_sign_qq_enable') == 'on';
    global $i;
    $weltolk_sign_qq_report_url = SYSTEM_URL . 'index.php?pub_plugin=weltolk_sign_qq&username=' . $i['user']['name'] . '&token=' . md5(md5($i['user']['name'] . $i['user']['uid'] . date('Y-m-d')) . md5($i['user']['uid']));

    ?>
    <tr>
        <td>每日签到qq推送</td>
        <td>
            <input type="radio" name="weltolk_sign_qq_enable"
                   value="on" <?php echo $is_open ? 'checked' : ''; ?> > 开启每日签到qq推送<br/>
            <input type="radio" name="weltolk_sign_qq_enable"
                   value="off" <?php echo $is_open ? '' : 'checked'; ?> > 关闭每日签到qq推送
        </td>
    </tr>
    <tr>
    <td>每日签到qq报告地址</td>
    <td>
        <a href="<?php echo $weltolk_sign_qq_report_url; ?>" target="_blank">点击查看</a>（有效期至<span
                style="padding: 2px 4px;color: #c7254e;background-color: #f9f2f4;border-radius: 4px;"><?php echo date('Y-m-d 23:59:59'); ?></span>）
    </td>
    <?php
}

function weltolk_sign_qq_set()
{
    global $PostArray;
    if (!empty($PostArray)) {
        $PostArray[] = 'weltolk_sign_qq_enable';
    }
}

function weltolk_sign_qq_set_navi()
{
    ?>
    <li <?php if (isset($_GET['plugin']) && $_GET['plugin'] == 'weltolk_sign_qq') {
        echo 'class="active"';
    } ?>><a href="index.php?plugin=weltolk_sign_qq"><span
                    class="glyphicon glyphicon-circle-arrow-up"></span> 每日签到qq推送</a></li>
    <?php
}

addAction('set_save1', 'weltolk_sign_qq_set');
addAction('navi_7', 'weltolk_sign_qq_set_navi');
addAction('set_2', 'weltolk_sign_qq_setting');
?>