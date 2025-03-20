<html>
<head><title>DinBenDon明細維護</title></head>
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

<body>
	<center>
    <form name="frm" method="post">
	<input type=hidden name="id" value="{id}">
    <table border="0" cellspacing="0" cellpadding="0" width="80%">
      <tr>
		<td>
		  <table style="font-size:12px" cellspacing="2" border="0" cellpadding="2" width="100%">
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee>{totalrows}</td>
			</tr>
			<tr Class="Forums_General">
			  <td class="Forums_Header" align="center">修改</td>
			  <td class="Forums_Header" align="center">序號</td>
			  <td class="Forums_Header">商品名稱</td>
			  <td class="Forums_Header" nowrap>型別</td>
			  <td class="Forums_Header">金額</td>
			  <td class="Forums_Header" nowrap>說明</td>
			  <td class="Forums_Header">狀態</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr Class="Forums_General">
			  <td Class="{classname}" align="center">
			  	<a href='./index.php?func=product&action=edit&id={pdsid}&sid={storeid}'><!-- ./EditPds.php?id={pdsid}&sid={storeid} -->
			  		<img border=0 src="tpl/images/Edit.gif">
			  	</a>
			  </td>
			  <td Class="{classname}" align="center">{pdsid}</td>
			  <td Class="{classname}" bgcolor="#ffffff">{pdsname}</td>
			  <td Class="{classname}" bgcolor="#ffffff">{pdstype}</td>
			  <td Class="{classname}" nowrap bgcolor="#ffffff">{price}</td>
			  <td Class="{classname}" bgcolor="#ffffff">{note}</td>
			  <td Class="{classname}" nowrap bgcolor="#ffffff">{status}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor="#eeeeee" noswarp>{pageselect}</td>
			</tr>
			<tr>
			  <td colspan="9" align="right">
			  	<a href="./index.php?func=store&action=list"><!-- ./ListStore.php -->
			  		[ <img border="0" src="tpl/images/Cancel.gif"> 取消 ]
			  	</a>
			  </td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	</form>
	
	<form name="addfrm" method="post" action="./index.php?func=product&action=add"><!-- ./AddPdsDetailsed.php -->
	<input type=hidden name="pdsid" value="{id}">
	<table border="0" cellspacing="2" cellpadding="2" width="80%" Class="Forums_General">
	  <tr Class="Forums_General">
	    <td class="Forums_Header" align="center">商品名稱</td>
		<td class="Forums_Header" align="center">型別</td>
		<td class="Forums_Header" align="center">單價(元)</td>
		<td class="Forums_Header" align="center">說明</td>
		<td class="Forums_Header">&nbsp;</td>
	  </tr>
	  <tr>
	    <td bgcolor="#F5F5F5" align="center"><input type="text" name="pdsname" size="20"></td>
		<td bgcolor="#F5F5F5" align="center"><input type="text" name="pdstype" size="5"></td>
		<td bgcolor="#F5F5F5" align="center"><input type="text" name="pdsprice" size="5" maxlength="4"></td>
		<td bgcolor="#F5F5F5" align="center"><input type="text" name="pdsnote" size="28"></td>
		<td bgcolor="#F5F5F5" align="center">[ <input type="image" src="tpl/images/OK.gif" name="sb"> 新增便當商品 ]</td>
	  </tr>
	</table>
	</form>
	</center>
</body>
</html>