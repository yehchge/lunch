<html>
<head><title>���w���a</title></head>

<SCRIPT language="JavaScript" type="text/JavaScript">
<!--
function ShowDetail(sid) {
  window.open('/lunch/StoreDetail.php?id='+sid+'','SD','height=300,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
function ShowPdsInfo(sid) {
  window.open('/lunch/UsrPdsDetails.php?id='+sid+'','SPI','height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430');
}
//-->
</SCRIPT>

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
			  <td class="Forums_Header" align="center">���w���a</td>
			  <td class="Forums_Header" align="center">�K��</td>
			  <td class="Forums_Header" align="center">�Ǹ�</td>
			  <td class="Forums_Header" align="center">���W</td>
			  <td class="Forums_Header" align="center">�q��</td>
			  <td class="Forums_Header" align="center">�t�d�H</td>
			  <td class="Forums_Header" align="center">�̫�ק��</td>
			  <td class="Forums_Header" align="center">���A</td>
			</tr>
			<!-- BEGIN DYNAMIC BLOCK: row -->
			<tr>
			  <td Class="{classname}" align="center" bgcolor="#ffffff">{editstoreid}</td>
			  <td Class="{classname}" bgcolor="#ffffff" align="center"><a href="javascript:ShowPdsInfo({storeid});"><img src="tpl/images/text_file_icon.gif" border="0"></a></td>
			  <td Class="{classname}" bgcolor="#ffffff">{storeid}</td>
			  <td Class="{classname}" bgcolor="#ffffff">{storename}</td>
			  <td Class="{classname}" bgcolor="#ffffff">{tel}</td>
			  <td Class="{classname}" nowrap bgcolor="#ffffff">{man}</td>
			  <td Class="{classname}" bgcolor="#ffffff">{editdate}</td>
			  <td Class="{classname}" nowrap bgcolor="#ffffff">{status}</td>
			</tr>
			<!-- END DYNAMIC BLOCK: row -->
			<tr>
			  <td colspan="9" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	<!-- <input type=button onClick="location='/lunch/index.php';" value="�^�W�@�B"> -->
	</form>
	</center>
</body>
</html>