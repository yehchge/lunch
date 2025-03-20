<html>
<head>
  <title>更新便當店家</title>
  
<style type="text/css">
<!--
.Forums_Header {
	font: bold Arial;
	color: white;
	background-color: #cccccc;
}

.Forums_Header2 {
	color: white;
	font: bold x-small Verdana, Arial, sans-serif;
	background-color: darkred;
	border: 1px;
	border-color: #000000;
	border-style: solid;
}

.Forums_TopicSubject {
	color: darkred;
	font: bold x-small Verdana, Arial, sans-serif;
	font-size: 16;
}

.Forums_Item {
	background-color: beige;
	vertical-align: top;
	border: 0px; 
	border-color: #c0c0c0;
	border-style: solid;
}

.Forums_AlternatingItem {
	font: tahoma;
	font-size: 2:
	color: white;
	background-color: moccasin;
	vertical-align: top;
	border: 0px; 
	border-color: #c0c0c0;
	border-style: solid;
}

.Forums_General {
	font: tahoma;
	font-size: 2ex;
	color: black;
	background-color: beige;
	vertical-align: top;
	border: 1px; 
	border-color: #c0c0c0;
	border-style: solid;
}
TD 
{
	font: x-small Verdana, Arial, sans-serif;
	font-size: 12;
	line-height: 17px;
}
.TextBox {
	font: x-small Verdana, Arial, sans-serif;
	font-size: 12;
	color: darkblue;
	background-color: lightyellow;
}
-->
</style>
 
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
			 
function seldroplist(form,str)
{
    //document.write(form.options[1].text);
    for (var i=0;i<form.length;i++) {
       if (form.options[i].value==str) {
          form.options.selectedIndex=i;
       }
	   //document.write(form.options[i].value);
       //document.write(document.frm.sc.options[i].text);
    }
}

function seldroplisttext(form,str)
{
    //document.write(form.options[1].text);
    for (var i=0;i<form.length;i++) {
       if (form.options[i].value.indexOf(str)!=-1) {
          form.options.selectedIndex=i;
       }
	   //document.write(form.options[i].value);
       //document.write(document.frm.sc.options[i].text);
    }
}
    //-->
    </script>
  
</head>

	
<center>
<form name="frm" method="post" onsubmit="return check_form(frm);" action="./index.php?func=store&action=edit"><!-- ./EditStoreed.php -->
<input type=hidden name="storeid" value="{storeid}">
<br>
<table Class="Forums_General" Width="80%">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;更新店家</font></td>
  </tr>
  <tr>
    <td>店名：</td>
	<td Class="TextBox"><input type=text name="sname" value="{sname}" maxLength=90 size=30></td>
  </tr> 
  <tr> 
    <td>簡介：</td>
	<td Class="TextBox"><textarea name="intro" rows="4" cols="50">{intro}</textarea></td>
  </tr> 
  <tr>
    <td>店家類別：</td>
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
    <td>負責人：</td>
	<td Class="TextBox"><input name="man" value="{man}" type="text" size="30" maxlength="10"><font color=red>(Ex:老闆)</font></td>
  </tr>
  <tr> 
    <td>地址：</td>
	<td Class="TextBox"><input name="addr" value="{addr}" type="text" size="50" maxlength="50"></td>
  </tr>
  <tr> 
    <td>電話：</td>
	<td Class="TextBox"><input type=text name="tel" value="{tel}" maxLength=21 size=30></td>
  </tr> 
  <tr> 
    <td>訂購說明：</td>
	<td Class="TextBox"><textarea name="note" rows="4" cols="50">{note}</textarea></td>
  </tr>
  <tr>
    <td>狀態：</td>
	<td Class="TextBox"><input type=checkbox name="status" {status}>停用</td>
  </tr>
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> 確定 ]&nbsp;[ <a href="/lunch/ListStore.php"><img src="tpl/images/Cancel.gif" border=0></a> 取消 ] </td>
  </tr>
</table>
</form>
</center>
{javaScript}
</html>