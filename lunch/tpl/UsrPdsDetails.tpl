<html>
<head>
	<title>DinBenDon明細顯示</title>
	<link rel="stylesheet" href="assets/css/index.css">
</head>

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