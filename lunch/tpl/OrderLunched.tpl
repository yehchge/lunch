<html>
<head>
  <title>訂購便當結果</title>
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

<center>
<table Width="70%" Class="Forums_General">
  <tr Class="Forums_Header">
    <td colspan=4><font color="#FFFFFF">&nbsp;訂購便當結果</font></td>
  </tr>
  <tr Class="Forums_General">
    <td Class="Forums_AlternatingItem">便當名稱</td>
	<td Class="Forums_AlternatingItem">單價</td>
	<td Class="Forums_AlternatingItem">數量</td>
	<td Class="Forums_AlternatingItem">備註</td>
  </tr>
  
  <!-- BEGIN DYNAMIC BLOCK: row -->  
  <tr Class="Forums_General">
    <td Class="{classname}">{pdsname}</td>
	<td Class="{classname}">{price}</td>
	<td Class="{classname}">{count}</td>
	<td Class="{classname}">{note}</td>
  </tr>
  <!-- END DYNAMIC BLOCK: row -->
  
  <tr Class="Forums_General">
    <td Class="{classname1}" colspan=4 align="right"> [ <a href="/lunch/index.php"><img src="tpl/images/OK.gif" border=0></a> 回主選單 ] </td>
  </tr>
  <tr Class="Forums_Header">
    <td colspan=4  align="center"> [ <font color="#FFFFFF">感謝您的訂購，先祝您用餐愉快！</font> ] </td>
  </tr>
</table>
</center>
</html>
