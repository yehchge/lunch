<html>
<head>
  <title>��s�K�����</title>
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

</head>
	<script Language="JavaScript">
    <!--
             function check_form(obj) {
                var err = '';
                if(obj.pdsname.value=="") {err +=" [�ӫ~�W��]";}
				if(obj.price.value=="") {err +=" [���]";}
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

	
<center>
<form name="frm" method="post" onsubmit="return check_form(frm);" action="/lunch/EditPdsed.php">
<input type=hidden name="pdsid" value="{pdsid}">
<input type=hidden name="sid" value="{sid}">
<br>
<table Class="Forums_General" Width="80%">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;��s�K�����</font></td>
  </tr>
  <tr>
    <td><b>�Ǹ��G</b></td>
	<td Class="TextBox">{pdsid}</td>
  </tr>
  <tr>
    <td><b>�ӫ~�W�١G</b></td>
	<td Class="TextBox"><input type=text name="pdsname" value="{pdsname}" maxLength=90 size=30></td>
  </tr> 
  <tr> 
    <td><b>���O�G</b></td>
	<td Class="TextBox"><input type=text name="pdstype" value="{pdstype}" maxLength=30 size=30></td>
  </tr> 
  <tr>
    <td><b>����G</b></td>
	<td Class="TextBox"><input type=text name="price" value="{price}" maxLength=90 size=30></td>
  </tr>
  <tr>
    <td><b>�����G</b></td>
	<td Class="TextBox"><input name="note" value="{note}" type="text" size="30" maxlength="10"></td>
  </tr>
  <tr>
    <td><b>���A�G</b></td>
	<td Class="TextBox"><input type=checkbox name="status" {status}>����</td>
  </tr>
  <tr>
    <td colspan="2" align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> �T�w ]&nbsp;[ <a href="/lunch/PdsDetails.php?id={sid}"><img src="tpl/images/Cancel.gif" border=0></a> ���� ] </td>
  </tr>
</table>
</form>
</center>
</html>