<div id="last_news_header"><?=$labels['news']['last_news'];?></div>
<div id="last_news_block">
    <? foreach($View->last_news as $news): ?>
        <div class="news">
            <div class="date"><?=substr(news::getDate($news['date']),0,10);?></div><br/>
            <div class="message"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/news/<?=$news['id'];?>/<?=urlencode($news['title']);?>.html">
            <?=$news['title'];?></a>
            </div>
        </div>
    <? endforeach;?>
</div>
