<html>
<head>
  <title>指定店家管理/截止/取消</title>
  
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
			  <td class="Forums_Header" align="center">日期</td>
			  <td class="Forums_Header" align="center">負責人</td>
			  <td class="Forums_Header" align="center">店家序號</td>
			  <td class="Forums_Header" align="center">店家</td>
			  <td class="Forums_Header" align="center">狀態</td>
			  <td class="Forums_Header" align="center">管理</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr>
			  <td Class="{classname}" align="center">{managerid}</td>
			  <td Class="{classname}" align="center">{createdate}</td>
			  <td Class="{classname}" align="center">{man}</td>
			  <td Class="{classname}" align="center">{storeid}</td>
			  <td Class="{classname}">{storename}</td>
			  <td Class="{classname}" align="center">{status}</td>
			  <td Class="{classname}" align="center">
			  	<a href='./index.php?func=store&action=edit_status&id={managerid}'><!-- ./EditManager.php?id={managerid} -->
			  		<img border="0" src="tpl/images/edit_s.gif">
			  	</a>
			  </td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	</form>
	</center>
</body>
</html>