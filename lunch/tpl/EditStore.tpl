<html>
<head>
  <title>��s�K���a</title>
  
<style type="text/css">
<!--
.Forums_Header {
	font: bold Arial;
	color: white;
	background-color: #E16161;
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
                if(obj.name.value=="") {err +=" [���W]";}
                if(obj.intro.value=="") {err +=" [²��]";}
				if(obj.sclass.selectedIndex==0) {err +=" [���a���O]";}
				if(obj.man.value=="") {err +=" [�t�d�H]";}
                if(obj.addr.value=="") {err +=" [�a�}]";}
                if(obj.tel.value=="") {err +=" [�q��]";} 
				if(obj.note.value=="") {err +=" [�q�ʻ���]";} 
                if(err) {alert("�Х��T��J "+err+"");return false;} 
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
<form name="frm" method="post" onsubmit="return check_form(frm);" action="/lunch/EditStoreed.php">
<input type=hidden name="storeid" value="{storeid}">
<br>
<table Class="Forums_General" Width="80%">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;��s���a</font></td>
  </tr>
  <tr>
    <td>���W�G</td>
	<td Class="TextBox"><input type=text name="sname" value="{sname}" maxLength=90 size=30></td>
  </tr> 
  <tr> 
    <td>²���G</td>
	<td Class="TextBox"><input type=text name="intro" value="{intro}" maxLength=30 size=30></td>
  </tr> 
  <tr>
    <td>���a���O�G</td>
	<td Class="TextBox"><select name="sclass">
					<option value="0">�п��
					<option value="�K��">�K��
					<option value="�t��">�t��
					<option value="����">����
				   </select>
	</td>
  </tr>
  <tr>
    <td>�t�d�H�G</td>
	<td Class="TextBox"><input name="man" value="{man}" type="text" size="30" maxlength="10"><font color=red>(Ex:����)</font></td>
  </tr>
  <tr> 
    <td>�a�}�G</td>
	<td Class="TextBox"><input name="addr" value="{addr}" type="text" size="50" maxlength="50"></td>
  </tr>
  <tr> 
    <td>�q�ܡG</td>
	<td Class="TextBox"><input type=text name="tel" value="{tel}" maxLength=30 size=30></td>
  </tr> 
  <tr> 
    <td>�q�ʻ����G</td>
	<td Class="TextBox"><input type=text name="note" value="{note}" maxLength=10 size=30></td>
  </tr>
  <tr>
    <td>���A�G</td>
	<td Class="TextBox"><input type=checkbox name="status" {status}>����</td>
  </tr>
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> �T�w ]&nbsp;[ <a href="/lunch/ListStore.php"><img src="tpl/images/Cancel.gif" border=0></a> ���� ] </td>
  </tr>
</table>
</form>
</center>
</html>