<? if (!defined("entrypoint"))die;?>
<div id="profile">

        <table class="user_data">
            <tr>
                <td><?=$labels['fileshare']['picture'];?></td>
                <td><input type="file" name="cover" id="cover"/></td>
            </tr>
            <tr>
                <td><?=$labels['fileshare']['file'];?></td>
                <td><input type="file" name="file" id="file"/></td>
            </tr>

            <tr>
                <td><?=$labels['fileshare']['semest'];?></td>
                <td><select name="semestr">
                        <? for($i=1;$i<13;$i++):?>
                        <option><?=$i;?></option>
                        <?endfor;?>
                    </select></td>
            </tr>
            <tr>
                <td><?=$labels['fileshare']['file'];?></td>
                <td><input type="text" name="title"/></td>
            </tr>

            <tr>
                <td><?=$labels['fileshare']['description'];?></td>
                <td><textarea style="width:480px; height:200px;" name="description"></textarea></td>
            </tr>
        </table>

</div>