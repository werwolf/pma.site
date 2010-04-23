<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Admin Panel</title>    
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="title" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/css/admin.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/css/pages_tree.css" type="text/css" media="screen" />
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/js/jquery.js"></script>
    <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/admin/static/js/setHeight2.js"></script>

    <!--[if IE 7]>
    <style type="text/css">
            #left_main_menu ul li { float: left; }
            #left_main_menu ul li a { height: 1%; }
    </style>
    <![endif]-->

</head>

<body onload="setHeight2();">

    <div id="wrapper">

        <div id="header">            
            <span>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>" style="font-size:12px">На сайт. Головна сторінка</a>
                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/logout" style="font-size:12px">Вихід</a>
            </span>
            <h1 style="position:relative;z-index:2;top:-25px">Admin Panel (PMA)</h1>
        </div><!-- #header-->

        <div id="middle">

            <div id="container">
                <div id="content">
                    <? if($View->keyExists("module")):?>
                        <? require_once("admin/view/".$View->module."/view_".$View->sub_module.".php");?>
                    <? endif;?>
                </div><!-- #content-->
            </div><!-- #container-->

            <div id="left_main_menu" class="sidebar sl"></div><!-- .sidebar.sl -->           
            <script type="text/javascript">$(".sidebar").load('http://<?=$_SERVER['HTTP_HOST'];?>/admin/view/menu/menu.html');</script>

        </div><!-- #middle-->

        <div id="footer">Cpyright PMA &copy; 2010</div><!-- #footer -->

    </div><!-- #wrapper -->

</body>
</html>