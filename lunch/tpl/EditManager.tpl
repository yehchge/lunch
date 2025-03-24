<html>
<head>
  <title>管理指定店家狀態</title>
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
<form name="frm" method="post" onsubmit="return check_form(frm);"><!-- ./EditManagered.php -->
<input type=hidden name="managerid" value="{managerid}">
<table Class="Forums_General" Width="70%">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;管理指定店家狀態</font></td>
  </tr>
  <tr>
    <td>管理序號：</td>
	<td Class="TextBox">{managerid}</td>
  </tr>
  <tr>
    <td>商店序號：</td>
	<td Class="TextBox">{storeid}</td>
  </tr>
  <tr>
    <td>店名：</td>
	<td Class="TextBox">{storename}</td>
  </tr>
  <tr>
    <td>負責人：</td>
	<td Class="TextBox">{man}</td>
  </tr>
  <tr>
    <td>說明：</td>
	<td Class="TextBox">{note}</td>
  </tr>
  <tr>
    <td>建立日期：</td>
	<td Class="TextBox">{createdate}</td>
  </tr>
  <tr>
    <td>狀態：</td>
	<td Class="TextBox"><select name="status">
			{strStatus}
		</select>
	</td>
  </tr>
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> 確定 ]&nbsp;[ 
        <a href="./index.php?func=store&action=list_assign"><!-- ./ListAssignStore.php -->
            <img src="tpl/images/Cancel.gif" border=0>
        </a> 取消 ] 
    </td>
  </tr>
</table>
</form>
{javaScript}
</center>
</html>