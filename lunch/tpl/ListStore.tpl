<html>
<head><title>店家維護</title></head>

<SCRIPT language="JavaScript" type="text/JavaScript">
<!--
function ShowDetail(sid) {
  window.open('./StoreDetail.php?id='+sid+'','sdetail','height=300,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
//-->
</SCRIPT>

<style type="text/css">
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
</style>

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
			  <td class="Forums_Header">修改</td>
			  <td class="Forums_Header">便當明細</td>
			  <td class="Forums_Header">序號</td>
			  <td class="Forums_Header" nowrap>店名</td>
			  <td class="Forums_Header">電話</td>
			  <td class="Forums_Header" nowrap>負責人</td>
			  <td class="Forums_Header" nowrap>最後修改日</td>
			  <td class="Forums_Header">狀態</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr Class="Forums_General">
			  <td Class="{classname}" align="center"><a href='./EditStore.php?id={storeid}'><img border=0 src="tpl/images/Edit.gif"></a></td>
			  <td Class="{classname}" align="center">{editdetails}</td>
			  <td Class="{classname}">{storeid}</td>
			  <td Class="{classname}">{storename}</td>
			  <td Class="{classname}">{tel}</td>
			  <td Class="{classname}" nowrap>{man}</td>
			  <td Class="{classname}">{editdate}</td>
			  <td Class="{classname}" nowrap>{status}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	<!-- <input type=button onClick="location='/lunch/index.php';" value="回上一步"> -->
	</form>
	</center>
</body>
</html>