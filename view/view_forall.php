<? if(!defined("entrypoint"))die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?=$View->title;?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="НТУУ-КП  И, КПИ, Кафедра прикладной математики" />
    <meta name="description" content="Сайт кафедры прикладной математики ФПМ НТУУ-КПИ" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/datepicker.css" />
<!-- -->
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/rating.css" />

    <? if($module[3]=='download'): ?>
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/fileview.css" />
    <? endif;?>
    <? if($module[3]=='upload' || $module[3] == "edit"):?><base href="http://<?=$_SERVER['HTTP_HOST'];?>/"></base><?endif;?>
    <? if($module[3]=='edit'): ?>
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/jqgrid/css/flick/jquery-ui-1.8.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/jqgrid/css/ui.jqgrid.css" />
    <? endif;?>
<!-- -->
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.js"></script>

    <? if($module[2] == "profile"):?>
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/profile_anketa.css" />
    <?endif;?>
    <? if($module[3]=='edit'): ?>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/jqgrid/js/i18n/grid.locale-ru.js"></script>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/jqgrid/js/my.jquery.jqGrid.min.js"></script>
    <? endif;?>
    <? if($module[2]=="site_map"):?>
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/sitemap.css" />
    <?endif;?>
    <? if(!user::isLoged()): ?>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/showLogin.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://<?=$_SERVER['HTTP_HOST'];?>/static/css/login.css" />
    <? endif;?>
    
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/setHeight.js"></script>    
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/check_file.js"></script>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/datepicker.js"></script>

</head>

<body>
<!--[if IE 7]>
<style type="text/css">
    #left_main_menu ul li { float: left; }
    #left_main_menu ul li a { height: 1%; }
</style>
<![endif]-->
<div id="wrapper">
    <div id="header">
        <div id="header_top">
            <div id="logo">
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/header/tower.png" alt="Сайт кафедры прикладной математики НТУУ-КПИ" /></a>
            </div> <!-- #logo -->
            <? if(!$View->show_quote): ?>
                <div id="title">
                        <h1><?=$labels['common']['header_ntuu'];?><br /></h1>
                        <h2><?=$labels['common']['header_fpm'];?><br /></h2>
                        <h2><?=$labels['common']['header_pma'];?><br /></h2>
                </div>
            <? else: ?>
                <div id="left_title">
                    <h2><?=$labels['common']['label_pma'];?></h2>
                </div>
                <div id="right_title">
                    <div class="quote"><?=$View->quote['quote_'.config::getDefaultLanguage()];?></div>
                    <div class="auther"><?=$View->quote["auther_".config::getDefaultLanguage()];?></div>
                </div>
            <?endif;?>
            <!-- #title -->

            <div id="flags">
                <? foreach ($View->languages as $key=>$langs): ?>
                <a href="<?=$langs['url'];?>"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/lang/<?=$langs['lang'];?>.png" alt="<?=strtoupper($langs);?>" id="flag_<?=($key+1);?>" /></a>
                <? endforeach; ?>
            </div>	<!-- #flags -->

        </div> <!-- #header_top -->

        <div id="background_right_top"></div>

        <div id="header_middle">
            <div id="left_menu">
                <!--<ul><? print $View->top_menu['left'];?></ul>-->
                <ul><? require_once("static/templates/top_menu/".$View->top_left_menu."/left_".config::getDefaultLanguage()."_".$View->top_left_menu.".php");?></ul>
            </div> <!-- #left_menu -->

            <div id="header_img_1"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/header/image1.png" alt="НТУУ-КПИ" /> </div> <!-- #header_img_1 -->
            <div id="header_img_2"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/hats/<?=$View->hat;?>.png" alt="НТУУ-КПИ" /></div> <!-- #header_img_2 -->
        </div> <!-- #header_middle -->

        <div id="header_img_3"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/header/kod.png" alt="НТУУ-КПИ" /></div> <!-- #header_img_3 -->

        <div id="right_menu">
           <ul><? require_once("static/templates/top_menu/".$View->top_right_menu."/right_".config::getDefaultLanguage()."_".$View->top_right_menu.".php");?></ul>
        </div>	<!-- #right_menu -->

        <div id="pic_1"></div>
        <? if(!user::isLoged()):?>
            <div id="login_label"><a id="login_a"><?=$labels['login']['enter_site'];?></a></div>
        <? else:?>
            <div id="login_label"><a id="login_a" href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/logout/"><?=$labels['login']['logout_wrd'];?></a></div>
        <?endif;?>
<!-- ************************************************************************************************************************************** -->
        <? if(!user::isLoged()):?>
        <div id="modal_dialog" style="display:none; cursor: default" class="dialog">
            <div class="dialog_title_bar">
                <div class="dialog_caption"><?=$labels['login']['enter_site'];?></div>
                <div class="rotes_kreuz"></div>
            </div>

            <div class="dialog_pane">
                <div style="margin-top: 10px;">
                    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/login" method="post">
                        <div class="text_lable">
                            <div class="dialog_login_lable"><?=$labels['login']['login_wrd'];?></div>
                            <input type="text" name="login" size="20" maxlength="200" value="" id="login"/>
                        </div>

                        <div class="text_lable">
                            <div class="dialog_login_lable"><?=$labels['login']['password_wrd'];?></div>
                            <input type="password" name="password" size="20" maxlength="200" value="" id="password"/>
                        </div>

                        <div class="text_lable">
                            <input type="submit" id="yes" value="<?=$labels['login']['login_in'];?>" class="dialog_button"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?endif;?>
<!-- ************************************************************************************************************************************** -->
            <form method="post" action="#" id="search_form">
                <div>
                    <input type="text" name="q" size="30" maxlength="200" value="" id="sbi" />                    
                    <input class="button_download" style="width:80px;height:18px;float:left" type="submit" name="sa" value="<?=$labels['common']['search'];?>" />
                </div>
            </form>

        <div id="img_PC"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/header/comp.png" alt="PMA" /></div>

    </div><!-- #header-->

    <div id="middle">

        <div id="container">
                <div id="content">
                    <?
                    require_once("view/".$View->module."/view_".$View->module.".php");

                    if($module[2]=='profile' && $module[3]=='rating') echo("PROFILE &amp;&amp; RATING");
                    ?>
                </div><!-- #content-->
        </div>

        <div id="sidebar">
            <?if($module[2]!='page' || ($module[3]!='60' && $module[3]!='4')):?>
                <div id="left_main_menu" class="left_content_menu"><? require_once("view/".$View->left_menu."/view_".$View->left_menu."_template.php"); ?></div>
            <?else:?>
                <div id="ubuntu_10.4" class="left_content_menu">
                    <div style="padding-left: 25px;"><script type="text/javascript" src="http://www.ubuntu.com/files/countdown/display2.js"></script></div>
                </div>
            <?endif;?>
            
            <!--<div id="left_main_menu_bakground"></div>-->
        </div><!-- #sidebar -->

    </div><!-- #middle -->

    <div id="footer">
        Copyrights (C) PMA - NTUU - KPI&nbsp;&nbsp;&nbsp;
        
   </div><!-- #footer -->

</div><!-- #wrapper -->

</body>
</html>