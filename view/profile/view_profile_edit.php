<? if (!defined("entrypoint"))die;?>
<style type="text/css">
        .button_download_1{
             position: relative;
             margin:0;
             padding:0;
             font-size: 12px;
             font-family: Georgia, "Times New Roman", Times, serif;
             color:#6e728e;
             border:1px solid #cdcdcd;
             float: left;
             margin-left: 10px;
             text-align:center;
             width:80px;
             height:20px;
             overflow:hidden;
             cursor:pointer;
             display:block;
             background-image:url("http://<?=$_SERVER['HTTP_HOST'];?>/static/img/obzor/obzor_<?=config::getDefaultLanguage();?>.jpg");
        }

        .button_download_1:hover{
            background-image:url("http://<?=$_SERVER['HTTP_HOST'];?>/static/img/obzor/obzor_<?=config::getDefaultLanguage();?>_active.jpg");
        }
    </style>
    
<div id="profile">
    <? if($View->keyExists("error")): ?>
    <b style="color:red;font-size:20px;"><?=$View->error;?></b><br/>
    <?endif;?>
    <form action="http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/profile/edit" enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE"  value="<?=MAX_PHOTO_SIZE;?>0"/>
    <input type="hidden" name="param_edit" value="edit"/>
    <input type="hidden" name="secret" value="<?=$user->getUserSecret();?>"/>
    <h2><?=$labels['profile']['user_profile'];?></h2>
    <table class="user_data">
        <tr>
            <td colspan="2" valign="top">
                <img src="http://<?=$_SERVER['HTTP_HOST'];?>/static/uploaded/user_photo/<?=$user->getUserPhoto();?>" style="margin-bottom:20px"/><br/>
                <b style='font-weight:normal;float:left'><?=$labels['profile']['change_photo'];?>:</b>&nbsp;
                <input type="text" id="temp_cover" readonly style="width:200px;float:left"/>
                <a class="button_download_1"><input class="hidden_input"  type="file" name="cover" id="cover" onchange="checkCover('http://<?=$_SERVER['HTTP_HOST'];?>/<?=config::getDefaultLanguage();?>/ajax/check_file')"/></a>
                <b id="cover_accept"></b>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr style="margin-top:10px;margin-bottom:10px"/></td>
        </tr>
        <tr>
            <td style="width:300px"><?=$labels['profile']['surname'];?></td>
            <td><input type="text" style="width:200px" name="surname" value="<?=$user->getUserSurname();?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['name'];?></td>
            <td><input type="text" style="width:200px" name="name" value="<?=$user->getUserName();?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['patronymik'];?></td>
            <td><input type="text" style="width:200px" name="patronymik" value="<?=$user->getUserPatronymic();?>"/></td>
        </tr>
        <tr>
            <td><?=$labels['profile']['birthday'];?></td>
            <td><input name='birthday' id='birthday' value="<?=$user->getDate($user->getUserBirthday());?>" style="width:200px" readonly/>
                <input type="button" style="background: url('http://<?=$_SERVER['HTTP_HOST'];?>/static/img/datepicker.jpg') no-repeat; width: 30px; border: 0px;" onclick="displayDatePicker('birthday', false, 'dmy', '.')" readonly/></td>
        </tr>
        <tr>
            <td valign="top"><?=$labels['profile']['sex'];?></td>
            <td align="left" style="text-align:left">
                <input type="radio" name="sex" value="M" <? if($user->getUserSex() == "M"): ?>checked<?endif;?>>&nbsp;<?=$labels['profile']['male'];?><br/>
                <input type="radio" name="sex" value="F" <? if($user->getUserSex() == "F"): ?>checked<?endif;?>>&nbsp;<?=$labels['profile']['female'];?>
            </td>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr>
            <td><?=$labels['profile']['status'];?></td>
            <td><input type="text" style="width:200px" name="status" value="<? if($user->getUserState() == "S"): ?><?=$labels['profile']['student'];?><? else:?><?=$labels['profile']['teacher'];?><?endif;?>" readonly/></td>
        </tr>        
        <tr>
            <td><?=$labels['profile']['email'];?></td>
            <td><input type="text" style="width:200px" name="email" value="<?=$user->getUserEmail();?>"/></td>
        </tr>
        
        <? if(get_class($user) == "Student"): ?>
            <tr>
                    <td><?=$labels['profile']['phone'];?></td>
                    <td><input type="text" style="width:200px" name="phone" value="<?=$user->getUserPhone();?>"/></td>
            </tr>
        <? endif;?>
            <tr><td colspan="2"></td></tr>
        <? if(get_class($user) == "Professor"): ?>
            <tr>
                <td><?=$labels['profile']['university'];?></td>
                <td><input name='university' id='university' value='<?=$user->getUserUniversity();?>' style="width:200px"/></td>
            </tr>
            <tr>
                <td><?=$labels['profile']['yearfinish'];?></td>
                <td><input name='yearfinish' id='yearfinish' value='<?=$user->getDate($user->getUserYearFinish());?>' style="width:200px" readonly/>
                <input type="button" style="background: url('http://<?=$_SERVER['HTTP_HOST'];?>/static/img/datepicker.jpg') no-repeat; width: 30px; border: 0px;" onclick="displayDatePicker('yearfinish', false, 'dmy', '.')" readonly/>
                </td>
            </tr>
            <tr>
                <td><?=$labels['profile']['stepen'];?></td>
                <td><input name='stepen' id='stepen' value='<?=$user->getUserStepen();?>' style="width:200px"/></td>
            </tr>
            <tr>
                <td valign="top"><?=$labels['profile']['consultacii'];?></td>
                <td><textarea name='consultacii' id='consultacii' style="width:200px" rows="3"/><?=$user->getUserConsultacii();?></textarea></td>
            </tr>
            <tr>
                <td><?=$labels['profile']['interests'];?></td>
                <td><input name='interests' id='interests' value='<?=$user->getUserScienseInterest();?>' style="width:200px"/></td>
            </tr>
            <tr>
                <td valign="top"><?=$labels['profile']['family'];?></td>
                <td><textarea name='family' id='family' style="width:200px" rows="3"/><?=$user->getUserFamily();?></textarea></td>
            </tr>
            <tr>
                <td valign="top"><?=$labels['profile']['work'];?></td>
                <td><textarea name='work' id='work' style="width:200px" rows="3"/><?=$user->getUserWork();?></textarea></td>
            </tr>
            <tr>
                <td valign="top"><?=$labels['profile']['hoby'];?></td>
                <td><textarea name='hoby' id='hoby' style="width:200px" rows="3"/><?=$user->getUserHoby();?></textarea></td>
            </tr>
            <tr>
                <td valign="top"><?=$labels['profile']['animal'];?></td>
                <td><textarea name='animal' id='animal' style="width:200px" rows="3"/><?=$user->getUserAnimal();?></textarea></td>
            </tr>
        <? endif;?>
        <tr>
            <td colspan="2"><input type="submit" value="<?=$labels['profile']['save'];?>" class="button_download" style="width:130px;height:25px;font-size:16px;margin-left:0"/></td>
        </tr>
    </table>
  </form>
</div>