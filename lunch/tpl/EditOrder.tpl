<html>
<head>
  <title>管理使用者DinBenDon狀態</title>
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
<form name="frm" method="post" onsubmit="return check_form(frm);"><!--  action="./EditOrdered.php" -->
<input type=hidden name="orderid" value="{orderid}">
<input type=hidden name="managerid" value="{managerid}">
<table Class="Forums_General" Width="70%">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;管理使用者DinBenDon狀態</font></td>
  </tr>
  <tr>
    <td>訂購編號：</td>
	<td Class="TextBox">{orderid}</td>
  </tr>
  <tr>
    <td>訂購人：</td>
	<td Class="TextBox">{orderman}</td>
  </tr>
  <tr>
    <td>商品名稱：</td>
	<td Class="TextBox">{pdsname}</td>
  </tr>
  <tr>
    <td>金額：</td>
	<td Class="TextBox">{price}</td>
  </tr>
  <tr>
    <td>數量：</td>
	<td Class="TextBox">{count}</td>
  </tr>
  <tr>
    <td>訂購說明：</td>
	<td Class="TextBox">{note}</td>
  </tr>
  <tr>
    <td>訂購時間：</td>
	<td Class="TextBox">{createdate}</td>
  </tr>
  <tr>
    <td>狀態：</td>
	<td Class="TextBox">
        <select name="status">
			<option value=0>請選擇
			<option value=1>正常
			<option value=2>取消
			<option value=9>刪除
		</select>
	</td>
  </tr>
  <tr>
    <td colspan=2 align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb1"> 確定 ]&nbsp;[ <a href="./index.php?func=order&action=list&mid={managerid}"><img src="tpl/images/Cancel.gif" border=0></a> 取消 ] </td>
  </tr>
</table>
</form>
{javaScript}
</center>
</html>