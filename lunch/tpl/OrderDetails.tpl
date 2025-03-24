<html>
<head>
  <title>訂購人明細</title>
  
<SCRIPT language="JavaScript" type="text/JavaScript">
<!--
function ShowDetail(sid) {
  window.open('./StoreDetail.php?id='+sid+'','SD','height=300,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
function ShowPdsInfo(sid) {
  window.open('./UsrPdsDetails.php?id='+sid+'','SPI','height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
//-->
</SCRIPT>

</head>
<body>
	<center>
    <form name="frm" method="post">
    <table border="0" cellspacing="0" cellpadding="0" width="80%">
      <tr>
		<td>
		  <table style="font-size:12px" cellspacing="2" border="0" cellpadding="2" width="100%">
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee>{totalrows}</td>
			</tr>
			<tr Class="Forums_General">
			  <td class="Forums_Header" align="center">序號</td>
			  <td class="Forums_Header" align="center">商品名稱</td>
			  <td class="Forums_Header" align="center">數量</td>
			  <td class="Forums_Header" align="center">單價</td>
			  <td class="Forums_Header" align="center">訂購人</td>
			  <td class="Forums_Header" align="center">備註</td>
			  <td class="Forums_Header" align="center">訂購時間</td>
			  <td  class="Forums_Header" align="center">狀態</td>
			  <td  class="Forums_Header" align="center">修改</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr Class="Forums_General">
			  <td Class="{classname}" align="center">{orderid}</td>
			  <td Class="{classname}" align="center">{pdsname}</td>
			  <td Class="{classname}" align="center">{count}</td>
			  <td Class="{classname}" align="center">{price}</td>
			  <td Class="{classname}" align="center">{man}</td>
			  <td Class="{classname}" align="center">{note}</td>
			  <td Class="{classname}" align="center">{createdate}</td>
			  <td Class="{classname}" align="center">{status}</td>
			  <td Class="{classname}" align="center">{editstatus}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
			<tr Class="Forums_General">
			  <td colspan="9" align="right"> [ <a href="./index.php?func=manager&action=list_order">回上一頁</a> ] </td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	</form>
	</center>
</body>
</html>