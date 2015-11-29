<html>
<head><title>便當明細顯示</title></head>


<style type="text/css">
<!--

.head {font:bold}
a:link, a:visited, a:hover {color: #006699;text-decoration: none;}
a:hover {text-decoration: underline;}

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


<body topmargin="5">
	<center>
    <form name="frm" method="post">
	<input type=hidden name="id" value="{id}">
    <table Class="Forums_General">
	  <tr Class="Forums_Header">
		<td colspan=2><font color="#FFFFFF">&nbsp;便當明細顯示</font></td>
	  </tr>
      <tr>
		<td>
		  <table style="font-size:12px" cellspacing="2" border="0" cellpadding="2">
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee>{totalrows}</td>
			</tr>
			<tr Class="Forums_General">
			  <td class="Forums_Header">序號</td>
			  <td class="Forums_Header">商品名稱</td>
			  <td class="Forums_Header">型別</td>
			  <td class="Forums_Header">金額</td>
			  <td class="Forums_Header">說明</td>
			  <td class="Forums_Header">狀態</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr Class="Forums_General">
			  <td Class="{classname}">{pdsid}</td>
			  <td Class="{classname}">{pdsname}</td>
			  <td Class="{classname}">{pdstype}</td>
			  <td Class="{classname}">{price}</td>
			  <td Class="{classname}">{note}</td>
			  <td Class="{classname}">{status}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
			<tr width=80%>   
			  <td align="right" colspan="9">[ <a href="javascript:self.close();"><img src="tpl/images/Cancel.gif" border=0> 關閉</a> ]</td>
			</tr> 
		  </table>
		</td>
	  </tr>
	</table>
	</form>
	</center>
</body>
</html>