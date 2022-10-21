<?php if (!defined('SYSTEM_ROOT')) {
    die('Insufficient Permissions');
}
function callback_init()
{
    global $m;
    //admin setting
    option::add('weltolk_sign_qq_default_open', 1);
    option::add('weltolk_sign_qq_zone', '+0800');
    option::add('weltolk_sign_qq_title', '【[date]】[name] 的签到报告');
    option::add('weltolk_sign_qq_content', '<html><head><title>贴吧云签到报告</title><style type="text/css">div.wrapper * { font: 12px "Microsoft YaHei", arial, helvetica, sans-serif; word-break: break-all; }div.wrapper a { color: #15c; text-decoration: none; }div.wrapper a:active { color: #d14836; }div.wrapper a:hover { text-decoration: underline; }div.wrapper p { line-height: 20px; margin: 0 0 .5em; text-align: center; }div.wrapper .sign_title { font-size: 20px; line-height: 24px; }div.wrapper .result_table { width: 85%; margin: 0 auto; border-spacing: 0; border-collapse: collapse; }div.wrapper .result_table td { padding: 10px 5px; text-align: center; border: 1px solid #dedede; }div.wrapper .result_table tr { background: #d5d5d5; }div.wrapper .result_table tbody tr { background: #efefef; }div.wrapper .result_table tbody tr:nth-child(odd) { background: #fafafa; }</style></head><body><h4 style="text-align:center;">贴吧云签到报告</h4><div class="wrapper"><table class="result_table"><thead><tr><td style="width: 60px">项目</td><td style="width: 150px">内容</td><td style="width: 75px">备注</td></tr></thead><tbody><tr><td>签到日期</td><td>[date]</td><td>当日报告已生成</td></tr><tr><td>用户名称</td><td><a href="http://tieba.baidu.com" target="_blank">[name]</a></td><td>您是该站云签用户</td></tr><tr><td>报告地址</td><td><a href="[link]" target="_blank">[link]</a></td><td>点击链接直达,次日失效</td></tr><tr><td>云签站点</td><td><a href="[SYSTEM_URL]" target="_blank">[SYSTEM_NAME]</a></td><td>如有疑问,进站反馈</td></tr></tbody></table><br><p style="font-size: 12px; color: #9f9f9f; text-align: right; border-top: 1px solid #dedede; padding: 20px 10px 0; margin-top: 25px;">发自[SYSTEM_NAME]<br>百度贴吧云签到作者:<a href="http://kenvix.com/"> Kenvix</a>&<a href="http://www.longtings.com/">mokeyjay</a>&<a href="http://fyy.l19l.com/">FYY</a><br>邮件扩展作者:<a href="https://github.com/Weltolk">Weltolk</a></p>
</div></body></html>');
    //create connect tab
    $m->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "weltolk_sign_qq_connect` (
        `id`  int(255) NOT NULL AUTO_INCREMENT ,
        `uid`  int(255) NOT NULL ,
        `client`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        `connect_type`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        `address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        `access_token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        PRIMARY KEY (`id`)
        )
        ENGINE=MyISAM
        DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
        AUTO_INCREMENT=12
        CHECKSUM=0
        ROW_FORMAT=DYNAMIC
        DELAY_KEY_WRITE=0;");
    //create target tab
    $m->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "weltolk_sign_qq_target` (
        `id`  int(255) NOT NULL AUTO_INCREMENT ,
        `uid`  int(255) NOT NULL ,
        `connect_id`  int(255) NOT NULL ,
        `hour`  int(255) NOT NULL ,
        `type`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        `type_id`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        `nextdo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        PRIMARY KEY (`id`)
        )
        ENGINE=MyISAM
        DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
        AUTO_INCREMENT=12
        CHECKSUM=0
        ROW_FORMAT=DYNAMIC
        DELAY_KEY_WRITE=0;");
    // plugin_option
    $set_arr = array(
        'limit' => "10",
    );
    $set_str = serialize($set_arr);
    option::set('plugin_weltolk_sign_qq', $set_str);
    //cron_tab setting
    cron::set('weltolk_sign_qq', 'plugins/weltolk_sign_qq/cron_weltolk_sign_qq.php', 0, '每日签到qq推送定时任务', 0);
}

function callback_inactive()
{
    //cron_tab setting
    cron::del('weltolk_sign_qq');

}

function callback_remove()
{
    //admin setting
    option::del('weltolk_sign_qq_default_open');
    option::del('weltolk_sign_qq_zone');
    option::del('weltolk_sign_qq_title');
    option::del('weltolk_sign_qq_content');
    // plugin_option
    option::del('plugin_weltolk_sign_qq');
    //user setting
    global $m;
    $m->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "weltolk_sign_qq_connect`");
    $m->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "weltolk_sign_qq_target`");
}

?>