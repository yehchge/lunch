<html>
<head>
    <title>店家維護</title>
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
              <td Class="{classname}" align="center">
                <a href='./index.php?func=store&action=edit&id={storeid}'>
                    <img border=0 src="tpl/images/Edit.gif">
                </a>
              </td>
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
    </form>
    </center>
    <script src="assets/js/main.js"></script>
</body>
</html>