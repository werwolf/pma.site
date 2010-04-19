<? if($View->view_type == 1): ?>
<div  id="news_news">
    <? foreach($View->news_page as $new): ?>
    <div class="links"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/news/<?=$new['id'];?>/<?=urlencode($new['title']);?>.html"><?=$new['title'];?></a></div>
    <div class="message"><?=$new['text'];?></div>
    <div class="date_comment"><?=news::getDate($new['date']);?>&nbsp;<? if($new['comments'] == 'y'): ?>,&nbsp;<?=$labels['news']['comments'];?>:&nbsp;<?=$new['comments_count'];?><?endif;?></div>
    <? endforeach; ?>
    <? if(news::getPagesCount() > 1): ?><div class="news_foot"><?=$labels['news']['page'];?>&nbsp;<?=$View->paging;?></div><?endif;?>
</div>
<?endif;?>

<? if($View->view_type == 2): ?>
<div id="newscontent">
    <b><?=$View->new['title'];?></b><br/><br/>
    <div class="message"><?=$View->new['text'];?></div><br/><br/>
    <? if(news::isComment()): ?>
    <?=$labels['news']['comment'];?><hr style="margin-top:10px;width: 640px;"/>
        <? foreach($View->comments as $comment): ?>
            <table style="margin-top:10px">
                <tr>
                    <td valign="top"><img alt="pic" src="<? if ($comment['Photo']!=''): ?>http://<?=$_SERVER['HTTP_HOST'];?>/static/uploaded/user_photo/<?=$comment['Photo'];?><? else: ?>http://<?=$_SERVER['HTTP_HOST'];?>/static/img/noavatar.png<?endif;?>" style="width:80px;height:80px"/>
                    </td>
                    <td valign="top" style="padding:5px;width:100%">
                        <div style="text-align:right;width:100%"><a href='#' class="comment_link"><?=$comment['Surname']." ".$comment['Name']." ".$comment['Patronymic'];?></a></div>
                        <?=$comment['text'];?>
                    </td>
                </tr>
                <tr><td colspan="2" align="left"><b style="font-size:10px;"><?=news::getDate($comment['date']);?></b></td></tr>
            </table>
        <? endforeach; ?>

        <? if(news::getPagesCount() > 1): ?><br/>
                <div style="width:100%;text-align:right;"><?=$labels['news']['page'];?>:&nbsp;<?=$View->paging;?></div>
        <?endif;?>
        <? if(user::isLoged()): ?>
               <br/><br/>
                <?=$labels['news']['add_comment'];?><br/><br/>
                <form action="" method="post">
                        <textarea style="width:640px;height:100px;overflow: auto;" name="comment"></textarea><br/>
                        <input type="submit" value="<?=$labels['news']['add_comment'];?>" style="background:#EEE;padding:2px"/>
                        <input type="hidden" name="user_id" value="<?=$user->getUserId();?>" />
                        <input type="hidden" name="new_id" value="<?=$View->new['id'];?>"/>
                        <input type="hidden" name="user_secret" value="<?=$user->getUserSecret();?>"/>
                        <input type="hidden" name="action" value="add_comment"/>
                </form>
        <? endif;?>
    <? endif; ?>
</div>
<?endif;?>