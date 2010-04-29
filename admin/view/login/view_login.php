<? if(!defined("entrypoint"))die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Админ панель</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.js"></script>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/showLogin.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/login.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/css/login.css" />
</head>
    <body>
        <div id="login_label"><a id="login_a" class="login">Вход</a></div>
        <div id="modal_dialog" style="display:none; cursor: default" class="dialog">
            <div class="dialog_title_bar">
                <div class="dialog_caption">Вход в админ панель</div>
                <div class="rotes_kreuz"></div>
            </div>

            <div class="dialog_pane">
                <div style="margin-top: 10px;">
                    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/login" method="post">
                        <div class="text_lable">
                            <div class="dialog_login_lable">Логин</div>
                            <input type="text" name="login" size="20" maxlength="200" value="" id="login"/>
                            <input type="hidden" name="admin" value="admin"/>
                        </div>

                        <div class="text_lable">
                            <div class="dialog_login_lable">Пароль</div>
                            <input type="password" name="password" size="20" maxlength="200" value="" id="password"/>
                        </div>

                        <div class="text_lable">
                            <input type="submit" id="yes" value="Вход" class="dialog_button"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
