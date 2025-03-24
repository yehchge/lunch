<html>
<head>
  <title>DinBenDon(指定店家)</title>
</head>

<body>
    <center>
    <form name="frm" method="post">
    <table border="0" cellspacing="0" cellpadding="0" width="80%">
      <tr>
        <td>
          <table style="font-size:12px" cellspacing="2" border="0" cellpadding="2" width="100%">
            <tr>
              <td colspan="7" align="center" bgcolor=#eeeeee>{totalrows}</td>
            </tr>
            <tr Class="Forums_General">
              <td class="Forums_Header" align="center">序號</td>
              <td class="Forums_Header" align="center">指定日期</td>
              <td class="Forums_Header" align="center">負責人</td>
              <td class="Forums_Header" align="center">店家</td>
              <td class="Forums_Header" align="center">明細</td>
              <td class="Forums_Header" align="center">狀態</td>
              <td class="Forums_Header" align="center">訂購GO</td>
            </tr>
            <!-- BEGIN DYNAMIC BLOCK: row -->
            <tr>
              <td Class="{classname}" align="center">{managerid}</td>
              <td Class="{classname}" align="center">{createdate}</td>
              <td Class="{classname}" align="center">{man}</td>
              <td Class="{classname}" align="center">{storename}</td>
              <td Class="{classname}" align="center"><a href="javascript:ShowPdsInfo({storeid});"><img src="tpl/images/text_file_icon.gif" border="0"></a></td>
              <td Class="{classname}" align="center">{status}</td>
              <td Class="{classname}" align="center">
                <a href='./index.php?func=order&action=add&id={storeid}&mid={managerid}'>
                    <img src="tpl/images/top_bt_srch_new.gif" border="0">
                </a>
            </td>
            </tr>
            <!-- END DYNAMIC BLOCK: row -->
            <tr>
              <td colspan="7" align="center" bgcolor=#eeeeee noswarp>{pageselect}</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    </form>
    </center>
    <script src="assets/js/main.js"></script>
</body>
</html>