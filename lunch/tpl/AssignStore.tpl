<html>
<head>
	<title>指定店家</title>
</head>

<SCRIPT language="JavaScript" type="text/JavaScript">
<!--
function ShowDetail(sid) {
  window.open('./index.php?func=store&action=show&id='+sid+'','SD','height=300,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
function ShowPdsInfo(sid) {
  // window.open('./UsrPdsDetails.php?id='+sid+'','SPI','height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
  window.open('./index.php?func=product&action=list_store&id='+sid+'','SPI','height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
//-->
</SCRIPT>

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
			<tr class="Forums_General">
			  <td class="Forums_Header" align="center">指定店家</td>
			  <td class="Forums_Header" align="center">便當</td>
			  <td class="Forums_Header" align="center">序號</td>
			  <td class="Forums_Header" align="center">店名</td>
			  <td class="Forums_Header" align="center">電話</td>
			  <td class="Forums_Header" align="center">負責人</td>
			  <td class="Forums_Header" align="center">最後修改日</td>
			  <td class="Forums_Header" align="center">狀態</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr>
			  <td class="{classname}" align="center" bgcolor="#ffffff">{editstoreid}</td>
			  <td class="{classname}" bgcolor="#ffffff" align="center"><a href="javascript:ShowPdsInfo({storeid});"><img src="tpl/images/text_file_icon.gif" border="0"></a></td>
			  <td class="{classname}" bgcolor="#ffffff">{storeid}</td>
			  <td class="{classname}" bgcolor="#ffffff">{storename}</td>
			  <td class="{classname}" bgcolor="#ffffff">{tel}</td>
			  <td class="{classname}" nowrap bgcolor="#ffffff">{man}</td>
			  <td class="{classname}" bgcolor="#ffffff">{editdate}</td>
			  <td class="{classname}" nowrap bgcolor="#ffffff">{status}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	<!-- <input type=button onClick="location='./index.php';" value="回上一步"> -->
	</form>
	</center>
</body>
</html>