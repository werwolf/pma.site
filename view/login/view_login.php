<div id="login_block" align="center" >
<form action="" method="post">
			<h2><?= $labels['login']['enter_site']; ?></h2>
			<table cellspacing="0" cellpadding="3" align="center">
				<tr>
					<td align="right">
						<?= $labels['login']['login_wrd']; ?>
					</td>
					<td align="left">
						<input type="text" name="login" value="" class="login_input" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<?= $labels['login']['password_wrd']; ?>
					</td>
					<td align="left">
						<input type="password" name="password" value="" class="login_input" />
					</td>
				</tr>
				<? if ($View->keyExists("error")): ?>
				<tr>
					<td colspan="2" align="right">
						<div class="block_error"><?= $labels['login']['error_login']; ?></div>
					</td>
				</tr>
				<? endif; ?>
				<tr>
					<td colspan="2" align="right">
                                            <input type="image" id="login_button" src="http://<?=$_SERVER['HTTP_HOST'];?>/static/img/enter/enter_button_<?=config::getDefaultLanguage();?>.png"/>
					</td>
				</tr>
			</table>
		</form>
</div>
