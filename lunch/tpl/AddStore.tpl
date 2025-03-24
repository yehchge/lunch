<html>
<head>
  <title>新增便當店家</title>
</head>

	<script Language="JavaScript">
    <!--
             function check_form(obj) {
                var err = '';
                if(obj.name.value=="") {err +=" [店名]";}
                if(obj.intro.value=="") {err +=" [簡介]";}
				if(obj.sclass.selectedIndex==0) {err +=" [店家類別]";}
				if(obj.man.value=="") {err +=" [負責人]";}
                if(obj.addr.value=="") {err +=" [地址]";}
                if(obj.tel.value=="") {err +=" [電話]";} 
				if(obj.note.value=="") {err +=" [訂購說明]";} 
                if(err) {alert("請正確輸入 "+err+"");return false;} 
                return ture;
             }
             
    //-->
    </script>
<center>
<form name="frm" method="post" onsubmit="return check_form(frm);" action="./index.php?func=store&action=add"><!-- ./AddStoreed.php -->
<br>
<table Width="80%" Class="Forums_General">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;新增店家</font></td>
  </tr>
  <tr>
    <td><b>商家名稱：</b></td>
	<td Class="TextBox"><input type=text name="name" maxLength=90 size=30></td>
  </tr> 
  <tr> 
    <td><b>商家簡介：</b></td>
	<td Class="TextBox"><input type=text name="intro" maxLength=30 size=30></td>
  </tr> 
  <tr>
    <td><b>商家類別：</b></td>
	<td Class="TextBox">
	  <select name="sclass">
		<option value="0">請選擇
		<option value="便當">便當
		<option value="速食">速食
		<option value="飲料">飲料
	  </select>
	</td>
  </tr>
  <tr>
    <td><b>負 責 人：</b></td>
	<td Class="TextBox"><input name="man" type="text" size="30" maxlength="10"><font color=red> (Ex: Boss) </font></td>
  </tr>
  <tr> 
    <td><b>商家地址：</b></td>
	<td Class="TextBox"><input name="addr" type="text" size="50" maxlength="50"></td>
  </tr>
  <tr> 
    <td><b>商家電話：</b></td>
	<td Class="TextBox"><input type=text name="tel" maxLength=21 size=30></td>
  </tr> 
  <tr> 
    <td><b>訂購說明：</b></td>
	<td Class="TextBox"><input type=text name="note" maxLength=10 size=30></td>
  </tr> 
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> 確定 ]&nbsp;[ <a href="/lunch/index.php"><img src="tpl/images/Cancel.gif" border=0></a> 取消 ] </td>
  </tr>
</table>
</form>
</center>
</html>