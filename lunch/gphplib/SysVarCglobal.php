<?php

class SysVarCglobal { 

  public $Citys; // ����
  public $ZipCode; //�l���ϸ�
  public $Gender;

  public function __construct (){

        $this->Gender[0] = "--";
        $this->Gender[1] = "�k��";
        $this->Gender[2] = "�k��";


        $this->Citys[1] = "�x�_��";
        $this->Citys[2] = "�򶩥�";
        $this->Citys[3] = "�x�_��";
        $this->Citys[4] = "�y����";
        $this->Citys[5] = "�s�˥�";
        $this->Citys[6] = "�s�˿�";
        $this->Citys[7] = "��鿤";
        $this->Citys[8] = "�]�߿�";
        $this->Citys[9] = "�x����";
        $this->Citys[10] = "�x����";
        $this->Citys[11] = "���ƿ�";
        $this->Citys[12] = "�n�뿤";
        $this->Citys[13] = "�Ÿq��";
        $this->Citys[14] = "�Ÿq��";
        $this->Citys[15] = "���L��";
        $this->Citys[16] = "�x�n��";
        $this->Citys[17] = "�x�n��";
        $this->Citys[18] = "������";
        $this->Citys[19] = "������";
        $this->Citys[20] = "���";
        $this->Citys[21] = "�̪F��";
        $this->Citys[22] = "�x�F��";
        $this->Citys[23] = "�Ὤ��";
        $this->Citys[24] = "������";
        $this->Citys[25] = "�s����";
//        $this->Citys[26] = "�n���Ѯq";
        $this->Citys[27] = "��L�a��";

         //�x�_��
         $this->ZipCode[1][100] = "������";
         $this->ZipCode[1][103] = "�j�P��";
         $this->ZipCode[1][104] = "���s��";
         $this->ZipCode[1][105] = "�Q�s��";
         $this->ZipCode[1][106] = "�j�w��";
         $this->ZipCode[1][108] = "�U�ذ�";
         $this->ZipCode[1][110] = "�H�q��";
         $this->ZipCode[1][111] = "�h�L��";
         $this->ZipCode[1][112] = "�_���";
         $this->ZipCode[1][114] = "�����";
         $this->ZipCode[1][115] = "�n���";
         $this->ZipCode[1][116] = "��s��";
         //�򶩥�
         $this->ZipCode[2][200] = "���R��";
         $this->ZipCode[2][201] = "�H�q��";
         $this->ZipCode[2][202] = "������";
         $this->ZipCode[2][203] = "���s��";
         $this->ZipCode[2][204] = "�w�ְ�";
         $this->ZipCode[2][205] = "�x�x��";
         $this->ZipCode[2][206] = "�C����";
         //�x�_��
         $this->ZipCode[3][207] = "�U��";
         $this->ZipCode[3][208] = "���s";
         $this->ZipCode[3][220] = "�O��";
         $this->ZipCode[3][221] = "����";
         $this->ZipCode[3][222] = "�`�|";
         $this->ZipCode[3][223] = "����";
         $this->ZipCode[3][224] = "���";
         $this->ZipCode[3][226] = "����";
         $this->ZipCode[3][227] = "����";
         $this->ZipCode[3][228] = "�^�d";
         $this->ZipCode[3][231] = "�s��";
         $this->ZipCode[3][232] = "�W�L";
         $this->ZipCode[3][233] = "�Q��";
         $this->ZipCode[3][234] = "�éM";
         $this->ZipCode[3][235] = "���M";
         $this->ZipCode[3][236] = "�g��";
         $this->ZipCode[3][237] = "�T�l";
         $this->ZipCode[3][238] = "��L";
         $this->ZipCode[3][239] = "�a�q";
         $this->ZipCode[3][241] = "�T��";
         $this->ZipCode[3][242] = "�s��";
         $this->ZipCode[3][243] = "���s";
         $this->ZipCode[3][244] = "�L�f";
         $this->ZipCode[3][247] = "Ī�w";
         $this->ZipCode[3][248] = "����";
         $this->ZipCode[3][249] = "�K��";
         $this->ZipCode[3][251] = "�H��";
         $this->ZipCode[3][252] = "�T��";
         $this->ZipCode[3][253] = "�۪�";
         //�y����
         $this->ZipCode[4][260] = "�y��";
         $this->ZipCode[4][261] = "�Y��";
         $this->ZipCode[4][262] = "�G��";
         $this->ZipCode[4][263] = "����";
         $this->ZipCode[4][264] = "���s";
         $this->ZipCode[4][265] = "ù�F";
         $this->ZipCode[4][266] = "�T�P";
         $this->ZipCode[4][267] = "�j�P";
         $this->ZipCode[4][268] = "����";
         $this->ZipCode[4][269] = "�V�s";
         $this->ZipCode[4][270] = "Ĭ�D";
         $this->ZipCode[4][272] = "�n�D";
         //�s�˥�
         $this->ZipCode[5][300] = "�s�˥�";
         //�s�˿�
         $this->ZipCode[6][302] = "�˥_";
         $this->ZipCode[6][303] = "��f";
         $this->ZipCode[6][304] = "�s��";
         $this->ZipCode[6][305] = "�s�H";
         $this->ZipCode[6][306] = "����";
         $this->ZipCode[6][307] = "�|�L";
         $this->ZipCode[6][308] = "�_�s";
         $this->ZipCode[6][310] = "�˪F";
         $this->ZipCode[6][311] = "���p";
         $this->ZipCode[6][312] = "��s";
         $this->ZipCode[6][313] = "�y��";
         $this->ZipCode[6][314] = "�_�H";
         $this->ZipCode[6][315] = "�o��";
         //��鿤
         $this->ZipCode[7][320] = "���c";
         $this->ZipCode[7][324] = "����";
         $this->ZipCode[7][325] = "�s��";
         $this->ZipCode[7][326] = "����";
         $this->ZipCode[7][327] = "�s��";
         $this->ZipCode[7][328] = "�[��";
         $this->ZipCode[7][330] = "���";
         $this->ZipCode[7][333] = "�t�s";
         $this->ZipCode[7][334] = "�K�w";
         $this->ZipCode[7][335] = "�j��";
         $this->ZipCode[7][336] = "�_��";
         $this->ZipCode[7][337] = "�j��";
         $this->ZipCode[7][338] = "Ī��";
         //�]�߿�
         $this->ZipCode[8][350] = "�˫n";
         $this->ZipCode[8][351] = "�Y��";
         $this->ZipCode[8][352] = "�T�W";
         $this->ZipCode[8][353] = "�n��";
         $this->ZipCode[8][354] = "���";
         $this->ZipCode[8][356] = "���s";
         $this->ZipCode[8][357] = "�q�]";
         $this->ZipCode[8][358] = "�b��";
         $this->ZipCode[8][360] = "�]��";
         $this->ZipCode[8][361] = "�y��";
         $this->ZipCode[8][362] = "�Y��";
         $this->ZipCode[8][363] = "���]";
         $this->ZipCode[8][364] = "�j��";
         $this->ZipCode[8][365] = "���w";
         $this->ZipCode[8][366] = "���r";
         $this->ZipCode[8][367] = "�T�q";
         $this->ZipCode[8][368] = "���";
         $this->ZipCode[8][369] = "����";
         //�x����
         $this->ZipCode[9][400] = "����";
         $this->ZipCode[9][401] = "�F��";
         $this->ZipCode[9][402] = "�n��";
         $this->ZipCode[9][403] = "���";
         $this->ZipCode[9][404] = "�_��";
         $this->ZipCode[9][406] = "�_�ٰ�";
         $this->ZipCode[9][407] = "��ٰ�";
         $this->ZipCode[9][408] = "�n�ٰ�";
         //�x����
         $this->ZipCode[10][411] = "�ӥ�";
         $this->ZipCode[10][412] = "�j��";
         $this->ZipCode[10][413] = "���p";
         $this->ZipCode[10][414] = "�Q��";
         $this->ZipCode[10][420] = "�׭�";
         $this->ZipCode[10][421] = "�Z��";
         $this->ZipCode[10][422] = "�۩�";
         $this->ZipCode[10][423] = "�F��";
         $this->ZipCode[10][424] = "�M��";
         $this->ZipCode[10][426] = "�s��";
         $this->ZipCode[10][427] = "��l";
         $this->ZipCode[10][428] = "�j��";
         $this->ZipCode[10][429] = "����";
         $this->ZipCode[10][432] = "�j�{";
         $this->ZipCode[10][433] = "�F��";
         $this->ZipCode[10][434] = "�s��";
         $this->ZipCode[10][435] = "���";
         $this->ZipCode[10][436] = "�M��";
         $this->ZipCode[10][437] = "�j��";
         $this->ZipCode[10][438] = "�~�H";
         $this->ZipCode[10][439] = "�j�w";
         //���ƿ�
         $this->ZipCode[11][500] = "����";
         $this->ZipCode[11][502] = "���";
         $this->ZipCode[11][503] = "���";
         $this->ZipCode[11][504] = "�q��";
         $this->ZipCode[11][505] = "����";
         $this->ZipCode[11][506] = "�ֿ�";
         $this->ZipCode[11][507] = "�u��";
         $this->ZipCode[11][508] = "�M��";
         $this->ZipCode[11][509] = "����";
         $this->ZipCode[11][510] = "���L";
         $this->ZipCode[11][511] = "���Y";
         $this->ZipCode[11][512] = "�ùt";
         $this->ZipCode[11][513] = "�H��";
         $this->ZipCode[11][514] = "�˴�";
         $this->ZipCode[11][515] = "�j��";
         $this->ZipCode[11][516] = "�H�Q";
         $this->ZipCode[11][520] = "�Ф�";
         $this->ZipCode[11][521] = "�_��";
         $this->ZipCode[11][522] = "�Ч�";
         $this->ZipCode[11][523] = "���Y";
         $this->ZipCode[11][524] = "�ˬw";
         $this->ZipCode[11][525] = "�˶�";
         $this->ZipCode[11][526] = "�G�L";
         $this->ZipCode[11][527] = "�j��";
         $this->ZipCode[11][528] = "�ڭb";
         $this->ZipCode[11][530] = "�G��";
         //�n�뿤
         $this->ZipCode[12][540] = "�n��";
         $this->ZipCode[12][541] = "���d";
         $this->ZipCode[12][542] = "���";
         $this->ZipCode[12][544] = "��m";
         $this->ZipCode[12][545] = "�H��";
         $this->ZipCode[12][546] = "���R";
         $this->ZipCode[12][551] = "�W��";
         $this->ZipCode[12][552] = "����";
         $this->ZipCode[12][553] = "����";
         $this->ZipCode[12][555] = "����";
         $this->ZipCode[12][556] = "�H�q";
         $this->ZipCode[12][557] = "�ˤs";
         $this->ZipCode[12][558] = "����";
         //�Ÿq��
         $this->ZipCode[13][600] = "�Ÿq��";
         //�Ÿq��
         $this->ZipCode[14][602] = "�f��";
         $this->ZipCode[14][603] = "���s";
         $this->ZipCode[14][604] = "�˱T";
         $this->ZipCode[14][605] = "�����s";
         $this->ZipCode[14][606] = "���H";
         $this->ZipCode[14][607] = "�j�H";
         $this->ZipCode[14][608] = "���W";
         $this->ZipCode[14][611] = "����";
         $this->ZipCode[14][612] = "�ӫO";
         $this->ZipCode[14][613] = "���l";
         $this->ZipCode[14][614] = "�F��";
         $this->ZipCode[14][615] = "���}";
         $this->ZipCode[14][616] = "�s��";
         $this->ZipCode[14][621] = "����";
         $this->ZipCode[14][622] = "�j�L";
         $this->ZipCode[14][623] = "�ˤf";
         $this->ZipCode[14][624] = "�q��";
         //���L��
         $this->ZipCode[15][630] = "��n";
         $this->ZipCode[15][631] = "�j��";
         $this->ZipCode[15][632] = "���";
         $this->ZipCode[15][633] = "�g�w";
         $this->ZipCode[15][634] = "�ǩ�";
         $this->ZipCode[15][635] = "�F��";
         $this->ZipCode[15][636] = "�O��";
         $this->ZipCode[15][637] = "�[�I";
         $this->ZipCode[15][638] = "���d";
         $this->ZipCode[15][640] = "�椻";
         $this->ZipCode[15][643] = "�L��";
         $this->ZipCode[15][646] = "�j�|";
         $this->ZipCode[15][647] = "�l��";
         $this->ZipCode[15][648] = "����";
         $this->ZipCode[15][649] = "�G�[";
         $this->ZipCode[15][651] = "�_��";
         $this->ZipCode[15][652] = "���L";
         $this->ZipCode[15][653] = "�f��";
         $this->ZipCode[15][654] = "�|��";
         $this->ZipCode[15][655] = "����";
         //�x�n��
         $this->ZipCode[16][700] = "����";
         $this->ZipCode[16][701] = "�F��";
         $this->ZipCode[16][702] = "�n��";
         $this->ZipCode[16][703] = "���";
         $this->ZipCode[16][704] = "�_��";
         $this->ZipCode[16][708] = "�w����";
         $this->ZipCode[16][709] = "�w�n��";
         //�x�n��
         $this->ZipCode[17][710] = "�ñd";
         $this->ZipCode[17][711] = "�k��";
         $this->ZipCode[17][712] = "�s��";
         $this->ZipCode[17][713] = "����";
         $this->ZipCode[17][714] = "�ɤ�";
         $this->ZipCode[17][715] = "����";
         $this->ZipCode[17][716] = "�n��";
         $this->ZipCode[17][717] = "���w";
         $this->ZipCode[17][718] = "���q";
         $this->ZipCode[17][719] = "�s�T";
         $this->ZipCode[17][720] = "�x��";
         $this->ZipCode[17][721] = "�¨�";
         $this->ZipCode[17][722] = "�Ψ�";
         $this->ZipCode[17][723] = "���";
         $this->ZipCode[17][724] = "�C��";
         $this->ZipCode[17][725] = "�N�x";
         $this->ZipCode[17][726] = "�ǥ�";
         $this->ZipCode[17][727] = "�_��";
         $this->ZipCode[17][730] = "�s��";
         $this->ZipCode[17][731] = "���";
         $this->ZipCode[17][732] = "�ժe";
         $this->ZipCode[17][733] = "�F�s";
         $this->ZipCode[17][734] = "����";
         $this->ZipCode[17][735] = "�U��";
         $this->ZipCode[17][736] = "�h��";
         $this->ZipCode[17][737] = "�Q��";
         $this->ZipCode[17][741] = "����";
         $this->ZipCode[17][742] = "�j��";
         $this->ZipCode[17][743] = "�s�W";
         $this->ZipCode[17][744] = "�s��";
         $this->ZipCode[17][745] = "�w�w";
         //������
         $this->ZipCode[18][800] = "�s����";
         $this->ZipCode[18][801] = "�e����";
         $this->ZipCode[18][802] = "�d����";
         $this->ZipCode[18][803] = "�Q�L��";
         $this->ZipCode[18][804] = "���s��";
         $this->ZipCode[18][805] = "�X�z��";
         $this->ZipCode[18][806] = "�e���";
         $this->ZipCode[18][807] = "�T����";
         $this->ZipCode[18][811] = "�����";
         $this->ZipCode[18][812] = "�p���";
         $this->ZipCode[18][813] = "�����";
         //������
         $this->ZipCode[19][814] = "���Z";
         $this->ZipCode[19][815] = "�j��";
         $this->ZipCode[19][820] = "���s";
         $this->ZipCode[19][821] = "����";
         $this->ZipCode[19][822] = "����";
         $this->ZipCode[19][823] = "�мd";
         $this->ZipCode[19][824] = "�P�_";
         $this->ZipCode[19][825] = "���Y";
         $this->ZipCode[19][826] = "��x";
         $this->ZipCode[19][827] = "����";
         $this->ZipCode[19][828] = "�æw";
         $this->ZipCode[19][829] = "��";
         $this->ZipCode[19][830] = "��s";
         $this->ZipCode[19][831] = "�j�d";
         $this->ZipCode[19][832] = "�L��";
         $this->ZipCode[19][833] = "���Q";
         $this->ZipCode[19][840] = "�j��";
         $this->ZipCode[19][842] = "�X�s";
         $this->ZipCode[19][843] = "���@";
         $this->ZipCode[19][844] = "���t";
         $this->ZipCode[19][845] = "����";
         $this->ZipCode[19][846] = "���L";
         $this->ZipCode[19][847] = "�ҥP";
         $this->ZipCode[19][848] = "�緽";
         $this->ZipCode[19][849] = "�T��";
         $this->ZipCode[19][851] = "�Z�L";
         $this->ZipCode[19][852] = "�X�_";
         //���
         $this->ZipCode[20][880] = "����";
         $this->ZipCode[20][881] = "����";
         $this->ZipCode[20][882] = "��w";
         $this->ZipCode[20][883] = "�C��";
         $this->ZipCode[20][884] = "�ըF";
         $this->ZipCode[20][885] = "���";
         //�̪F��
         $this->ZipCode[21][900] = "�̪F";
         $this->ZipCode[21][901] = "�T�a��";
         $this->ZipCode[21][902] = "���O";
         $this->ZipCode[21][903] = "���a";
         $this->ZipCode[21][904] = "�E�p";
         $this->ZipCode[21][905] = "����";
         $this->ZipCode[21][906] = "����";
         $this->ZipCode[21][907] = "�Q�H";
         $this->ZipCode[21][908] = "���v";
         $this->ZipCode[21][909] = "�ﬥ";
         $this->ZipCode[21][911] = "�˥�";
         $this->ZipCode[21][912] = "���H";
         $this->ZipCode[21][913] = "�U��";
         $this->ZipCode[21][920] = "��{";
         $this->ZipCode[21][921] = "���Z";
         $this->ZipCode[21][922] = "�Ӹq";
         $this->ZipCode[21][923] = "�U�r";
         $this->ZipCode[21][924] = "�r��";
         $this->ZipCode[21][925] = "�s��";
         $this->ZipCode[21][926] = "�n�{";
         $this->ZipCode[21][927] = "�L��";
         $this->ZipCode[21][928] = "�F��";
         $this->ZipCode[21][929] = "�[�y";
         $this->ZipCode[21][931] = "�ΥV";
         $this->ZipCode[21][932] = "�s��";
         $this->ZipCode[21][940] = "�D�d";
         $this->ZipCode[21][941] = "�D�s";
         $this->ZipCode[21][942] = "�K��";
         $this->ZipCode[21][943] = "��l";
         $this->ZipCode[21][944] = "����";
         $this->ZipCode[21][945] = "�d��";
         $this->ZipCode[21][946] = "��K";
         $this->ZipCode[21][947] = "���{";
         //�x�F��
         $this->ZipCode[22][950] = "�x�F";
         $this->ZipCode[22][951] = "��q";
         $this->ZipCode[22][952] = "����";
         $this->ZipCode[22][953] = "����";
         $this->ZipCode[22][954] = "���n";
         $this->ZipCode[22][955] = "����";
         $this->ZipCode[22][956] = "���s";
         $this->ZipCode[22][957] = "����";
         $this->ZipCode[22][958] = "���W";
         $this->ZipCode[22][959] = "�F�e";
         $this->ZipCode[22][961] = "���\\";
         $this->ZipCode[22][962] = "����";
         $this->ZipCode[22][963] = "�ӳ¨�";
         $this->ZipCode[22][964] = "���p";
         $this->ZipCode[22][965] = "�j�Z";
         $this->ZipCode[22][966] = "�F��";
         //�Ὤ��
         $this->ZipCode[23][970] = "�Ὤ";
         $this->ZipCode[23][971] = "�s��";
         $this->ZipCode[23][972] = "�N�w";
         $this->ZipCode[23][974] = "����";
         $this->ZipCode[23][975] = "��L";
         $this->ZipCode[23][976] = "���_";
         $this->ZipCode[23][977] = "����";
         $this->ZipCode[23][978] = "���J";
         $this->ZipCode[23][979] = "�U�a";
         $this->ZipCode[23][981] = "�ɨ�";
         $this->ZipCode[23][982] = "����";
         $this->ZipCode[23][983] = "�I��";
         //������
         $this->ZipCode[24][890] = "���F";
         $this->ZipCode[24][891] = "����";
         $this->ZipCode[24][892] = "����";
         $this->ZipCode[24][893] = "����";
         $this->ZipCode[24][894] = "�P��";
         $this->ZipCode[24][896] = "�Q��";
         //�s����
         $this->ZipCode[25][209] = "�n��";
         $this->ZipCode[25][210] = "�_��";
         $this->ZipCode[25][211] = "����";
         $this->ZipCode[25][212] = "�F��";
         $this->ZipCode[27][999] = "��L";

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

?>
