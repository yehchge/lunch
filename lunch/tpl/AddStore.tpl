<html>
<head>
  <title>�u�Q�o-�s�W�K���a</title>
</head>
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
             
    //-->
    </script>
<center>
<form name="frm" method="post" onsubmit="return check_form(frm);" action="/lunch/AddStoreed.php">
<br>
<table Width="80%" Class="Forums_General">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;�s�W���a</font></td>
  </tr>
  <tr>
    <td><b>�Ӯa�W�١G</b></td>
	<td Class="TextBox"><input type=text name="name" maxLength=90 size=30></td>
  </tr> 
  <tr> 
    <td><b>�Ӯa²���G</b></td>
	<td Class="TextBox"><input type=text name="intro" maxLength=30 size=30></td>
  </tr> 
  <tr>
    <td><b>�Ӯa���O�G</b></td>
	<td Class="TextBox">
	  <select name="sclass">
		<option value="0">�п��
		<option value="�K��">�K��
		<option value="�t��">�t��
		<option value="����">����
	  </select>
	</td>
  </tr>
  <tr>
    <td><b>�t �d �H�G</b></td>
	<td Class="TextBox"><input name="man" type="text" size="30" maxlength="10"><font color=red> (Ex:����) </font></td>
  </tr>
  <tr> 
    <td><b>�Ӯa�a�}�G</b></td>
	<td Class="TextBox"><input name="addr" type="text" size="50" maxlength="50"></td>
  </tr>
  <tr> 
    <td><b>�Ӯa�q�ܡG</b></td>
	<td Class="TextBox"><input type=text name="tel" maxLength=30 size=30></td>
  </tr> 
  <tr> 
    <td><b>�q�ʻ����G</b></td>
	<td Class="TextBox"><input type=text name="note" maxLength=10 size=30></td>
  </tr> 
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> �T�w ]&nbsp;[ <a href="/lunch/index.php"><img src="tpl/images/Cancel.gif" border=0></a> ���� ] </td>
  </tr>
</table>
</form>
</center>
</html>