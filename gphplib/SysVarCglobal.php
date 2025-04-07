<?php

declare(strict_types=1); // 嚴格類型

class SysVarCglobal { 

  public $Citys; // 縣市
  public $ZipCode; //郵遞區號
  public $Gender;

  public function __construct(){

        $this->Gender[0] = "--";
        $this->Gender[1] = "男生";
        $this->Gender[2] = "女生";


        $this->Citys[1] = "台北市";
        $this->Citys[2] = "基隆市";
        $this->Citys[3] = "台北縣";
        $this->Citys[4] = "宜蘭縣";
        $this->Citys[5] = "新竹市";
        $this->Citys[6] = "新竹縣";
        $this->Citys[7] = "桃園縣";
        $this->Citys[8] = "苗栗縣";
        $this->Citys[9] = "台中市";
        $this->Citys[10] = "台中縣";
        $this->Citys[11] = "彰化縣";
        $this->Citys[12] = "南投縣";
        $this->Citys[13] = "嘉義市";
        $this->Citys[14] = "嘉義縣";
        $this->Citys[15] = "雲林縣";
        $this->Citys[16] = "台南市";
        $this->Citys[17] = "台南縣";
        $this->Citys[18] = "高雄市";
        $this->Citys[19] = "高雄縣";
        $this->Citys[20] = "澎湖縣";
        $this->Citys[21] = "屏東縣";
        $this->Citys[22] = "台東縣";
        $this->Citys[23] = "花蓮縣";
        $this->Citys[24] = "金門縣";
        $this->Citys[25] = "連江縣";
//        $this->Citys[26] = "南海諸島";
        $this->Citys[27] = "其他地區";

         //台北市
         $this->ZipCode[1][100] = "中正區";
         $this->ZipCode[1][103] = "大同區";
         $this->ZipCode[1][104] = "中山區";
         $this->ZipCode[1][105] = "松山區";
         $this->ZipCode[1][106] = "大安區";
         $this->ZipCode[1][108] = "萬華區";
         $this->ZipCode[1][110] = "信義區";
         $this->ZipCode[1][111] = "士林區";
         $this->ZipCode[1][112] = "北投區";
         $this->ZipCode[1][114] = "內湖區";
         $this->ZipCode[1][115] = "南港區";
         $this->ZipCode[1][116] = "文山區";
         //基隆市
         $this->ZipCode[2][200] = "仁愛區";
         $this->ZipCode[2][201] = "信義區";
         $this->ZipCode[2][202] = "中正區";
         $this->ZipCode[2][203] = "中山區";
         $this->ZipCode[2][204] = "安樂區";
         $this->ZipCode[2][205] = "暖暖區";
         $this->ZipCode[2][206] = "七堵區";
         //台北縣
         $this->ZipCode[3][207] = "萬里";
         $this->ZipCode[3][208] = "金山";
         $this->ZipCode[3][220] = "板橋";
         $this->ZipCode[3][221] = "汐止";
         $this->ZipCode[3][222] = "深坑";
         $this->ZipCode[3][223] = "石碇";
         $this->ZipCode[3][224] = "瑞芳";
         $this->ZipCode[3][226] = "平溪";
         $this->ZipCode[3][227] = "雙溪";
         $this->ZipCode[3][228] = "貢寮";
         $this->ZipCode[3][231] = "新店";
         $this->ZipCode[3][232] = "坪林";
         $this->ZipCode[3][233] = "烏來";
         $this->ZipCode[3][234] = "永和";
         $this->ZipCode[3][235] = "中和";
         $this->ZipCode[3][236] = "土城";
         $this->ZipCode[3][237] = "三峽";
         $this->ZipCode[3][238] = "樹林";
         $this->ZipCode[3][239] = "鶯歌";
         $this->ZipCode[3][241] = "三重";
         $this->ZipCode[3][242] = "新莊";
         $this->ZipCode[3][243] = "泰山";
         $this->ZipCode[3][244] = "林口";
         $this->ZipCode[3][247] = "蘆洲";
         $this->ZipCode[3][248] = "五股";
         $this->ZipCode[3][249] = "八里";
         $this->ZipCode[3][251] = "淡水";
         $this->ZipCode[3][252] = "三芝";
         $this->ZipCode[3][253] = "石門";
         //宜蘭縣
         $this->ZipCode[4][260] = "宜蘭";
         $this->ZipCode[4][261] = "頭城";
         $this->ZipCode[4][262] = "礁溪";
         $this->ZipCode[4][263] = "壯圍";
         $this->ZipCode[4][264] = "員山";
         $this->ZipCode[4][265] = "羅東";
         $this->ZipCode[4][266] = "三星";
         $this->ZipCode[4][267] = "大同";
         $this->ZipCode[4][268] = "五結";
         $this->ZipCode[4][269] = "冬山";
         $this->ZipCode[4][270] = "蘇澳";
         $this->ZipCode[4][272] = "南澳";
         //新竹市
         $this->ZipCode[5][300] = "新竹市";
         //新竹縣
         $this->ZipCode[6][302] = "竹北";
         $this->ZipCode[6][303] = "湖口";
         $this->ZipCode[6][304] = "新豐";
         $this->ZipCode[6][305] = "新埔";
         $this->ZipCode[6][306] = "關西";
         $this->ZipCode[6][307] = "芎林";
         $this->ZipCode[6][308] = "寶山";
         $this->ZipCode[6][310] = "竹東";
         $this->ZipCode[6][311] = "五峰";
         $this->ZipCode[6][312] = "橫山";
         $this->ZipCode[6][313] = "尖石";
         $this->ZipCode[6][314] = "北埔";
         $this->ZipCode[6][315] = "峨眉";
         //桃園縣
         $this->ZipCode[7][320] = "中壢";
         $this->ZipCode[7][324] = "平鎮";
         $this->ZipCode[7][325] = "龍潭";
         $this->ZipCode[7][326] = "楊梅";
         $this->ZipCode[7][327] = "新屋";
         $this->ZipCode[7][328] = "觀音";
         $this->ZipCode[7][330] = "桃園";
         $this->ZipCode[7][333] = "龜山";
         $this->ZipCode[7][334] = "八德";
         $this->ZipCode[7][335] = "大溪";
         $this->ZipCode[7][336] = "復興";
         $this->ZipCode[7][337] = "大園";
         $this->ZipCode[7][338] = "蘆竹";
         //苗栗縣
         $this->ZipCode[8][350] = "竹南";
         $this->ZipCode[8][351] = "頭份";
         $this->ZipCode[8][352] = "三灣";
         $this->ZipCode[8][353] = "南庄";
         $this->ZipCode[8][354] = "獅潭";
         $this->ZipCode[8][356] = "後龍";
         $this->ZipCode[8][357] = "通霄";
         $this->ZipCode[8][358] = "苑裡";
         $this->ZipCode[8][360] = "苗栗";
         $this->ZipCode[8][361] = "造橋";
         $this->ZipCode[8][362] = "頭屋";
         $this->ZipCode[8][363] = "公館";
         $this->ZipCode[8][364] = "大湖";
         $this->ZipCode[8][365] = "泰安";
         $this->ZipCode[8][366] = "銅鑼";
         $this->ZipCode[8][367] = "三義";
         $this->ZipCode[8][368] = "西湖";
         $this->ZipCode[8][369] = "卓蘭";
         //台中市
         $this->ZipCode[9][400] = "中區";
         $this->ZipCode[9][401] = "東區";
         $this->ZipCode[9][402] = "南區";
         $this->ZipCode[9][403] = "西區";
         $this->ZipCode[9][404] = "北區";
         $this->ZipCode[9][406] = "北屯區";
         $this->ZipCode[9][407] = "西屯區";
         $this->ZipCode[9][408] = "南屯區";
         //台中縣
         $this->ZipCode[10][411] = "太平";
         $this->ZipCode[10][412] = "大里";
         $this->ZipCode[10][413] = "霧峰";
         $this->ZipCode[10][414] = "烏日";
         $this->ZipCode[10][420] = "豐原";
         $this->ZipCode[10][421] = "后里";
         $this->ZipCode[10][422] = "石岡";
         $this->ZipCode[10][423] = "東勢";
         $this->ZipCode[10][424] = "和平";
         $this->ZipCode[10][426] = "新社";
         $this->ZipCode[10][427] = "潭子";
         $this->ZipCode[10][428] = "大雅";
         $this->ZipCode[10][429] = "神岡";
         $this->ZipCode[10][432] = "大肚";
         $this->ZipCode[10][433] = "沙鹿";
         $this->ZipCode[10][434] = "龍井";
         $this->ZipCode[10][435] = "梧棲";
         $this->ZipCode[10][436] = "清水";
         $this->ZipCode[10][437] = "大甲";
         $this->ZipCode[10][438] = "外埔";
         $this->ZipCode[10][439] = "大安";
         //彰化縣
         $this->ZipCode[11][500] = "彰化";
         $this->ZipCode[11][502] = "芬園";
         $this->ZipCode[11][503] = "花壇";
         $this->ZipCode[11][504] = "秀水";
         $this->ZipCode[11][505] = "鹿港";
         $this->ZipCode[11][506] = "福興";
         $this->ZipCode[11][507] = "線西";
         $this->ZipCode[11][508] = "和美";
         $this->ZipCode[11][509] = "伸港";
         $this->ZipCode[11][510] = "員林";
         $this->ZipCode[11][511] = "社頭";
         $this->ZipCode[11][512] = "永靖";
         $this->ZipCode[11][513] = "埔心";
         $this->ZipCode[11][514] = "溪湖";
         $this->ZipCode[11][515] = "大村";
         $this->ZipCode[11][516] = "埔鹽";
         $this->ZipCode[11][520] = "田中";
         $this->ZipCode[11][521] = "北斗";
         $this->ZipCode[11][522] = "田尾";
         $this->ZipCode[11][523] = "埤頭";
         $this->ZipCode[11][524] = "溪洲";
         $this->ZipCode[11][525] = "竹塘";
         $this->ZipCode[11][526] = "二林";
         $this->ZipCode[11][527] = "大城";
         $this->ZipCode[11][528] = "芳苑";
         $this->ZipCode[11][530] = "二水";
         //南投縣
         $this->ZipCode[12][540] = "南投";
         $this->ZipCode[12][541] = "中寮";
         $this->ZipCode[12][542] = "草屯";
         $this->ZipCode[12][544] = "國姓";
         $this->ZipCode[12][545] = "埔里";
         $this->ZipCode[12][546] = "仁愛";
         $this->ZipCode[12][551] = "名間";
         $this->ZipCode[12][552] = "集集";
         $this->ZipCode[12][553] = "水里";
         $this->ZipCode[12][555] = "魚池";
         $this->ZipCode[12][556] = "信義";
         $this->ZipCode[12][557] = "竹山";
         $this->ZipCode[12][558] = "鹿谷";
         //嘉義市
         $this->ZipCode[13][600] = "嘉義市";
         //嘉義縣
         $this->ZipCode[14][602] = "番路";
         $this->ZipCode[14][603] = "梅山";
         $this->ZipCode[14][604] = "竹崎";
         $this->ZipCode[14][605] = "阿里山";
         $this->ZipCode[14][606] = "中埔";
         $this->ZipCode[14][607] = "大埔";
         $this->ZipCode[14][608] = "水上";
         $this->ZipCode[14][611] = "鹿草";
         $this->ZipCode[14][612] = "太保";
         $this->ZipCode[14][613] = "朴子";
         $this->ZipCode[14][614] = "東石";
         $this->ZipCode[14][615] = "六腳";
         $this->ZipCode[14][616] = "新港";
         $this->ZipCode[14][621] = "民雄";
         $this->ZipCode[14][622] = "大林";
         $this->ZipCode[14][623] = "溪口";
         $this->ZipCode[14][624] = "義竹";
         //雲林縣
         $this->ZipCode[15][630] = "斗南";
         $this->ZipCode[15][631] = "大埤";
         $this->ZipCode[15][632] = "虎尾";
         $this->ZipCode[15][633] = "土庫";
         $this->ZipCode[15][634] = "褒忠";
         $this->ZipCode[15][635] = "東勢";
         $this->ZipCode[15][636] = "臺西";
         $this->ZipCode[15][637] = "崙背";
         $this->ZipCode[15][638] = "麥寮";
         $this->ZipCode[15][640] = "斗六";
         $this->ZipCode[15][643] = "林內";
         $this->ZipCode[15][646] = "古坑";
         $this->ZipCode[15][647] = "莿桐";
         $this->ZipCode[15][648] = "西螺";
         $this->ZipCode[15][649] = "二崙";
         $this->ZipCode[15][651] = "北港";
         $this->ZipCode[15][652] = "水林";
         $this->ZipCode[15][653] = "口湖";
         $this->ZipCode[15][654] = "四湖";
         $this->ZipCode[15][655] = "元長";
         //台南市
         $this->ZipCode[16][700] = "中區";
         $this->ZipCode[16][701] = "東區";
         $this->ZipCode[16][702] = "南區";
         $this->ZipCode[16][703] = "西區";
         $this->ZipCode[16][704] = "北區";
         $this->ZipCode[16][708] = "安平區";
         $this->ZipCode[16][709] = "安南區";
         //台南縣
         $this->ZipCode[17][710] = "永康";
         $this->ZipCode[17][711] = "歸仁";
         $this->ZipCode[17][712] = "新化";
         $this->ZipCode[17][713] = "左鎮";
         $this->ZipCode[17][714] = "玉井";
         $this->ZipCode[17][715] = "楠西";
         $this->ZipCode[17][716] = "南化";
         $this->ZipCode[17][717] = "仁德";
         $this->ZipCode[17][718] = "關廟";
         $this->ZipCode[17][719] = "龍崎";
         $this->ZipCode[17][720] = "官田";
         $this->ZipCode[17][721] = "麻豆";
         $this->ZipCode[17][722] = "佳里";
         $this->ZipCode[17][723] = "西港";
         $this->ZipCode[17][724] = "七股";
         $this->ZipCode[17][725] = "將軍";
         $this->ZipCode[17][726] = "學甲";
         $this->ZipCode[17][727] = "北門";
         $this->ZipCode[17][730] = "新營";
         $this->ZipCode[17][731] = "後壁";
         $this->ZipCode[17][732] = "白河";
         $this->ZipCode[17][733] = "東山";
         $this->ZipCode[17][734] = "六甲";
         $this->ZipCode[17][735] = "下營";
         $this->ZipCode[17][736] = "柳營";
         $this->ZipCode[17][737] = "鹽水";
         $this->ZipCode[17][741] = "善化";
         $this->ZipCode[17][742] = "大內";
         $this->ZipCode[17][743] = "山上";
         $this->ZipCode[17][744] = "新市";
         $this->ZipCode[17][745] = "安定";
         //高雄市
         $this->ZipCode[18][800] = "新興區";
         $this->ZipCode[18][801] = "前金區";
         $this->ZipCode[18][802] = "苓雅區";
         $this->ZipCode[18][803] = "鹽埕區";
         $this->ZipCode[18][804] = "鼓山區";
         $this->ZipCode[18][805] = "旗津區";
         $this->ZipCode[18][806] = "前鎮區";
         $this->ZipCode[18][807] = "三民區";
         $this->ZipCode[18][811] = "楠梓區";
         $this->ZipCode[18][812] = "小港區";
         $this->ZipCode[18][813] = "左營區";
         //高雄縣
         $this->ZipCode[19][814] = "仁武";
         $this->ZipCode[19][815] = "大社";
         $this->ZipCode[19][820] = "岡山";
         $this->ZipCode[19][821] = "路竹";
         $this->ZipCode[19][822] = "阿蓮";
         $this->ZipCode[19][823] = "田寮";
         $this->ZipCode[19][824] = "燕巢";
         $this->ZipCode[19][825] = "橋頭";
         $this->ZipCode[19][826] = "梓官";
         $this->ZipCode[19][827] = "彌陀";
         $this->ZipCode[19][828] = "永安";
         $this->ZipCode[19][829] = "湖內";
         $this->ZipCode[19][830] = "鳳山";
         $this->ZipCode[19][831] = "大寮";
         $this->ZipCode[19][832] = "林園";
         $this->ZipCode[19][833] = "鳥松";
         $this->ZipCode[19][840] = "大樹";
         $this->ZipCode[19][842] = "旗山";
         $this->ZipCode[19][843] = "美濃";
         $this->ZipCode[19][844] = "六龜";
         $this->ZipCode[19][845] = "內門";
         $this->ZipCode[19][846] = "杉林";
         $this->ZipCode[19][847] = "甲仙";
         $this->ZipCode[19][848] = "桃源";
         $this->ZipCode[19][849] = "三民";
         $this->ZipCode[19][851] = "茂林";
         $this->ZipCode[19][852] = "茄萣";
         //澎湖縣
         $this->ZipCode[20][880] = "馬公";
         $this->ZipCode[20][881] = "西嶼";
         $this->ZipCode[20][882] = "望安";
         $this->ZipCode[20][883] = "七美";
         $this->ZipCode[20][884] = "白沙";
         $this->ZipCode[20][885] = "湖西";
         //屏東縣
         $this->ZipCode[21][900] = "屏東";
         $this->ZipCode[21][901] = "三地門";
         $this->ZipCode[21][902] = "霧臺";
         $this->ZipCode[21][903] = "瑪家";
         $this->ZipCode[21][904] = "九如";
         $this->ZipCode[21][905] = "里港";
         $this->ZipCode[21][906] = "高樹";
         $this->ZipCode[21][907] = "鹽埔";
         $this->ZipCode[21][908] = "長治";
         $this->ZipCode[21][909] = "麟洛";
         $this->ZipCode[21][911] = "竹田";
         $this->ZipCode[21][912] = "內埔";
         $this->ZipCode[21][913] = "萬丹";
         $this->ZipCode[21][920] = "潮州";
         $this->ZipCode[21][921] = "泰武";
         $this->ZipCode[21][922] = "來義";
         $this->ZipCode[21][923] = "萬巒";
         $this->ZipCode[21][924] = "崁頂";
         $this->ZipCode[21][925] = "新埤";
         $this->ZipCode[21][926] = "南州";
         $this->ZipCode[21][927] = "林邊";
         $this->ZipCode[21][928] = "東港";
         $this->ZipCode[21][929] = "琉球";
         $this->ZipCode[21][931] = "佳冬";
         $this->ZipCode[21][932] = "新園";
         $this->ZipCode[21][940] = "枋寮";
         $this->ZipCode[21][941] = "枋山";
         $this->ZipCode[21][942] = "春日";
         $this->ZipCode[21][943] = "獅子";
         $this->ZipCode[21][944] = "車城";
         $this->ZipCode[21][945] = "牡丹";
         $this->ZipCode[21][946] = "恆春";
         $this->ZipCode[21][947] = "滿州";
         //台東縣
         $this->ZipCode[22][950] = "台東";
         $this->ZipCode[22][951] = "綠島";
         $this->ZipCode[22][952] = "蘭嶼";
         $this->ZipCode[22][953] = "延平";
         $this->ZipCode[22][954] = "卑南";
         $this->ZipCode[22][955] = "鹿野";
         $this->ZipCode[22][956] = "關山";
         $this->ZipCode[22][957] = "海端";
         $this->ZipCode[22][958] = "池上";
         $this->ZipCode[22][959] = "東河";
         $this->ZipCode[22][961] = "成功";
         $this->ZipCode[22][962] = "長賓";
         $this->ZipCode[22][963] = "太麻里";
         $this->ZipCode[22][964] = "金峰";
         $this->ZipCode[22][965] = "大武";
         $this->ZipCode[22][966] = "達仁";
         //花蓮縣
         $this->ZipCode[23][970] = "花蓮";
         $this->ZipCode[23][971] = "新城";
         $this->ZipCode[23][972] = "吉安";
         $this->ZipCode[23][974] = "壽豐";
         $this->ZipCode[23][975] = "鳳林";
         $this->ZipCode[23][976] = "光復";
         $this->ZipCode[23][977] = "豐濱";
         $this->ZipCode[23][978] = "瑞穗";
         $this->ZipCode[23][979] = "萬榮";
         $this->ZipCode[23][981] = "玉里";
         $this->ZipCode[23][982] = "卓溪";
         $this->ZipCode[23][983] = "富里";
         //金門縣
         $this->ZipCode[24][890] = "金沙";
         $this->ZipCode[24][891] = "金湖";
         $this->ZipCode[24][892] = "金寧";
         $this->ZipCode[24][893] = "金城";
         $this->ZipCode[24][894] = "烈嶼";
         $this->ZipCode[24][896] = "烏坵";
         //連江縣
         $this->ZipCode[25][209] = "南竿";
         $this->ZipCode[25][210] = "北竿";
         $this->ZipCode[25][211] = "莒光";
         $this->ZipCode[25][212] = "東引";
         $this->ZipCode[27][999] = "其他";

	}
 }

 function Rfc2822ToTimestamp($date){
   $aMonth = array(
                "Jan"=>"1", "Feb"=>"2", "Mar"=>"3", "Apr"=>"4", "May"=>"5",
	        "Jun"=>"6", "Jul"=>"7", "Aug"=>"8", "Sep"=>"9", "Oct"=>"10",
	        "Nov"=>"11", "Dec"=>"12");

   list(  $month, $day,  $year, $time) = explode(" ", $date);
   list($hour, $min, $sec) = explode(":", $time);
   $month = $aMonth[$month];

    return mktime(12, 0, 0, $month, $day, $year);
 }
