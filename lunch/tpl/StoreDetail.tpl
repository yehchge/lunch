<html>
<head>
<title>顯示店家詳細資料</title>

<style type="text/css">
<!--

.head {font:bold}
a:link, a:visited, a:hover {color: #006699;text-decoration: none;}
a:hover {text-decoration: underline;}

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
<body topmargin="5">
<center>
<table Class="Forums_General">
  <tr Class="Forums_Header">
    <td colspan=2><font color="#FFFFFF">&nbsp;顯示店家詳細資料</font></td>
  </tr>
<tr width=80%>
   <td class="head">商家序號：</td>
   <td Class="TextBox">{storeid}</td>
</tr>   
<tr width=80%>   
   <td class="head">商家名稱：</td>
   <td Class="TextBox">{store}</td>
</tr> 
<tr width=80%>   
   <td class="head">商家簡介：</td>
   <td Class="TextBox">{intro}</td>
</tr>   
<tr width=80%>   
   <td class="head">商家類別：</td>
   <td Class="TextBox">{sclass}</td>
</tr>   
<tr width=80%>  
   <td class="head">負責人：</td>
   <td Class="TextBox">{man}</td>
</tr> 
<tr width=80%>
   <td class="head">商家電話：</td>
   <td Class="TextBox">{tel}</td>
</tr> 
<tr width=80%>
   <td class="head">地址：</td>
   <td Class="TextBox">{addr}</td>
</tr> 
<tr width=80%>   
   <td class="head">建立日期：</td>
   <td Class="TextBox">{createdate}</td>
</tr> 
<tr width=80%>   
   <td class="head">更新日期：</td>
   <td Class="TextBox">{editdate}</td>
</tr> 

<tr width=80%>   
   <td class="head">訂購說明：</td>
   <td Class="TextBox">{note}</td>
</tr> 
<tr width=80%>   
   <td class="head">商家狀態：</td>
   <td Class="TextBox">{status}</td>
</tr> 
<tr width=80%>   
   <td align="right" colspan=2>[ <a href="javascript:self.close();"><img src="tpl/images/Cancel.gif" border=0> 關閉</a> ]</td>
</tr> 
</table>
 
</center>
</body>
</html>