<html>
<head>
  <title>更新便當明細</title>
</head>
<center>
<form name="frm" method="post" onsubmit="return check_form_editpds(frm);" action="./index.php?func=product&action=edit">
<input type=hidden name="pdsid" value="{pdsid}">
<input type=hidden name="sid" value="{sid}">
<br>
<table class="Forums_General" Width="80%">
  <tr class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;更新便當明細</font></td>
  </tr>
  <tr>
    <td><b>序號：</b></td>
	<td class="TextBox">{pdsid}</td>
  </tr>
  <tr>
    <td><b>商品名稱：</b></td>
	<td class="TextBox"><input type=text name="pdsname" value="{pdsname}" maxLength=90 size=30></td>
  </tr> 
  <tr> 
    <td><b>型別：</b></td>
	<td class="TextBox"><input type=text name="pdstype" value="{pdstype}" maxLength=30 size=30></td>
  </tr> 
  <tr>
    <td><b>單價：</b></td>
	<td class="TextBox"><input type=text name="price" value="{price}" maxLength=90 size=30></td>
  </tr>
  <tr>
    <td><b>說明：</b></td>
	<td class="TextBox"><textarea name="note" rows="4" cols="50">{note}</textarea></td>
  </tr>
  <tr>
    <td><b>狀態：</b></td>
	<td class="TextBox"><input type=checkbox name="status" {status}>停用</td>
  </tr>
  <tr>
    <td colspan="2" align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> 確定 ]&nbsp;[ <a href="./index.php?func=product&action=list&id={sid}"><img src="tpl/images/Cancel.gif" border=0></a> 取消 ] </td>
  </tr>
</table>
</form>
</center>
<script src="assets/js/main.js"></script>
</html>