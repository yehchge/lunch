<html>
<head>
  <title>�޲z�ϥΪ̭q�K���A</title>
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
	
<center>
<form name="frm" method="post" onsubmit="return check_form(frm);" action="./EditOrdered.php">
<input type=hidden name="orderid" value="{orderid}">
<input type=hidden name="managerid" value="{managerid}">
<table Class="Forums_General" Width="70%">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;�޲z�ϥΪ̭q�K���A</font></td>
  </tr>
  <tr>
    <td>�q�ʽs���G</td>
	<td Class="TextBox">{orderid}</td>
  </tr>
  <tr>
    <td>�q�ʤH�G</td>
	<td Class="TextBox">{orderman}</td>
  </tr>
  <tr>
    <td>�ӫ~�W�١G</td>
	<td Class="TextBox">{pdsname}</td>
  </tr>
  <tr>
    <td>���B�G</td>
	<td Class="TextBox">{price}</td>
  </tr>
  <tr>
    <td>�ƶq�G</td>
	<td Class="TextBox">{count}</td>
  </tr>
  <tr>
    <td>�q�ʻ����G</td>
	<td Class="TextBox">{note}</td>
  </tr>
  <tr>
    <td>�q�ʮɶ��G</td>
	<td Class="TextBox">{createdate}</td>
  </tr>
  <tr>
    <td>���A�G</td>
	<td Class="TextBox"><select name="status">
			<option value=0>�п��
			<option value=1>���`
			<option value=2>����
			<option value=9>�R��
		</select>
	</td>
  </tr>
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> �T�w ]&nbsp;[ <a href="./OrderDetails.php?mid={managerid}"><img src="tpl/images/Cancel.gif" border=0></a> ���� ] </td>
  </tr>
</table>
</form>
</center>
</html>