<? if(!defined("entrypoint"))die;?>

<div id="profile">      
    <table id="user_data_anketa">
        <tr>
            <td valign="top">
                <? if(file_exists("static/uploaded/user_photo/".$user->getUserPhoto()) && strlen($user->getUserPhoto()) > 0):?><img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/uploaded/user_photo/<?=$user->getUserPhoto();?>" class="user_photo"/><?endif;?><br/>
                <label class="labels">
                    <? if(get_class($user) == "Student"): ?><?=$labels['profile']['student'];?><? else:?><?=$labels['profile']['teacher'];?><?endif;?>:
                </label><br/>
                <label class="name">
                    <?=$user->getUserSurname();?>
                </label><br/>
                <label class="name">
                    <?=$user->getUserName();?>&nbsp;<?=$user->getUserPatronymic();?>
                </label><br/><br/>
                <label class="labels">
                    <?=$labels['profile']['email'];?>:
                </label><br/>
                <label class="name">
                    <?=$user->getUserEmail();?>
                </label>
            </td>
            <td valign="top" style="padding-top:20px" align="left">
                <? if(get_class($user) == "Student"): ?>
                    <label class="labels_right">
                        <?=$labels['profile']['group'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserGroupName();?>
                    </label><br/><br/>
                    <label class="labels_right">
                        <?=$labels['profile']['student_state'];?>:
                    </label><br/>
                    <label class="other_info">
                        <? if($user->getUserRank() == "trade-union"): ?>
                            <?=$labels['profile']['trade-union'];?>
                        <? elseif($user->getUserRank() == 'praepostor'):?>
                            <?=$labels['profile']['praepostor'];?>
                        <? else: ?>
                            <?=$labels['profile']['student'];?>
                        <?endif;?>
                    </label><br/><br/>
                    <label class="labels_right">
                        <?=$labels['profile']['phone'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserPhone();?>
                    </label><br/><br/>
                <? endif;?>
                <? if(get_class($user) == "Professor"): ?>
                    <label class="labels_right">
                        <?=$labels['profile']['univer_finish'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserUniversity();?>&nbsp;,&nbsp;<?=$user->getUserYearFinish();?>
                    </label><br/><br/>
                    <label class="labels_right">
                        <?=$labels['profile']['stepen'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserStepen();?>
                    </label><br/><br/>
                    <label class="labels_right">
                        <?=$labels['profile']['consultacii'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserConsultacii();?>
                    </label><br/><br/>
                    <label class="labels_right">
                        <?=$labels['profile']['interests'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserScienseInterest();?>
                    </label><br/><br/>
                    <label class="labels_right">
                        <?=$labels['profile']['work'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserWork();?>
                    </label><br/><br/>
                <?endif;?>
                <label class="labels_right">
                      <?=$labels['profile']['birthday'];?>:
                </label><br/>
                <label class="other_info">
                      <?=$user->getDate($user->getUserBirthday());?>
                </label><br/><br/>
                <? if(get_class($user) == "Professor"): ?>
                    <label class="labels_right">
                          <?=$labels['profile']['family'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserFamily();?>
                    </label><br/><br/>
                          <label class="labels_right">
                          <?=$labels['profile']['hoby'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserHoby();?>
                    </label><br/><br/>
                    <label class="labels_right">
                          <?=$labels['profile']['animal'];?>:
                    </label><br/>
                    <label class="other_info">
                        <?=$user->getUserAnimal();?>
                    </label><br/><br/>
                <?endif;?>
            </td>
        </tr>
    </table>  
</div>