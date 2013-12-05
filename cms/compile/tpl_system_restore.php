<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

			<div class="detailMember_txt">选择还原版本：</div>

			<select name="para[serverfile]" id="serverfile">
			<option value="">-请选择-</option>
			<?php echo runFunc('getBackupDataFile',array());?>
			</select>
			</div>
			
    <div class="detailMember_doedit"><input type="button" value="恢复" onclick="submitData();" /></div>
         
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
