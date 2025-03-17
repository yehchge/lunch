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
			  <td Class="{classname}" align="center"><a href='./EditManager.php?id={managerid}'><img border="0" src="tpl/images/edit_s.gif"></a></td>
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