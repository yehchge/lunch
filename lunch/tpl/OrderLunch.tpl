<html>
<head>
  <title>DinBenDon</title>
</head>

<script language='JavaScript'>
<!--
// 防止回此頁
history.forward();
//-->
</script>
<body>
	<center>
    <form name="frm" method="post"><!-- ./OrderLunched.php -->
	<input type=hidden name="id" value="{id}">
	<input type=hidden name="mid" value="{mid}">
    <table border="0" cellspacing="0" cellpadding="0" width="80%">
      <tr>
		<td>
		  <table style="font-size:12px" cellspacing="2" border="0" cellpadding="2" width="100%">
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee>{totalrows}</td>
			</tr>
			<tr Class="Forums_General">
			  <td class="Forums_Header" align="center">勾選</td>
			  <td class="Forums_Header" align="center">數量</td>
			  <td class="Forums_Header" align="center">備註</td>
			  <td class="Forums_Header" align="center">序號</td>
			  <td class="Forums_Header" align="center">商品名稱</td>
			  <td class="Forums_Header" align="center">型別</td>
			  <td class="Forums_Header" align="center">金額</td>
			  <td class="Forums_Header" align="center">說明</td>
			  <td class="Forums_Header" align="center">狀態</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr Class="Forums_General">
			  <td Class="{classname}" align="center"><input type="checkbox" name="chk[]" value="{pdsid}"></td>
			  <td Class="{classname}" align="center"><input type="text" name="cnt{pdsid}" maxLength=2 size=4></td>
			  <td Class="{classname}" align="center"><input type="text" name="note{pdsid}" maxLength=60></td>
			  <td Class="{classname}" align="center">{pdsid}</td>
			  <td Class="{classname}" align="center">{pdsname}</td>
			  <td Class="{classname}" align="center">{pdstype}</td>
			  <td Class="{classname}" align="center">{price}</td>
			  <td Class="{classname}" align="center">{note}</td>
			  <td Class="{classname}" align="center">{status}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
			<tr>
			  <td colspan="9" align="right"> [ <input type="image" src="tpl/images/OK.gif" name="sb"> 確定訂購 ]&nbsp;[ <a href="./OrderStore.php"><img src="tpl/images/Cancel.gif" border=0></a> 取消 ] </td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	</form>
	</center>
</body>
</html>