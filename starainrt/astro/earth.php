<?php
namespace Starainrt\Astro;
class Earth{
    private function SinR($du)
    {
        $du = $du/180*M_PI;
        return sin($du);
    }
    private function CosR($du)
    {
        $du = $du/180*M_PI;
        return cos($du);
    }
    private function TanR($du)
    {
        $du = $du/180*M_PI;
        return tan($du);
    }
    private function ArcSin($X,$models=0){
        $tmp =asin($X);
        if($models==1)
            $tmp= $tmp / M_PI * 180;
	return $tmp;
    }
    private function ArcCos($X,$models=0){
        $tmp =acos($X);
        if($models==1)
            $tmp= $tmp / M_PI * 180;
	return $tmp;
    }
    private function ArcTan($X,$models=0){
        $tmp =atan($X);
        if($models==1)
            $tmp= $tmp / M_PI * 180;
            return $tmp;
    }
    private function Limit360($deg)
    {
        while($deg>360)
            $deg-=360;
        while($deg<0)
            $deg+=360;
        return $deg;
    }
    /*
     * @黄赤交角、nutation==true时，计算交角章动
     */
   public function EclipticObliquity($jde,$nutation=true)
   {
       $U = ($jde - 2451545) / 3652500;
       $sita = 23 + 26 / 60 + 21.448 / 3600 - ((4680.93 * $U - 1.55 * $U* $U + 1999.25 * $U * $U* $U - 51.38 * $U  * $U* $U * $U- 249.67 * $U  * $U* $U * $U* $U - 39.05 * $U* $U * $U* $U * $U* $U+ 7.12 * $U * $U* $U * $U* $U * $U* $U+ 27.87  * $U* $U * $U* $U * $U* $U * $U* $U + 5.79  * $U* $U * $U* $U * $U* $U * $U* $U * $U + 2.45 * $U* $U * $U* $U * $U* $U * $U* $U * $U* $U) / 3600);
	if($nutation)
		return $sita+$this->JJZD($jde);
	else
		return $sita;
   }
   public function sita($jde,$nutation=true)
   {
       return $this->EclipticObliquity($jde,$nutation);
   }
   /*
    * @name 黄经章动
    */
   public function HJZD($JD) // '黄经章动
    {
        // Dim p As Double, T As Double, Lmoon As Double
        $T = ($JD - 2451545) / 36525;
        $moon=new Moon();
	$D=297.8502042+445267.1115168*$T-0.0016300*$T*$T+$T*$T*$T/545868-$T*$T*$T*$T/113065000;
	$M = $this->sunM($JD);
	$N = $moon->MoonM($JD);
	$F = $moon->MoonLonX($JD);
	$O= 125.04452 - 1934.136261*$T + 0.0020708*$T*$T + $T*$T*$T/450000;
	//die($T." ".$D." ".$M." ".$N." ".$F." ".$O);
	$tp[1][1]=0;$tp[1][2]=0;$tp[1][3]=0;$tp[1][4]=0;$tp[1][5]=1;$tp[1][6]=-171996;$tp[1][7]=-174.2*$T;
        $tp[2][1]=-2;$tp[2][2]=0;$tp[2][3]=0;$tp[2][4]=2;$tp[2][5]=2;$tp[2][6]=-13187;$tp[2][7]=-1.6*$T;
        $tp[3][1]=0;$tp[3][2]=0;$tp[3][3]=0;$tp[3][4]=2;$tp[3][5]=2;$tp[3][6]=-2274;$tp[3][7]=-0.2*$T;
        $tp[4][1]=0;$tp[4][2]=0;$tp[4][3]=0;$tp[4][4]=0;$tp[4][5]=2;$tp[4][6]=2062;$tp[4][7]=0.2*$T;
        $tp[5][1]=0;$tp[5][2]=1;$tp[5][3]=0;$tp[5][4]=0;$tp[5][5]=0;$tp[5][6]=1426;$tp[5][7]=-3.4*$T;
        $tp[6][1]=0;$tp[6][2]=0;$tp[6][3]=1;$tp[6][4]=0;$tp[6][5]=0;$tp[6][6]=712;$tp[6][7]=0.1*$T;
        $tp[7][1]=-2;$tp[7][2]=1;$tp[7][3]=0;$tp[7][4]=2;$tp[7][5]=2;$tp[7][6]=-517;$tp[7][7]=1.2*$T;
        $tp[8][1]=0;$tp[8][2]=0;$tp[8][3]=0;$tp[8][4]=2;$tp[8][5]=1;$tp[8][6]=-386;$tp[8][7]=-0.4*$T;
        $tp[9][1]=0;$tp[9][2]=0;$tp[9][3]=1;$tp[9][4]=2;$tp[9][5]=2;$tp[9][6]=-301;$tp[9][7]=0;
        $tp[10][1]=-2;$tp[10][2]=-1;$tp[10][3]=0;$tp[10][4]=2;$tp[10][5]=2;$tp[10][6]=217;$tp[10][7]=-0.5*$T;
        $tp[11][1]=-2;$tp[11][2]=0;$tp[11][3]=1;$tp[11][4]=0;$tp[11][5]=0;$tp[11][6]=-158;$tp[11][7]=0;
        $tp[12][1]=-2;$tp[12][2]=0;$tp[12][3]=0;$tp[12][4]=2;$tp[12][5]=1;$tp[12][6]=129;$tp[12][7]=0.1*$T;
        $tp[13][1]=0;$tp[13][2]=0;$tp[13][3]=-1;$tp[13][4]=2;$tp[13][5]=2;$tp[13][6]=123;$tp[13][7]=0;
        $tp[14][1]=2;$tp[14][2]=0;$tp[14][3]=0;$tp[14][4]=0;$tp[14][5]=0;$tp[14][6]=63;$tp[14][7]=0;
        $tp[15][1]=0;$tp[15][2]=0;$tp[15][3]=1;$tp[15][4]=0;$tp[15][5]=1;$tp[15][6]=63;$tp[15][7]=0.1*$T;
        $tp[16][1]=2;$tp[16][2]=0;$tp[16][3]=-1;$tp[16][4]=2;$tp[16][5]=2;$tp[16][6]=-59;$tp[16][7]=0;
        $tp[17][1]=0;$tp[17][2]=0;$tp[17][3]=-1;$tp[17][4]=0;$tp[17][5]=1;$tp[17][6]=-58;$tp[17][7]=-0.1*$T;
        $tp[18][1]=0;$tp[18][2]=0;$tp[18][3]=1;$tp[18][4]=2;$tp[18][5]=1;$tp[18][6]=-51;$tp[18][7]=0;
        $tp[19][1]=-2;$tp[19][2]=0;$tp[19][3]=2;$tp[19][4]=0;$tp[19][5]=0;$tp[19][6]=48;$tp[19][7]=0;
        $tp[20][1]=0;$tp[20][2]=0;$tp[20][3]=-2;$tp[20][4]=2;$tp[20][5]=1;$tp[20][6]=46;$tp[20][7]=0;
        $tp[21][1]=2;$tp[21][2]=0;$tp[21][3]=0;$tp[21][4]=2;$tp[21][5]=2;$tp[21][6]=-38;$tp[21][7]=0;
        $tp[22][1]=0;$tp[22][2]=0;$tp[22][3]=2;$tp[22][4]=2;$tp[22][5]=2;$tp[22][6]=-31;$tp[22][7]=0;
        $tp[23][1]=0;$tp[23][2]=0;$tp[23][3]=2;$tp[23][4]=0;$tp[23][5]=0;$tp[23][6]=29;$tp[23][7]=0;
        $tp[24][1]=-2;$tp[24][2]=0;$tp[24][3]=1;$tp[24][4]=2;$tp[24][5]=2;$tp[24][6]=29;$tp[24][7]=0;
        $tp[25][1]=0;$tp[25][2]=0;$tp[25][3]=0;$tp[25][4]=2;$tp[25][5]=0;$tp[25][6]=26;$tp[25][7]=0;
        $tp[26][1]=-2;$tp[26][2]=0;$tp[26][3]=0;$tp[26][4]=2;$tp[26][5]=0;$tp[26][6]=-22;$tp[26][7]=0;
        $tp[27][1]=0;$tp[27][2]=0;$tp[27][3]=-1;$tp[27][4]=2;$tp[27][5]=1;$tp[27][6]=21;$tp[27][7]=0;
        $tp[28][1]=0;$tp[28][2]=2;$tp[28][3]=0;$tp[28][4]=0;$tp[28][5]=0;$tp[28][6]=17;$tp[28][7]=-0.1*$T;
        $tp[29][1]=2;$tp[29][2]=0;$tp[29][3]=-1;$tp[29][4]=0;$tp[29][5]=1;$tp[29][6]=16;$tp[29][7]=0;
        $tp[30][1]=-2;$tp[30][2]=2;$tp[30][3]=0;$tp[30][4]=2;$tp[30][5]=2;$tp[30][6]=-16;$tp[30][7]=0.1*$T;
        $tp[31][1]=0;$tp[31][2]=1;$tp[31][3]=0;$tp[31][4]=0;$tp[31][5]=1;$tp[31][6]=-15;$tp[31][7]=0;
        $tp[32][1]=-2;$tp[32][2]=0;$tp[32][3]=1;$tp[32][4]=0;$tp[32][5]=1;$tp[32][6]=-13;$tp[32][7]=0;
        $tp[33][1]=0;$tp[33][2]=-1;$tp[33][3]=0;$tp[33][4]=0;$tp[33][5]=1;$tp[33][6]=-12;$tp[33][7]=0;
        $tp[34][1]=0;$tp[34][2]=0;$tp[34][3]=2;$tp[34][4]=-2;$tp[34][5]=0;$tp[34][6]=11;$tp[34][7]=0;
        $tp[35][1]=2;$tp[35][2]=0;$tp[35][3]=-1;$tp[35][4]=2;$tp[35][5]=1;$tp[35][6]=-10;$tp[35][7]=0;
        $tp[36][1]=2;$tp[36][2]=0;$tp[36][3]=1;$tp[36][4]=2;$tp[36][5]=2;$tp[36][6]=-8;$tp[36][7]=0;
        $tp[37][1]=0;$tp[37][2]=1;$tp[37][3]=0;$tp[37][4]=2;$tp[37][5]=2;$tp[37][6]=7;$tp[37][7]=0;
        $tp[38][1]=-2;$tp[38][2]=1;$tp[38][3]=1;$tp[38][4]=0;$tp[38][5]=0;$tp[38][6]=-7;$tp[38][7]=0;
        $tp[39][1]=0;$tp[39][2]=-1;$tp[39][3]=0;$tp[39][4]=2;$tp[39][5]=2;$tp[39][6]=-7;$tp[39][7]=0;
        $tp[40][1]=2;$tp[40][2]=0;$tp[40][3]=0;$tp[40][4]=2;$tp[40][5]=1;$tp[40][6]=-7;$tp[40][7]=0;
        $tp[41][1]=2;$tp[41][2]=0;$tp[41][3]=1;$tp[41][4]=0;$tp[41][5]=0;$tp[41][6]=6;$tp[41][7]=0;
        $tp[42][1]=-2;$tp[42][2]=0;$tp[42][3]=2;$tp[42][4]=2;$tp[42][5]=2;$tp[42][6]=6;$tp[42][7]=0;
        $tp[43][1]=-2;$tp[43][2]=0;$tp[43][3]=1;$tp[43][4]=2;$tp[43][5]=1;$tp[43][6]=6;$tp[43][7]=0;
        $tp[44][1]=2;$tp[44][2]=0;$tp[44][3]=-2;$tp[44][4]=0;$tp[44][5]=1;$tp[44][6]=-6;$tp[44][7]=0;
        $tp[45][1]=2;$tp[45][2]=0;$tp[45][3]=0;$tp[45][4]=0;$tp[45][5]=1;$tp[45][6]=-6;$tp[45][7]=0;
        $tp[46][1]=0;$tp[46][2]=-1;$tp[46][3]=1;$tp[46][4]=0;$tp[46][5]=0;$tp[46][6]=5;$tp[46][7]=0;
        $tp[47][1]=-2;$tp[47][2]=-1;$tp[47][3]=0;$tp[47][4]=2;$tp[47][5]=1;$tp[47][6]=-5;$tp[47][7]=0;
        $tp[48][1]=-2;$tp[48][2]=0;$tp[48][3]=0;$tp[48][4]=0;$tp[48][5]=1;$tp[48][6]=-5;$tp[48][7]=0;
        $tp[49][1]=0;$tp[49][2]=0;$tp[49][3]=2;$tp[49][4]=2;$tp[49][5]=1;$tp[49][6]=-5;$tp[49][7]=0;
        $tp[50][1]=-2;$tp[50][2]=0;$tp[50][3]=2;$tp[50][4]=0;$tp[50][5]=1;$tp[50][6]=4;$tp[50][7]=0;
        $tp[51][1]=-2;$tp[51][2]=1;$tp[51][3]=0;$tp[51][4]=2;$tp[51][5]=1;$tp[51][6]=4;$tp[51][7]=0;
        $tp[52][1]=0;$tp[52][2]=0;$tp[52][3]=1;$tp[52][4]=-2;$tp[52][5]=0;$tp[52][6]=4;$tp[52][7]=0;
        $tp[53][1]=-1;$tp[53][2]=0;$tp[53][3]=1;$tp[53][4]=0;$tp[53][5]=0;$tp[53][6]=-4;$tp[53][7]=0;
        $tp[54][1]=-2;$tp[54][2]=1;$tp[54][3]=0;$tp[54][4]=0;$tp[54][5]=0;$tp[54][6]=-4;$tp[54][7]=0;
        $tp[55][1]=1;$tp[55][2]=0;$tp[55][3]=0;$tp[55][4]=0;$tp[55][5]=0;$tp[55][6]=-4;$tp[55][7]=0;
        $tp[56][1]=0;$tp[56][2]=0;$tp[56][3]=1;$tp[56][4]=2;$tp[56][5]=0;$tp[56][6]=3;$tp[56][7]=0;
        $tp[57][1]=0;$tp[57][2]=0;$tp[57][3]=-2;$tp[57][4]=2;$tp[57][5]=2;$tp[57][6]=-3;$tp[57][7]=0;
        $tp[58][1]=-1;$tp[58][2]=-1;$tp[58][3]=1;$tp[58][4]=0;$tp[58][5]=0;$tp[58][6]=-3;$tp[58][7]=0;
        $tp[59][1]=0;$tp[59][2]=1;$tp[59][3]=1;$tp[59][4]=0;$tp[59][5]=0;$tp[59][6]=-3;$tp[59][7]=0;
        $tp[60][1]=0;$tp[60][2]=-1;$tp[60][3]=1;$tp[60][4]=2;$tp[60][5]=2;$tp[60][6]=-3;$tp[60][7]=0;
        $tp[61][1]=2;$tp[61][2]=-1;$tp[61][3]=-1;$tp[61][4]=2;$tp[61][5]=2;$tp[61][6]=-3;$tp[61][7]=0;
        $tp[62][1]=0;$tp[62][2]=0;$tp[62][3]=3;$tp[62][4]=2;$tp[62][5]=2;$tp[62][6]=-3;$tp[62][7]=0;
        $tp[63][1]=2;$tp[63][2]=-1;$tp[63][3]=0;$tp[63][4]=2;$tp[63][5]=2;$tp[63][6]=-3;$tp[63][7]=0;
	$S=0;
	for($i=1;$i<64;$i++)
	{
		$S+=($tp[$i][6]+$tp[$i][7])*SinR($D*$tp[$i][1]+$M*$tp[$i][2]+$N*$tp[$i][3]+$F*$tp[$i][4]+$O*$tp[$i][5]);
	}
	//$P=-17.20*SinR($O)-1.32*SinR(2*280.4665 + 36000.7698*$T)-0.23*SinR(2*218.3165 + 481267.8813*$T )+0.21*SinR(2*$O);
	//return $P/3600;
	return ($S/10000)/3600 ;
    }
    /*
     * 交角章动
     */
    public function JJZD($JD)  //交角章动
    {
	$T = ($JD - 2451545) / 36525;
	//$D = 297.85036 +455267.111480*$T - 0.0019142*$T*$T+ $T*$T*$T/189474;
	//$M = 357.52772 + 35999.050340*$T - 0.0001603*$T*$T- $T*$T*$T/300000;
	//$N= 134.96298 + 477198.867398*$T + 0.0086972*$T*$T + $T*$T*$T/56250;
	//$F = 93.27191 + 483202.017538*$T - 0.0036825*$T*$T + $T*$T*$T/327270;
	$D=297.8502042+445267.1115168*$T-0.0016300*$T*$T+$T*$T*$T/545868-$T*$T*$T*$T/113065000;
	$M = $this->sunM($JD);
        $moon=new Moon();
	$N =$moon-> MoonM($JD);
	$F = $moon->MoonLonX($JD);
	$O= 125.04452 - 1934.136261*$T + 0.0020708*$T*$T + $T*$T*$T/450000;
	
	$tp[1][1]=0;$tp[1][2]=0;$tp[1][3]=0;$tp[1][4]=0;$tp[1][5]=1;$tp[1][6]=92025;$tp[1][7]=8.9*$T;
        $tp[2][1]=-2;$tp[2][2]=0;$tp[2][3]=0;$tp[2][4]=2;$tp[2][5]=2;$tp[2][6]=5736;$tp[2][7]=-3.1*$T;
        $tp[3][1]=0;$tp[3][2]=0;$tp[3][3]=0;$tp[3][4]=2;$tp[3][5]=2;$tp[3][6]=977;$tp[3][7]=-0.5*$T;
        $tp[4][1]=0;$tp[4][2]=0;$tp[4][3]=0;$tp[4][4]=0;$tp[4][5]=2;$tp[4][6]=-895;$tp[4][7]=0.5*$T;
        $tp[5][1]=0;$tp[5][2]=1;$tp[5][3]=0;$tp[5][4]=0;$tp[5][5]=0;$tp[5][6]=54;$tp[5][7]=-0.1*$T;
        $tp[6][1]=0;$tp[6][2]=0;$tp[6][3]=1;$tp[6][4]=0;$tp[6][5]=0;$tp[6][6]=-7;$tp[6][7]=0;
        $tp[7][1]=-2;$tp[7][2]=1;$tp[7][3]=0;$tp[7][4]=2;$tp[7][5]=2;$tp[7][6]=224;$tp[7][7]=-0.6*$T;
        $tp[8][1]=0;$tp[8][2]=0;$tp[8][3]=0;$tp[8][4]=2;$tp[8][5]=1;$tp[8][6]=200;$tp[8][7]=0;
        $tp[9][1]=0;$tp[9][2]=0;$tp[9][3]=1;$tp[9][4]=2;$tp[9][5]=2;$tp[9][6]=129;$tp[9][7]=-0.1*$T;
        $tp[10][1]=-2;$tp[10][2]=-1;$tp[10][3]=0;$tp[10][4]=2;$tp[10][5]=2;$tp[10][6]=-95;$tp[10][7]=0.3*$T;
        $tp[11][1]=-2;$tp[11][2]=0;$tp[11][3]=0;$tp[11][4]=2;$tp[11][5]=1;$tp[11][6]=-70;$tp[11][7]=0;
        $tp[12][1]=0;$tp[12][2]=0;$tp[12][3]=-1;$tp[12][4]=2;$tp[12][5]=2;$tp[12][6]=-53;$tp[12][7]=0;
        $tp[13][1]=2;$tp[13][2]=0;$tp[13][3]=0;$tp[13][4]=0;$tp[13][5]=0;$tp[13][6]=63;$tp[13][7]=0;
        $tp[14][1]=0;$tp[14][2]=0;$tp[14][3]=1;$tp[14][4]=0;$tp[14][5]=1;$tp[14][6]=-33;$tp[14][7]=0;
        $tp[15][1]=2;$tp[15][2]=0;$tp[15][3]=-1;$tp[15][4]=2;$tp[15][5]=2;$tp[15][6]=26;$tp[15][7]=0;
        $tp[16][1]=0;$tp[16][2]=0;$tp[16][3]=-1;$tp[16][4]=0;$tp[16][5]=1;$tp[16][6]=32;$tp[16][7]=0;
        $tp[17][1]=0;$tp[17][2]=0;$tp[17][3]=1;$tp[17][4]=2;$tp[17][5]=1;$tp[17][6]=27;$tp[17][7]=0;
        $tp[18][1]=0;$tp[18][2]=0;$tp[18][3]=-2;$tp[18][4]=2;$tp[18][5]=1;$tp[18][6]=-24;$tp[18][7]=0;
        $tp[19][1]=2;$tp[19][2]=0;$tp[19][3]=0;$tp[19][4]=2;$tp[19][5]=2;$tp[19][6]=16;$tp[19][7]=0;
        $tp[20][1]=0;$tp[20][2]=0;$tp[20][3]=2;$tp[20][4]=2;$tp[20][5]=2;$tp[20][6]=13;$tp[20][7]=0;
        $tp[21][1]=-2;$tp[21][2]=0;$tp[21][3]=1;$tp[21][4]=2;$tp[21][5]=2;$tp[21][6]=-12;$tp[21][7]=0;
        $tp[22][1]=0;$tp[22][2]=0;$tp[22][3]=-1;$tp[22][4]=2;$tp[22][5]=1;$tp[22][6]=-10;$tp[22][7]=0;
        $tp[23][1]=2;$tp[23][2]=0;$tp[23][3]=-1;$tp[23][4]=0;$tp[23][5]=1;$tp[23][6]=-8;$tp[23][7]=0;
        $tp[24][1]=-2;$tp[24][2]=2;$tp[24][3]=0;$tp[24][4]=2;$tp[24][5]=2;$tp[24][6]=7;$tp[24][7]=0;
        $tp[25][1]=0;$tp[25][2]=1;$tp[25][3]=0;$tp[25][4]=0;$tp[25][5]=1;$tp[25][6]=9;$tp[25][7]=0;
        $tp[26][1]=-2;$tp[26][2]=0;$tp[26][3]=1;$tp[26][4]=0;$tp[26][5]=1;$tp[26][6]=7;$tp[26][7]=0;
        $tp[27][1]=0;$tp[27][2]=-1;$tp[27][3]=0;$tp[27][4]=0;$tp[27][5]=1;$tp[27][6]=6;$tp[27][7]=0;
        $tp[28][1]=2;$tp[28][2]=0;$tp[28][3]=-1;$tp[28][4]=2;$tp[28][5]=1;$tp[28][6]=5;$tp[28][7]=0;
        $tp[29][1]=2;$tp[29][2]=0;$tp[29][3]=1;$tp[29][4]=2;$tp[29][5]=2;$tp[29][6]=3;$tp[29][7]=0;
        $tp[30][1]=0;$tp[30][2]=1;$tp[30][3]=0;$tp[30][4]=2;$tp[30][5]=2;$tp[30][6]=-3;$tp[30][7]=0;
        $tp[31][1]=0;$tp[31][2]=-1;$tp[31][3]=0;$tp[31][4]=2;$tp[31][5]=2;$tp[31][6]=3;$tp[31][7]=0;
        $tp[32][1]=2;$tp[32][2]=0;$tp[32][3]=0;$tp[32][4]=2;$tp[32][5]=1;$tp[32][6]=3;$tp[32][7]=0;
        $tp[33][1]=-2;$tp[33][2]=0;$tp[33][3]=2;$tp[33][4]=2;$tp[33][5]=2;$tp[33][6]=-3;$tp[33][7]=0;
        $tp[34][1]=-2;$tp[34][2]=0;$tp[34][3]=1;$tp[34][4]=2;$tp[34][5]=1;$tp[34][6]=-3;$tp[34][7]=0;
        $tp[35][1]=2;$tp[35][2]=0;$tp[35][3]=-2;$tp[35][4]=0;$tp[35][5]=1;$tp[35][6]=3;$tp[35][7]=0;
        $tp[36][1]=2;$tp[36][2]=0;$tp[36][3]=0;$tp[36][4]=0;$tp[36][5]=1;$tp[36][6]=3;$tp[36][7]=0;
        $tp[37][1]=-2;$tp[37][2]=-1;$tp[37][3]=0;$tp[37][4]=2;$tp[37][5]=1;$tp[37][6]=3;$tp[37][7]=0;
        $tp[38][1]=-2;$tp[38][2]=0;$tp[38][3]=0;$tp[38][4]=0;$tp[38][5]=1;$tp[38][6]=3;$tp[38][7]=0;
        $tp[39][1]=0;$tp[39][2]=0;$tp[39][3]=2;$tp[39][4]=2;$tp[39][5]=1;$tp[39][6]=3;$tp[39][7]=0;
        $S=0;
	for($i=1;$i<40;$i++)
	{
		$S+=($tp[$i][6]+$tp[$i][7])*CosR($D*$tp[$i][1]+$M*$tp[$i][2]+$N*$tp[$i][3]+$F*$tp[$i][4]+$O*$tp[$i][5]);
	}
	//die($S/10000);
	return $S/10000/3600 ;
    }
    /*
     @name 太阳几何黄经
     */
    public function SunLo($jd) {
        $T = ($jd - 2451545) / 365250;
        $SunLo = 280.4664567 + 360007.6982779 * $T + 0.03032028 * $T * $T + $T * $T * $T / 49931 - $T * $T * $T * $T / 15299 - $T * $T * $T * $T * $T / 1988000;
        While ($SunLo > 360){
            $SunLo = $SunLo - 360;
        }
        While ($SunLo < 0){
            $SunLo = $SunLo + 360;
	 }
        return ($SunLo);
    }
    /*
     @name 太阳平近点角
     */
    public function sunM($JD) //太阳平近点角
    {
        $T = ($JD - 2451545) / 36525;
        $sunM = 357.5291092 + 35999.0502909 * $T - 0.0001559 * $T * $T - 0.00000048 * $T * $T * $T;
        While ($sunM > 360)
            $sunM = $sunM - 360;
        While ($sunM < 0)
            $sunM = $sunM + 360;
            return $sunM;
    }
    /*
     @name 地球偏心率
     */
    public function Earthe($JD) //'地球偏心率
    {
        $T = ($JD - 2451545) / 36525;
        $Earthe = 0.016708617 - 0.000042037 * $T - 0.0000001236 * $T * $T;
	return $Earthe;
    }
    public  function EarthPI($JD) //近日點經度
    {	
	$T = ($JD - 2451545) / 36525;
	return 102.93735 + 1.71953*$T + 000046*$T*$T;
    }
    public function SunMidFun($JD)//'太阳中间方程
    {
        $T = ($JD - 2451545) / 36525;
        $M = $this->sunM($JD);
        $SunMidFun = (1.9146 - 0.004817 * $T - 0.000014 * $T * $T) * $this->SinR($M) + (0.019993 - 0.000101 * $T) * $this->SinR(2 * $M) + 0.00029 * $this->SinR(3 * $M);
	return $SunMidFun;
    }
    public function SunTrueLo($JD)// '太阳真黄经
    {
        $SunTrueLo = $this->SunLo($JD) + $this->SunMidFun($JD);
	return $SunTrueLo ;
    }
    public function SunSeeLo($JD)//'太阳视黄经
    {
        $T = ($JD - 2451545) / 36525;
        $SunSeeLo = $this->SunTrueLo($JD) - 0.00569 - 0.00478 * $this->SinR(125.04 - 1934.136 * $T);
	return $SunSeeLo;
    }
    public function SunSeeRa($JD )// '太阳视赤经
    {
        $T = ($JD - 2451545) / 36525;
        $sitas = $this->sita($JD) + 0.00256 * $this->CosR(125.04 - 1934.136 * $T);
        $SunSeeRa = $this->ArcTan(CosR($sitas) * SinR(SunSeeLo($JD)) / CosR(SunSeeLo($JD)), 1);
        $tmp=$this->SunSeeLo($JD);
	if($tmp>=90 && $tmp<180)
            $SunSeeRa = 180 + $SunSeeRa;
        elseif($tmp>=180 && $tmp<270)
            $SunSeeRa = 180 + $SunSeeRa;
        elseif($tmp>=270 && $tmp<=360)
            $SunSeeRa = 360 + $SunSeeRa;
	return $SunSeeRa;
    }

    public function SunTrueRa($JD)  //'太阳真赤经
    {
        $sitas = $this->sita($JD);
        $SunTrueRa = $this->ArcTan(CosR($sitas) * SinR(SunTrueLo($JD)) / CosR(SunTrueLo($JD)), 1);
        //Select Case SunTrueLo(JD)
	$tmp=$this->SunTrueLo($JD);
	if($tmp>=90 && $tmp<180)
            $SunTrueRa = 180 + $SunTrueRa;
        elseif($tmp>=180 && $tmp<270)
            $SunTrueRa = 180 + $SunTrueRa;
        elseif($tmp>=270 && $tmp<=360)
            $SunTrueRa = 360 + $SunTrueRa;
	return $SunTrueRa;
    }

    public function SunSeeDec($JD)// '太阳视赤纬
    {
        $T = ($JD - 2451545) / 36525;
        $sitas = $this->sita($JD) + 0.00256 * $this->CosR(125.04 - 1934.136 * $T);
        $SunSeeDec = $this->ArcSin($this->SinR($sitas) * $this->SinR(SunSeeLo($JD)), 1);
	return $SunSeeDec;
    }
    public function SunTrueDec($JD)// '太阳真赤纬
    {
        $sitas = $this->sita($JD);
        $SunTrueDec = $this->ArcSin(SinR($sitas) * $this->SinR(SunTrueLo($JD)), 1);
	return $SunTrueDec;
    }
    public function SunTime($JD) //均时差
    {
	$tm=($this->SunLo($JD)-0.0057183-($this->HSunSeeRa($JD))+($this->HJZD($JD))*cos($this->sita($JD)))/15;
	if($tm>23) $tm=-24+$tm;
	return $tm;
    }
    public function TrueStarTime($JD) //视恒星时
    {
	$T = ($JD - 2451545) / 36525;
	return ($this->Limit360(280.46061837 + 360.98564736629*($JD-2451545.0) + 0.000387933*$T*$T - $T*$T*$T/38710000)/15);
    }
    public function SeeStarTime($JD) //平恒星时
    {
	$tmp=$this->TrueStarTime($JD);
	return $tmp+$this->HJZD($JD)*cos($this->sita($JD))/15;
    }
    public function SunSC($Lo,$JD) //黄道上的岁差，仅黄纬=0时
    {
	$t = ($JD - 2451545) / 36525;
	$n = 47.0029/3600 *$t -0.03302/3600*$t*$t +0.000060/3600*$t*$t*$t;
        $m = 174.876384/3600-869.8089/3600*$t +0.03536/3600*$t*$t;
        $pk = 5029.0966/3600.00*$t+1.11113/3600.00 *$t*$t -0.000006/3600.00*$t*$t*$t;
	$A= $this->CosR($n)*$this->SinR($m-$Lo);
	$B= $this->CosR($m-$Lo);
	return $Lo+$pk;
    }
    /*
     * 中间变量
     */
    public function EarthL($JD)
    {
	$t=($JD - 2451545) / 365250;
	$L0=$this->Earth_L0($t);
	$L1=$this->Earth_L1($t);
	$L2=$this->Earth_L2($t);
	$L3=$this->Earth_L3($t);
	$L4=$this->Earth_L4($t);
	$L5=$this->Earth_L5($t);
	$L = $L0+$L1+$L2+$L3+$L4+$L5;
	return $this->Limit360($L*180/M_PI);
    }
    public function EarthB($JD)
    {
	$t=($JD - 2451545) / 365250;
	$B0=$this->Earth_B0($t);
	$B1=$this->Earth_B1($t);
	$B2=$this->Earth_B2($t);
	$B3=$this->Earth_B3($t);
	$B4=$this->Earth_B4($t);
	//$B5=Earth_B5($t);
	$B= $B0+$B1+$B2+$B3+$B4;
	return $B*180/M_PI;
    }
    public function EarthR($JD)
    {
	$t=($JD - 2451545) / 365250;
	$R0=$this->Earth_R0($t);
	$R1=$this->Earth_R1($t);
	$R2=$this->Earth_R2($t);
	$R3=$this->Earth_R3($t);
	$R4=$this->Earth_R4($t);
	$R5=$this->Earth_R5($t);
	$R = $R0+$R1+$R2+$R3+$R4+$R5;
	return $R;
    }
    public function HSunTrueLo($JD)
    {
	//$JD=2448908.5;
	$t=($JD - 2451545) / 365250;
	$L0=$this->Earth_L0($t);
	$L1=$this->Earth_L1($t);
	$L2=$this->Earth_L2($t);
	$L3=$this->Earth_L3($t);
	$L4=$this->Earth_L4($t);
	$L5=$this->Earth_L5($t);
	$L = $L0+$L1+$L2+$L3+$L4+$L5;
	//$B=Earth_B4($t)+Earth_B3($t)+Earth_B2($t)+Earth_B1($t)+Earth_B0($t);
	$L=$this->Limit360($L*180/M_PI);
	$L=$this->Limit360($L+180);
	return $L;
    }
    public function HSunSeeLo($JD)
    {
	$t=($JD - 2451545) / 365250;
	$L=$this->HSunTrueLo($JD);
	$R=$this->Earth_R5($t)+$this->Earth_R4($t)+$this->Earth_R3($t)+$this->Earth_R2($t)+$this->Earth_R1($t)+$this->Earth_R0($t);
	$L=$L+$this->HJZD($JD)-20.4898/$R/3600;
	return $L;
    }
    public function EarthAway($JD)
    {
	$t=($JD - 2451545) / 365250;
	$R=$this->Earth_R5($t)+$this->Earth_R4($t)+$this->Earth_R3($t)+$this->Earth_R2($t)+$this->Earth_R1($t)+$this->Earth_R0($t);
	return $R;
    }
    public function HSunSeeRa($JD )// '太阳视赤经
    {
        $T = ($JD - 2451545) / 36525;
        $sitas = $this->sita($JD) + 0.00256 * $this->CosR(125.04 - 1934.136 * $T);
        $HSunSeeRa = $this->ArcTan($this->CosR($sitas) * $this->SinR($this->HSunSeeLo($JD)) / $this->CosR(HSunSeeLo($JD)), 1);
        $tmp=$this->HSunSeeLo($JD);
	if($tmp>=90 && $tmp<180)
            $HSunSeeRa = 180 + $HSunSeeRa;
        elseif($tmp>=180 && $tmp<270)
            $HSunSeeRa = 180 + $HSunSeeRa;
        elseif($tmp>=270 && $tmp<=360)
            $HSunSeeRa = 360 + $HSunSeeRa;
	return $HSunSeeRa;
    }

    public function HSunTrueRa($JD)  //'太阳真赤经
    {
        $sitas = $this->sita($JD);
        $HSunTrueRa = $this->ArcTan($this->CosR($sitas) * $this->SinR($this->HSunTrueLo($JD)) / $this->CosR($this->HSunTrueLo($JD)), 1);
        //Select Case SunTrueLo(JD)
        $tmp=$this->HSunTrueLo($JD);
        if($tmp>=90 && $tmp<180)
            $HSunTrueRa = 180 + $HSunTrueRa;
        elseif($tmp>=180 && $tmp<270)
            $HSunTrueRa = 180 + $HSunTrueRa;
        elseif($tmp>=270 && $tmp<=360)
            $HSunTrueRa = 360 + $HSunTrueRa;
	return $HSunTrueRa;
    }

    public Function HSunSeeDec($JD)// '太阳视赤纬
    {
        $T = ($JD - 2451545) / 36525;
        $sitas = $this->sita($JD,false) + 0.00256 * $this->CosR(125.04 - 1934.136 * $T);
        $HSunSeeDec = $this->ArcSin($this->SinR($sitas) * $this->SinR($this->HSunSeeLo($JD)), 1);
	return $HSunSeeDec;
    }
    public function HSunTrueDec($JD)// '太阳真赤纬
    {
        $sitas = $this->sita($JD,false);
        $HSunTrueDec = $this->ArcSin($this->SinR($sitas) * $this->SinR($this->HSunTrueLo($JD)), 1);
	return $HSunTrueDec;
    }


    public function GetLunar($year,$month,$day,&$lmonth,&$lday,&$p)
    {
        $astro=new AstroMain();
        $moons=new Moon();
        $jde= $astro->JDECalc($year,$month, $day);
        if($month==11 || $month==12)
        {	
            $jd= $astro->JDECalc($year, $month, $day-8/24);
            $l1= $astro->TD2UT($moons->CalcMoonS($year+11/12+5/30/12)-8/24,false);
            if($l1-floor($l1)<0.5) $l1=floor($l1)-0.5; else $l1=floor($l1)+0.5;
            $l2=$astro->TD2UT($moons->CalcMoonS($year+1)-8/24,false);
            if($l2-floor($l2)<0.5) $l2=floor($l2)-0.5; else $l2=floor($l2)+0.5;
            $dz=GetJQTime($year,270)-8/24;
            if($dz>=$l1 && $dz<$l2)
            {
                if($jd<$l1) $year--;
            }
            if($dz>=$l2)
            {
                if($jd<$l2) $year--;
            }
        }else{
            $year--;
        }
        $jq=$this->GetOneYearJQ($year);
        $moon=$this->GetOneYearMoon($year);
        $huyu1=$jq[1];
        $huyu2=$jq[25];
        $cnum=0;
        for($i=1;$i<15;$i++)
        {
            //$moon[$i]+=8/24;
            if($moon[$i]-floor($moon[$i])<0.5) $moon[$i]=floor($moon[$i])-0.5; else $moon[$i]=floor($moon[$i])+0.5;
        }
        if($moon[1]<$huyu1 && $moon[2]<$huyu1)
        {
            for($i=1;$i<15;$i++)
            {
                if($i==14){$moon[14]=$moon[13]+30;break;}
                $moon[$i]=$moon[$i+1];
            }
        }
        if($moon[1]<$huyu1 && $moon[2]<$huyu1)
        {
            for($i=1;$i<15;$i++)
            {
                if($i==14){$moon[14]=$moon[13]+30;break;}
                    $moon[$i]=$moon[$i+1];
            }
        }
        foreach($moon as $tmp)
        {
            // echo DateCalc($tmp)."<br />";
            if($tmp>=$huyu1 && $tmp<$huyu2) {$cnum++; $months[$cnum]=$tmp;}
        }
        if($cnum==13)
        {
            $lrun=1;
            for($i=2;$i<14;$i++)
            {
                if(!($jq[$i*2-1]>=$months[$i-1] && $jq[$i*2-1]<=$months[$i])) break;
            }
            $run=$i-2;
            if($run<=0) $run+=12;
        }else
            $lrun=0;
        for($i=1;$i<15;$i++)
        {
            if($jde>=$moon[$i] && $jde<$moon[$i+1]) break;
             //echo $jde." ".$moon[$i]." ".$moon[$i+1]." ".DateCalc($moon[$i])."<br />";
        }

        $startday=$moon[$i];
        if($startday-floor($startday)<0.5)
            $startday=floor($startday)-0.5;
        else
            $startday=floor($startday)+0.5;
        $lday=$jde-$startday+1;
        $k=1;
        if($lrun)
            if($i==13 && $run<11){ $i--; $k=0;}
        if($i<3) $i+=12;
            $lmonth=$i-2;
           //echo DateCalc($moon[1]);
        $p=0;
        if($lrun)
        {
            if($lmonth==$run && $k)
            {
                $lmonth--;
                $p=1;
            }elseif($lmonth>$run && ($lmonth <11 && $run<11) && $k)
                $lmonth--;
            elseif($lmonth>$run && $run>11 && $k)
                $lmonth--;
            elseif($lmonth<$run && $run>11 && $k)
            {
                $lmonth--;
                if($lmonth<1) $lmonth+=12;
            }
        }
        $mon=array("零","正月","二月","三月","四月","五月","六月","七月","八月","九月","十月","冬月","腊月");
        $da=array("十","一","二","三","四","五","六","七","八","九","十");
        $tp=floor($lday/10);
        if($lday==10) $tp--;
        switch($tp)
        {case 0:
            $tmp="初".$da[$lday%10];
            break;
        case 1:
            $tmp="十".$da[$lday%10];
            break;
        case 2:
            $tmp="廿".$da[$lday%10];
            break;
        case 3:
            $tmp="三".$da[$lday%10];
            break;
        }
        if($lday==20) $tmp="二十";
        if($p)
            $result="闰".$mon[$lmonth].$tmp;
        else
            $result=$mon[$lmonth].$tmp;
        return $result;
    }
    
    private function GetOneYearMoon($year)
    {
        $astro=new AstroMain();
        $moons=new Moon();
	$start=$year+11/12+5/30/12;
        for($i=1;$i<16;$i++)
        {
           
            $moon[$i]=$astro->TD2UT($moons->CalcMoonS($start+($i-1)/12.5)+8/24,false);
            
           // echo DateCalc($moon[$i])."<br />";
        }
        return $moon;   
    }
    private function GetOneYearJQ($year)
    {
        $start=270;
        for($i=1;$i<26;$i++)
        {
            $angle=$start+15*($i-1);
            if($angle>360)$angle-=360;
            if($i>1)$years=$year+1; else $years=$year;
            $jq[$i]= $this->GetJQTime($years, $angle)+8/24;
       //  echo DateCalc($jq[$i])."<br />";
        }
        return $jq;
    }
    
   /*
    * 农历转公里函数废弃，才用二号
    */
    private function GetSunCa($year,$month,$day,$lrun,&$lyear,&$lmonth,&$lday)  //农历转公历
    {
        $lmonth=$month+1;
        if($lmonth>12) $lmonth=1;
        $lday=5;
        if($lrun)$lday=25;
            $k= mktime(0, 0, 0, $lmonth, $lday, $year);
        $this->GetLunar(date('Y',$k), date('m',$k), date('d',$k), $T1, $T2, $T3);
        if($T1<$month || ($T1==$month && $T2<$day ) && $lrun==false)
        {
            while($T1!=$month || ($T1==$month && $T2!=$day))
            {
                $k+=24*3600;
                $this->GetLunar(date('Y',$k), date('m',$k), date('d',$k), $T1, $T2, $T3);
            }
        }
        if($T1>$month || ($T1==$month && $T2>$day) && $lrun==false)
        {
            while($T1!=$month ||  ($T1==$month && $T2!=$day) )
            {
                $k-=24*3600;
                $this->GetLunar(date('Y',$k), date('m',$k), date('d',$k), $T1, $T2, $T3);
            }
        }
        if($lrun)
        {
            if($T1<$month || ($T1==$month && $T2<$day && $T3==true) || ($T1==$month && $T3==false ) )
            {
                while($T1!=$month || ($T1==$month && $T2!=$day))
                {
                    $k+=24*3600;
                    $this->GetLunar(date('Y',$k), date('m',$k), date('d',$k), $T1, $T2, $T3);
                }
            }
            if($T1>$month || ($T1==$month && $T2>$day && $T3==true))
            {
                while($T1!=$month ||  ($T1==$month && $T2!=$day) )
                {
                    $k-=24*3600;
                    $this->GetLunar(date('Y',$k), date('m',$k), date('d',$k), $T1, $T2, $T3);
                }
            }
        }
        $lyear=date('Y',$k);
        $lmonth=date('m',$k);
        $lday=date('d',$k);
        return $lyear."年". $lmonth."月".$lday."日";
    }
    /**
     * 二号转换函数
     */
 
    public function GetSunCal($year,$month,$day,$leap){
        $astro=new AstroMain();
        $motoy=$year;
        $year--;
        if($month>10){
            $dz=$astro->JDE2Date($this->GetJQTime($year+1, 270));
            $yd=$this->GetLunar($dz["year"], $dz["month"], $dz["day"], $lm, $ld, $lp);
            if($month==$lm && !($leap xor $lp) )
            {
                if($ld<=$day)
                    $year++;
            }
            if($month>$lm){
                $year++;
            }
            if($month==$lm && $leap && (!$lp))
                $year++;
        }
        $jq=$this->GetOneYearJQ($year);
        $tsuki=$this->GetOneYearMoon($year);
        
         foreach($tsuki as $tmp=>$tmp2)
        {
            if($tmp2-floor($tmp2)>0.5)
                $tmp2= floor ($tmp2)+0.5;
            else
                $tmp2=floor($tmp2)-0.5;
            $tsuki[$tmp]=$tmp2;
        }
       
        $HuyuHajimari=$jq[1];
        $HuyuOwari=$jq[25];
        $moonum=0;
        $allmonth=array();
        foreach($tsuki as $tmptsu)
        {
            if(($tmptsu>=$HuyuHajimari && $tmptsu<$HuyuOwari) || $HuyuHajimari-$tmptsu<31)
            {
                if(($tmptsu>=$HuyuHajimari && $tmptsu<$HuyuOwari))
                    $moonum++;
                $allmonth[]=$tmptsu;
            }
        }
        if($HuyuHajimari>$allmonth[0] && $HuyuHajimari>$allmonth[1])
        {
            unset($allmonth[0]);
        }
        if($moonum>=13)
        {
            $isleap=true;
        }else{
            $isleap=false;
        }
       
        $leapmonth=0;
        if($isleap)
        {
            $i=0;
            for($j=0;$j<count($allmonth)-1;$j++)
            {
                if($jq[($j+1)*2+1]-$allmonth[$i]>40)
                    $i++;
                if($jq[($j+1)*2+1]-$allmonth[$i]<-40)
                    $j++;
                if(!($jq[($j+1)*2+1]>$allmonth[$i] && $jq[($j+1)*2+1]<$allmonth[$i+1])){
                    $lpdate=$allmonth[$j];
                    break;
                }
                $i++;
            }
            $leapmonth=11+$j;
            if($leapmonth>12) $leapmonth-=12;
        }
        $i=0;
        $resmon=array();
       
        foreach($allmonth as $tmp)
        {
            $tmpy=$astro->JDE2Date($tmp);
            $years=$tmpy["year"];
            if($tmpy['month']<3)
                $years--;
            $months=11+$i;
            $i++;
            if($months-$leapmonth==1 && $leapmonth!=0)
            {
                if($months>12) $months-=12;
                if($tmpy['month']<3 && $months<10)
                    $years++;
                $resmon[]=array("year"=>$years,"month"=>$months-1,"leap"=>true, "jd"=> $tmp);
            }elseif($months-$leapmonth>1 && $leapmonth!=0 && $tmp>$lpdate){
                if($months-1>12) $months-=12;
                 if($tmpy['month']<3 && $months<10)
                    $years++;
                $resmon[]=array("year"=>$years,"month"=>$months-1,"leap"=>false,"jd"=>$tmp);
            }else{
                if($months>12) $months-=12;
                 if($tmpy['month']<3 && $months<10)
                    $years++;
                 $resmon[]=array("year"=>$years,"month"=>$months,"leap"=>false,"jd"=>$tmp);
            }
        }
        $i=0;
        foreach($resmon as $tmp){
            if($motoy==$tmp["year"] && $month==$tmp["month"] && (!($leap xor $tmp["leap"])))
            {
                $date=$tmp["jd"]+$day-1;
                return $date;
            }
        }
        return false;
    }
    
    public function GetXC($jd)   //十二次
    {
	$tlo=HSunSeeLo($jd);
	if($tlo>=255 && $tlo<285)
		return "星纪";
	else if($tlo>=285 && $tlo<315)
		return "玄枵";
	else if($tlo>=315 && $tlo<345)
		return "娵訾";
	else if($tlo>=345 || $tlo<15)
		return "降娄";
	else if($tlo>=15 && $tlo<45)
		return "大梁";
	else if($tlo>=45 && $tlo<75)
		return "实沈";
	else if($tlo>=75 && $tlo<105)
		return "鹑首";
	else if($tlo>=105 && $tlo<135)
		return "鹑火";
	else if($tlo>=135 && $tlo<165)
		return "鹑尾";
	else if($tlo>=165 && $tlo<195)
		return "寿星";
	else if($tlo>=195 && $tlo<225)
		return "大火";
	else if($tlo>=225 && $tlo<255)
		return "析木";
    }
    public function GetXZ($jd)
    {
	$XZ[1]=351.6443056;
	$XZ[]=28.683555555556;
	$XZ[]=53.41102778;
	$XZ[]=90.13525;
	$XZ[]=117.9848611;
	$XZ[]=138.0512083;
	$XZ[]=173.8502126939;
	$XZ[]=217.9122917;
	$XZ[]=241.0607361;
	$XZ[]=247.6422722;
	$XZ[]=266.2388056;
	$XZ[]=299.6524722;
	$XZ[]=327.4870722;
	$nm=array("双鱼座","白羊座","金牛座","双子座","巨蟹座","狮子座","室女座","天秤座","天蝎座","蛇夫座","人马座","摩羯座","宝瓶座");
        $tlo=$this->HSunSeeLo($jd);
	//die($tlo);
	for($i=1;$i<14;$i++)
	{
		if($i==1)
		{
			if($tlo>$this->SunSC($XZ[1],$jd) || $tlo<$this->SunSC($XZ[2],$jd))
				break;
		}else{
			$p=$i+1;
			if($p>13) $p=1;
			if($tlo>$this->SunSC($XZ[$i],$jd) && $tlo<$this->SunSC($XZ[$p],$jd))
				break;
		}
	}
	if($i==14) $i=13;
	return $nm[$i-1];
    }
    public function GetWHTime($Year,$Angle)
    {
                $astro=new AstroMain();
		$tmp=$Angle;
		$Angle=floor($Angle/15)*15;
		if($Angle%2==0)
			$Day=18;
		else
			$Day=3;
		if($Angle%10!=0)
			$tp=($Angle+15)/30;
		else
			$tp=($Angle)/30;
		$Month=3+$tp;
		if($Month>12)$Month-=12;
		$JD1 = $astro->JDECalc($Year,$Month,$Day);
		$JD1+=$tmp-$Angle;
		$Angle=$tmp;
		if($Angle<=5) $Angle=360+$Angle;
		do
		{
			$JD0 = $JD1;
			$stDegree = $this->JQLospec($JD0) - $Angle;         
			$stDegreep = ($this->JQLospec($JD0 + 0.000005)
                      - $this->JQLospec($JD0 - 0.000005)) / 0.00001;
			$JD1 = $JD0 - $stDegree / $stDegreep;
		}while((floor($JD1 - $JD0) > 0.000001));
		return $astro->TD2UT($JD1,false);
    }

    public function GetWH(&$num)
    {
        $astro=new AstroMain();
	$jd1 =$astro->TD2UT($astro->JDECalc(date('Y'), date('m'), date('d')-8/24));
	$jd2=$jd1+1;
	$lo1=$this->HSunTrueLo($jd1);
	$lo2=$this->HSunTrueLo($jd2);
	for($i=0;$i<360;$i+=5)
		$data[]=$i;
	//$jq=array("春分","清明","谷雨","立夏","小满","芒种","夏至","小暑","大暑","立秋","处暑","白露","秋分","寒露","霜降","立冬","小雪","大雪","冬至","小寒","大寒","立春","雨水","惊蛰");
	for($i=0;$i<72;$i++)
	{
		if($i==0)
		{
			if($lo1<360 && $lo1>355 && $lo2<5 && $lo2>0)
				break;
		}else{
			if($lo1<$data[$i] && $data[$i]<$lo2)
				break;
		}
	}
	if($i==72)
	{
		$num=-1;
		return "";
	}
	else{
		$num=$i-62;
		if($num<=0) $num+=72;
		return $i;
	}
	
    }

    public function GetJQ(&$num,$jd=0)   
    {
	$astro=new AstroMain();
	if($jd!=0)
		$jd1=$jd;
	else
		$jd1 =$astro->TD2UT($astro->JDECalc(date('Y'), date('m'), date('d')-8/24));
	$jd2=$jd1+1;
	$lo1=$this->HSunTrueLo($jd1);
	$lo2=$this->HSunTrueLo($jd2);
	//die($lo1." ".$lo2);
	$data=array(0,15,30,45,60,75,90,105,120,135,150,165,180,195,210,225,240,255,270,285,300,315,330,345);
	$jq=array("春分","清明","谷雨","立夏","小满","芒种","夏至","小暑","大暑","立秋","处暑","白露","秋分","寒露","霜降","立冬","小雪","大雪","冬至","小寒","大寒","立春","雨水","惊蛰");
	for($i=0;$i<24;$i++)
	{
		if($i==0)
		{
			if($lo1<360 && $lo1>345 && $lo2<15 && $lo2>0)
				break;
		}else{
			if($lo1<$data[$i] && $data[$i]<$lo2)
				break;
		}
	}
	if($i==24)
	{
		$num=-1;
		return "";
	}
	else{
		$num=$data[$i];
		return "今日".$jq[$i]."，太阳将经过黄经".$data[$i]."度。";
	}
}

    private function JQLospec($JD)
    {
	$t=$this->HSunSeeLo($JD);
	if($t<=5)
		$t+=360;
	return $t;
    }
    public function GetJQTime($Year,$Angle)  //节气时间
        {
                $astro=new AstroMain();
		if($Angle%2==0)
			$Day=18;
		else
			$Day=3;
		if($Angle%10!=0)
			$tp=($Angle+15)/30;
		else
			$tp=($Angle)/30;
		$Month=3+$tp;
		if($Month>12)$Month-=12;
		$JD1 = $astro->JDECalc($Year,$Month,$Day);
		if($Angle==0) $Angle=360;
		do
		{
			$JD0 = $JD1;
			$stDegree = $this->JQLospec($JD0) - $Angle;         
			$stDegreep = ($this->JQLospec($JD0 + 0.000005)
                      - $this->JQLospec($JD0 - 0.000005)) / 0.00001;
			$JD1 = $JD0 - $stDegree / $stDegreep;
		}while((floor($JD1 - $JD0) > 0.000001));
		Switch($Year)
		{
			case 2017:
				if($Angle==90)
					return $astro->TD2UT($JD1,false)+1/86400;
				break;
			default:
				break;
		}
		return $astro->TD2UT($JD1,false);
	}
    public function RDJL($jd) //ri di ju li
    {
	$f=$this->SunMidFun($jd);
	$m=$this->sunM($jd);
	$e=$this->Earthe($jd);
	return number_format((1.000001018*(1-$e*$e) / (1+$e*CosR($f+$m))),7);
    }

    /*
     * 太阳中天时刻，通过均时差计算
     */
    public function GetSunTZTime($JD,$Lon,$TZ)  //实际中天时间
    {
	$JD=floor($JD);
	$tmp=($TZ*15-$Lon)*4/60;
	return $JD+$tmp/24-$this->SunTime($JD)/24;
    }
    /*
     * 昏朦影传入 当天午时时刻
     */
    public function GetBanTime($JD,$Lon,$Lat,$TZ,$An)
    {
	$JD=floor($JD);
	$tmp=($TZ*15-$Lon)*4/60;
	$tmp1=$JD+$tmp/24-SunTime($JD)/24;
	$tmp2=$this->HSunSeeDec($JD-$TZ/24-0.5);
	if(abs($Lat+$tmp2)-90>$An)
	{
		return -1;
	}
	if(90-abs($Lat-$tmp2)<$An)
	{
		return -2;
	}
	$tmp3=$this->ArcCos(-$this->TanR($tmp2)*$this->TanR($Lat),1)/15;
	$tmp4=$tmp1+$tmp3/24-5/60/24;
	//$tmp4=$tmp4-$TZ/24+8/24;
	$JD1=$tmp4;
	do
	{
            $JD0 = $JD1;
            $stDegree = $this->SunHeight($JD0,$Lon,$Lat,$TZ) - $An;         
            $stDegreep = ($this->SunHeight($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunHeight($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
            $JD1 = $JD0 - $stDegree / $stDegreep;
        }while((floor($JD1 - $JD0) > 0.000001));
	//$JD1=$JD1-8/24+$TZ/24;
	return $JD1;
    }
 
    public function GetAsaTime($JD,$Lon,$Lat,$TZ,$An)
    {
	$JD=floor($JD);
	$tmp=($TZ*15-$Lon)*4/60;
	$tmp1=$JD+$tmp/24-$this->SunTime($JD)/24;
	$tmp2=$this->HSunSeeDec($JD-$TZ/24-0.5);
	if(abs($Lat+$tmp2)-90>$An)
	{
		return -1;
	}
	if(90-abs($Lat-$tmp2)<$An)
	{
		return -2;
	}
	$tmp3=$this->ArcCos(-$this->TanR($tmp2)*$this->TanR($Lat),1)/15;
	$tmp4=$tmp1-$tmp3/24+$An/6*30/60/24;
	//$tmp4=$tmp4-$TZ/24+8/24;
	$i=0;
	while ($this->SunHeight($tmp4,$Lon,$Lat,$TZ)>$An) 
	{
		$i++;
		$tmp4-=15/60/24;
		if ($i>12) break;
	}
	$JD1=$tmp4;
	do
	{
            $JD0 = $JD1;
            $stDegree = $this->SunHeight($JD0,$Lon,$Lat,$TZ) - $An;         
            $stDegreep = ($this->SunHeight($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunHeight($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
            $JD1 = $JD0 - $stDegree / $stDegreep;
	}while((floor($JD1 - $JD0) > 0.000001));
	//$JD1=$JD1-8/24+$TZ/24;
	return $JD1;
    }
    /*
     * 太阳时角
     */
    public function SunTimeAngle($JD,$Lon,$Lat,$TZ)
    {
        $astro=new AstroMain();
        $star=new Star();
	$startime=$this->Limit360($star->SeeStarTime($JD-$TZ/24)*15+$Lon);
	$timeangle=$startime-$this->HSunSeeRa($astro->TD2UT($JD-$TZ/24));
	if($timeangle<0)
		$timeangle+=360;
	return $timeangle;
    }
    /*
     * 精确计算，传入当日0时JDE
     */
    public function GetSunRiseTime1($JD,$Lon,$Lat,$TZ,$ZS=0)
    {
	$JD=floor($JD)+0.5; 
	$JD1=$JD; 
	$SunHeight=$this->SunHeight($JD,$Lon,$Lat,$TZ); 
	$An=0;
		if($ZS!=0) $An=-0.8333;
	if($SunHeight>0 || $this->SunTimeAngle($JD1,$Lon,$Lat,$TZ)<180)
	{
            do{
		$timeangle=$this->SunTimeAngle($JD1,$Lon,$Lat,$TZ);
		if($timeangle>180)
			$JD1+=0.05;
            }while($timeangle>180);
            do{
		$JD0 = $JD1;
		$stDegree = $this->SunTimeAngle($JD0,$Lon,$Lat,$TZ) - 180;         
		$stDegreep = ($this->SunTimeAngle($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunTimeAngle($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
		$ki=$stDegree / $stDegreep;
		if(abs($ki)>0.007)
		{
                    if($ki>0)
			$ki=0.003;
                    else
                        $ki=-0.003;
		}
		$JD1 = $JD0 -$ki;
            }while($JD1 - $JD0> 0.000001);
            $JD1=$JD1-8/24+$TZ/24;
            //$JD1+=0.001;
            if($JD1>$JD+1 || $JD1<$JD)
		return -1;
            if(($this->SunHeight($JD1,$Lon,$Lat,$TZ)>$An))
		return -1;
	}
        while($this->SunHeight($JD1,$Lon,$Lat,$TZ)-$An<-5)
            $JD1+=40/60/24;
	if($this->SunHeight($JD1,$Lon,$Lat,$TZ)-$An>0)
            $JD1-=40/60/24;
	do{
            $JD0 = $JD1;
            $stDegree = $this->SunHeight($JD0,$Lon,$Lat,$TZ) - $An;         
            $stDegreep = ($this->SunHeight($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunHeight($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
            $ki=$stDegree / $stDegreep;
            if(abs($ki)>0.007){
		if($ki>0)
                    $ki=0.003;
		else
                    $ki=-0.003;
            }
            $JD1 = $JD0 - $ki;
	}while(($JD1 - $JD0 > 0.00001));
	#$JD1=$JD1-8/24+$TZ/24;
	if($this->SunTimeAngle($JD1,$Lon,$Lat,$TZ)<181  && $this->SunTimeAngle($JD1,$Lon,$Lat,$TZ)>179 && $this->SunHeight($JD1,$Lon,$Lat,$TZ)<$An)
            return -1;
	if($JD1>$JD+1 || $JD1<$JD)
            return -1;
        else
            return $JD1;
    }
    public function GetSunDownTime1($JD,$Lon,$Lat,$TZ,$ZS=0)
    {
	$JD=floor($JD)+0.5;
	$JD1=$JD;
	$SunHeight=$this->SunHeight($JD,$Lon,$Lat,$TZ);
	$An=0;
	if($ZS!=0) $An=-0.8333;
	if($SunHeight<0 || $this->SunTimeAngle($JD1,$Lon,$Lat,$TZ)>180)
	{
            do
            {
		$timeangle=$this->SunTimeAngle($JD1,$Lon,$Lat,$TZ);
		if($timeangle>15)
                    $JD1+=0.03;
            }while($timeangle>15);
            do
            {
                $JD0 = $JD1;
		$stDegree = $this->SunTimeAngle($JD0,$Lon,$Lat,$TZ) - 1;         
		$stDegreep = ($this->SunTimeAngle($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunTimeAngle($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
		$ki=$stDegree / $stDegreep;
		if(abs($ki)>0.007)
		{
                    if($ki>0)
			$ki=0.003;
                    else
			$ki=-0.003;
		}
                $JD1 = $JD0 -$ki;
            }while($JD1 - $JD0> 0.000001);
            $JD1=$JD1-8/24+$TZ/24;
            $JD1+=0.001;
		//echo DateCalc($JD1);
            if($JD1>$JD+1 || $JD1<$JD)
		return -1;
            if(($this->SunHeight($JD1,$Lon,$Lat,$TZ)<$An))
		return -1;
	}
	while($this->SunHeight($JD1,$Lon,$Lat,$TZ)-$An>5)
            $JD1+=40/60/24;
	if($this->SunHeight($JD1,$Lon,$Lat,$TZ)-$An<0)
            $JD1-=40/60/24;
	do{
            $JD0 = $JD1;
            $stDegree = $this->SunHeight($JD0,$Lon,$Lat,$TZ) - $An;         
            $stDegreep = ($this->SunHeight($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunHeight($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
            $ki=$stDegree / $stDegreep;
            if(abs($ki)>0.007)
            {
		if($ki>0)
                    $ki=0.003;
		else
                    $ki=-0.003;
            }
            $JD1 = $JD0 - $ki;
	}while(($JD1 - $JD0 > 0.00001));
	#$JD1=$JD1-8/24+$TZ/24;
	if($this->SunTimeAngle($JD1,$Lon,$Lat,$TZ)<181  && $this->SunTimeAngle($JD1,$Lon,$Lat,$TZ)>179 && $this->SunHeight($JD1,$Lon,$Lat,$TZ)>$An)
            return -1;
        if($JD1>$JD+1 || $JD1<$JD)
		return -1;
	else
                return $JD1;
    }

    public function GetSunRiseTime($JD,$Lon,$Lat,$TZ,$ZS=0)
    {
	$JD=floor($JD);
	$tmp=($TZ*15-$Lon)*4/60;
	$tmp1=$JD+$tmp/24-$this->SunTime($JD)/24;
	//echo DateCalc($tmp1);
	$tmp2=$this->HSunSeeDec($JD-$TZ/24);
	if($Lat>0)
	{
            if(-90+$Lat>$tmp2)
		return -1; //极夜
            else if(90-$Lat<$tmp2)
		return -2; //极昼
	}else{
            if(90+$Lat<$tmp2)
		return -1; //极夜
            else if(-90-$Lat>$tmp2)
		return -2; //极昼
	}
	$tmp3=$this->ArcCos(-$this->TanR($tmp2)*$this->TanR($Lat),1)/15;
	$tmp4=$tmp1-$tmp3/24-15/60/24;
	//$tmp4=$tmp4-$TZ/24+8/24;
	if ($this->SunHeight($tmp4,$Lon,$Lat,$TZ)>0) $tmp4-=15/60/24;
	$JD1=$tmp4;
	$An=0;
	if($ZS!=0) $An=-0.83;
	do
	{
            $JD0 = $JD1;
            $stDegree = $this->SunHeight($JD0,$Lon,$Lat,$TZ) - $An;         
            $stDegreep = ($this->SunHeight($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunHeight($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
            $JD1 = $JD0 - $stDegree / $stDegreep;
	}while((floor($JD1 - $JD0) > 0.000001));
	//$JD1=$JD1-8/24+$TZ/24;
	return $JD1;
    }
 
    public function GetSunDownTime($JD,$Lon,$Lat,$TZ,$ZS=0)
    {
	$JD=floor($JD);
	$tmp=($TZ*15-$Lon)*4/60;
	$tmp1=$JD+$tmp/24-$this->SunTime($JD)/24;
	$tmp2=$this->HSunSeeDec($JD-$TZ/24);
	if($Lat>0)
	{
            if(-90+$Lat>$tmp2)
		return -1; //极夜
            else if(90-$Lat<$tmp2)
		return -2; //极昼
	}else{
            if(90+$Lat<$tmp2)
		return -1; //极夜
            else if(-90-$Lat>$tmp2)
		return -2; //极昼
	}
	$tmp3=$this->ArcCos(-$this->TanR($tmp2)*$this->TanR($Lat),1)/15;
	$tmp4=$tmp1+$tmp3/24-15/60/24;
	//$tmp4=$tmp4-$TZ/24+8/24;
	if ($this->SunHeight($tmp4,$Lon,$Lat,$TZ)<0) $tmp4-=15/60/24;
	$JD1=$tmp4;
	$An=0;
	if($ZS!=0) $An=-0.83;
	do{
            $JD0 = $JD1;
            $stDegree = $this->SunHeight($JD0,$Lon,$Lat,$TZ) - $An;         
            $stDegreep = ($this->SunHeight($JD0 + 0.000005,$Lon,$Lat,$TZ)
                      - $this->SunHeight($JD0 - 0.000005,$Lon,$Lat,$TZ)) / 0.00001;
            $JD1 = $JD0 - $stDegree / $stDegreep;
	}while((floor($JD1 - $JD0) > 0.000001));
	//$JD1=$JD1-8/24+$TZ/24;
	return $JD1;
    }
    /*
     * 太阳高度角 世界时
     */
     public function SunHeight($JD,$Lon,$Lat,$TZ)
    {
         $astro=new AstroMain();
	 #$JD=$JD-8/24+$TZ/24;
	 $tmp=($TZ*15-$Lon)*4/60;
	 $truejd=$JD-$tmp/24;
	 $calcjd=$JD-$TZ/24;
	 $st=$this->Limit360($this->SeeStarTime($calcjd)*15+$Lon);
	 $H=$this->Limit360($st-$this->HSunSeeRa($astro->TD2UT($calcjd)));
	 $tmp2=$this->SinR($Lat)*$this->SinR(HSunSeeDec($astro->TD2UT($calcjd)))+$this->CosR($this->HSunSeeDec($astro->TD2UT($calcjd)))*$this->CosR($Lat)*$this->CosR($H);
	 return  $this->ArcSin($tmp2,1);
    }
     public function SunAngle($JD,$Lon,$Lat,$TZ)
    {
         $star=new Star();
         $astro=new AstroMain();
	 #$JD=$JD-8/24+$TZ/24;
	 $tmp=($TZ*15-$Lon)*4/60;
	 $truejd=$JD-$tmp/24;
	 $calcjd=$JD-$TZ/24;
	 $st=$this->Limit360($star->SeeStarTime($calcjd)*15+$Lon);
	 $H=$this->Limit360($st-$this->HSunSeeRa($astro->TD2UT($calcjd)));
	 $tmp2=$this->SinR($H)/($this->CosR($H)*$this->SinR($Lat)-$this->TanR($this->HSunSeeDec($astro->TD2UT($calcjd)))*$this->CosR($Lat));
	 $Angle=$this->ArcTan($tmp2,1);
	 if($Angle<0)
	 {
            if($H/15<12)
                return $Angle+360;
            else
                return $Angle+180;
	 }else{
            if($H/15<12)
                return $Angle+180;
            else
                return $Angle;
         }
    }

/**
 * 弃用函数
 
function GetSunCa2($year,$month,$day,$runs)
{
  
if($month==11 || $month==12)
   $year=$year;
else{
  $year--;
}
$jq= GetOneYearJQ($year);
$moon= GetOneYearMoon($year);
$huyu1=$jq[1];
$huyu2=$jq[25];
$cnum=0;
for($i=1;$i<15;$i++)
{
   // $moon[$i]+8/24;
    if($moon[$i]-floor($moon[$i])<0.5) $moon[$i]=floor($moon[$i])-0.5; else $moon[$i]=floor($moon[$i])+0.5;
}

if($moon[1]<$huyu1 && $moon[2]<$huyu1)
{
    for($i=1;$i<15;$i++)
    {
    if($i==14){$moon[14]=$moon[13]+30;break;}
        $moon[$i]=$moon[$i+1];
    }
}
foreach($moon as $tmp)
{
    //echo DateCalc($tmp)."<br />";
    if($tmp>=$huyu1 && $tmp<$huyu2) {$cnum++; $months[$cnum]=$tmp;}
}
if($cnum==13)
{
    $lrun=1;
    for($i=2;$i<14;$i++)
    {
        if(!($jq[$i*2-1]>=$months[$i-1] && $jq[$i*2-1]<=$months[$i])) break;
    }
    $run=$i-2;
    if($run<=0) $run+=12;
}else
    $lrun=0;
$tmps=$month;
if($lrun)
{
    if(($month>$run-1 && $month<11) || ($month==$run-1 && $runs==1) || ($run>11 && $month>$run-1) || ($run>11 && $month<$run))
        $month+=3;
    else
        $month+=2;
}else
    $month+=2;
if($tmps>10 && $month>12) $month-=12;
return ($moon[$month]+$day-1);
}


function LGetLunar($year,$month,$day,$pp=0)
{
	if($pp)
		$jde= JDEcalc($year+1,$month, $day);
	else
		$jde= JDEcalc($year,$month, $day);
if($month!=12)
  $year--;
$jq= LGetOneYearJQ($year);
$moon= LGetOneYearMoon($year);
$huyu1=$jq[1];
$huyu2=$jq[25];

$cnum=0;
for($i=1;$i<15;$i++)
{
    //$moon[$i]+=8/24;
    if($moon[$i]-floor($moon[$i])<0.5) $moon[$i]=floor($moon[$i])-0.5; else $moon[$i]=floor($moon[$i])+0.5;
}

if($moon[1]<$huyu1 && $moon[2]<=$huyu1)
{
    for($i=1;$i<15;$i++)
    {
    if($i==14){$moon[14]=$moon[13]+30;break;}
        $moon[$i]=$moon[$i+1];
    }
}

if($moon[1]<$huyu1 && $moon[2]<$huyu1)
{
    for($i=1;$i<15;$i++)
    {
    if($i==14){$moon[14]=$moon[13]+30;break;}
        $moon[$i]=$moon[$i+1];
    }
}
foreach($moon as $tmp)
{
   // echo DateCalc($tmp)."<br />";
    if($tmp>$huyu1 && $tmp<=$huyu2) {$cnum++; $months[$cnum]=$tmp;}
}
if($cnum==13)
{
    $lrun=1;
    for($i=2;$i<14;$i++)
    {
        if(!($jq[$i*2-1]>=$months[$i-1] && $jq[$i*2-1]<=$months[$i])) break;
    }
    $run=$i-2;
    if($run<=0) $run+=12;
}else
    $lrun=0;
if($year==2033) $run=12;
for($i=1;$i<15;$i++)
{
    if($jde>=$moon[$i] && $jde<$moon[$i+1]) break;
    //echo $jde." ".$moon[$i]." ".$moon[$i+1]." ".DateCalc($moon[$i])."<br />";
}
if($i==15 && month==12)
{
	$res=LGetLunar($year-1,$month,$day,1);
	return $res;
}elseif($i==15 && month==11)
{
	$res=LGetLunar($year+1,$month,$day,1);
	return $res;
}
$startday=$moon[$i];
echo $i;
if($startday-floor($startday)<0.5)
 $startday=floor($startday)-0.5;
else
   $startday=floor($startday)+0.5;
$lday=$jde-$startday+1;
$k=1;
if($lrun)
	if($i==13 && $run<11){ $i--; $k=0;}
if($i<3) $i+=12;
$lmonth=$i-2;
//echo DateCalc($moon[1]);
$p=0;
if($lrun)
{

    if($lmonth==$run && $k==1)
    {
        $lmonth--;
        $p=1;
    }elseif($lmonth>$run && ($lmonth <11 && $run<11) && $k)
        $lmonth--;
    elseif($lmonth>$run && $run>11 && $k)
        $lmonth--;
    elseif($lmonth<$run && $run>11 && $k)
    {
        $lmonth--;
        if($lmonth<1) $lmonth+=12;
    }
}
$mon=array("零","正月","二月","三月","四月","五月","六月","七月","八月","九月","十月","冬月","腊月");
$da=array("十","一","二","三","四","五","六","七","八","九","十");
$tp=floor($lday/10);
if($lday==10) $tp--;
switch($tp)
{case 0:
     $tmp="初".$da[$lday%10];
     break;
 case 1:
     $tmp="十".$da[$lday%10];
     break;
 case 2:
     $tmp="廿".$da[$lday%10];
     break;
 case 3:
     $tmp="三".$da[$lday%10];
     break;
}
if($lday==20) $tmp="二十";
if($p)
    $result="闰".$mon[$lmonth].$tmp;
else
    $result=$mon[$lmonth].$tmp;
return $result;
}

function LGetOneYearMoon($year)
{
	$y=floor(($year-1900)*12.36826+12);
	$i=1;
	for ($m=$y;$m<$y+15;$m++)
	{	$M = 1.6 + 29.5306 * $m + 0.4 * sin(1 - 0.45058 * $m);
		$M+=JDECalc(1900,1,1)-1;
		//echo DateCalc($M)."<br />";
		$res[$i]=$M;
		$i++;
	}
	return $res;
}
FUNCTION LGetOneYearJQ($year)
{
	$jq[1]=LGetDateJQ($year,0);
	$year++;
	//echo DateCalc($jq[1])."<br />";
	
	for($i=2;$i<26;$i++)
	{
		$p=$i;
		$years=$year;
		if($i>24) {$p=$i-24;}
		$jq[$i]=LGetDateJQ($years,$p-1);
		//echo DateCalc($jq[$i])."<br />";
	}
	return $jq;
}
function LGetDateJQ($year,$x)
{
	$D=0.2422;
	$Y=$year-2000;
	$L=floor($Y/4);
	$C=array(21.94,5.4055,20.12,3.87,18.73,5.63,20.646,4.81,20.1,5.52,21.04,5.678,21.37,
	  7.108,22.83,7.5,23.13,7.646,23.042,8.318,23.438,7.438,22.36,7.18);
	$day=floor($Y*$D+$C[$x])-$L;
	if($Y==21 && $x==0) $day--;
	if($Y==19 && $x==1) $day--;
	if($Y==82 && $x==2) $day++;
	if($Y==26 && $x==4) $day--;
	if($Y%4==0 && ($x==4 || $x==3)) $day++;
	if($Y==84 && $x==6) $day++;
	if($Y==8 && $x==10) $day++;
	if($Y==16 && $x==13) $day++;
	if($Y==2 && $x==15) $day++;
	if($Y==89 && $x==20) $day++;
	if($Y==89 && $x==21) $day++;
	$yue=array(12,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11,12);
	$jde=JDECalc($year,$yue[$x],$day);
	//echo $year."-".$yue[$x]."-".$day;
	return $jde;
}
*/

    /*
     * 干支
     */
    public function GetGZ($year)
    {
	$tiangan=array("庚","辛","壬","癸","甲","乙","丙","丁","戊","已");
	$dizhi=array("申","酉","戌","亥","子","丑","寅","卯","辰","巳","午","未");
	$t=substr($year,3,1);
	$d=$year % 12;
	return $tiangan[$t].$dizhi[$d]."年";
    }


function Earth_L0($t) // 559 terms of order 0
{
   $L0  = 1.75347045673;
   $L0 += 0.03341656456*cos(4.66925680417 + 6283.0758499914*$t);
   $L0 += 0.00034894275*cos(4.62610241759 + 12566.1516999828*$t);
   $L0 += 0.00003417571*cos(2.82886579606 + 3.523118349*$t);
   $L0 += 0.00003497056*cos(2.74411800971 + 5753.3848848968*$t);
   $L0 += 0.00003135896*cos(3.62767041758 + 77713.7714681205*$t);
   $L0 += 0.00002676218*cos(4.41808351397 + 7860.4193924392*$t);
   $L0 += 0.00002342687*cos(6.13516237631 + 3930.2096962196*$t);
   $L0 += 0.00001273166*cos(2.03709655772 + 529.6909650946*$t);
   $L0 += 0.00001324292*cos(0.74246356352 + 11506.7697697936*$t);
   $L0 += 0.00000901855*cos(2.04505443513 + 26.2983197998*$t);
   $L0 += 0.00001199167*cos(1.10962944315 + 1577.3435424478*$t);
   $L0 += 0.00000857223*cos(3.50849156957 + 398.1490034082*$t);
   $L0 += 0.00000779786*cos(1.17882652114 + 5223.6939198022*$t);
   $L0 += 0.00000990250*cos(5.23268129594 + 5884.9268465832*$t);
   $L0 += 0.00000753141*cos(2.53339053818 + 5507.5532386674*$t);
   $L0 += 0.00000505264*cos(4.58292563052 + 18849.2275499742*$t);
   $L0 += 0.00000492379*cos(4.20506639861 + 775.522611324*$t);
   $L0 += 0.00000356655*cos(2.91954116867 + 0.0673103028*$t);
   $L0 += 0.00000284125*cos(1.89869034186 + 796.2980068164*$t);
   $L0 += 0.00000242810*cos(0.34481140906 + 5486.777843175*$t);
   $L0 += 0.00000317087*cos(5.84901952218 + 11790.6290886588*$t);
   $L0 += 0.00000271039*cos(0.31488607649 + 10977.078804699*$t);
   $L0 += 0.00000206160*cos(4.80646606059 + 2544.3144198834*$t);
   $L0 += 0.00000205385*cos(1.86947813692 + 5573.1428014331*$t);
   $L0 += 0.00000202261*cos(2.45767795458 + 6069.7767545534*$t);
   $L0 += 0.00000126184*cos(1.08302630210 + 20.7753954924*$t);
   $L0 += 0.00000155516*cos(0.83306073807 + 213.299095438*$t);
   $L0 += 0.00000115132*cos(0.64544911683 + 0.9803210682*$t);
   $L0 += 0.00000102851*cos(0.63599846727 + 4694.0029547076*$t);
   $L0 += 0.00000101724*cos(4.26679821365 + 7.1135470008*$t);
   $L0 += 0.00000099206*cos(6.20992940258 + 2146.1654164752*$t);
   $L0 += 0.00000132212*cos(3.41118275555 + 2942.4634232916*$t);
   $L0 += 0.00000097607*cos(0.68101272270 + 155.4203994342*$t);
   $L0 += 0.00000085128*cos(1.29870743025 + 6275.9623029906*$t);
   $L0 += 0.00000074651*cos(1.75508916159 + 5088.6288397668*$t);
   $L0 += 0.00000101895*cos(0.97569221824 + 15720.8387848784*$t);
   $L0 += 0.00000084711*cos(3.67080093025 + 71430.69561812909*$t);
   $L0 += 0.00000073547*cos(4.67926565481 + 801.8209311238*$t);
   $L0 += 0.00000073874*cos(3.50319443167 + 3154.6870848956*$t);
   $L0 += 0.00000078756*cos(3.03698313141 + 12036.4607348882*$t);
   $L0 += 0.00000079637*cos(1.80791330700 + 17260.1546546904*$t);
   $L0 += 0.00000085803*cos(5.98322631256 + 161000.6857376741*$t);
   $L0 += 0.00000056963*cos(2.78430398043 + 6286.5989683404*$t);
   $L0 += 0.00000061148*cos(1.81839811024 + 7084.8967811152*$t);
   $L0 += 0.00000069627*cos(0.83297596966 + 9437.762934887*$t);
   $L0 += 0.00000056116*cos(4.38694880779 + 14143.4952424306*$t);
   $L0 += 0.00000062449*cos(3.97763880587 + 8827.3902698748*$t);
   $L0 += 0.00000051145*cos(0.28306864501 + 5856.4776591154*$t);
   $L0 += 0.00000055577*cos(3.47006009062 + 6279.5527316424*$t);
   $L0 += 0.00000041036*cos(5.36817351402 + 8429.2412664666*$t);
   $L0 += 0.00000051605*cos(1.33282746983 + 1748.016413067*$t);
   $L0 += 0.00000051992*cos(0.18914945834 + 12139.5535091068*$t);
   $L0 += 0.00000049000*cos(0.48735065033 + 1194.4470102246*$t);
   $L0 += 0.00000039200*cos(6.16832995016 + 10447.3878396044*$t);
   $L0 += 0.00000035566*cos(1.77597314691 + 6812.766815086*$t);
   $L0 += 0.00000036770*cos(6.04133859347 + 10213.285546211*$t);
   $L0 += 0.00000036596*cos(2.56955238628 + 1059.3819301892*$t);
   $L0 += 0.00000033291*cos(0.59309499459 + 17789.845619785*$t);
   $L0 += 0.00000035954*cos(1.70876111898 + 2352.8661537718*$t);
   $L0 += 0.00000040938*cos(2.39850881707 + 19651.048481098*$t);
   $L0 += 0.00000030047*cos(2.73975123935 + 1349.8674096588*$t);
   $L0 += 0.00000030412*cos(0.44294464135 + 83996.84731811189*$t);
   $L0 += 0.00000023663*cos(0.48473567763 + 8031.0922630584*$t);
   $L0 += 0.00000023574*cos(2.06527720049 + 3340.6124266998*$t);
   $L0 += 0.00000021089*cos(4.14825464101 + 951.7184062506*$t);
   $L0 += 0.00000024738*cos(0.21484762138 + 3.5904286518*$t);
   $L0 += 0.00000025352*cos(3.16470953405 + 4690.4798363586*$t);
   $L0 += 0.00000022820*cos(5.22197888032 + 4705.7323075436*$t);
   $L0 += 0.00000021419*cos(1.42563735525 + 16730.4636895958*$t);
   $L0 += 0.00000021891*cos(5.55594302562 + 553.5694028424*$t);
   $L0 += 0.00000017481*cos(4.56052900359 + 135.0650800354*$t);
   $L0 += 0.00000019925*cos(5.22208471269 + 12168.0026965746*$t);
   $L0 += 0.00000019860*cos(5.77470167653 + 6309.3741697912*$t);
   $L0 += 0.00000020300*cos(0.37133792946 + 283.8593188652*$t);
   $L0 += 0.00000014421*cos(4.19315332546 + 242.728603974*$t);
   $L0 += 0.00000016225*cos(5.98837722564 + 11769.8536931664*$t);
   $L0 += 0.00000015077*cos(4.19567181073 + 6256.7775301916*$t);
   $L0 += 0.00000019124*cos(3.82219996949 + 23581.2581773176*$t);
   $L0 += 0.00000018888*cos(5.38626880969 + 149854.40013480789*$t);
   $L0 += 0.00000014346*cos(3.72355084422 + 38.0276726358*$t);
   $L0 += 0.00000017898*cos(2.21490735647 + 13367.9726311066*$t);
   $L0 += 0.00000012054*cos(2.62229588349 + 955.5997416086*$t);
   $L0 += 0.00000011287*cos(0.17739328092 + 4164.311989613*$t);
   $L0 += 0.00000013971*cos(4.40138139996 + 6681.2248533996*$t);
   $L0 += 0.00000013621*cos(1.88934471407 + 7632.9432596502*$t);
   $L0 += 0.00000012503*cos(1.13052412208 + 5.5229243074*$t);
   $L0 += 0.00000010498*cos(5.35909518669 + 1592.5960136328*$t);
   $L0 += 0.00000009803*cos(0.99947478995 + 11371.7046897582*$t);
   $L0 += 0.00000009220*cos(4.57138609781 + 4292.3308329504*$t);
   $L0 += 0.00000010327*cos(6.19982566125 + 6438.4962494256*$t);
   $L0 += 0.00000012003*cos(1.00351456700 + 632.7837393132*$t);
   $L0 += 0.00000010827*cos(0.32734520222 + 103.0927742186*$t);
   $L0 += 0.00000008356*cos(4.53902685948 + 25132.3033999656*$t);
   $L0 += 0.00000010005*cos(6.02914963280 + 5746.271337896*$t);
   $L0 += 0.00000008409*cos(3.29946744189 + 7234.794256242*$t);
   $L0 += 0.00000008006*cos(5.82145271907 + 28.4491874678*$t);
   $L0 += 0.00000010523*cos(0.93871805506 + 11926.2544136688*$t);
   $L0 += 0.00000007686*cos(3.12142363172 + 7238.67559160*$t);
   $L0 += 0.00000009378*cos(2.62414241032 + 5760.4984318976*$t);
   $L0 += 0.00000008127*cos(6.11228001785 + 4732.0306273434*$t);
   $L0 += 0.00000009232*cos(0.48343968736 + 522.5774180938*$t);
   $L0 += 0.00000009802*cos(5.24413991147 + 27511.4678735372*$t);
   $L0 += 0.00000007871*cos(0.99590177926 + 5643.1785636774*$t);
   $L0 += 0.00000008123*cos(6.27053013650 + 426.598190876*$t);
   $L0 += 0.00000009048*cos(5.33686335897 + 6386.16862421*$t);
   $L0 += 0.00000008620*cos(4.16538210888 + 7058.5984613154*$t);
   $L0 += 0.00000006297*cos(4.71724819317 + 6836.6452528338*$t);
   $L0 += 0.00000007575*cos(3.97382858911 + 11499.6562227928*$t);
   $L0 += 0.00000007756*cos(2.95729056763 + 23013.5395395872*$t);
   $L0 += 0.00000007314*cos(0.60652505806 + 11513.8833167944*$t);
   $L0 += 0.00000005955*cos(2.87641047971 + 6283.14316029419*$t);
   $L0 += 0.00000006534*cos(5.79072926033 + 18073.7049386502*$t);
   $L0 += 0.00000007188*cos(3.99831508699 + 74.7815985673*$t);
   $L0 += 0.00000007346*cos(4.38582365437 + 316.3918696566*$t);
   $L0 += 0.00000005413*cos(5.39199024641 + 419.4846438752*$t);
   $L0 += 0.00000005127*cos(2.36062848786 + 10973.55568635*$t);
   $L0 += 0.00000007056*cos(0.32258441903 + 263.0839233728*$t);
   $L0 += 0.00000006625*cos(3.66475158672 + 17298.1823273262*$t);
   $L0 += 0.00000006762*cos(5.91132535899 + 90955.5516944961*$t);
   $L0 += 0.00000004938*cos(5.73672165674 + 9917.6968745098*$t);
   $L0 += 0.00000005547*cos(2.45152597661 + 12352.8526045448*$t);
   $L0 += 0.00000005958*cos(3.32051344676 + 6283.0085396886*$t);
   $L0 += 0.00000004471*cos(2.06385999536 + 7079.3738568078*$t);
   $L0 += 0.00000006153*cos(1.45823331144 + 233141.31440436149*$t);
   $L0 += 0.00000004348*cos(4.42342175480 + 5216.5803728014*$t);
   $L0 += 0.00000006123*cos(1.07494905258 + 19804.8272915828*$t);
   $L0 += 0.00000004488*cos(3.65285037150 + 206.1855484372*$t);
   $L0 += 0.00000004020*cos(0.83995823171 + 20.3553193988*$t);
   $L0 += 0.00000005188*cos(4.06503864016 + 6208.2942514241*$t);
   $L0 += 0.00000005307*cos(0.38217636096 + 31441.6775697568*$t);
   $L0 += 0.00000003785*cos(2.34369213733 + 3.881335358*$t);
   $L0 += 0.00000004497*cos(3.27230796845 + 11015.1064773348*$t);
   $L0 += 0.00000004132*cos(0.92128915753 + 3738.761430108*$t);
   $L0 += 0.00000003521*cos(5.97844807108 + 3894.1818295422*$t);
   $L0 += 0.00000004215*cos(1.90601120623 + 245.8316462294*$t);
   $L0 += 0.00000003701*cos(5.03069397926 + 536.8045120954*$t);
   $L0 += 0.00000003865*cos(1.82634360607 + 11856.2186514245*$t);
   $L0 += 0.00000003652*cos(1.01838584934 + 16200.7727245012*$t);
   $L0 += 0.00000003390*cos(0.97785123922 + 8635.9420037632*$t);
   $L0 += 0.00000003737*cos(2.95380107829 + 3128.3887650958*$t);
   $L0 += 0.00000003507*cos(3.71291946325 + 6290.1893969922*$t);
   $L0 += 0.00000003086*cos(3.64646921512 + 10.6366653498*$t);
   $L0 += 0.00000003397*cos(1.10590684017 + 14712.317116458*$t);
   $L0 += 0.00000003334*cos(0.83684924911 + 6496.3749454294*$t);
   $L0 += 0.00000002805*cos(2.58504514144 + 14314.1681130498*$t);
   $L0 += 0.00000003650*cos(1.08344142571 + 88860.05707098669*$t);
   $L0 += 0.00000003388*cos(3.20185096055 + 5120.6011455836*$t);
   $L0 += 0.00000003252*cos(3.47859752062 + 6133.5126528568*$t);
   $L0 += 0.00000002553*cos(3.94869034189 + 1990.745017041*$t);
   $L0 += 0.00000003520*cos(2.05559692878 + 244287.60000722769*$t);
   $L0 += 0.00000002565*cos(1.56071784900 + 23543.23050468179*$t);
   $L0 += 0.00000002621*cos(3.85639359951 + 266.6070417218*$t);
   $L0 += 0.00000002955*cos(3.39692949667 + 9225.539273283*$t);
   $L0 += 0.00000002876*cos(6.02635617464 + 154717.60988768269*$t);
   $L0 += 0.00000002395*cos(1.16131956403 + 10984.1923516998*$t);
   $L0 += 0.00000003161*cos(1.32798718453 + 10873.9860304804*$t);
   $L0 += 0.00000003163*cos(5.08946464629 + 21228.3920235458*$t);
   $L0 += 0.00000002361*cos(4.27212906992 + 6040.3472460174*$t);
   $L0 += 0.00000003030*cos(1.80209931347 + 35371.8872659764*$t);
   $L0 += 0.00000002343*cos(3.57689860500 + 10969.9652576982*$t);
   $L0 += 0.00000002618*cos(2.57870156528 + 22483.84857449259*$t);
   $L0 += 0.00000002113*cos(3.71393780256 + 65147.6197681377*$t);
   $L0 += 0.00000002019*cos(0.81393923319 + 170.6728706192*$t);
   $L0 += 0.00000002003*cos(0.38091017375 + 6172.869528772*$t);
   $L0 += 0.00000002506*cos(3.74379142438 + 10575.4066829418*$t);
   $L0 += 0.00000002381*cos(0.10581361289 + 7.046236698*$t);
   $L0 += 0.00000001949*cos(4.86892513469 + 36.0278666774*$t);
   $L0 += 0.00000002074*cos(4.22794774570 + 5650.2921106782*$t);
   $L0 += 0.00000001924*cos(5.59460549860 + 6282.0955289232*$t);
   $L0 += 0.00000001949*cos(1.07002512703 + 5230.807466803*$t);
   $L0 += 0.00000001988*cos(5.19736046771 + 6262.300454499*$t);
   $L0 += 0.00000001887*cos(3.74365662683 + 23.8784377478*$t);
   $L0 += 0.00000001787*cos(1.25929682929 + 12559.038152982*$t);
   $L0 += 0.00000001883*cos(1.90364058477 + 15.252471185*$t);
   $L0 += 0.00000001816*cos(3.68083868442 + 15110.4661198662*$t);
   $L0 += 0.00000001701*cos(4.41105895380 + 110.2063212194*$t);
   $L0 += 0.00000001990*cos(3.93295788548 + 6206.8097787158*$t);
   $L0 += 0.00000002103*cos(0.75354917468 + 13521.7514415914*$t);
   $L0 += 0.00000001774*cos(0.48747535361 + 1551.045222648*$t);
   $L0 += 0.00000001882*cos(0.86684493432 + 22003.9146348698*$t);
   $L0 += 0.00000001924*cos(1.22898324132 + 709.9330485583*$t);
   $L0 += 0.00000002009*cos(4.62850921980 + 6037.244203762*$t);
   $L0 += 0.00000001924*cos(0.60231842508 + 6284.0561710596*$t);
   $L0 += 0.00000001596*cos(3.98332956992 + 13916.0191096416*$t);
   $L0 += 0.00000001664*cos(4.41939715469 + 8662.240323563*$t);
   $L0 += 0.00000001971*cos(1.04560500503 + 18209.33026366019*$t);
   $L0 += 0.00000001942*cos(4.31335979989 + 6244.9428143536*$t);
   $L0 += 0.00000001476*cos(0.93271367331 + 2379.1644735716*$t);
   $L0 += 0.00000001810*cos(0.49112137707 + 1.4844727083*$t);
   $L0 += 0.00000001346*cos(1.51574702235 + 4136.9104335162*$t);
   $L0 += 0.00000001528*cos(5.61835711404 + 6127.6554505572*$t);
   $L0 += 0.00000001791*cos(3.22187270126 + 39302.096962196*$t);
   $L0 += 0.00000001747*cos(3.05638656738 + 18319.5365848796*$t);
   $L0 += 0.00000001431*cos(4.51153808594 + 20426.571092422*$t);
   $L0 += 0.00000001695*cos(0.22047718414 + 25158.6017197654*$t);
   $L0 += 0.00000001242*cos(4.46665769933 + 17256.6315363414*$t);
   $L0 += 0.00000001463*cos(4.69242679213 + 14945.3161735544*$t);
   $L0 += 0.00000001205*cos(1.86912144659 + 4590.910180489*$t);
   $L0 += 0.00000001192*cos(2.74227166898 + 12569.6748183318*$t);
   $L0 += 0.00000001222*cos(5.18120087482 + 5333.9002410216*$t);
   $L0 += 0.00000001390*cos(5.42894648983 + 143571.32428481648*$t);
   $L0 += 0.00000001473*cos(1.70479245805 + 11712.9553182308*$t);
   $L0 += 0.00000001362*cos(2.61069503292 + 6062.6632075526*$t);
   $L0 += 0.00000001148*cos(6.03001800540 + 3634.6210245184*$t);
   $L0 += 0.00000001198*cos(5.15294130422 + 10177.2576795336*$t);
   $L0 += 0.00000001266*cos(0.11421493643 + 18422.62935909819*$t);
   $L0 += 0.00000001411*cos(1.09908857534 + 3496.032826134*$t);
   $L0 += 0.00000001349*cos(2.99805109633 + 17654.7805397496*$t);
   $L0 += 0.00000001253*cos(2.79850152848 + 167283.76158766549*$t);
   $L0 += 0.00000001311*cos(1.60942984879 + 5481.2549188676*$t);
   $L0 += 0.00000001079*cos(6.20304501787 + 3.2863574178*$t);
   $L0 += 0.00000001181*cos(1.20653776978 + 131.5419616864*$t);
   $L0 += 0.00000001254*cos(5.45103277798 + 6076.8903015542*$t);
   $L0 += 0.00000001035*cos(2.32142722747 + 7342.4577801806*$t);
   $L0 += 0.00000001117*cos(0.38838354256 + 949.1756089698*$t);
   $L0 += 0.00000000966*cos(3.18341890851 + 11087.2851259184*$t);
   $L0 += 0.00000001171*cos(3.39635049962 + 12562.6285816338*$t);
   $L0 += 0.00000001121*cos(0.72627490378 + 220.4126424388*$t);
   $L0 += 0.00000001024*cos(2.19378315386 + 11403.676995575*$t);
   $L0 += 0.00000000888*cos(3.91173199285 + 4686.8894077068*$t);
   $L0 += 0.00000000910*cos(1.98802695087 + 735.8765135318*$t);
   $L0 += 0.00000000830*cos(0.48984915507 + 24072.9214697764*$t);
   $L0 += 0.00000001096*cos(6.17377835617 + 5436.9930152402*$t);
   $L0 += 0.00000000908*cos(0.44959639433 + 7477.522860216*$t);
   $L0 += 0.00000000974*cos(1.52996238356 + 9623.6882766912*$t);
   $L0 += 0.00000000840*cos(1.79543266333 + 5429.8794682394*$t);
   $L0 += 0.00000000778*cos(6.17699177946 + 38.1330356378*$t);
   $L0 += 0.00000000776*cos(4.09855402433 + 14.2270940016*$t);
   $L0 += 0.00000001068*cos(4.64200173735 + 43232.3066584156*$t);
   $L0 += 0.00000000954*cos(1.49988435748 + 1162.4747044078*$t);
   $L0 += 0.00000000907*cos(0.86986870809 + 10344.2950653858*$t);
   $L0 += 0.00000000931*cos(4.06044689031 + 28766.924424484*$t);
   $L0 += 0.00000000739*cos(5.04368197372 + 639.897286314*$t);
   $L0 += 0.00000000937*cos(3.46884698960 + 1589.0728952838*$t);
   $L0 += 0.00000000763*cos(5.86304932998 + 16858.4825329332*$t);
   $L0 += 0.00000000953*cos(4.20801492835 + 11190.377900137*$t);
   $L0 += 0.00000000708*cos(1.72899988940 + 13095.8426650774*$t);
   $L0 += 0.00000000969*cos(1.64439522215 + 29088.811415985*$t);
   $L0 += 0.00000000717*cos(0.16688678895 + 11.729352836*$t);
   $L0 += 0.00000000962*cos(3.53092337542 + 12416.5885028482*$t);
   $L0 += 0.00000000747*cos(5.77866940346 + 12592.4500197826*$t);
   $L0 += 0.00000000672*cos(1.91095796194 + 3.9321532631*$t);
   $L0 += 0.00000000671*cos(5.46240843677 + 18052.9295431578*$t);
   $L0 += 0.00000000675*cos(6.28311558823 + 4535.0594369244*$t);
   $L0 += 0.00000000684*cos(0.39975012080 + 5849.3641121146*$t);
   $L0 += 0.00000000799*cos(0.29851185294 + 12132.439962106*$t);
   $L0 += 0.00000000758*cos(0.96370823331 + 1052.2683831884*$t);
   $L0 += 0.00000000782*cos(5.33878339919 + 13517.8701062334*$t);
   $L0 += 0.00000000730*cos(1.70106160291 + 17267.26820169119*$t);
   $L0 += 0.00000000749*cos(2.59599901875 + 11609.8625440122*$t);
   $L0 += 0.00000000734*cos(2.78417782952 + 640.8776073822*$t);
   $L0 += 0.00000000688*cos(5.15048287468 + 16496.3613962024*$t);
   $L0 += 0.00000000770*cos(1.62469589333 + 4701.1165017084*$t);
   $L0 += 0.00000000633*cos(2.20587893893 + 25934.1243310894*$t);
   $L0 += 0.00000000760*cos(4.21317219403 + 377.3736079158*$t);
   $L0 += 0.00000000584*cos(2.13420121623 + 10557.5941608238*$t);
   $L0 += 0.00000000574*cos(0.24250054587 + 9779.1086761254*$t);
   $L0 += 0.00000000573*cos(3.16435264609 + 533.2140834436*$t);
   $L0 += 0.00000000685*cos(3.19344289472 + 12146.6670561076*$t);
   $L0 += 0.00000000675*cos(0.96179233959 + 10454.5013866052*$t);
   $L0 += 0.00000000648*cos(1.46327342555 + 6268.8487559898*$t);
   $L0 += 0.00000000589*cos(2.50543543638 + 3097.88382272579*$t);
   $L0 += 0.00000000551*cos(5.28099026956 + 9388.0059094152*$t);
   $L0 += 0.00000000696*cos(3.65342150016 + 4804.209275927*$t);
   $L0 += 0.00000000669*cos(2.51030077026 + 2388.8940204492*$t);
   $L0 += 0.00000000550*cos(0.06883864342 + 20199.094959633*$t);
   $L0 += 0.00000000629*cos(4.13350995675 + 45892.73043315699*$t);
   $L0 += 0.00000000678*cos(6.09190163533 + 135.62532501*$t);
   $L0 += 0.00000000593*cos(1.50136257618 + 226858.23855437008*$t);
   $L0 += 0.00000000542*cos(3.58573645173 + 6148.010769956*$t);
   $L0 += 0.00000000682*cos(5.02203067788 + 17253.04110768959*$t);
   $L0 += 0.00000000565*cos(4.29309238610 + 11933.3679606696*$t);
   $L0 += 0.00000000486*cos(0.77746204893 + 27.4015560968*$t);
   $L0 += 0.00000000503*cos(0.58963565969 + 15671.0817594066*$t);
   $L0 += 0.00000000616*cos(4.06539884128 + 227.476132789*$t);
   $L0 += 0.00000000583*cos(6.12695541996 + 18875.525869774*$t);
   $L0 += 0.00000000537*cos(2.15056440980 + 21954.15760939799*$t);
   $L0 += 0.00000000669*cos(6.06986269566 + 47162.5163546352*$t);
   $L0 += 0.00000000475*cos(0.40343842110 + 6915.8595893046*$t);
   $L0 += 0.00000000540*cos(2.83444222174 + 5326.7866940208*$t);
   $L0 += 0.00000000530*cos(5.26359885263 + 10988.808157535*$t);
   $L0 += 0.00000000582*cos(3.24533095664 + 153.7788104848*$t);
   $L0 += 0.00000000641*cos(3.24711791371 + 2107.0345075424*$t);
   $L0 += 0.00000000621*cos(3.09698523779 + 33019.0211122046*$t);
   $L0 += 0.00000000466*cos(3.14982372198 + 10440.2742926036*$t);
   $L0 += 0.00000000466*cos(0.90708835657 + 5966.6839803348*$t);
   $L0 += 0.00000000528*cos(0.81926454470 + 813.5502839598*$t);
   $L0 += 0.00000000603*cos(3.81378921927 + 316428.22867391503*$t);
   $L0 += 0.00000000559*cos(1.81894804124 + 17996.0311682222*$t);
   $L0 += 0.00000000437*cos(2.28625594435 + 6303.8512454838*$t);
   $L0 += 0.00000000518*cos(4.86069178322 + 20597.2439630412*$t);
   $L0 += 0.00000000424*cos(6.23520018693 + 6489.2613984286*$t);
   $L0 += 0.00000000518*cos(6.17617826756 + 0.2438174835*$t);
   $L0 += 0.00000000404*cos(5.72804304258 + 5642.1982426092*$t);
   $L0 += 0.00000000458*cos(1.34117773915 + 6287.0080032545*$t);
   $L0 += 0.00000000548*cos(5.68454458320 + 155427.54293624099*$t);
   $L0 += 0.00000000547*cos(1.03391472061 + 3646.3503773544*$t);
   $L0 += 0.00000000428*cos(4.69800981138 + 846.0828347512*$t);
   $L0 += 0.00000000413*cos(6.02520699406 + 6279.4854213396*$t);
   $L0 += 0.00000000534*cos(3.03030638223 + 66567.48586525429*$t);
   $L0 += 0.00000000383*cos(1.49056949125 + 19800.9459562248*$t);
   $L0 += 0.00000000410*cos(5.28319622279 + 18451.07854656599*$t);
   $L0 += 0.00000000352*cos(4.68891600359 + 4907.3020501456*$t);
   $L0 += 0.00000000480*cos(5.36572651091 + 348.924420448*$t);
   $L0 += 0.00000000344*cos(5.89157452896 + 6546.1597733642*$t);
   $L0 += 0.00000000340*cos(0.37557426440 + 13119.72110282519*$t);
   $L0 += 0.00000000434*cos(4.98417785901 + 6702.5604938666*$t);
   $L0 += 0.00000000332*cos(2.68902519126 + 29296.6153895786*$t);
   $L0 += 0.00000000448*cos(2.16478480251 + 5905.7022420756*$t);
   $L0 += 0.00000000344*cos(2.06546633735 + 49.7570254718*$t);
   $L0 += 0.00000000315*cos(1.24023811803 + 4061.2192153944*$t);
   $L0 += 0.00000000324*cos(2.30897526929 + 5017.508371365*$t);
   $L0 += 0.00000000413*cos(0.17171692962 + 6286.6662786432*$t);
   $L0 += 0.00000000431*cos(3.86601101393 + 12489.8856287072*$t);
   $L0 += 0.00000000349*cos(4.55372342974 + 4933.2084403326*$t);
   $L0 += 0.00000000323*cos(0.41971136084 + 10770.8932562618*$t);
   $L0 += 0.00000000341*cos(2.68612860807 + 11.0457002639*$t);
   $L0 += 0.00000000316*cos(3.52936906658 + 17782.7320727842*$t);
   $L0 += 0.00000000315*cos(5.63357264999 + 568.8218740274*$t);
   $L0 += 0.00000000340*cos(3.83571212349 + 10660.6869350424*$t);
   $L0 += 0.00000000297*cos(0.62691416712 + 20995.3929664494*$t);
   $L0 += 0.00000000405*cos(1.00085779471 + 16460.33352952499*$t);
   $L0 += 0.00000000414*cos(1.21998752076 + 51092.7260508548*$t);
   $L0 += 0.00000000336*cos(4.71465945226 + 6179.9830757728*$t);
   $L0 += 0.00000000361*cos(3.71227508354 + 28237.2334593894*$t);
   $L0 += 0.00000000385*cos(6.21925225757 + 24356.7807886416*$t);
   $L0 += 0.00000000327*cos(1.05606504715 + 11919.140866668*$t);
   $L0 += 0.00000000327*cos(6.14222420989 + 6254.6266625236*$t);
   $L0 += 0.00000000268*cos(2.47224339737 + 664.75604513*$t);
   $L0 += 0.00000000269*cos(1.86207884109 + 23141.5583829246*$t);
   $L0 += 0.00000000345*cos(0.93461290184 + 6058.7310542895*$t);
   $L0 += 0.00000000296*cos(4.51687557180 + 6418.1409300268*$t);
   $L0 += 0.00000000353*cos(4.50033653082 + 36949.2308084242*$t);
   $L0 += 0.00000000260*cos(4.04963546305 + 6525.8044539654*$t);
   $L0 += 0.00000000298*cos(2.20046722622 + 156137.47598479928*$t);
   $L0 += 0.00000000253*cos(3.49900838384 + 29864.334027309*$t);
   $L0 += 0.00000000254*cos(2.44901693835 + 5331.3574437408*$t);
   $L0 += 0.00000000296*cos(0.84347588787 + 5729.506447149*$t);
   $L0 += 0.00000000298*cos(1.29194706125 + 22805.7355659936*$t);
   $L0 += 0.00000000241*cos(2.00721280805 + 16737.5772365966*$t);
   $L0 += 0.00000000311*cos(1.23668016334 + 6281.5913772831*$t);
   $L0 += 0.00000000240*cos(2.51650377121 + 6245.0481773556*$t);
   $L0 += 0.00000000332*cos(3.55576945724 + 7668.6374249425*$t);
   $L0 += 0.00000000264*cos(4.44052061202 + 12964.300703391*$t);
   $L0 += 0.00000000257*cos(1.79654471948 + 11080.1715789176*$t);
   $L0 += 0.00000000260*cos(3.33077598420 + 5888.4499649322*$t);
   $L0 += 0.00000000285*cos(0.30886361430 + 11823.1616394502*$t);
   $L0 += 0.00000000290*cos(5.70141882483 + 77.673770428*$t);
   $L0 += 0.00000000255*cos(4.00939664440 + 5881.4037282342*$t);
   $L0 += 0.00000000253*cos(4.73318493678 + 16723.350142595*$t);
   $L0 += 0.00000000228*cos(0.95333661324 + 5540.0857894588*$t);
   $L0 += 0.00000000319*cos(1.38633229189 + 163096.18036118349*$t);
   $L0 += 0.00000000224*cos(1.65156322696 + 10027.9031957292*$t);
   $L0 += 0.00000000226*cos(0.34106460604 + 17796.9591667858*$t);
   $L0 += 0.00000000236*cos(4.19817431922 + 19.66976089979*$t);
   $L0 += 0.00000000280*cos(4.14080268970 + 12539.853380183*$t);
   $L0 += 0.00000000275*cos(5.50306930248 + 32.5325507914*$t);
   $L0 += 0.00000000223*cos(5.23334210294 + 56.8983749356*$t);
   $L0 += 0.00000000217*cos(6.08587881787 + 6805.6532680852*$t);
   $L0 += 0.00000000280*cos(4.52472044653 + 6016.4688082696*$t);
   $L0 += 0.00000000227*cos(5.06509843737 + 6277.552925684*$t);
   $L0 += 0.00000000226*cos(5.17755154305 + 11720.0688652316*$t);
   $L0 += 0.00000000245*cos(3.96486270306 + 22.7752014508*$t);
   $L0 += 0.00000000220*cos(4.72078081970 + 6.62855890001*$t);
   $L0 += 0.00000000207*cos(5.71701403951 + 41.5507909848*$t);
   $L0 += 0.00000000204*cos(3.91227411250 + 2699.7348193176*$t);
   $L0 += 0.00000000209*cos(0.86881969011 + 6321.1035226272*$t);
   $L0 += 0.00000000200*cos(2.11984445273 + 4274.5183108324*$t);
   $L0 += 0.00000000200*cos(5.39839888163 + 6019.9919266186*$t);
   $L0 += 0.00000000209*cos(5.67606291663 + 11293.4706743556*$t);
   $L0 += 0.00000000252*cos(1.64965729351 + 9380.9596727172*$t);
   $L0 += 0.00000000275*cos(5.04826903506 + 73.297125859*$t);
   $L0 += 0.00000000208*cos(1.88207277133 + 11300.5842213564*$t);
   $L0 += 0.00000000272*cos(0.74640926842 + 1975.492545856*$t);
   $L0 += 0.00000000199*cos(3.30836672397 + 22743.4093795164*$t);
   $L0 += 0.00000000269*cos(4.48560812155 + 64471.99124174489*$t);
   $L0 += 0.00000000192*cos(2.17464236325 + 5863.5912061162*$t);
   $L0 += 0.00000000228*cos(5.85373115869 + 128.0188433374*$t);
   $L0 += 0.00000000261*cos(2.64321183295 + 55022.9357470744*$t);
   $L0 += 0.00000000220*cos(5.75012110079 + 29.429508536*$t);
   $L0 += 0.00000000187*cos(4.03230554718 + 467.9649903544*$t);
   $L0 += 0.00000000200*cos(5.60556112058 + 1066.49547719*$t);
   $L0 += 0.00000000231*cos(1.09802712785 + 12341.8069042809*$t);
   $L0 += 0.00000000199*cos(0.29500625200 + 149.5631971346*$t);
   $L0 += 0.00000000249*cos(5.10473210814 + 7875.6718636242*$t);
   $L0 += 0.00000000208*cos(0.93013835019 + 14919.0178537546*$t);
   $L0 += 0.00000000179*cos(0.87104393079 + 12721.572099417*$t);
   $L0 += 0.00000000203*cos(1.56920753653 + 28286.9904848612*$t);
   $L0 += 0.00000000179*cos(2.47036386443 + 16062.1845261168*$t);
   $L0 += 0.00000000198*cos(3.54061588502 + 30.914125635*$t);
   $L0 += 0.00000000171*cos(3.45356518113 + 5327.4761083828*$t);
   $L0 += 0.00000000183*cos(0.72325421604 + 6272.0301497275*$t);
   $L0 += 0.00000000216*cos(2.97174580686 + 19402.7969528166*$t);
   $L0 += 0.00000000168*cos(2.51550550242 + 23937.856389741*$t);
   $L0 += 0.00000000195*cos(0.09045393425 + 156.4007205024*$t);
   $L0 += 0.00000000179*cos(4.49471798090 + 31415.379249957*$t);
   $L0 += 0.00000000216*cos(0.42177594328 + 23539.7073863328*$t);
   $L0 += 0.00000000189*cos(0.37542530191 + 9814.6041002912*$t);
   $L0 += 0.00000000218*cos(2.36835880025 + 16627.3709153772*$t);
   $L0 += 0.00000000166*cos(4.23182968446 + 16840.67001081519*$t);
   $L0 += 0.00000000200*cos(2.02153258098 + 16097.6799502826*$t);
   $L0 += 0.00000000169*cos(0.91318727000 + 95.9792272178*$t);
   $L0 += 0.00000000211*cos(5.73370637657 + 151.8972810852*$t);
   $L0 += 0.00000000204*cos(0.42643085174 + 515.463871093*$t);
   $L0 += 0.00000000212*cos(3.00233538977 + 12043.574281889*$t);
   $L0 += 0.00000000192*cos(5.46153589821 + 6379.0550772092*$t);
   $L0 += 0.00000000165*cos(1.38698167064 + 4171.4255366138*$t);
   $L0 += 0.00000000160*cos(6.23798383332 + 202.2533951741*$t);
   $L0 += 0.00000000215*cos(0.20889073407 + 5621.8429232104*$t);
   $L0 += 0.00000000181*cos(4.12439203622 + 13341.6743113068*$t);
   $L0 += 0.00000000153*cos(1.24460848836 + 29826.3063546732*$t);
   $L0 += 0.00000000150*cos(3.12999753018 + 799.8211251654*$t);
   $L0 += 0.00000000175*cos(4.55671604437 + 239424.39025435288*$t);
   $L0 += 0.00000000192*cos(1.33928820063 + 394.6258850592*$t);
   $L0 += 0.00000000149*cos(2.65697593276 + 21.335640467*$t);
   $L0 += 0.00000000146*cos(5.58021191726 + 412.3710968744*$t);
   $L0 += 0.00000000156*cos(3.75650175503 + 12323.4230960088*$t);
   $L0 += 0.00000000143*cos(3.75708566606 + 58864.5439181463*$t);
   $L0 += 0.00000000143*cos(3.28248547724 + 29.8214381488*$t);
   $L0 += 0.00000000144*cos(1.07862546598 + 1265.5674786264*$t);
   $L0 += 0.00000000148*cos(0.23389236655 + 10021.8372800994*$t);
   $L0 += 0.00000000193*cos(5.92751083086 + 40879.4405046438*$t);
   $L0 += 0.00000000140*cos(4.97612440269 + 158.9435177832*$t);
   $L0 += 0.00000000148*cos(2.61640453469 + 17157.0618804718*$t);
   $L0 += 0.00000000141*cos(3.66871308723 + 26084.0218062162*$t);
   $L0 += 0.00000000147*cos(5.09968173403 + 661.232926781*$t);
   $L0 += 0.00000000146*cos(4.96885605695 + 57375.8019008462*$t);
   $L0 += 0.00000000142*cos(0.78678347839 + 12779.4507954208*$t);
   $L0 += 0.00000000134*cos(4.79432636012 + 111.1866422876*$t);
   $L0 += 0.00000000140*cos(1.27748013377 + 107.6635239386*$t);
   $L0 += 0.00000000169*cos(2.74893543762 + 26735.9452622132*$t);
   $L0 += 0.00000000165*cos(3.95288000638 + 6357.8574485587*$t);
   $L0 += 0.00000000183*cos(5.43418358741 + 369.6998159404*$t);
   $L0 += 0.00000000134*cos(3.09132862833 + 17.812522118*$t);
   $L0 += 0.00000000132*cos(3.05633896779 + 22490.9621214934*$t);
   $L0 += 0.00000000134*cos(4.09472795832 + 6599.467719648*$t);
   $L0 += 0.00000000181*cos(4.22950689891 + 966.9708774356*$t);
   $L0 += 0.00000000152*cos(5.28885894415 + 12669.2444742014*$t);
   $L0 += 0.00000000150*cos(5.86819430908 + 97238.62754448749*$t);
   $L0 += 0.00000000142*cos(5.87266532526 + 22476.73502749179*$t);
   $L0 += 0.00000000145*cos(5.07330784304 + 87.30820453981*$t);
   $L0 += 0.00000000133*cos(5.65471067133 + 31.9723058168*$t);
   $L0 += 0.00000000124*cos(2.83326217072 + 12566.2190102856*$t);
   $L0 += 0.00000000135*cos(3.12861731644 + 32217.2001810808*$t);
   $L0 += 0.00000000137*cos(0.86487461904 + 9924.8104215106*$t);
   $L0 += 0.00000000172*cos(1.98369595114 + 174242.4659640497*$t);
   $L0 += 0.00000000170*cos(4.41115280254 + 327574.51427678125*$t);
   $L0 += 0.00000000151*cos(0.46542099527 + 39609.6545831656*$t);
   $L0 += 0.00000000148*cos(2.13439571118 + 491.6632924588*$t);
   $L0 += 0.00000000153*cos(3.78801830344 + 17363.24742890899*$t);
   $L0 += 0.00000000165*cos(5.31654110459 + 16943.7627850338*$t);
   $L0 += 0.00000000165*cos(4.06747587817 + 58953.145443294*$t);
   $L0 += 0.00000000118*cos(0.63846333239 + 6.0659156298*$t);
   $L0 += 0.00000000159*cos(0.86086959274 + 221995.02880149524*$t);
   $L0 += 0.00000000119*cos(5.96432932413 + 1385.8952763362*$t);
   $L0 += 0.00000000114*cos(5.16516114595 + 25685.872802808*$t);
   $L0 += 0.00000000112*cos(3.39403722178 + 21393.5419698576*$t);
   $L0 += 0.00000000112*cos(4.92889233335 + 56.8032621698*$t);
   $L0 += 0.00000000119*cos(2.40637635942 + 18635.9284545362*$t);
   $L0 += 0.00000000115*cos(0.23374479051 + 418.9243989006*$t);
   $L0 += 0.00000000122*cos(0.93575234049 + 24492.40611365159*$t);
   $L0 += 0.00000000115*cos(4.58880032176 + 26709.6469424134*$t);
   $L0 += 0.00000000130*cos(4.85539251000 + 22345.2603761082*$t);
   $L0 += 0.00000000140*cos(1.09413073202 + 44809.6502008634*$t);
   $L0 += 0.00000000112*cos(6.05401806281 + 433.7117378768*$t);
   $L0 += 0.00000000104*cos(1.54931540602 + 127.9515330346*$t);
   $L0 += 0.00000000105*cos(4.82620858888 + 33794.5437235286*$t);
   $L0 += 0.00000000102*cos(4.12448497391 + 15664.03552270859*$t);
   $L0 += 0.00000000107*cos(4.67919356465 + 77690.75950573849*$t);
   $L0 += 0.00000000118*cos(4.52320170120 + 19004.6479494084*$t);
   $L0 += 0.00000000107*cos(5.71774478555 + 77736.78343050249*$t);
   $L0 += 0.00000000143*cos(1.81201813018 + 4214.0690150848*$t);
   $L0 += 0.00000000125*cos(1.14419195615 + 625.6701923124*$t);
   $L0 += 0.00000000124*cos(3.27736514057 + 12566.08438968*$t);
   $L0 += 0.00000000110*cos(1.08682570828 + 2787.0430238574*$t);
   $L0 += 0.00000000105*cos(1.78318141871 + 18139.2945014159*$t);
   $L0 += 0.00000000102*cos(4.75119578149 + 12242.6462833254*$t);
   $L0 += 0.00000000137*cos(1.43510636754 + 86464.61331683119*$t);
   $L0 += 0.00000000101*cos(4.91289409429 + 401.6721217572*$t);
   $L0 += 0.00000000129*cos(1.23567904485 + 12029.3471878874*$t);
   $L0 += 0.00000000138*cos(2.45654707999 + 7576.560073574*$t);
   $L0 += 0.00000000103*cos(0.40004073416 + 90279.92316810328*$t);
   $L0 += 0.00000000108*cos(0.98989774940 + 5636.0650166766*$t);
   $L0 += 0.00000000117*cos(5.17362872063 + 34520.3093093808*$t);
   $L0 += 0.00000000100*cos(3.95534628189 + 5547.1993364596*$t);
   $L0 += 0.00000000098*cos(1.28118280598 + 21548.9623692918*$t);
   $L0 += 0.00000000097*cos(3.34717130592 + 16310.9790457206*$t);
   $L0 += 0.00000000098*cos(4.37041908717 + 34513.2630726828*$t);
   $L0 += 0.00000000125*cos(2.72164432960 + 24065.80792277559*$t);
   $L0 += 0.00000000102*cos(0.66938025772 + 10239.5838660108*$t);
   $L0 += 0.00000000119*cos(1.21689479331 + 1478.8665740644*$t);
   $L0 += 0.00000000094*cos(1.99595224256 + 13362.4497067992*$t);
   $L0 += 0.00000000094*cos(4.30965982872 + 26880.3198130326*$t);
   $L0 += 0.00000000095*cos(2.89807657534 + 34911.412076091*$t);
   $L0 += 0.00000000106*cos(1.00156653590 + 16522.6597160022*$t);
   $L0 += 0.00000000097*cos(0.89642320201 + 71980.63357473118*$t);
   $L0 += 0.00000000116*cos(4.19967201116 + 206.7007372966*$t);
   $L0 += 0.00000000099*cos(1.37437847718 + 1039.0266107904*$t);
   $L0 += 0.00000000126*cos(3.21642544972 + 305281.94307104882*$t);
   $L0 += 0.00000000094*cos(0.68997876060 + 7834.1210726394*$t);
   $L0 += 0.00000000094*cos(5.58132218606 + 3104.9300594238*$t);
   $L0 += 0.00000000095*cos(3.03823741110 + 8982.810669309*$t);
   $L0 += 0.00000000108*cos(0.52696637156 + 276.7457718644*$t);
   $L0 += 0.00000000124*cos(3.43899862683 + 172146.97134054029*$t);
   $L0 += 0.00000000102*cos(1.04031728553 + 95143.1329209781*$t);
   $L0 += 0.00000000104*cos(3.39218586218 + 290.972865866*$t);
   $L0 += 0.00000000110*cos(3.68205877433 + 22380.755800274*$t);
   $L0 += 0.00000000117*cos(0.78475956902 + 83286.91426955358*$t);
   $L0 += 0.00000000083*cos(0.18241793425 + 15141.390794312*$t);
   $L0 += 0.00000000089*cos(4.45371820659 + 792.7748884674*$t);
   $L0 += 0.00000000082*cos(4.80703651241 + 6819.8803620868*$t);
   $L0 += 0.00000000087*cos(3.43122851097 + 27707.5424942948*$t);
   $L0 += 0.00000000101*cos(5.32081603011 + 2301.58581590939*$t);
   $L0 += 0.00000000082*cos(0.87060089842 + 10241.2022911672*$t);
   $L0 += 0.00000000086*cos(4.61919461931 + 36147.4098773004*$t);
   $L0 += 0.00000000095*cos(2.87032884659 + 23020.65308658799*$t);
   $L0 += 0.00000000088*cos(3.21133165690 + 33326.5787331742*$t);
   $L0 += 0.00000000080*cos(1.84900424847 + 21424.4666443034*$t);
   $L0 += 0.00000000101*cos(4.18796434479 + 30666.1549584328*$t);
   $L0 += 0.00000000107*cos(5.77864921649 + 34115.1140692746*$t);
   $L0 += 0.00000000104*cos(1.08739495962 + 6288.5987742988*$t);
   $L0 += 0.00000000110*cos(3.32898859416 + 72140.62866668739*$t);
   $L0 += 0.00000000087*cos(4.40657711727 + 142.1786270362*$t);
   $L0 += 0.00000000109*cos(1.94546030825 + 24279.10701821359*$t);
   $L0 += 0.00000000087*cos(4.32472045435 + 742.9900605326*$t);
   $L0 += 0.00000000107*cos(4.91580912547 + 277.0349937414*$t);
   $L0 += 0.00000000088*cos(2.10180220766 + 26482.1708096244*$t);
   $L0 += 0.00000000086*cos(4.01887374432 + 12491.3701014155*$t);
   $L0 += 0.00000000106*cos(5.49092372854 + 62883.3551395136*$t);
   $L0 += 0.00000000080*cos(6.19781316983 + 6709.6740408674*$t);
   $L0 += 0.00000000088*cos(2.09872810657 + 238004.52415723629*$t);
   $L0 += 0.00000000083*cos(4.90662164029 + 51.28033786241*$t);
   $L0 += 0.00000000095*cos(4.13387406591 + 18216.443810661*$t);
   $L0 += 0.00000000078*cos(6.06949391680 + 148434.53403769129*$t);
   $L0 += 0.00000000079*cos(3.03048221644 + 838.9692877504*$t);
   $L0 += 0.00000000074*cos(5.49813051211 + 29026.48522950779*$t);
   $L0 += 0.00000000073*cos(3.05008665738 + 567.7186377304*$t);
   $L0 += 0.00000000084*cos(0.46604373274 + 45.1412196366*$t);
   $L0 += 0.00000000093*cos(2.52267536308 + 48739.859897083*$t);
   $L0 += 0.00000000076*cos(1.76418124905 + 41654.9631159678*$t);
   $L0 += 0.00000000067*cos(5.77851227793 + 6311.5250374592*$t);
   $L0 += 0.00000000062*cos(3.32967880172 + 15508.6151232744*$t);
   $L0 += 0.00000000079*cos(5.59773841328 + 71960.38658322369*$t);
   $L0 += 0.00000000057*cos(3.90629505268 + 5999.2165311262*$t);
   $L0 += 0.00000000061*cos(0.05695043232 + 7856.89627409019*$t);
   $L0 += 0.00000000061*cos(5.63297958433 + 7863.9425107882*$t);
   $L0 += 0.00000000065*cos(3.72178394016 + 12573.2652469836*$t);
   $L0 += 0.00000000057*cos(4.18217219541 + 26087.9031415742*$t);
   $L0 += 0.00000000066*cos(3.92262333487 + 69853.35207568129*$t);
   $L0 += 0.00000000053*cos(5.51119362045 + 77710.24834977149*$t);
   $L0 += 0.00000000053*cos(4.88573986961 + 77717.29458646949*$t);
   $L0 += 0.00000000062*cos(2.88876342225 + 9411.4646150872*$t);
   $L0 += 0.00000000051*cos(1.12657183874 + 82576.98122099529*$t);
   $L0 += 0.00000000045*cos(2.95671076719 + 24602.61243487099*$t);
   $L0 += 0.00000000040*cos(5.55145719241 + 12565.1713789146*$t);
   $L0 += 0.00000000039*cos(1.20838190039 + 18842.11400297339*$t);
   $L0 += 0.00000000045*cos(3.18590558749 + 45585.1728121874*$t);
   $L0 += 0.00000000049*cos(2.44790934886 + 13613.804277336*$t);
   return $L0;
}



   function Earth_L1($t) // 341 terms of order 1
{
   $L1  = 6283.31966747491;
   $L1 += 0.00206058863*cos(2.67823455584 + 6283.0758499914*$t);
   $L1 += 0.00004303430*cos(2.63512650414 + 12566.1516999828*$t);
   $L1 += 0.00000425264*cos(1.59046980729 + 3.523118349*$t);
   $L1 += 0.00000108977*cos(2.96618001993 + 1577.3435424478*$t);
   $L1 += 0.00000093478*cos(2.59212835365 + 18849.2275499742*$t);
   $L1 += 0.00000119261*cos(5.79557487799 + 26.2983197998*$t);
   $L1 += 0.00000072122*cos(1.13846158196 + 529.6909650946*$t);
   $L1 += 0.00000067768*cos(1.87472304791 + 398.1490034082*$t);
   $L1 += 0.00000067327*cos(4.40918235168 + 5507.5532386674*$t);
   $L1 += 0.00000059027*cos(2.88797038460 + 5223.6939198022*$t);
   $L1 += 0.00000055976*cos(2.17471680261 + 155.4203994342*$t);
   $L1 += 0.00000045407*cos(0.39803079805 + 796.2980068164*$t);
   $L1 += 0.00000036369*cos(0.46624739835 + 775.522611324*$t);
   $L1 += 0.00000028958*cos(2.64707383882 + 7.1135470008*$t);
   $L1 += 0.00000019097*cos(1.84628332577 + 5486.777843175*$t);
   $L1 += 0.00000020844*cos(5.34138275149 + 0.9803210682*$t);
   $L1 += 0.00000018508*cos(4.96855124577 + 213.299095438*$t);
   $L1 += 0.00000016233*cos(0.03216483047 + 2544.3144198834*$t);
   $L1 += 0.00000017293*cos(2.99116864949 + 6275.9623029906*$t);
   $L1 += 0.00000015832*cos(1.43049285325 + 2146.1654164752*$t);
   $L1 += 0.00000014615*cos(1.20532366323 + 10977.078804699*$t);
   $L1 += 0.00000011877*cos(3.25804815607 + 5088.6288397668*$t);
   $L1 += 0.00000011514*cos(2.07502418155 + 4694.0029547076*$t);
   $L1 += 0.00000009721*cos(4.23925472239 + 1349.8674096588*$t);
   $L1 += 0.00000009969*cos(1.30262991097 + 6286.5989683404*$t);
   $L1 += 0.00000009452*cos(2.69957062864 + 242.728603974*$t);
   $L1 += 0.00000012461*cos(2.83432285512 + 1748.016413067*$t);
   $L1 += 0.00000011808*cos(5.27379790480 + 1194.4470102246*$t);
   $L1 += 0.00000008577*cos(5.64475868067 + 951.7184062506*$t);
   $L1 += 0.00000010641*cos(0.76614199202 + 553.5694028424*$t);
   $L1 += 0.00000007576*cos(5.30062664886 + 2352.8661537718*$t);
   $L1 += 0.00000005834*cos(1.76649917904 + 1059.3819301892*$t);
   $L1 += 0.00000006385*cos(2.65033984967 + 9437.762934887*$t);
   $L1 += 0.00000005223*cos(5.66135767624 + 71430.69561812909*$t);
   $L1 += 0.00000005305*cos(0.90857521574 + 3154.6870848956*$t);
   $L1 += 0.00000006101*cos(4.66632584188 + 4690.4798363586*$t);
   $L1 += 0.00000004330*cos(0.24102555403 + 6812.766815086*$t);
   $L1 += 0.00000005041*cos(1.42490103709 + 6438.4962494256*$t);
   $L1 += 0.00000004259*cos(0.77355900599 + 10447.3878396044*$t);
   $L1 += 0.00000005198*cos(1.85353197345 + 801.8209311238*$t);
   $L1 += 0.00000003744*cos(2.00119516488 + 8031.0922630584*$t);
   $L1 += 0.00000003558*cos(2.42901552681 + 14143.4952424306*$t);
   $L1 += 0.00000003372*cos(3.86210700128 + 1592.5960136328*$t);
   $L1 += 0.00000003374*cos(0.88776219727 + 12036.4607348882*$t);
   $L1 += 0.00000003175*cos(3.18785710594 + 4705.7323075436*$t);
   $L1 += 0.00000003221*cos(0.61599835472 + 8429.2412664666*$t);
   $L1 += 0.00000004132*cos(5.23992859705 + 7084.8967811152*$t);
   $L1 += 0.00000002970*cos(6.07026318493 + 4292.3308329504*$t);
   $L1 += 0.00000002900*cos(2.32464208411 + 20.3553193988*$t);
   $L1 += 0.00000003504*cos(4.79975694359 + 6279.5527316424*$t);
   $L1 += 0.00000002950*cos(1.43108874817 + 5746.271337896*$t);
   $L1 += 0.00000002697*cos(4.80368225199 + 7234.794256242*$t);
   $L1 += 0.00000002531*cos(6.22290682655 + 6836.6452528338*$t);
   $L1 += 0.00000002745*cos(0.93466065396 + 5760.4984318976*$t);
   $L1 += 0.00000003250*cos(3.39954640038 + 7632.9432596502*$t);
   $L1 += 0.00000002277*cos(5.00277837672 + 17789.845619785*$t);
   $L1 += 0.00000002075*cos(3.95534978634 + 10213.285546211*$t);
   $L1 += 0.00000002061*cos(2.22411683077 + 5856.4776591154*$t);
   $L1 += 0.00000002252*cos(5.67166499885 + 11499.6562227928*$t);
   $L1 += 0.00000002148*cos(5.20184578235 + 11513.8833167944*$t);
   $L1 += 0.00000001886*cos(0.53198320577 + 3340.6124266998*$t);
   $L1 += 0.00000001875*cos(4.73511970207 + 83996.84731811189*$t);
   $L1 += 0.00000002060*cos(2.54987293999 + 25132.3033999656*$t);
   $L1 += 0.00000001794*cos(1.47435409831 + 4164.311989613*$t);
   $L1 += 0.00000001778*cos(3.02473091781 + 5.5229243074*$t);
   $L1 += 0.00000002029*cos(0.90960209983 + 6256.7775301916*$t);
   $L1 += 0.00000002075*cos(2.26767270157 + 522.5774180938*$t);
   $L1 += 0.00000001772*cos(3.02622802353 + 5753.3848848968*$t);
   $L1 += 0.00000001569*cos(6.12410242782 + 5216.5803728014*$t);
   $L1 += 0.00000001590*cos(4.63713748247 + 3.2863574178*$t);
   $L1 += 0.00000001542*cos(4.20004448567 + 13367.9726311066*$t);
   $L1 += 0.00000001427*cos(1.19088061711 + 3894.1818295422*$t);
   $L1 += 0.00000001375*cos(3.09301252193 + 135.0650800354*$t);
   $L1 += 0.00000001359*cos(4.24532506641 + 426.598190876*$t);
   $L1 += 0.00000001340*cos(5.76511818622 + 6040.3472460174*$t);
   $L1 += 0.00000001284*cos(3.08524663344 + 5643.1785636774*$t);
   $L1 += 0.00000001250*cos(3.07748157144 + 11926.2544136688*$t);
   $L1 += 0.00000001551*cos(3.07665451458 + 6681.2248533996*$t);
   $L1 += 0.00000001268*cos(2.09196018331 + 6290.1893969922*$t);
   $L1 += 0.00000001144*cos(3.24444699514 + 12168.0026965746*$t);
   $L1 += 0.00000001248*cos(3.44504937285 + 536.8045120954*$t);
   $L1 += 0.00000001118*cos(2.31829670425 + 16730.4636895958*$t);
   $L1 += 0.00000001105*cos(5.31966001019 + 23.8784377478*$t);
   $L1 += 0.00000001051*cos(3.75015946014 + 7860.4193924392*$t);
   $L1 += 0.00000001025*cos(2.44688534235 + 1990.745017041*$t);
   $L1 += 0.00000000962*cos(0.81771017882 + 3.881335358*$t);
   $L1 += 0.00000000910*cos(0.41727865299 + 7079.3738568078*$t);
   $L1 += 0.00000000883*cos(5.16833917651 + 11790.6290886588*$t);
   $L1 += 0.00000000957*cos(4.07673573735 + 6127.6554505572*$t);
   $L1 += 0.00000001110*cos(3.90096793825 + 11506.7697697936*$t);
   $L1 += 0.00000000802*cos(3.88778875582 + 10973.55568635*$t);
   $L1 += 0.00000000780*cos(2.39934293755 + 1589.0728952838*$t);
   $L1 += 0.00000000758*cos(1.30034364248 + 103.0927742186*$t);
   $L1 += 0.00000000749*cos(4.96275803300 + 6496.3749454294*$t);
   $L1 += 0.00000000765*cos(3.36312388424 + 36.0278666774*$t);
   $L1 += 0.00000000915*cos(5.41543742089 + 206.1855484372*$t);
   $L1 += 0.00000000776*cos(2.57589093871 + 11371.7046897582*$t);
   $L1 += 0.00000000772*cos(3.98369209464 + 955.5997416086*$t);
   $L1 += 0.00000000749*cos(5.17890001805 + 10969.9652576982*$t);
   $L1 += 0.00000000806*cos(0.34218864254 + 9917.6968745098*$t);
   $L1 += 0.00000000728*cos(5.20962563787 + 38.0276726358*$t);
   $L1 += 0.00000000685*cos(2.77592961854 + 20.7753954924*$t);
   $L1 += 0.00000000636*cos(4.28242193632 + 28.4491874678*$t);
   $L1 += 0.00000000608*cos(5.63278508906 + 10984.1923516998*$t);
   $L1 += 0.00000000704*cos(5.60738823665 + 3738.761430108*$t);
   $L1 += 0.00000000685*cos(0.38876148682 + 15.252471185*$t);
   $L1 += 0.00000000601*cos(0.73489602442 + 419.4846438752*$t);
   $L1 += 0.00000000716*cos(2.65279791438 + 6309.3741697912*$t);
   $L1 += 0.00000000584*cos(5.54502568227 + 17298.1823273262*$t);
   $L1 += 0.00000000650*cos(1.13379656406 + 7058.5984613154*$t);
   $L1 += 0.00000000688*cos(2.59683891779 + 3496.032826134*$t);
   $L1 += 0.00000000485*cos(0.44467180946 + 12352.8526045448*$t);
   $L1 += 0.00000000528*cos(2.74936967681 + 3930.2096962196*$t);
   $L1 += 0.00000000597*cos(5.27668281777 + 10575.4066829418*$t);
   $L1 += 0.00000000583*cos(3.18929067810 + 4732.0306273434*$t);
   $L1 += 0.00000000526*cos(5.01697321546 + 5884.9268465832*$t);
   $L1 += 0.00000000540*cos(1.29175137075 + 640.8776073822*$t);
   $L1 += 0.00000000473*cos(5.49953306970 + 5230.807466803*$t);
   $L1 += 0.00000000406*cos(5.21248452189 + 220.4126424388*$t);
   $L1 += 0.00000000395*cos(1.87474483222 + 16200.7727245012*$t);
   $L1 += 0.00000000370*cos(3.84921354713 + 18073.7049386502*$t);
   $L1 += 0.00000000367*cos(0.88533542778 + 6283.14316029419*$t);
   $L1 += 0.00000000379*cos(0.37983009325 + 10177.2576795336*$t);
   $L1 += 0.00000000356*cos(3.84145204913 + 11712.9553182308*$t);
   $L1 += 0.00000000374*cos(5.01577520608 + 7.046236698*$t);
   $L1 += 0.00000000381*cos(4.30250406634 + 6062.6632075526*$t);
   $L1 += 0.00000000471*cos(0.86381834647 + 6069.7767545534*$t);
   $L1 += 0.00000000367*cos(1.32943839763 + 6283.0085396886*$t);
   $L1 += 0.00000000460*cos(5.19667219575 + 6284.0561710596*$t);
   $L1 += 0.00000000333*cos(5.54256205741 + 4686.8894077068*$t);
   $L1 += 0.00000000341*cos(4.36522989934 + 7238.67559160*$t);
   $L1 += 0.00000000336*cos(4.00205876835 + 3097.88382272579*$t);
   $L1 += 0.00000000359*cos(6.22679790284 + 245.8316462294*$t);
   $L1 += 0.00000000307*cos(2.35299010924 + 170.6728706192*$t);
   $L1 += 0.00000000343*cos(3.77164927143 + 6076.8903015542*$t);
   $L1 += 0.00000000296*cos(5.44152227481 + 17260.1546546904*$t);
   $L1 += 0.00000000328*cos(0.13837875384 + 11015.1064773348*$t);
   $L1 += 0.00000000268*cos(1.13904550630 + 12569.6748183318*$t);
   $L1 += 0.00000000263*cos(0.00538633678 + 4136.9104335162*$t);
   $L1 += 0.00000000282*cos(5.04399837480 + 7477.522860216*$t);
   $L1 += 0.00000000288*cos(3.13401177517 + 12559.038152982*$t);
   $L1 += 0.00000000259*cos(0.93882269387 + 5642.1982426092*$t);
   $L1 += 0.00000000292*cos(1.98420020514 + 12132.439962106*$t);
   $L1 += 0.00000000247*cos(3.84244798532 + 5429.8794682394*$t);
   $L1 += 0.00000000245*cos(5.70467521726 + 65147.6197681377*$t);
   $L1 += 0.00000000241*cos(0.99480969552 + 3634.6210245184*$t);
   $L1 += 0.00000000246*cos(3.06168069935 + 110.2063212194*$t);
   $L1 += 0.00000000239*cos(6.11855909114 + 11856.2186514245*$t);
   $L1 += 0.00000000263*cos(0.66348415419 + 21228.3920235458*$t);
   $L1 += 0.00000000262*cos(1.51070507866 + 12146.6670561076*$t);
   $L1 += 0.00000000230*cos(1.75927314884 + 9779.1086761254*$t);
   $L1 += 0.00000000223*cos(2.00967043606 + 6172.869528772*$t);
   $L1 += 0.00000000246*cos(1.10411690865 + 6282.0955289232*$t);
   $L1 += 0.00000000221*cos(3.03945240854 + 8635.9420037632*$t);
   $L1 += 0.00000000214*cos(4.03840869663 + 14314.1681130498*$t);
   $L1 += 0.00000000236*cos(5.46915070580 + 13916.0191096416*$t);
   $L1 += 0.00000000224*cos(4.68408089456 + 24072.9214697764*$t);
   $L1 += 0.00000000212*cos(2.13695625494 + 5849.3641121146*$t);
   $L1 += 0.00000000207*cos(3.07724246401 + 11.729352836*$t);
   $L1 += 0.00000000207*cos(6.10306282747 + 23543.23050468179*$t);
   $L1 += 0.00000000266*cos(1.00709566823 + 2388.8940204492*$t);
   $L1 += 0.00000000217*cos(6.27837036335 + 17267.26820169119*$t);
   $L1 += 0.00000000204*cos(2.34615348695 + 266.6070417218*$t);
   $L1 += 0.00000000195*cos(5.55015549753 + 6133.5126528568*$t);
   $L1 += 0.00000000188*cos(2.52667166175 + 6525.8044539654*$t);
   $L1 += 0.00000000185*cos(0.90960768344 + 18319.5365848796*$t);
   $L1 += 0.00000000177*cos(1.73429218289 + 154717.60988768269*$t);
   $L1 += 0.00000000187*cos(4.76483647432 + 4535.0594369244*$t);
   $L1 += 0.00000000186*cos(4.63080493407 + 10440.2742926036*$t);
   $L1 += 0.00000000215*cos(2.81255454560 + 7342.4577801806*$t);
   $L1 += 0.00000000172*cos(1.45551888559 + 9225.539273283*$t);
   $L1 += 0.00000000162*cos(3.30661909388 + 639.897286314*$t);
   $L1 += 0.00000000168*cos(2.17671416605 + 27.4015560968*$t);
   $L1 += 0.00000000160*cos(1.68164180475 + 15110.4661198662*$t);
   $L1 += 0.00000000158*cos(0.13519771874 + 13095.8426650774*$t);
   $L1 += 0.00000000183*cos(0.56281322071 + 13517.8701062334*$t);
   $L1 += 0.00000000179*cos(3.58450811616 + 87.30820453981*$t);
   $L1 += 0.00000000152*cos(2.84070476818 + 5650.2921106782*$t);
   $L1 += 0.00000000182*cos(0.44065530624 + 17253.04110768959*$t);
   $L1 += 0.00000000160*cos(5.95767264171 + 4701.1165017084*$t);
   $L1 += 0.00000000142*cos(1.46290137520 + 11087.2851259184*$t);
   $L1 += 0.00000000142*cos(2.04464036087 + 20426.571092422*$t);
   $L1 += 0.00000000131*cos(5.40912137746 + 2699.7348193176*$t);
   $L1 += 0.00000000144*cos(2.07312090485 + 25158.6017197654*$t);
   $L1 += 0.00000000147*cos(6.15106982168 + 9623.6882766912*$t);
   $L1 += 0.00000000141*cos(5.55739979498 + 10454.5013866052*$t);
   $L1 += 0.00000000135*cos(0.06098110407 + 16723.350142595*$t);
   $L1 += 0.00000000124*cos(5.81218025669 + 17256.6315363414*$t);
   $L1 += 0.00000000124*cos(2.36293551623 + 4933.2084403326*$t);
   $L1 += 0.00000000126*cos(3.47435905118 + 22483.84857449259*$t);
   $L1 += 0.00000000159*cos(5.63954754618 + 5729.506447149*$t);
   $L1 += 0.00000000123*cos(3.92815963256 + 17996.0311682222*$t);
   $L1 += 0.00000000148*cos(3.02509280598 + 1551.045222648*$t);
   $L1 += 0.00000000120*cos(5.91904349732 + 6206.8097787158*$t);
   $L1 += 0.00000000134*cos(3.11122937825 + 21954.15760939799*$t);
   $L1 += 0.00000000119*cos(5.52141123450 + 709.9330485583*$t);
   $L1 += 0.00000000122*cos(3.00813429479 + 19800.9459562248*$t);
   $L1 += 0.00000000127*cos(1.37618620001 + 14945.3161735544*$t);
   $L1 += 0.00000000141*cos(2.56889468729 + 1052.2683831884*$t);
   $L1 += 0.00000000123*cos(2.83671175442 + 11919.140866668*$t);
   $L1 += 0.00000000118*cos(0.81934438215 + 5331.3574437408*$t);
   $L1 += 0.00000000151*cos(2.68731829165 + 11769.8536931664*$t);
   $L1 += 0.00000000119*cos(5.08835797638 + 5481.2549188676*$t);
   $L1 += 0.00000000153*cos(2.46021790779 + 11933.3679606696*$t);
   $L1 += 0.00000000108*cos(1.04936452145 + 11403.676995575*$t);
   $L1 += 0.00000000128*cos(0.99794735107 + 8827.3902698748*$t);
   $L1 += 0.00000000144*cos(2.54869747042 + 227.476132789*$t);
   $L1 += 0.00000000150*cos(4.50631437136 + 2379.1644735716*$t);
   $L1 += 0.00000000107*cos(1.79272017026 + 13119.72110282519*$t);
   $L1 += 0.00000000107*cos(4.43556814486 + 18422.62935909819*$t);
   $L1 += 0.00000000109*cos(0.29269062317 + 16737.5772365966*$t);
   $L1 += 0.00000000141*cos(3.18979826258 + 6262.300454499*$t);
   $L1 += 0.00000000122*cos(4.23040027813 + 29.429508536*$t);
   $L1 += 0.00000000111*cos(5.16954029551 + 17782.7320727842*$t);
   $L1 += 0.00000000100*cos(3.52213872761 + 18052.9295431578*$t);
   $L1 += 0.00000000108*cos(1.08514212991 + 16858.4825329332*$t);
   $L1 += 0.00000000106*cos(1.96085248410 + 74.7815985673*$t);
   $L1 += 0.00000000110*cos(2.30582372873 + 16460.33352952499*$t);
   $L1 += 0.00000000097*cos(3.50918940210 + 5333.9002410216*$t);
   $L1 += 0.00000000099*cos(3.56417337974 + 735.8765135318*$t);
   $L1 += 0.00000000094*cos(5.01857894228 + 3128.3887650958*$t);
   $L1 += 0.00000000097*cos(1.65579893894 + 533.2140834436*$t);
   $L1 += 0.00000000092*cos(0.89217162285 + 29296.6153895786*$t);
   $L1 += 0.00000000123*cos(3.16062050433 + 9380.9596727172*$t);
   $L1 += 0.00000000102*cos(1.20493500565 + 23020.65308658799*$t);
   $L1 += 0.00000000088*cos(2.21296088224 + 12721.572099417*$t);
   $L1 += 0.00000000089*cos(1.54264720310 + 20199.094959633*$t);
   $L1 += 0.00000000113*cos(4.83320707870 + 16496.3613962024*$t);
   $L1 += 0.00000000121*cos(6.19860353182 + 9388.0059094152*$t);
   $L1 += 0.00000000089*cos(4.08082274765 + 22805.7355659936*$t);
   $L1 += 0.00000000098*cos(1.09181832830 + 12043.574281889*$t);
   $L1 += 0.00000000086*cos(1.13655027605 + 143571.32428481648*$t);
   $L1 += 0.00000000088*cos(5.96980472191 + 107.6635239386*$t);
   $L1 += 0.00000000082*cos(5.01340404594 + 22003.9146348698*$t);
   $L1 += 0.00000000094*cos(1.69615700473 + 23006.42599258639*$t);
   $L1 += 0.00000000081*cos(3.00657814365 + 2118.7638603784*$t);
   $L1 += 0.00000000098*cos(1.39215287161 + 8662.240323563*$t);
   $L1 += 0.00000000077*cos(3.33555190840 + 15720.8387848784*$t);
   $L1 += 0.00000000082*cos(5.86880116464 + 2787.0430238574*$t);
   $L1 += 0.00000000076*cos(5.67183650604 + 14.2270940016*$t);
   $L1 += 0.00000000081*cos(6.16619455699 + 1039.0266107904*$t);
   $L1 += 0.00000000076*cos(3.21449884756 + 111.1866422876*$t);
   $L1 += 0.00000000078*cos(1.37531518377 + 21947.11137270*$t);
   $L1 += 0.00000000074*cos(3.58814195051 + 11609.8625440122*$t);
   $L1 += 0.00000000077*cos(4.84846488388 + 22743.4093795164*$t);
   $L1 += 0.00000000090*cos(1.48869013606 + 15671.0817594066*$t);
   $L1 += 0.00000000082*cos(3.48618399109 + 29088.811415985*$t);
   $L1 += 0.00000000069*cos(3.55746476593 + 4590.910180489*$t);
   $L1 += 0.00000000069*cos(1.93625656075 + 135.62532501*$t);
   $L1 += 0.00000000070*cos(2.66548322237 + 18875.525869774*$t);
   $L1 += 0.00000000069*cos(5.41478093731 + 26735.9452622132*$t);
   $L1 += 0.00000000079*cos(5.15154513662 + 12323.4230960088*$t);
   $L1 += 0.00000000094*cos(3.62899392448 + 77713.7714681205*$t);
   $L1 += 0.00000000078*cos(4.17011182047 + 1066.49547719*$t);
   $L1 += 0.00000000071*cos(3.89435637865 + 22779.4372461938*$t);
   $L1 += 0.00000000063*cos(4.53968787714 + 8982.810669309*$t);
   $L1 += 0.00000000069*cos(0.96028230548 + 14919.0178537546*$t);
   $L1 += 0.00000000076*cos(3.29092216589 + 2942.4634232916*$t);
   $L1 += 0.00000000063*cos(4.09167842893 + 16062.1845261168*$t);
   $L1 += 0.00000000065*cos(3.34580407184 + 51.28033786241*$t);
   $L1 += 0.00000000065*cos(5.75757544877 + 52670.0695933026*$t);
   $L1 += 0.00000000068*cos(5.75884067555 + 21424.4666443034*$t);
   $L1 += 0.00000000057*cos(5.45122399850 + 12592.4500197826*$t);
   $L1 += 0.00000000057*cos(5.25043362558 + 20995.3929664494*$t);
   $L1 += 0.00000000073*cos(0.53299090807 + 2301.58581590939*$t);
   $L1 += 0.00000000070*cos(4.31243357502 + 19402.7969528166*$t);
   $L1 += 0.00000000067*cos(2.53852336668 + 377.3736079158*$t);
   $L1 += 0.00000000056*cos(3.20816844695 + 24889.5747959916*$t);
   $L1 += 0.00000000053*cos(3.17816599142 + 18451.07854656599*$t);
   $L1 += 0.00000000053*cos(3.61529270216 + 77.673770428*$t);
   $L1 += 0.00000000053*cos(0.45467549335 + 30666.1549584328*$t);
   $L1 += 0.00000000061*cos(0.14807288453 + 23013.5395395872*$t);
   $L1 += 0.00000000051*cos(3.32803972907 + 56.8983749356*$t);
   $L1 += 0.00000000052*cos(3.41177624177 + 23141.5583829246*$t);
   $L1 += 0.00000000058*cos(3.13638677202 + 309.2783226558*$t);
   $L1 += 0.00000000070*cos(2.50592323465 + 31415.379249957*$t);
   $L1 += 0.00000000052*cos(5.10673376738 + 17796.9591667858*$t);
   $L1 += 0.00000000067*cos(6.27917920454 + 22345.2603761082*$t);
   $L1 += 0.00000000050*cos(0.42577644151 + 25685.872802808*$t);
   $L1 += 0.00000000048*cos(0.70204553333 + 1162.4747044078*$t);
   $L1 += 0.00000000066*cos(3.64350022359 + 15265.8865193004*$t);
   $L1 += 0.00000000050*cos(5.74382917440 + 19.66976089979*$t);
   $L1 += 0.00000000050*cos(4.69825387775 + 28237.2334593894*$t);
   $L1 += 0.00000000047*cos(5.74015846442 + 12139.5535091068*$t);
   $L1 += 0.00000000054*cos(1.97301333704 + 23581.2581773176*$t);
   $L1 += 0.00000000049*cos(4.98223579027 + 10021.8372800994*$t);
   $L1 += 0.00000000046*cos(5.41431705539 + 33019.0211122046*$t);
   $L1 += 0.00000000051*cos(1.23882053879 + 12539.853380183*$t);
   $L1 += 0.00000000046*cos(2.41369976086 + 98068.53671630539*$t);
   $L1 += 0.00000000044*cos(0.80750593746 + 167283.76158766549*$t);
   $L1 += 0.00000000045*cos(4.39613584445 + 433.7117378768*$t);
   $L1 += 0.00000000044*cos(2.57358208785 + 12964.300703391*$t);
   $L1 += 0.00000000046*cos(0.26142733448 + 11.0457002639*$t);
   $L1 += 0.00000000045*cos(2.46230645202 + 51868.2486621788*$t);
   $L1 += 0.00000000048*cos(0.89551707131 + 56600.2792895222*$t);
   $L1 += 0.00000000057*cos(1.86416707010 + 25287.7237993998*$t);
   $L1 += 0.00000000042*cos(5.26377513431 + 26084.0218062162*$t);
   $L1 += 0.00000000049*cos(3.17757670611 + 6303.8512454838*$t);
   $L1 += 0.00000000052*cos(3.65266055509 + 7872.1487452752*$t);
   $L1 += 0.00000000040*cos(1.81891629936 + 34596.3646546524*$t);
   $L1 += 0.00000000043*cos(1.94164978061 + 1903.4368125012*$t);
   $L1 += 0.00000000041*cos(0.74461854136 + 23937.856389741*$t);
   $L1 += 0.00000000048*cos(6.26034008181 + 28286.9904848612*$t);
   $L1 += 0.00000000045*cos(5.45575017530 + 60530.4889857418*$t);
   $L1 += 0.00000000040*cos(2.92105728682 + 21548.9623692918*$t);
   $L1 += 0.00000000040*cos(0.04502010161 + 38526.574350872*$t);
   $L1 += 0.00000000053*cos(3.64791042082 + 11925.2740926006*$t);
   $L1 += 0.00000000041*cos(5.04048954693 + 27832.0382192832*$t);
   $L1 += 0.00000000042*cos(5.19292937193 + 19004.6479494084*$t);
   $L1 += 0.00000000040*cos(2.57120233428 + 24356.7807886416*$t);
   $L1 += 0.00000000038*cos(3.49190341464 + 226858.23855437008*$t);
   $L1 += 0.00000000039*cos(4.61184303844 + 95.9792272178*$t);
   $L1 += 0.00000000043*cos(2.20648228147 + 13521.7514415914*$t);
   $L1 += 0.00000000040*cos(5.83461945819 + 16193.65917750039*$t);
   $L1 += 0.00000000045*cos(3.73714372195 + 7875.6718636242*$t);
   $L1 += 0.00000000043*cos(1.14078465002 + 49.7570254718*$t);
   $L1 += 0.00000000037*cos(1.29390383811 + 310.8407988684*$t);
   $L1 += 0.00000000038*cos(0.95970925950 + 664.75604513*$t);
   $L1 += 0.00000000037*cos(4.27532649462 + 6709.6740408674*$t);
   $L1 += 0.00000000038*cos(2.20108541046 + 28628.3362260996*$t);
   $L1 += 0.00000000039*cos(0.85957361635 + 16522.6597160022*$t);
   $L1 += 0.00000000040*cos(4.35214003837 + 48739.859897083*$t);
   $L1 += 0.00000000036*cos(1.68167662194 + 10344.2950653858*$t);
   $L1 += 0.00000000040*cos(5.13217319067 + 15664.03552270859*$t);
   $L1 += 0.00000000036*cos(3.72187132496 + 30774.5016425748*$t);
   $L1 += 0.00000000036*cos(3.32158458257 + 16207.886271502*$t);
   $L1 += 0.00000000045*cos(3.94202418608 + 10988.808157535*$t);
   $L1 += 0.00000000039*cos(1.51948786199 + 12029.3471878874*$t);
   $L1 += 0.00000000026*cos(3.87685883180 + 6262.7205305926*$t);
   $L1 += 0.00000000024*cos(4.91804163466 + 19651.048481098*$t);
   $L1 += 0.00000000023*cos(0.29300197709 + 13362.4497067992*$t);
   $L1 += 0.00000000021*cos(3.18605672363 + 6277.552925684*$t);
   $L1 += 0.00000000021*cos(6.07546891132 + 18139.2945014159*$t);
   $L1 += 0.00000000022*cos(2.31199937177 + 6303.4311693902*$t);
   $L1 += 0.00000000021*cos(3.58418394393 + 18209.33026366019*$t);
   $L1 += 0.00000000026*cos(2.06801296900 + 12573.2652469836*$t);
   $L1 += 0.00000000021*cos(1.56857722317 + 13341.6743113068*$t);
   $L1 += 0.00000000024*cos(5.72605158675 + 29864.334027309*$t);
   $L1 += 0.00000000024*cos(1.40237993205 + 14712.317116458*$t);
   $L1 += 0.00000000025*cos(5.71466092822 + 25934.1243310894*$t);
   return $L1*$t;
}



   function Earth_L2($t) // 142 terms of order 2
{
   $L2  = 0.00052918870;
   $L2 += 0.00008719837*cos(1.07209665242 + 6283.0758499914*$t);
   $L2 += 0.00000309125*cos(0.86728818832 + 12566.1516999828*$t);
   $L2 += 0.00000027339*cos(0.05297871691 + 3.523118349*$t);
   $L2 += 0.00000016334*cos(5.18826691036 + 26.2983197998*$t);
   $L2 += 0.00000015752*cos(3.68457889430 + 155.4203994342*$t);
   $L2 += 0.00000009541*cos(0.75742297675 + 18849.2275499742*$t);
   $L2 += 0.00000008937*cos(2.05705419118 + 77713.7714681205*$t);
   $L2 += 0.00000006952*cos(0.82673305410 + 775.522611324*$t);
   $L2 += 0.00000005064*cos(4.66284525271 + 1577.3435424478*$t);
   $L2 += 0.00000004061*cos(1.03057162962 + 7.1135470008*$t);
   $L2 += 0.00000003463*cos(5.14074632811 + 796.2980068164*$t);
   $L2 += 0.00000003169*cos(6.05291851171 + 5507.5532386674*$t);
   $L2 += 0.00000003020*cos(1.19246506441 + 242.728603974*$t);
   $L2 += 0.00000002886*cos(6.11652627155 + 529.6909650946*$t);
   $L2 += 0.00000003810*cos(3.44050803490 + 5573.1428014331*$t);
   $L2 += 0.00000002714*cos(0.30637881025 + 398.1490034082*$t);
   $L2 += 0.00000002371*cos(4.38118838167 + 5223.6939198022*$t);
   $L2 += 0.00000002538*cos(2.27992810679 + 553.5694028424*$t);
   $L2 += 0.00000002079*cos(3.75435330484 + 0.9803210682*$t);
   $L2 += 0.00000001675*cos(0.90216407959 + 951.7184062506*$t);
   $L2 += 0.00000001534*cos(5.75900462759 + 1349.8674096588*$t);
   $L2 += 0.00000001224*cos(2.97328088405 + 2146.1654164752*$t);
   $L2 += 0.00000001449*cos(4.36415913970 + 1748.016413067*$t);
   $L2 += 0.00000001341*cos(3.72061130861 + 1194.4470102246*$t);
   $L2 += 0.00000001254*cos(2.94846826628 + 6438.4962494256*$t);
   $L2 += 0.00000000999*cos(5.98640014468 + 6286.5989683404*$t);
   $L2 += 0.00000000917*cos(4.79788687522 + 5088.6288397668*$t);
   $L2 += 0.00000000828*cos(3.31321076572 + 213.299095438*$t);
   $L2 += 0.00000001103*cos(1.27104454479 + 161000.6857376741*$t);
   $L2 += 0.00000000762*cos(3.41582762988 + 5486.777843175*$t);
   $L2 += 0.00000001044*cos(0.60409577691 + 3154.6870848956*$t);
   $L2 += 0.00000000887*cos(5.23465144638 + 7084.8967811152*$t);
   $L2 += 0.00000000645*cos(1.60096192515 + 2544.3144198834*$t);
   $L2 += 0.00000000681*cos(3.43155669169 + 4694.0029547076*$t);
   $L2 += 0.00000000605*cos(2.47806340546 + 10977.078804699*$t);
   $L2 += 0.00000000706*cos(6.19393222575 + 4690.4798363586*$t);
   $L2 += 0.00000000643*cos(1.98042503148 + 801.8209311238*$t);
   $L2 += 0.00000000502*cos(1.44394375363 + 6836.6452528338*$t);
   $L2 += 0.00000000490*cos(2.34129524194 + 1592.5960136328*$t);
   $L2 += 0.00000000458*cos(1.30876448575 + 4292.3308329504*$t);
   $L2 += 0.00000000431*cos(0.03526421494 + 7234.794256242*$t);
   $L2 += 0.00000000379*cos(3.17030522615 + 6309.3741697912*$t);
   $L2 += 0.00000000348*cos(0.99049550009 + 6040.3472460174*$t);
   $L2 += 0.00000000386*cos(1.57019797263 + 71430.69561812909*$t);
   $L2 += 0.00000000347*cos(0.67013291338 + 1059.3819301892*$t);
   $L2 += 0.00000000458*cos(3.81499443681 + 149854.40013480789*$t);
   $L2 += 0.00000000302*cos(1.91760044838 + 10447.3878396044*$t);
   $L2 += 0.00000000307*cos(3.55343347416 + 8031.0922630584*$t);
   $L2 += 0.00000000395*cos(4.93701776616 + 7632.9432596502*$t);
   $L2 += 0.00000000314*cos(3.18093696547 + 2352.8661537718*$t);
   $L2 += 0.00000000282*cos(4.41936437052 + 9437.762934887*$t);
   $L2 += 0.00000000276*cos(2.71314254553 + 3894.1818295422*$t);
   $L2 += 0.00000000298*cos(2.52037474210 + 6127.6554505572*$t);
   $L2 += 0.00000000230*cos(1.37790215549 + 4705.7323075436*$t);
   $L2 += 0.00000000252*cos(0.55330133471 + 6279.5527316424*$t);
   $L2 += 0.00000000255*cos(5.26570187369 + 6812.766815086*$t);
   $L2 += 0.00000000275*cos(0.67264264272 + 25132.3033999656*$t);
   $L2 += 0.00000000178*cos(0.92820785174 + 1990.745017041*$t);
   $L2 += 0.00000000221*cos(0.63897368842 + 6256.7775301916*$t);
   $L2 += 0.00000000155*cos(0.77319790838 + 14143.4952424306*$t);
   $L2 += 0.00000000150*cos(2.40470465561 + 426.598190876*$t);
   $L2 += 0.00000000196*cos(6.06877865012 + 640.8776073822*$t);
   $L2 += 0.00000000137*cos(2.21679460145 + 8429.2412664666*$t);
   $L2 += 0.00000000127*cos(3.26094223174 + 17789.845619785*$t);
   $L2 += 0.00000000128*cos(5.47237279946 + 12036.4607348882*$t);
   $L2 += 0.00000000122*cos(2.16291082757 + 10213.285546211*$t);
   $L2 += 0.00000000118*cos(0.45789822268 + 7058.5984613154*$t);
   $L2 += 0.00000000141*cos(2.34932647403 + 11506.7697697936*$t);
   $L2 += 0.00000000100*cos(0.85621569847 + 6290.1893969922*$t);
   $L2 += 0.00000000092*cos(5.10587476002 + 7079.3738568078*$t);
   $L2 += 0.00000000126*cos(2.65428307012 + 88860.05707098669*$t);
   $L2 += 0.00000000106*cos(5.85646710022 + 7860.4193924392*$t);
   $L2 += 0.00000000084*cos(3.57457554262 + 16730.4636895958*$t);
   $L2 += 0.00000000089*cos(4.21433259618 + 83996.84731811189*$t);
   $L2 += 0.00000000097*cos(5.57938280855 + 13367.9726311066*$t);
   $L2 += 0.00000000102*cos(2.05853060226 + 87.30820453981*$t);
   $L2 += 0.00000000080*cos(4.73792651816 + 11926.2544136688*$t);
   $L2 += 0.00000000080*cos(5.41418965044 + 10973.55568635*$t);
   $L2 += 0.00000000106*cos(4.10978997399 + 3496.032826134*$t);
   $L2 += 0.00000000102*cos(3.62650006043 + 244287.60000722769*$t);
   $L2 += 0.00000000075*cos(4.89483161769 + 5643.1785636774*$t);
   $L2 += 0.00000000087*cos(0.42863750683 + 11015.1064773348*$t);
   $L2 += 0.00000000069*cos(1.88908760720 + 10177.2576795336*$t);
   $L2 += 0.00000000089*cos(1.35567273119 + 6681.2248533996*$t);
   $L2 += 0.00000000066*cos(0.99455837265 + 6525.8044539654*$t);
   $L2 += 0.00000000067*cos(5.51240997070 + 3097.88382272579*$t);
   $L2 += 0.00000000076*cos(2.72016814799 + 4164.311989613*$t);
   $L2 += 0.00000000063*cos(1.44349902540 + 9917.6968745098*$t);
   $L2 += 0.00000000078*cos(3.51469733747 + 11856.2186514245*$t);
   $L2 += 0.00000000085*cos(0.50956043858 + 10575.4066829418*$t);
   $L2 += 0.00000000067*cos(3.62043033405 + 16496.3613962024*$t);
   $L2 += 0.00000000055*cos(5.24637517308 + 3340.6124266998*$t);
   $L2 += 0.00000000048*cos(5.43966777314 + 20426.571092422*$t);
   $L2 += 0.00000000064*cos(5.79535817813 + 2388.8940204492*$t);
   $L2 += 0.00000000046*cos(5.43499966519 + 6275.9623029906*$t);
   $L2 += 0.00000000050*cos(3.86263598617 + 5729.506447149*$t);
   $L2 += 0.00000000044*cos(1.52269529228 + 12168.0026965746*$t);
   $L2 += 0.00000000057*cos(4.96352373486 + 14945.3161735544*$t);
   $L2 += 0.00000000045*cos(1.00861230160 + 8635.9420037632*$t);
   $L2 += 0.00000000043*cos(3.30685683359 + 9779.1086761254*$t);
   $L2 += 0.00000000042*cos(0.63481258930 + 2699.7348193176*$t);
   $L2 += 0.00000000041*cos(5.67996766641 + 11712.9553182308*$t);
   $L2 += 0.00000000056*cos(4.34024451468 + 90955.5516944961*$t);
   $L2 += 0.00000000041*cos(5.81722212845 + 709.9330485583*$t);
   $L2 += 0.00000000053*cos(6.17052087143 + 233141.31440436149*$t);
   $L2 += 0.00000000037*cos(3.12495025087 + 16200.7727245012*$t);
   $L2 += 0.00000000035*cos(5.76973458495 + 12569.6748183318*$t);
   $L2 += 0.00000000037*cos(0.31656444326 + 24356.7807886416*$t);
   $L2 += 0.00000000035*cos(0.96229051027 + 17298.1823273262*$t);
   $L2 += 0.00000000033*cos(5.23130355867 + 5331.3574437408*$t);
   $L2 += 0.00000000035*cos(0.62517020593 + 25158.6017197654*$t);
   $L2 += 0.00000000035*cos(0.80004512129 + 13916.0191096416*$t);
   $L2 += 0.00000000037*cos(2.89336088688 + 12721.572099417*$t);
   $L2 += 0.00000000030*cos(4.50198402401 + 23543.23050468179*$t);
   $L2 += 0.00000000030*cos(5.31355708693 + 18319.5365848796*$t);
   $L2 += 0.00000000029*cos(3.47275229977 + 13119.72110282519*$t);
   $L2 += 0.00000000029*cos(3.11002782516 + 4136.9104335162*$t);
   $L2 += 0.00000000032*cos(5.52273255667 + 5753.3848848968*$t);
   $L2 += 0.00000000035*cos(3.79699996680 + 143571.32428481648*$t);
   $L2 += 0.00000000026*cos(1.50634201907 + 154717.60988768269*$t);
   $L2 += 0.00000000030*cos(3.53519084118 + 6284.0561710596*$t);
   $L2 += 0.00000000023*cos(4.41808025967 + 5884.9268465832*$t);
   $L2 += 0.00000000025*cos(1.38477355808 + 65147.6197681377*$t);
   $L2 += 0.00000000023*cos(3.49782549797 + 7477.522860216*$t);
   $L2 += 0.00000000019*cos(3.14329413716 + 6496.3749454294*$t);
   $L2 += 0.00000000019*cos(2.20135125199 + 18073.7049386502*$t);
   $L2 += 0.00000000019*cos(4.95020255309 + 3930.2096962196*$t);
   $L2 += 0.00000000019*cos(0.57998702747 + 31415.379249957*$t);
   $L2 += 0.00000000021*cos(1.75474323399 + 12139.5535091068*$t);
   $L2 += 0.00000000019*cos(3.92233070499 + 19651.048481098*$t);
   $L2 += 0.00000000014*cos(0.98131213224 + 12559.038152982*$t);
   $L2 += 0.00000000019*cos(4.93309333729 + 2942.4634232916*$t);
   $L2 += 0.00000000016*cos(5.55997534558 + 8827.3902698748*$t);
   $L2 += 0.00000000013*cos(1.68808165516 + 4535.0594369244*$t);
   $L2 += 0.00000000013*cos(0.33982116161 + 4933.2084403326*$t);
   $L2 += 0.00000000012*cos(1.85426309994 + 5856.4776591154*$t);
   $L2 += 0.00000000010*cos(4.82763996845 + 13095.8426650774*$t);
   $L2 += 0.00000000011*cos(5.38005490571 + 11790.6290886588*$t);
   $L2 += 0.00000000010*cos(1.40815507226 + 10988.808157535*$t);
   $L2 += 0.00000000011*cos(3.05005267431 + 17260.1546546904*$t);
   $L2 += 0.00000000010*cos(4.93364992366 + 12352.8526045448*$t);
   return $L2*$t*$t;
}



   function Earth_L3($t) // 22 terms of order 3
{
   $L3  = 0.00000289226*cos(5.84384198723 + 6283.0758499914*$t);
   $L3 += 0.00000034955;
   $L3 += 0.00000016819*cos(5.48766912348 + 12566.1516999828*$t);
   $L3 += 0.00000002962*cos(5.19577265202 + 155.4203994342*$t);
   $L3 += 0.00000001288*cos(4.72200252235 + 3.523118349*$t);
   $L3 += 0.00000000635*cos(5.96925937141 + 242.728603974*$t);
   $L3 += 0.00000000714*cos(5.30045809128 + 18849.2275499742*$t);
   $L3 += 0.00000000402*cos(3.78682982419 + 553.5694028424*$t);
   $L3 += 0.00000000072*cos(4.29768126180 + 6286.5989683404*$t);
   $L3 += 0.00000000067*cos(0.90721687647 + 6127.6554505572*$t);
   $L3 += 0.00000000036*cos(5.24029648014 + 6438.4962494256*$t);
   $L3 += 0.00000000024*cos(5.16003960716 + 25132.3033999656*$t);
   $L3 += 0.00000000023*cos(3.01921570335 + 6309.3741697912*$t);
   $L3 += 0.00000000017*cos(5.82863573502 + 6525.8044539654*$t);
   $L3 += 0.00000000017*cos(3.67772863930 + 71430.69561812909*$t);
   $L3 += 0.00000000009*cos(4.58467294499 + 1577.3435424478*$t);
   $L3 += 0.00000000008*cos(1.40626662824 + 11856.2186514245*$t);
   $L3 += 0.00000000008*cos(5.07561257196 + 6256.7775301916*$t);
   $L3 += 0.00000000007*cos(2.82473374405 + 83996.84731811189*$t);
   $L3 += 0.00000000005*cos(2.71488713339 + 10977.078804699*$t);
   $L3 += 0.00000000005*cos(3.76879847273 + 12036.4607348882*$t);
   $L3 += 0.00000000005*cos(4.28412873331 + 6275.9623029906*$t);
   return $L3*$t*$t*$t;
}



   function Earth_L4($t) // 11 terms of order 4
{
   $L4  = 0.00000114084;
   $L4 += 0.00000007717*cos(4.13446589358 + 6283.0758499914*$t);
   $L4 += 0.00000000765*cos(3.83803776214 + 12566.1516999828*$t);
   $L4 += 0.00000000420*cos(0.41925861858 + 155.4203994342*$t);
   $L4 += 0.00000000040*cos(3.59847585840 + 18849.2275499742*$t);
   $L4 += 0.00000000041*cos(3.14398414077 + 3.523118349*$t);
   $L4 += 0.00000000035*cos(5.00298940826 + 5573.1428014331*$t);
   $L4 += 0.00000000013*cos(0.48794833701 + 77713.7714681205*$t);
   $L4 += 0.00000000010*cos(5.64801766350 + 6127.6554505572*$t);
   $L4 += 0.00000000008*cos(2.84160570605 + 161000.6857376741*$t);
   $L4 += 0.00000000002*cos(0.54912904658 + 6438.4962494256*$t);
   return $L4*$t*$t*$t*$t;
}



   function Earth_L5($t) // 5 terms of order 5
{
   $L5  = 0.00000000878;
   $L5 += 0.00000000172*cos(2.76579069510 + 6283.0758499914*$t);
   $L5 += 0.00000000050*cos(2.01353298182 + 155.4203994342*$t);
   $L5 += 0.00000000028*cos(2.21496423926 + 12566.1516999828*$t);
   $L5 += 0.00000000005*cos(1.75600058765 + 18849.2275499742*$t);
   return $L5*$t*$t*$t*$t*$t;
}



   function Earth_B0($t) // 184 terms of order 0
{
   $B0  = 0.00000279620*cos(3.19870156017 + 84334.66158130829*$t);
   $B0 += 0.00000101643*cos(5.42248619256 + 5507.5532386674*$t);
   $B0 += 0.00000080445*cos(3.88013204458 + 5223.6939198022*$t);
   $B0 += 0.00000043806*cos(3.70444689758 + 2352.8661537718*$t);
   $B0 += 0.00000031933*cos(4.00026369781 + 1577.3435424478*$t);
   $B0 += 0.00000022724*cos(3.98473831560 + 1047.7473117547*$t);
   $B0 += 0.00000016392*cos(3.56456119782 + 5856.4776591154*$t);
   $B0 += 0.00000018141*cos(4.98367470263 + 6283.0758499914*$t);
   $B0 += 0.00000014443*cos(3.70275614914 + 9437.762934887*$t);
   $B0 += 0.00000014304*cos(3.41117857525 + 10213.285546211*$t);
   $B0 += 0.00000011246*cos(4.82820690530 + 14143.4952424306*$t);
   $B0 += 0.00000010900*cos(2.08574562327 + 6812.766815086*$t);
   $B0 += 0.00000009714*cos(3.47303947752 + 4694.0029547076*$t);
   $B0 += 0.00000010367*cos(4.05663927946 + 71092.88135493269*$t);
   $B0 += 0.00000008775*cos(4.44016515669 + 5753.3848848968*$t);
   $B0 += 0.00000008366*cos(4.99251512180 + 7084.8967811152*$t);
   $B0 += 0.00000006921*cos(4.32559054073 + 6275.9623029906*$t);
   $B0 += 0.00000009145*cos(1.14182646613 + 6620.8901131878*$t);
   $B0 += 0.00000007194*cos(3.60193205752 + 529.6909650946*$t);
   $B0 += 0.00000007698*cos(5.55425745881 + 167621.57585086189*$t);
   $B0 += 0.00000005285*cos(2.48446991566 + 4705.7323075436*$t);
   $B0 += 0.00000005208*cos(6.24992674537 + 18073.7049386502*$t);
   $B0 += 0.00000004529*cos(2.33827747356 + 6309.3741697912*$t);
   $B0 += 0.00000005579*cos(4.41023653738 + 7860.4193924392*$t);
   $B0 += 0.00000004743*cos(0.70995680136 + 5884.9268465832*$t);
   $B0 += 0.00000004301*cos(1.10255777773 + 6681.2248533996*$t);
   $B0 += 0.00000003849*cos(1.82229412531 + 5486.777843175*$t);
   $B0 += 0.00000004093*cos(5.11700141207 + 13367.9726311066*$t);
   $B0 += 0.00000003681*cos(0.43793170356 + 3154.6870848956*$t);
   $B0 += 0.00000003420*cos(5.42034800952 + 6069.7767545534*$t);
   $B0 += 0.00000003617*cos(6.04641937526 + 3930.2096962196*$t);
   $B0 += 0.00000003670*cos(4.58210192227 + 12194.0329146209*$t);
   $B0 += 0.00000002918*cos(1.95463881126 + 10977.078804699*$t);
   $B0 += 0.00000002797*cos(5.61259275048 + 11790.6290886588*$t);
   $B0 += 0.00000002502*cos(0.60499729367 + 6496.3749454294*$t);
   $B0 += 0.00000002319*cos(5.01648216014 + 1059.3819301892*$t);
   $B0 += 0.00000002684*cos(1.39470396488 + 22003.9146348698*$t);
   $B0 += 0.00000002428*cos(3.24183056052 + 78051.5857313169*$t);
   $B0 += 0.00000002120*cos(4.30691000285 + 5643.1785636774*$t);
   $B0 += 0.00000002257*cos(3.15557225618 + 90617.7374312997*$t);
   $B0 += 0.00000001813*cos(3.75574218285 + 3340.6124266998*$t);
   $B0 += 0.00000002226*cos(2.79699346659 + 12036.4607348882*$t);
   $B0 += 0.00000001888*cos(0.86991545823 + 8635.9420037632*$t);
   $B0 += 0.00000001517*cos(1.95852055701 + 398.1490034082*$t);
   $B0 += 0.00000001581*cos(3.19976230948 + 5088.6288397668*$t);
   $B0 += 0.00000001421*cos(6.25530883827 + 2544.3144198834*$t);
   $B0 += 0.00000001595*cos(0.25619915135 + 17298.1823273262*$t);
   $B0 += 0.00000001391*cos(4.69964175561 + 7058.5984613154*$t);
   $B0 += 0.00000001478*cos(2.81808207569 + 25934.1243310894*$t);
   $B0 += 0.00000001481*cos(3.65823554806 + 11506.7697697936*$t);
   $B0 += 0.00000001693*cos(4.95689385293 + 156475.2902479957*$t);
   $B0 += 0.00000001183*cos(1.29343061246 + 775.522611324*$t);
   $B0 += 0.00000001114*cos(2.37889311846 + 3738.761430108*$t);
   $B0 += 0.00000000994*cos(4.30088900425 + 9225.539273283*$t);
   $B0 += 0.00000000924*cos(3.06451026812 + 4164.311989613*$t);
   $B0 += 0.00000000867*cos(0.55606931068 + 8429.2412664666*$t);
   $B0 += 0.00000000988*cos(5.97286104208 + 7079.3738568078*$t);
   $B0 += 0.00000000824*cos(1.50984806173 + 10447.3878396044*$t);
   $B0 += 0.00000000915*cos(0.12635654592 + 11015.1064773348*$t);
   $B0 += 0.00000000742*cos(1.99159139281 + 26087.9031415742*$t);
   $B0 -= 0.00000001039;
   $B0 += 0.00000000850*cos(4.24120016095 + 29864.334027309*$t);
   $B0 += 0.00000000755*cos(2.89631873320 + 4732.0306273434*$t);
   $B0 += 0.00000000714*cos(1.37548118603 + 2146.1654164752*$t);
   $B0 += 0.00000000708*cos(1.91406542362 + 8031.0922630584*$t);
   $B0 += 0.00000000746*cos(0.57893808616 + 796.2980068164*$t);
   $B0 += 0.00000000802*cos(5.12339137230 + 2942.4634232916*$t);
   $B0 += 0.00000000751*cos(1.67479850166 + 21228.3920235458*$t);
   $B0 += 0.00000000602*cos(4.09976538826 + 64809.80550494129*$t);
   $B0 += 0.00000000594*cos(3.49580704962 + 16496.3613962024*$t);
   $B0 += 0.00000000592*cos(4.59481504319 + 4690.4798363586*$t);
   $B0 += 0.00000000530*cos(5.73979295200 + 8827.3902698748*$t);
   $B0 += 0.00000000503*cos(5.66433137112 + 33794.5437235286*$t);
   $B0 += 0.00000000483*cos(1.57106522411 + 801.8209311238*$t);
   $B0 += 0.00000000438*cos(0.06707733767 + 3128.3887650958*$t);
   $B0 += 0.00000000423*cos(2.86944595927 + 12566.1516999828*$t);
   $B0 += 0.00000000504*cos(3.26207669160 + 7632.9432596502*$t);
   $B0 += 0.00000000552*cos(1.02926440457 + 239762.20451754928*$t);
   $B0 += 0.00000000427*cos(3.67434378210 + 213.299095438*$t);
   $B0 += 0.00000000404*cos(1.46193297142 + 15720.8387848784*$t);
   $B0 += 0.00000000503*cos(4.85802444134 + 6290.1893969922*$t);
   $B0 += 0.00000000417*cos(0.81920713533 + 5216.5803728014*$t);
   $B0 += 0.00000000365*cos(0.01002966162 + 12168.0026965746*$t);
   $B0 += 0.00000000363*cos(1.28376436579 + 6206.8097787158*$t);
   $B0 += 0.00000000353*cos(4.70059133110 + 7234.794256242*$t);
   $B0 += 0.00000000415*cos(0.96862624175 + 4136.9104335162*$t);
   $B0 += 0.00000000387*cos(3.09145061418 + 25158.6017197654*$t);
   $B0 += 0.00000000373*cos(2.65119262792 + 7342.4577801806*$t);
   $B0 += 0.00000000361*cos(2.97762937739 + 9623.6882766912*$t);
   $B0 += 0.00000000418*cos(3.75759994446 + 5230.807466803*$t);
   $B0 += 0.00000000396*cos(1.22507712354 + 6438.4962494256*$t);
   $B0 += 0.00000000322*cos(1.21162178805 + 8662.240323563*$t);
   $B0 += 0.00000000284*cos(5.64170320068 + 1589.0728952838*$t);
   $B0 += 0.00000000379*cos(1.72248432748 + 14945.3161735544*$t);
   $B0 += 0.00000000320*cos(3.94161159962 + 7330.8231617461*$t);
   $B0 += 0.00000000313*cos(5.47602376446 + 1194.4470102246*$t);
   $B0 += 0.00000000292*cos(1.38971327603 + 11769.8536931664*$t);
   $B0 += 0.00000000305*cos(0.80429352049 + 37724.7534197482*$t);
   $B0 += 0.00000000257*cos(5.81382809757 + 426.598190876*$t);
   $B0 += 0.00000000265*cos(6.10358507671 + 6836.6452528338*$t);
   $B0 += 0.00000000250*cos(4.56452895547 + 7477.522860216*$t);
   $B0 += 0.00000000266*cos(2.62926282354 + 7238.67559160*$t);
   $B0 += 0.00000000263*cos(6.22089501237 + 6133.5126528568*$t);
   $B0 += 0.00000000306*cos(2.79682380531 + 1748.016413067*$t);
   $B0 += 0.00000000236*cos(2.46093023714 + 11371.7046897582*$t);
   $B0 += 0.00000000316*cos(1.62662805006 + 250908.49012041549*$t);
   $B0 += 0.00000000216*cos(3.68721275185 + 5849.3641121146*$t);
   $B0 += 0.00000000230*cos(0.36165162947 + 5863.5912061162*$t);
   $B0 += 0.00000000233*cos(5.03509933858 + 20426.571092422*$t);
   $B0 += 0.00000000200*cos(5.86073159059 + 4535.0594369244*$t);
   $B0 += 0.00000000277*cos(4.65400292395 + 82239.16695779889*$t);
   $B0 += 0.00000000209*cos(3.72323200804 + 10973.55568635*$t);
   $B0 += 0.00000000199*cos(5.05186622555 + 5429.8794682394*$t);
   $B0 += 0.00000000256*cos(2.40923279770 + 19651.048481098*$t);
   $B0 += 0.00000000210*cos(4.50691909144 + 29088.811415985*$t);
   $B0 += 0.00000000181*cos(6.00294783127 + 4292.3308329504*$t);
   $B0 += 0.00000000249*cos(0.12900984422 + 154379.79562448629*$t);
   $B0 += 0.00000000209*cos(3.87759458598 + 17789.845619785*$t);
   $B0 += 0.00000000225*cos(3.18339652605 + 18875.525869774*$t);
   $B0 += 0.00000000191*cos(4.53897489299 + 18477.1087646123*$t);
   $B0 += 0.00000000172*cos(2.09694183014 + 13095.8426650774*$t);
   $B0 += 0.00000000182*cos(3.16107943500 + 16730.4636895958*$t);
   $B0 += 0.00000000188*cos(2.22746128596 + 41654.9631159678*$t);
   $B0 += 0.00000000164*cos(5.18686275017 + 5481.2549188676*$t);
   $B0 += 0.00000000160*cos(2.49298855159 + 12592.4500197826*$t);
   $B0 += 0.00000000155*cos(1.59595438230 + 10021.8372800994*$t);
   $B0 += 0.00000000135*cos(0.21349051064 + 10988.808157535*$t);
   $B0 += 0.00000000178*cos(3.80375177970 + 23581.2581773176*$t);
   $B0 += 0.00000000123*cos(1.66800739151 + 15110.4661198662*$t);
   $B0 += 0.00000000122*cos(2.72678272244 + 18849.2275499742*$t);
   $B0 += 0.00000000126*cos(1.17675512910 + 14919.0178537546*$t);
   $B0 += 0.00000000142*cos(3.95053441332 + 337.8142631964*$t);
   $B0 += 0.00000000116*cos(6.06340906229 + 6709.6740408674*$t);
   $B0 += 0.00000000137*cos(3.52143246757 + 12139.5535091068*$t);
   $B0 += 0.00000000136*cos(2.92179113542 + 32217.2001810808*$t);
   $B0 += 0.00000000110*cos(3.51203379263 + 18052.9295431578*$t);
   $B0 += 0.00000000147*cos(4.63371971408 + 22805.7355659936*$t);
   $B0 += 0.00000000108*cos(5.45280814878 + 7.1135470008*$t);
   $B0 += 0.00000000148*cos(0.65447253687 + 95480.9471841745*$t);
   $B0 += 0.00000000119*cos(5.92110458985 + 33019.0211122046*$t);
   $B0 += 0.00000000110*cos(5.34824206306 + 639.897286314*$t);
   $B0 += 0.00000000106*cos(3.71081682629 + 14314.1681130498*$t);
   $B0 += 0.00000000139*cos(6.17607198418 + 24356.7807886416*$t);
   $B0 += 0.00000000118*cos(5.59738712670 + 161338.5000008705*$t);
   $B0 += 0.00000000117*cos(3.65065271640 + 45585.1728121874*$t);
   $B0 += 0.00000000127*cos(4.74596574209 + 49515.382508407*$t);
   $B0 += 0.00000000120*cos(1.04211499785 + 6915.8595893046*$t);
   $B0 += 0.00000000120*cos(5.60638811846 + 5650.2921106782*$t);
   $B0 += 0.00000000115*cos(3.10668213289 + 14712.317116458*$t);
   $B0 += 0.00000000099*cos(0.69018940049 + 12779.4507954208*$t);
   $B0 += 0.00000000097*cos(1.07908724794 + 9917.6968745098*$t);
   $B0 += 0.00000000093*cos(2.62295197319 + 17260.1546546904*$t);
   $B0 += 0.00000000099*cos(4.45774681732 + 4933.2084403326*$t);
   $B0 += 0.00000000123*cos(1.37488922089 + 28286.9904848612*$t);
   $B0 += 0.00000000121*cos(5.19767249813 + 27511.4678735372*$t);
   $B0 += 0.00000000105*cos(0.87192267806 + 77375.95720492408*$t);
   $B0 += 0.00000000087*cos(3.93637812950 + 17654.7805397496*$t);
   $B0 += 0.00000000122*cos(2.23956068680 + 83997.09113559539*$t);
   $B0 += 0.00000000087*cos(4.18201600952 + 22779.4372461938*$t);
   $B0 += 0.00000000104*cos(4.59580877295 + 1349.8674096588*$t);
   $B0 += 0.00000000102*cos(2.83545248411 + 12352.8526045448*$t);
   $B0 += 0.00000000102*cos(3.97386522171 + 10818.1352869158*$t);
   $B0 += 0.00000000101*cos(4.32892825857 + 36147.4098773004*$t);
   $B0 += 0.00000000094*cos(5.00001709261 + 150192.21439800429*$t);
   $B0 += 0.00000000077*cos(3.97199369296 + 1592.5960136328*$t);
   $B0 += 0.00000000100*cos(6.07733097102 + 26735.9452622132*$t);
   $B0 += 0.00000000086*cos(5.26029638250 + 28313.288804661*$t);
   $B0 += 0.00000000093*cos(4.31900620254 + 44809.6502008634*$t);
   $B0 += 0.00000000076*cos(6.22743405935 + 13521.7514415914*$t);
   $B0 += 0.00000000072*cos(1.55820597747 + 6256.7775301916*$t);
   $B0 += 0.00000000082*cos(4.95202664555 + 10575.4066829418*$t);
   $B0 += 0.00000000082*cos(1.69647647075 + 1990.745017041*$t);
   $B0 += 0.00000000075*cos(2.29836095644 + 3634.6210245184*$t);
   $B0 += 0.00000000075*cos(2.66367876557 + 16200.7727245012*$t);
   $B0 += 0.00000000087*cos(0.26630214764 + 31441.6775697568*$t);
   $B0 += 0.00000000077*cos(2.25530954137 + 5235.3285382367*$t);
   $B0 += 0.00000000076*cos(1.09869730846 + 12903.9659631792*$t);
   $B0 += 0.00000000058*cos(4.28246138307 + 12559.038152982*$t);
   $B0 += 0.00000000064*cos(5.51112830114 + 173904.65170085328*$t);
   $B0 += 0.00000000056*cos(2.60133794851 + 73188.3759784421*$t);
   $B0 += 0.00000000055*cos(5.81483150022 + 143233.51002162008*$t);
   $B0 += 0.00000000054*cos(3.38482031504 + 323049.11878710288*$t);
   $B0 += 0.00000000039*cos(3.28500401343 + 71768.50988132549*$t);
   $B0 += 0.00000000039*cos(3.11239910690 + 96900.81328129109*$t);
   return $B0;
}



   function Earth_B1($t) // 99 terms of order 1
{
   $B1  = 0.00000009030*cos(3.89729061890 + 5507.5532386674*$t);
   $B1 += 0.00000006177*cos(1.73038850355 + 5223.6939198022*$t);
   $B1 += 0.00000003800*cos(5.24404145734 + 2352.8661537718*$t);
   $B1 += 0.00000002834*cos(2.47345037450 + 1577.3435424478*$t);
   $B1 += 0.00000001817*cos(0.41874743765 + 6283.0758499914*$t);
   $B1 += 0.00000001499*cos(1.83320979291 + 5856.4776591154*$t);
   $B1 += 0.00000001466*cos(5.69401926017 + 5753.3848848968*$t);
   $B1 += 0.00000001301*cos(2.18890066314 + 9437.762934887*$t);
   $B1 += 0.00000001233*cos(4.95222451476 + 10213.285546211*$t);
   $B1 += 0.00000001021*cos(0.12866660208 + 7860.4193924392*$t);
   $B1 += 0.00000000982*cos(0.09005453285 + 14143.4952424306*$t);
   $B1 += 0.00000000865*cos(1.73949953555 + 3930.2096962196*$t);
   $B1 += 0.00000000581*cos(2.26949174067 + 5884.9268465832*$t);
   $B1 += 0.00000000524*cos(5.65662503159 + 529.6909650946*$t);
   $B1 += 0.00000000473*cos(6.22750969242 + 6309.3741697912*$t);
   $B1 += 0.00000000451*cos(1.53288619213 + 18073.7049386502*$t);
   $B1 += 0.00000000364*cos(3.61614477374 + 13367.9726311066*$t);
   $B1 += 0.00000000372*cos(3.22470721320 + 6275.9623029906*$t);
   $B1 += 0.00000000268*cos(2.34341267879 + 11790.6290886588*$t);
   $B1 += 0.00000000322*cos(0.94084045832 + 6069.7767545534*$t);
   $B1 += 0.00000000232*cos(0.26781182579 + 7058.5984613154*$t);
   $B1 += 0.00000000216*cos(6.05952221329 + 10977.078804699*$t);
   $B1 += 0.00000000232*cos(2.93325646109 + 22003.9146348698*$t);
   $B1 += 0.00000000204*cos(3.86264841382 + 6496.3749454294*$t);
   $B1 += 0.00000000202*cos(2.81892511133 + 15720.8387848784*$t);
   $B1 += 0.00000000185*cos(4.93512381859 + 12036.4607348882*$t);
   $B1 += 0.00000000220*cos(3.99305643742 + 6812.766815086*$t);
   $B1 += 0.00000000166*cos(1.74970002999 + 11506.7697697936*$t);
   $B1 += 0.00000000212*cos(1.57166285369 + 4694.0029547076*$t);
   $B1 += 0.00000000157*cos(1.08259734788 + 5643.1785636774*$t);
   $B1 += 0.00000000154*cos(5.99434678412 + 5486.777843175*$t);
   $B1 += 0.00000000144*cos(5.23285656085 + 78051.5857313169*$t);
   $B1 += 0.00000000144*cos(1.16454655948 + 90617.7374312997*$t);
   $B1 += 0.00000000137*cos(2.67760436027 + 6290.1893969922*$t);
   $B1 += 0.00000000180*cos(2.06509026215 + 7084.8967811152*$t);
   $B1 += 0.00000000121*cos(5.90212574947 + 9225.539273283*$t);
   $B1 += 0.00000000150*cos(2.00175038718 + 5230.807466803*$t);
   $B1 += 0.00000000149*cos(5.06157254516 + 17298.1823273262*$t);
   $B1 += 0.00000000118*cos(5.39979058038 + 3340.6124266998*$t);
   $B1 += 0.00000000161*cos(3.32421999691 + 6283.3196674749*$t);
   $B1 += 0.00000000121*cos(4.36722193162 + 19651.048481098*$t);
   $B1 += 0.00000000116*cos(5.83462858507 + 4705.7323075436*$t);
   $B1 += 0.00000000128*cos(4.35489873365 + 25934.1243310894*$t);
   $B1 += 0.00000000143;
   $B1 += 0.00000000109*cos(2.52157834166 + 6438.4962494256*$t);
   $B1 += 0.00000000099*cos(2.70727488041 + 5216.5803728014*$t);
   $B1 += 0.00000000103*cos(0.93782340879 + 8827.3902698748*$t);
   $B1 += 0.00000000082*cos(4.29214680390 + 8635.9420037632*$t);
   $B1 += 0.00000000079*cos(2.24085737326 + 1059.3819301892*$t);
   $B1 += 0.00000000097*cos(5.50959692365 + 29864.334027309*$t);
   $B1 += 0.00000000072*cos(0.21891639822 + 21228.3920235458*$t);
   $B1 += 0.00000000071*cos(2.86755026812 + 6681.2248533996*$t);
   $B1 += 0.00000000074*cos(2.20184828895 + 37724.7534197482*$t);
   $B1 += 0.00000000063*cos(4.45586625948 + 7079.3738568078*$t);
   $B1 += 0.00000000061*cos(0.63918772258 + 33794.5437235286*$t);
   $B1 += 0.00000000047*cos(2.09070235724 + 3128.3887650958*$t);
   $B1 += 0.00000000047*cos(3.32543843300 + 26087.9031415742*$t);
   $B1 += 0.00000000049*cos(1.60680905005 + 6702.5604938666*$t);
   $B1 += 0.00000000057*cos(0.11215813438 + 29088.811415985*$t);
   $B1 += 0.00000000056*cos(5.47982934911 + 775.522611324*$t);
   $B1 += 0.00000000050*cos(1.89396788463 + 12139.5535091068*$t);
   $B1 += 0.00000000047*cos(2.97214907240 + 20426.571092422*$t);
   $B1 += 0.00000000041*cos(5.55329394890 + 11015.1064773348*$t);
   $B1 += 0.00000000041*cos(5.91861144924 + 23581.2581773176*$t);
   $B1 += 0.00000000045*cos(4.95273290181 + 5863.5912061162*$t);
   $B1 += 0.00000000050*cos(3.62740835096 + 41654.9631159678*$t);
   $B1 += 0.00000000037*cos(6.09033460601 + 64809.80550494129*$t);
   $B1 += 0.00000000037*cos(5.86153655431 + 12566.1516999828*$t);
   $B1 += 0.00000000046*cos(1.65798680284 + 25158.6017197654*$t);
   $B1 += 0.00000000038*cos(2.00673650251 + 426.598190876*$t);
   $B1 += 0.00000000036*cos(6.24373396652 + 6283.14316029419*$t);
   $B1 += 0.00000000036*cos(0.40465162918 + 6283.0085396886*$t);
   $B1 += 0.00000000032*cos(6.03707103538 + 2942.4634232916*$t);
   $B1 += 0.00000000041*cos(4.86809570283 + 1592.5960136328*$t);
   $B1 += 0.00000000028*cos(4.38359423735 + 7632.9432596502*$t);
   $B1 += 0.00000000028*cos(6.03334294232 + 17789.845619785*$t);
   $B1 += 0.00000000026*cos(3.88971333608 + 5331.3574437408*$t);
   $B1 += 0.00000000026*cos(5.94932724051 + 16496.3613962024*$t);
   $B1 += 0.00000000031*cos(1.44666331503 + 16730.4636895958*$t);
   $B1 += 0.00000000026*cos(6.26376705837 + 23543.23050468179*$t);
   $B1 += 0.00000000033*cos(0.93797239147 + 213.299095438*$t);
   $B1 += 0.00000000026*cos(3.71858432944 + 13095.8426650774*$t);
   $B1 += 0.00000000027*cos(0.60565274405 + 10988.808157535*$t);
   $B1 += 0.00000000023*cos(4.44388985550 + 18849.2275499742*$t);
   $B1 += 0.00000000028*cos(1.53862289477 + 6279.4854213396*$t);
   $B1 += 0.00000000028*cos(1.96831814872 + 6286.6662786432*$t);
   $B1 += 0.00000000028*cos(5.78094918529 + 15110.4661198662*$t);
   $B1 += 0.00000000026*cos(2.48165809843 + 5729.506447149*$t);
   $B1 += 0.00000000020*cos(3.85655029499 + 9623.6882766912*$t);
   $B1 += 0.00000000021*cos(5.83006047147 + 7234.794256242*$t);
   $B1 += 0.00000000021*cos(0.69628570421 + 398.1490034082*$t);
   $B1 += 0.00000000022*cos(5.02222806555 + 6127.6554505572*$t);
   $B1 += 0.00000000020*cos(3.47611265290 + 6148.010769956*$t);
   $B1 += 0.00000000020*cos(0.90769829044 + 5481.2549188676*$t);
   $B1 += 0.00000000020*cos(0.03081589303 + 6418.1409300268*$t);
   $B1 += 0.00000000020*cos(3.74220084927 + 1589.0728952838*$t);
   $B1 += 0.00000000021*cos(4.00149269576 + 3154.6870848956*$t);
   $B1 += 0.00000000018*cos(1.58348238359 + 2118.7638603784*$t);
   $B1 += 0.00000000019*cos(0.85407021371 + 14712.317116458*$t);
   return $B1*$t;
}



   function Earth_B2($t) // 49 terms of order 2
{
   $B2  = 0.00000001662*cos(1.62703209173 + 84334.66158130829*$t);
   $B2 += 0.00000000492*cos(2.41382223971 + 1047.7473117547*$t);
   $B2 += 0.00000000344*cos(2.24353004539 + 5507.5532386674*$t);
   $B2 += 0.00000000258*cos(6.00906896311 + 5223.6939198022*$t);
   $B2 += 0.00000000131*cos(0.95447345240 + 6283.0758499914*$t);
   $B2 += 0.00000000086*cos(1.67530247303 + 7860.4193924392*$t);
   $B2 += 0.00000000090*cos(0.97606804452 + 1577.3435424478*$t);
   $B2 += 0.00000000090*cos(0.37899871725 + 2352.8661537718*$t);
   $B2 += 0.00000000089*cos(6.25807507963 + 10213.285546211*$t);
   $B2 += 0.00000000075*cos(0.84213523741 + 167621.57585086189*$t);
   $B2 += 0.00000000052*cos(1.70501566089 + 14143.4952424306*$t);
   $B2 += 0.00000000057*cos(6.15295833679 + 12194.0329146209*$t);
   $B2 += 0.00000000051*cos(1.27616016740 + 5753.3848848968*$t);
   $B2 += 0.00000000051*cos(5.37229738682 + 6812.766815086*$t);
   $B2 += 0.00000000034*cos(1.73672994279 + 7058.5984613154*$t);
   $B2 += 0.00000000038*cos(2.77761031485 + 10988.808157535*$t);
   $B2 += 0.00000000046*cos(3.38617099014 + 156475.2902479957*$t);
   $B2 += 0.00000000021*cos(1.95248349228 + 8827.3902698748*$t);
   $B2 += 0.00000000018*cos(3.33419222028 + 8429.2412664666*$t);
   $B2 += 0.00000000019*cos(4.32945160287 + 17789.845619785*$t);
   $B2 += 0.00000000017*cos(0.66191210656 + 6283.0085396886*$t);
   $B2 += 0.00000000018*cos(3.74885333072 + 11769.8536931664*$t);
   $B2 += 0.00000000017*cos(4.23058370776 + 10977.078804699*$t);
   $B2 += 0.00000000017*cos(1.78116162721 + 5486.777843175*$t);
   $B2 += 0.00000000021*cos(1.36972913918 + 12036.4607348882*$t);
   $B2 += 0.00000000017*cos(2.79601092529 + 796.2980068164*$t);
   $B2 += 0.00000000015*cos(0.43087848850 + 11790.6290886588*$t);
   $B2 += 0.00000000017*cos(1.35132152761 + 78051.5857313169*$t);
   $B2 += 0.00000000015*cos(1.17032155085 + 213.299095438*$t);
   $B2 += 0.00000000018*cos(2.85221514199 + 5088.6288397668*$t);
   $B2 += 0.00000000017*cos(0.21780913672 + 6283.14316029419*$t);
   $B2 += 0.00000000013*cos(1.21201504386 + 25132.3033999656*$t);
   $B2 += 0.00000000012*cos(1.12953712197 + 90617.7374312997*$t);
   $B2 += 0.00000000012*cos(5.13714452592 + 7079.3738568078*$t);
   $B2 += 0.00000000013*cos(3.79842135217 + 4933.2084403326*$t);
   $B2 += 0.00000000012*cos(4.89407978213 + 3738.761430108*$t);
   $B2 += 0.00000000015*cos(6.05682328852 + 398.1490034082*$t);
   $B2 += 0.00000000014*cos(4.81029291856 + 4694.0029547076*$t);
   $B2 += 0.00000000011*cos(0.61684523405 + 3128.3887650958*$t);
   $B2 += 0.00000000011*cos(5.32876538500 + 6040.3472460174*$t);
   $B2 += 0.00000000014*cos(5.27227350286 + 4535.0594369244*$t);
   $B2 += 0.00000000011*cos(2.39292099451 + 5331.3574437408*$t);
   $B2 += 0.00000000010*cos(4.45296532710 + 6525.8044539654*$t);
   $B2 += 0.00000000014*cos(4.66400985037 + 8031.0922630584*$t);
   $B2 += 0.00000000010*cos(3.22472385926 + 9437.762934887*$t);
   $B2 += 0.00000000011*cos(3.80913404437 + 801.8209311238*$t);
   $B2 += 0.00000000010*cos(5.15032130575 + 11371.7046897582*$t);
   $B2 += 0.00000000013*cos(0.98720797401 + 5729.506447149*$t);
   $B2 += 0.00000000009*cos(5.94191743597 + 7632.9432596502*$t);
   return $B2*$t*$t;
}



   function Earth_B3($t) // 11 terms of order 3
{
   $B3  = 0.00000000011*cos(0.23877262399 + 7860.4193924392*$t);
   $B3 += 0.00000000009*cos(1.16069982609 + 5507.5532386674*$t);
   $B3 += 0.00000000008*cos(1.65357552925 + 5884.9268465832*$t);
   $B3 += 0.00000000008*cos(2.86720038197 + 7058.5984613154*$t);
   $B3 += 0.00000000007*cos(3.04818741666 + 5486.777843175*$t);
   $B3 += 0.00000000007*cos(2.59437103785 + 529.6909650946*$t);
   $B3 += 0.00000000008*cos(4.02863090524 + 6256.7775301916*$t);
   $B3 += 0.00000000008*cos(2.42003508927 + 5753.3848848968*$t);
   $B3 += 0.00000000006*cos(0.84181087594 + 6275.9623029906*$t);
   $B3 += 0.00000000006*cos(5.40160929468 + 1577.3435424478*$t);
   $B3 += 0.00000000007*cos(2.73399865247 + 6309.3741697912*$t);
   return $B3*$t*$t*$t;
}



   function Earth_B4($t) // 5 terms of order 4
{
   $B4  = 0.00000000004*cos(0.79662198849 + 6438.4962494256*$t);
   $B4 += 0.00000000005*cos(0.84308705203 + 1047.7473117547*$t);
   $B4 += 0.00000000005*cos(0.05711572303 + 84334.66158130829*$t);
   $B4 += 0.00000000003*cos(3.46779895686 + 6279.5527316424*$t);
   $B4 += 0.00000000003*cos(2.89822201212 + 6127.6554505572*$t);
   return $B4*$t*$t*$t*$t;
}





   function Earth_R0($t) // 526 terms of order 0
{
   $R0  = 1.00013988799;
   $R0 += 0.01670699626*cos(3.09846350771 + 6283.0758499914*$t);
   $R0 += 0.00013956023*cos(3.05524609620 + 12566.1516999828*$t);
   $R0 += 0.00003083720*cos(5.19846674381 + 77713.7714681205*$t);
   $R0 += 0.00001628461*cos(1.17387749012 + 5753.3848848968*$t);
   $R0 += 0.00001575568*cos(2.84685245825 + 7860.4193924392*$t);
   $R0 += 0.00000924799*cos(5.45292234084 + 11506.7697697936*$t);
   $R0 += 0.00000542444*cos(4.56409149777 + 3930.2096962196*$t);
   $R0 += 0.00000472110*cos(3.66100022149 + 5884.9268465832*$t);
   $R0 += 0.00000328780*cos(5.89983646482 + 5223.6939198022*$t);
   $R0 += 0.00000345983*cos(0.96368617687 + 5507.5532386674*$t);
   $R0 += 0.00000306784*cos(0.29867139512 + 5573.1428014331*$t);
   $R0 += 0.00000174844*cos(3.01193636534 + 18849.2275499742*$t);
   $R0 += 0.00000243189*cos(4.27349536153 + 11790.6290886588*$t);
   $R0 += 0.00000211829*cos(5.84714540314 + 1577.3435424478*$t);
   $R0 += 0.00000185752*cos(5.02194447178 + 10977.078804699*$t);
   $R0 += 0.00000109835*cos(5.05510636285 + 5486.777843175*$t);
   $R0 += 0.00000098316*cos(0.88681311277 + 6069.7767545534*$t);
   $R0 += 0.00000086499*cos(5.68959778254 + 15720.8387848784*$t);
   $R0 += 0.00000085825*cos(1.27083733351 + 161000.6857376741*$t);
   $R0 += 0.00000062916*cos(0.92177108832 + 529.6909650946*$t);
   $R0 += 0.00000057056*cos(2.01374292014 + 83996.84731811189*$t);
   $R0 += 0.00000064903*cos(0.27250613787 + 17260.1546546904*$t);
   $R0 += 0.00000049384*cos(3.24501240359 + 2544.3144198834*$t);
   $R0 += 0.00000055736*cos(5.24159798933 + 71430.69561812909*$t);
   $R0 += 0.00000042515*cos(6.01110242003 + 6275.9623029906*$t);
   $R0 += 0.00000046963*cos(2.57805070386 + 775.522611324*$t);
   $R0 += 0.00000038968*cos(5.36071738169 + 4694.0029547076*$t);
   $R0 += 0.00000044661*cos(5.53715807302 + 9437.762934887*$t);
   $R0 += 0.00000035660*cos(1.67468058995 + 12036.4607348882*$t);
   $R0 += 0.00000031921*cos(0.18368229781 + 5088.6288397668*$t);
   $R0 += 0.00000031846*cos(1.77775642085 + 398.1490034082*$t);
   $R0 += 0.00000033193*cos(0.24370300098 + 7084.8967811152*$t);
   $R0 += 0.00000038245*cos(2.39255343974 + 8827.3902698748*$t);
   $R0 += 0.00000028464*cos(1.21344868176 + 6286.5989683404*$t);
   $R0 += 0.00000037490*cos(0.82952922332 + 19651.048481098*$t);
   $R0 += 0.00000036957*cos(4.90107591914 + 12139.5535091068*$t);
   $R0 += 0.00000034537*cos(1.84270693282 + 2942.4634232916*$t);
   $R0 += 0.00000026275*cos(4.58896850401 + 10447.3878396044*$t);
   $R0 += 0.00000024596*cos(3.78660875483 + 8429.2412664666*$t);
   $R0 += 0.00000023587*cos(0.26866117066 + 796.2980068164*$t);
   $R0 += 0.00000027793*cos(1.89934330904 + 6279.5527316424*$t);
   $R0 += 0.00000023927*cos(4.99598548138 + 5856.4776591154*$t);
   $R0 += 0.00000020349*cos(4.65267995431 + 2146.1654164752*$t);
   $R0 += 0.00000023287*cos(2.80783650928 + 14143.4952424306*$t);
   $R0 += 0.00000022103*cos(1.95004702988 + 3154.6870848956*$t);
   $R0 += 0.00000019506*cos(5.38227371393 + 2352.8661537718*$t);
   $R0 += 0.00000017958*cos(0.19871379385 + 6812.766815086*$t);
   $R0 += 0.00000017174*cos(4.43315560735 + 10213.285546211*$t);
   $R0 += 0.00000016190*cos(5.23160507859 + 17789.845619785*$t);
   $R0 += 0.00000017314*cos(6.15200787916 + 16730.4636895958*$t);
   $R0 += 0.00000013814*cos(5.18962074032 + 8031.0922630584*$t);
   $R0 += 0.00000018833*cos(0.67306674027 + 149854.40013480789*$t);
   $R0 += 0.00000018331*cos(2.25348733734 + 23581.2581773176*$t);
   $R0 += 0.00000013641*cos(3.68516118804 + 4705.7323075436*$t);
   $R0 += 0.00000013139*cos(0.65289581324 + 13367.9726311066*$t);
   $R0 += 0.00000010414*cos(4.33285688538 + 11769.8536931664*$t);
   $R0 += 0.00000009978*cos(4.20126336355 + 6309.3741697912*$t);
   $R0 += 0.00000010169*cos(1.59390681369 + 4690.4798363586*$t);
   $R0 += 0.00000007564*cos(2.62560597390 + 6256.7775301916*$t);
   $R0 += 0.00000009661*cos(3.67586791220 + 27511.4678735372*$t);
   $R0 += 0.00000006743*cos(0.56270332741 + 3340.6124266998*$t);
   $R0 += 0.00000008743*cos(6.06359123461 + 1748.016413067*$t);
   $R0 += 0.00000007786*cos(3.67371235637 + 12168.0026965746*$t);
   $R0 += 0.00000006633*cos(5.66149277792 + 11371.7046897582*$t);
   $R0 += 0.00000007712*cos(0.31242577789 + 7632.9432596502*$t);
   $R0 += 0.00000006592*cos(3.13576266188 + 801.8209311238*$t);
   $R0 += 0.00000007460*cos(5.64757188143 + 11926.2544136688*$t);
   $R0 += 0.00000006933*cos(2.92384586400 + 6681.2248533996*$t);
   $R0 += 0.00000006802*cos(1.42329806420 + 23013.5395395872*$t);
   $R0 += 0.00000006115*cos(5.13393615454 + 1194.4470102246*$t);
   $R0 += 0.00000006477*cos(2.64986648492 + 19804.8272915828*$t);
   $R0 += 0.00000005233*cos(4.62434053374 + 6438.4962494256*$t);
   $R0 += 0.00000006147*cos(3.02863936662 + 233141.31440436149*$t);
   $R0 += 0.00000004608*cos(1.72194702724 + 7234.794256242*$t);
   $R0 += 0.00000004221*cos(1.55697533729 + 7238.67559160*$t);
   $R0 += 0.00000005314*cos(2.40716580847 + 11499.6562227928*$t);
   $R0 += 0.00000005128*cos(5.32398965690 + 11513.8833167944*$t);
   $R0 += 0.00000004770*cos(0.25554312006 + 11856.2186514245*$t);
   $R0 += 0.00000005519*cos(2.09089154502 + 17298.1823273262*$t);
   $R0 += 0.00000005625*cos(4.34052903053 + 90955.5516944961*$t);
   $R0 += 0.00000004578*cos(4.46569641570 + 5746.271337896*$t);
   $R0 += 0.00000003788*cos(4.90729383510 + 4164.311989613*$t);
   $R0 += 0.00000005337*cos(5.09957905104 + 31441.6775697568*$t);
   $R0 += 0.00000003967*cos(1.20054555174 + 1349.8674096588*$t);
   $R0 += 0.00000004008*cos(3.03007204392 + 1059.3819301892*$t);
   $R0 += 0.00000003476*cos(0.76080277030 + 10973.55568635*$t);
   $R0 += 0.00000004232*cos(1.05485713117 + 5760.4984318976*$t);
   $R0 += 0.00000004582*cos(3.76570026763 + 6386.16862421*$t);
   $R0 += 0.00000003335*cos(3.13829943354 + 6836.6452528338*$t);
   $R0 += 0.00000003418*cos(3.00072390334 + 4292.3308329504*$t);
   $R0 += 0.00000003598*cos(5.70718084323 + 5643.1785636774*$t);
   $R0 += 0.00000003237*cos(4.16448773994 + 9917.6968745098*$t);
   $R0 += 0.00000004154*cos(2.59941292162 + 7058.5984613154*$t);
   $R0 += 0.00000003362*cos(4.54577697964 + 4732.0306273434*$t);
   $R0 += 0.00000002978*cos(1.30561268820 + 6283.14316029419*$t);
   $R0 += 0.00000002765*cos(0.51311975679 + 26.2983197998*$t);
   $R0 += 0.00000002802*cos(5.66263240521 + 8635.9420037632*$t);
   $R0 += 0.00000002927*cos(5.73787481548 + 16200.7727245012*$t);
   $R0 += 0.00000003164*cos(1.69140262657 + 11015.1064773348*$t);
   $R0 += 0.00000002598*cos(2.96244118586 + 25132.3033999656*$t);
   $R0 += 0.00000003519*cos(3.62639325753 + 244287.60000722769*$t);
   $R0 += 0.00000002676*cos(4.20725700850 + 18073.7049386502*$t);
   $R0 += 0.00000002978*cos(1.74971565805 + 6283.0085396886*$t);
   $R0 += 0.00000002287*cos(1.06975704977 + 14314.1681130498*$t);
   $R0 += 0.00000002863*cos(5.92838131397 + 14712.317116458*$t);
   $R0 += 0.00000003071*cos(0.23793217002 + 35371.8872659764*$t);
   $R0 += 0.00000002656*cos(0.89959301780 + 12352.8526045448*$t);
   $R0 += 0.00000002415*cos(2.79975176257 + 709.9330485583*$t);
   $R0 += 0.00000002814*cos(3.51488206882 + 21228.3920235458*$t);
   $R0 += 0.00000001977*cos(2.61358297550 + 951.7184062506*$t);
   $R0 += 0.00000002548*cos(2.47684686575 + 6208.2942514241*$t);
   $R0 += 0.00000001999*cos(0.56090388160 + 7079.3738568078*$t);
   $R0 += 0.00000002305*cos(1.05376461628 + 22483.84857449259*$t);
   $R0 += 0.00000001855*cos(2.86090681163 + 5216.5803728014*$t);
   $R0 += 0.00000002157*cos(1.31396741861 + 154717.60988768269*$t);
   $R0 += 0.00000001970*cos(4.36929875289 + 167283.76158766549*$t);
   $R0 += 0.00000001635*cos(5.85571606764 + 10984.1923516998*$t);
   $R0 += 0.00000001754*cos(2.14452408833 + 6290.1893969922*$t);
   $R0 += 0.00000002154*cos(6.03828341543 + 10873.9860304804*$t);
   $R0 += 0.00000001714*cos(3.70157691113 + 1592.5960136328*$t);
   $R0 += 0.00000001541*cos(6.21598380732 + 23543.23050468179*$t);
   $R0 += 0.00000001611*cos(1.99824499377 + 10969.9652576982*$t);
   $R0 += 0.00000001712*cos(1.34295663542 + 3128.3887650958*$t);
   $R0 += 0.00000001642*cos(5.55026665339 + 6496.3749454294*$t);
   $R0 += 0.00000001502*cos(5.43948825854 + 155.4203994342*$t);
   $R0 += 0.00000001827*cos(5.91227480261 + 3738.761430108*$t);
   $R0 += 0.00000001726*cos(2.16764983583 + 10575.4066829418*$t);
   $R0 += 0.00000001532*cos(5.35683107070 + 13521.7514415914*$t);
   $R0 += 0.00000001829*cos(1.66006148731 + 39302.096962196*$t);
   $R0 += 0.00000001605*cos(1.90928637633 + 6133.5126528568*$t);
   $R0 += 0.00000001282*cos(2.46014880418 + 13916.0191096416*$t);
   $R0 += 0.00000001211*cos(4.41360631550 + 3894.1818295422*$t);
   $R0 += 0.00000001394*cos(1.77801929354 + 9225.539273283*$t);
   $R0 += 0.00000001571*cos(4.95512957592 + 25158.6017197654*$t);
   $R0 += 0.00000001205*cos(1.19212540615 + 3.523118349*$t);
   $R0 += 0.00000001132*cos(2.69830084955 + 6040.3472460174*$t);
   $R0 += 0.00000001504*cos(5.77002730341 + 18209.33026366019*$t);
   $R0 += 0.00000001393*cos(1.62621805428 + 5120.6011455836*$t);
   $R0 += 0.00000001077*cos(2.93931554233 + 17256.6315363414*$t);
   $R0 += 0.00000001232*cos(0.71655165307 + 143571.32428481648*$t);
   $R0 += 0.00000001087*cos(0.99769687939 + 955.5997416086*$t);
   $R0 += 0.00000001068*cos(5.28472576231 + 65147.6197681377*$t);
   $R0 += 0.00000000980*cos(5.10949204607 + 6172.869528772*$t);
   $R0 += 0.00000001169*cos(3.11664290862 + 14945.3161735544*$t);
   $R0 += 0.00000001202*cos(4.02992510402 + 553.5694028424*$t);
   $R0 += 0.00000000979*cos(2.00000879212 + 15110.4661198662*$t);
   $R0 += 0.00000000962*cos(4.02380771400 + 6282.0955289232*$t);
   $R0 += 0.00000000999*cos(3.62643002790 + 6262.300454499*$t);
   $R0 += 0.00000001030*cos(5.84989900289 + 213.299095438*$t);
   $R0 += 0.00000001014*cos(2.84221578218 + 8662.240323563*$t);
   $R0 += 0.00000001185*cos(1.51330541132 + 17654.7805397496*$t);
   $R0 += 0.00000000967*cos(2.67081017562 + 5650.2921106782*$t);
   $R0 += 0.00000001222*cos(2.65423784904 + 88860.05707098669*$t);
   $R0 += 0.00000000981*cos(2.36370360283 + 6206.8097787158*$t);
   $R0 += 0.00000001033*cos(0.13874927606 + 11712.9553182308*$t);
   $R0 += 0.00000001103*cos(3.08477302937 + 43232.3066584156*$t);
   $R0 += 0.00000000781*cos(2.53372735932 + 16496.3613962024*$t);
   $R0 += 0.00000001019*cos(3.04569392376 + 6037.244203762*$t);
   $R0 += 0.00000000795*cos(5.80662989111 + 5230.807466803*$t);
   $R0 += 0.00000000813*cos(3.57710279439 + 10177.2576795336*$t);
   $R0 += 0.00000000962*cos(5.31470594766 + 6284.0561710596*$t);
   $R0 += 0.00000000721*cos(5.96264301567 + 12559.038152982*$t);
   $R0 += 0.00000000966*cos(2.74714939953 + 6244.9428143536*$t);
   $R0 += 0.00000000921*cos(0.10155275926 + 29088.811415985*$t);
   $R0 += 0.00000000692*cos(3.89764447548 + 1589.0728952838*$t);
   $R0 += 0.00000000719*cos(5.91791450402 + 4136.9104335162*$t);
   $R0 += 0.00000000772*cos(4.05505682353 + 6127.6554505572*$t);
   $R0 += 0.00000000712*cos(5.49291532439 + 22003.9146348698*$t);
   $R0 += 0.00000000672*cos(1.60700490811 + 11087.2851259184*$t);
   $R0 += 0.00000000690*cos(4.50539825563 + 426.598190876*$t);
   $R0 += 0.00000000854*cos(3.26104981596 + 20426.571092422*$t);
   $R0 += 0.00000000656*cos(4.32410182940 + 16858.4825329332*$t);
   $R0 += 0.00000000840*cos(2.59572585222 + 28766.924424484*$t);
   $R0 += 0.00000000692*cos(0.61650089011 + 11403.676995575*$t);
   $R0 += 0.00000000700*cos(3.40901167143 + 7.1135470008*$t);
   $R0 += 0.00000000726*cos(0.04243053594 + 5481.2549188676*$t);
   $R0 += 0.00000000557*cos(4.78317696534 + 20199.094959633*$t);
   $R0 += 0.00000000649*cos(1.04027912958 + 6062.6632075526*$t);
   $R0 += 0.00000000633*cos(5.70229959167 + 45892.73043315699*$t);
   $R0 += 0.00000000592*cos(6.11836729658 + 9623.6882766912*$t);
   $R0 += 0.00000000523*cos(3.62840021266 + 5333.9002410216*$t);
   $R0 += 0.00000000604*cos(5.57734696185 + 10344.2950653858*$t);
   $R0 += 0.00000000496*cos(2.21023499449 + 1990.745017041*$t);
   $R0 += 0.00000000691*cos(1.96071732602 + 12416.5885028482*$t);
   $R0 += 0.00000000640*cos(1.59074172032 + 18319.5365848796*$t);
   $R0 += 0.00000000625*cos(3.82362791378 + 13517.8701062334*$t);
   $R0 += 0.00000000663*cos(5.08444996779 + 283.8593188652*$t);
   $R0 += 0.00000000475*cos(1.17025894287 + 12569.6748183318*$t);
   $R0 += 0.00000000664*cos(4.50029469969 + 47162.5163546352*$t);
   $R0 += 0.00000000569*cos(0.16310365162 + 17267.26820169119*$t);
   $R0 += 0.00000000568*cos(3.86100969474 + 6076.8903015542*$t);
   $R0 += 0.00000000539*cos(4.83282276086 + 18422.62935909819*$t);
   $R0 += 0.00000000466*cos(0.75872342878 + 7342.4577801806*$t);
   $R0 += 0.00000000541*cos(3.07212190507 + 226858.23855437008*$t);
   $R0 += 0.00000000458*cos(0.26774483096 + 4590.910180489*$t);
   $R0 += 0.00000000610*cos(1.53597051291 + 33019.0211122046*$t);
   $R0 += 0.00000000617*cos(2.62356328726 + 11190.377900137*$t);
   $R0 += 0.00000000548*cos(4.55798855791 + 18875.525869774*$t);
   $R0 += 0.00000000633*cos(4.60110281228 + 66567.48586525429*$t);
   $R0 += 0.00000000596*cos(5.78202396722 + 632.7837393132*$t);
   $R0 += 0.00000000533*cos(5.01786882904 + 12132.439962106*$t);
   $R0 += 0.00000000603*cos(5.38458554802 + 316428.22867391503*$t);
   $R0 += 0.00000000469*cos(0.59168241917 + 21954.15760939799*$t);
   $R0 += 0.00000000548*cos(3.50613163558 + 17253.04110768959*$t);
   $R0 += 0.00000000502*cos(0.98804327589 + 11609.8625440122*$t);
   $R0 += 0.00000000568*cos(1.98497313089 + 7668.6374249425*$t);
   $R0 += 0.00000000482*cos(1.62141803864 + 12146.6670561076*$t);
   $R0 += 0.00000000391*cos(3.68718382989 + 18052.9295431578*$t);
   $R0 += 0.00000000457*cos(3.77205737340 + 156137.47598479928*$t);
   $R0 += 0.00000000401*cos(5.28260651958 + 15671.0817594066*$t);
   $R0 += 0.00000000469*cos(1.80963184268 + 12562.6285816338*$t);
   $R0 += 0.00000000508*cos(3.36399024699 + 20597.2439630412*$t);
   $R0 += 0.00000000450*cos(5.66054299250 + 10454.5013866052*$t);
   $R0 += 0.00000000375*cos(4.98534633105 + 9779.1086761254*$t);
   $R0 += 0.00000000523*cos(0.97215560834 + 155427.54293624099*$t);
   $R0 += 0.00000000403*cos(5.13939866506 + 1551.045222648*$t);
   $R0 += 0.00000000372*cos(3.69883738807 + 9388.0059094152*$t);
   $R0 += 0.00000000367*cos(4.43875659716 + 4535.0594369244*$t);
   $R0 += 0.00000000406*cos(4.20863156600 + 12592.4500197826*$t);
   $R0 += 0.00000000360*cos(2.53924644657 + 242.728603974*$t);
   $R0 += 0.00000000471*cos(4.61907324819 + 5436.9930152402*$t);
   $R0 += 0.00000000441*cos(5.83872966262 + 3496.032826134*$t);
   $R0 += 0.00000000385*cos(4.94496680973 + 24356.7807886416*$t);
   $R0 += 0.00000000349*cos(6.15018231784 + 19800.9459562248*$t);
   $R0 += 0.00000000355*cos(0.21895678106 + 5429.8794682394*$t);
   $R0 += 0.00000000344*cos(5.62993724928 + 2379.1644735716*$t);
   $R0 += 0.00000000380*cos(2.72105213143 + 11933.3679606696*$t);
   $R0 += 0.00000000432*cos(0.24221790536 + 17996.0311682222*$t);
   $R0 += 0.00000000378*cos(5.22517556974 + 7477.522860216*$t);
   $R0 += 0.00000000337*cos(5.10888041439 + 5849.3641121146*$t);
   $R0 += 0.00000000315*cos(0.57827745123 + 10557.5941608238*$t);
   $R0 += 0.00000000318*cos(4.49953141399 + 3634.6210245184*$t);
   $R0 += 0.00000000323*cos(1.54274281393 + 10440.2742926036*$t);
   $R0 += 0.00000000309*cos(5.76839284397 + 20.7753954924*$t);
   $R0 += 0.00000000301*cos(2.34727604008 + 4686.8894077068*$t);
   $R0 += 0.00000000414*cos(5.93237602310 + 51092.7260508548*$t);
   $R0 += 0.00000000361*cos(2.16398609550 + 28237.2334593894*$t);
   $R0 += 0.00000000288*cos(0.18376252189 + 13095.8426650774*$t);
   $R0 += 0.00000000277*cos(5.12952205045 + 13119.72110282519*$t);
   $R0 += 0.00000000327*cos(6.19222146204 + 6268.8487559898*$t);
   $R0 += 0.00000000273*cos(0.30522428863 + 23141.5583829246*$t);
   $R0 += 0.00000000267*cos(5.76152585786 + 5966.6839803348*$t);
   $R0 += 0.00000000308*cos(5.99280509979 + 22805.7355659936*$t);
   $R0 += 0.00000000345*cos(2.92489919444 + 36949.2308084242*$t);
   $R0 += 0.00000000253*cos(5.20995219509 + 24072.9214697764*$t);
   $R0 += 0.00000000342*cos(5.72702586209 + 16460.33352952499*$t);
   $R0 += 0.00000000261*cos(2.00304796059 + 6148.010769956*$t);
   $R0 += 0.00000000238*cos(5.08264392839 + 6915.8595893046*$t);
   $R0 += 0.00000000249*cos(2.94762789744 + 135.0650800354*$t);
   $R0 += 0.00000000306*cos(3.89764686987 + 10988.808157535*$t);
   $R0 += 0.00000000305*cos(0.05827812117 + 4701.1165017084*$t);
   $R0 += 0.00000000319*cos(2.95712862064 + 163096.18036118349*$t);
   $R0 += 0.00000000209*cos(4.43768461442 + 6546.1597733642*$t);
   $R0 += 0.00000000270*cos(2.06643178717 + 4804.209275927*$t);
   $R0 += 0.00000000217*cos(0.73691592312 + 6303.8512454838*$t);
   $R0 += 0.00000000206*cos(0.32075959415 + 25934.1243310894*$t);
   $R0 += 0.00000000218*cos(0.18428135264 + 28286.9904848612*$t);
   $R0 += 0.00000000205*cos(5.21312087405 + 20995.3929664494*$t);
   $R0 += 0.00000000199*cos(0.44384292491 + 16737.5772365966*$t);
   $R0 += 0.00000000230*cos(6.06567392849 + 6287.0080032545*$t);
   $R0 += 0.00000000219*cos(1.29194216300 + 5326.7866940208*$t);
   $R0 += 0.00000000201*cos(1.74700937253 + 22743.4093795164*$t);
   $R0 += 0.00000000207*cos(4.45440927276 + 6279.4854213396*$t);
   $R0 += 0.00000000269*cos(6.05640445030 + 64471.99124174489*$t);
   $R0 += 0.00000000190*cos(0.99256176518 + 29296.6153895786*$t);
   $R0 += 0.00000000238*cos(5.42471431221 + 39609.6545831656*$t);
   $R0 += 0.00000000262*cos(5.26961924198 + 522.5774180938*$t);
   $R0 += 0.00000000210*cos(4.68618183158 + 6254.6266625236*$t);
   $R0 += 0.00000000197*cos(2.80624554080 + 4933.2084403326*$t);
   $R0 += 0.00000000252*cos(4.36220154608 + 40879.4405046438*$t);
   $R0 += 0.00000000261*cos(1.07241516738 + 55022.9357470744*$t);
   $R0 += 0.00000000189*cos(3.82966734476 + 419.4846438752*$t);
   $R0 += 0.00000000185*cos(4.14324541379 + 5642.1982426092*$t);
   $R0 += 0.00000000247*cos(3.44855612987 + 6702.5604938666*$t);
   $R0 += 0.00000000205*cos(4.04424043223 + 536.8045120954*$t);
   $R0 += 0.00000000191*cos(3.14082686083 + 16723.350142595*$t);
   $R0 += 0.00000000222*cos(5.16263907319 + 23539.7073863328*$t);
   $R0 += 0.00000000180*cos(4.56214752149 + 6489.2613984286*$t);
   $R0 += 0.00000000219*cos(0.80382553358 + 16627.3709153772*$t);
   $R0 += 0.00000000227*cos(0.60156339452 + 5905.7022420756*$t);
   $R0 += 0.00000000168*cos(0.88753528161 + 16062.1845261168*$t);
   $R0 += 0.00000000158*cos(0.92127725775 + 23937.856389741*$t);
   $R0 += 0.00000000157*cos(4.69607868164 + 6805.6532680852*$t);
   $R0 += 0.00000000207*cos(4.88410451334 + 6286.6662786432*$t);
   $R0 += 0.00000000160*cos(4.95943826846 + 10021.8372800994*$t);
   $R0 += 0.00000000166*cos(0.97126433565 + 3097.88382272579*$t);
   $R0 += 0.00000000209*cos(5.75663411805 + 3646.3503773544*$t);
   $R0 += 0.00000000175*cos(6.12762824412 + 239424.39025435288*$t);
   $R0 += 0.00000000173*cos(3.13887234973 + 6179.9830757728*$t);
   $R0 += 0.00000000157*cos(3.62822058179 + 18451.07854656599*$t);
   $R0 += 0.00000000157*cos(4.67695912235 + 6709.6740408674*$t);
   $R0 += 0.00000000146*cos(3.09506069735 + 4907.3020501456*$t);
   $R0 += 0.00000000165*cos(2.27139128760 + 10660.6869350424*$t);
   $R0 += 0.00000000201*cos(1.67701267433 + 2107.0345075424*$t);
   $R0 += 0.00000000144*cos(3.96947747592 + 6019.9919266186*$t);
   $R0 += 0.00000000171*cos(5.91302216729 + 6058.7310542895*$t);
   $R0 += 0.00000000144*cos(2.13155655120 + 26084.0218062162*$t);
   $R0 += 0.00000000151*cos(0.67417383554 + 2388.8940204492*$t);
   $R0 += 0.00000000189*cos(5.07122281033 + 263.0839233728*$t);
   $R0 += 0.00000000146*cos(5.10373877968 + 10770.8932562618*$t);
   $R0 += 0.00000000187*cos(1.23915444627 + 19402.7969528166*$t);
   $R0 += 0.00000000174*cos(0.08407293391 + 9380.9596727172*$t);
   $R0 += 0.00000000137*cos(1.26247412309 + 12566.2190102856*$t);
   $R0 += 0.00000000137*cos(3.52826010842 + 639.897286314*$t);
   $R0 += 0.00000000148*cos(1.76124372592 + 5888.4499649322*$t);
   $R0 += 0.00000000164*cos(2.39195095081 + 6357.8574485587*$t);
   $R0 += 0.00000000146*cos(2.43675816553 + 5881.4037282342*$t);
   $R0 += 0.00000000161*cos(1.15721259372 + 26735.9452622132*$t);
   $R0 += 0.00000000131*cos(2.51859277344 + 6599.467719648*$t);
   $R0 += 0.00000000153*cos(5.85203687779 + 6281.5913772831*$t);
   $R0 += 0.00000000151*cos(3.72338532649 + 12669.2444742014*$t);
   $R0 += 0.00000000132*cos(2.38417741883 + 6525.8044539654*$t);
   $R0 += 0.00000000129*cos(0.75556744143 + 5017.508371365*$t);
   $R0 += 0.00000000127*cos(0.00254936441 + 10027.9031957292*$t);
   $R0 += 0.00000000148*cos(2.85102145528 + 6418.1409300268*$t);
   $R0 += 0.00000000143*cos(5.74460279367 + 26087.9031415742*$t);
   $R0 += 0.00000000172*cos(0.41289962240 + 174242.4659640497*$t);
   $R0 += 0.00000000136*cos(4.15497742275 + 6311.5250374592*$t);
   $R0 += 0.00000000170*cos(5.98194913129 + 327574.51427678125*$t);
   $R0 += 0.00000000124*cos(1.65497607604 + 32217.2001810808*$t);
   $R0 += 0.00000000136*cos(2.48430783417 + 13341.6743113068*$t);
   $R0 += 0.00000000165*cos(2.49667924600 + 58953.145443294*$t);
   $R0 += 0.00000000123*cos(3.45660563754 + 6277.552925684*$t);
   $R0 += 0.00000000117*cos(0.86065134175 + 6245.0481773556*$t);
   $R0 += 0.00000000149*cos(5.61358280963 + 5729.506447149*$t);
   $R0 += 0.00000000153*cos(0.26860029950 + 245.8316462294*$t);
   $R0 += 0.00000000128*cos(0.71204006588 + 103.0927742186*$t);
   $R0 += 0.00000000159*cos(2.43166592149 + 221995.02880149524*$t);
   $R0 += 0.00000000130*cos(2.80707316718 + 6016.4688082696*$t);
   $R0 += 0.00000000137*cos(1.70657709294 + 12566.08438968*$t);
   $R0 += 0.00000000111*cos(1.56305648432 + 17782.7320727842*$t);
   $R0 += 0.00000000113*cos(3.58302904101 + 25685.872802808*$t);
   $R0 += 0.00000000109*cos(3.26403795962 + 6819.8803620868*$t);
   $R0 += 0.00000000122*cos(0.34120688217 + 1162.4747044078*$t);
   $R0 += 0.00000000119*cos(5.84644718278 + 12721.572099417*$t);
   $R0 += 0.00000000144*cos(2.28899679126 + 12489.8856287072*$t);
   $R0 += 0.00000000137*cos(5.82029768354 + 44809.6502008634*$t);
   $R0 += 0.00000000107*cos(2.42818544140 + 5547.1993364596*$t);
   $R0 += 0.00000000134*cos(1.26539982939 + 5331.3574437408*$t);
   $R0 += 0.00000000103*cos(5.96518130595 + 6321.1035226272*$t);
   $R0 += 0.00000000109*cos(0.33808549034 + 11300.5842213564*$t);
   $R0 += 0.00000000129*cos(5.89187277327 + 12029.3471878874*$t);
   $R0 += 0.00000000122*cos(5.77325634636 + 11919.140866668*$t);
   $R0 += 0.00000000107*cos(6.24998989350 + 77690.75950573849*$t);
   $R0 += 0.00000000107*cos(1.00535580713 + 77736.78343050249*$t);
   $R0 += 0.00000000143*cos(0.24122178432 + 4214.0690150848*$t);
   $R0 += 0.00000000143*cos(0.88529649733 + 7576.560073574*$t);
   $R0 += 0.00000000107*cos(2.92124030496 + 31415.379249957*$t);
   $R0 += 0.00000000099*cos(5.70862227072 + 5540.0857894588*$t);
   $R0 += 0.00000000110*cos(0.37528037383 + 5863.5912061162*$t);
   $R0 += 0.00000000104*cos(4.44107178366 + 2118.7638603784*$t);
   $R0 += 0.00000000098*cos(5.95877916706 + 4061.2192153944*$t);
   $R0 += 0.00000000113*cos(1.24206857385 + 84672.47584450469*$t);
   $R0 += 0.00000000124*cos(2.55619029867 + 12539.853380183*$t);
   $R0 += 0.00000000110*cos(3.66952094329 + 238004.52415723629*$t);
   $R0 += 0.00000000112*cos(4.32512422943 + 97238.62754448749*$t);
   $R0 += 0.00000000097*cos(3.70151541181 + 11720.0688652316*$t);
   $R0 += 0.00000000120*cos(1.26895630252 + 12043.574281889*$t);
   $R0 += 0.00000000094*cos(2.56461130309 + 19004.6479494084*$t);
   $R0 += 0.00000000117*cos(3.65425622684 + 34520.3093093808*$t);
   $R0 += 0.00000000098*cos(0.13589994287 + 11080.1715789176*$t);
   $R0 += 0.00000000097*cos(5.38330115253 + 7834.1210726394*$t);
   $R0 += 0.00000000097*cos(2.46722096722 + 71980.63357473118*$t);
   $R0 += 0.00000000095*cos(5.36958330451 + 6288.5987742988*$t);
   $R0 += 0.00000000111*cos(5.01961920313 + 11823.1616394502*$t);
   $R0 += 0.00000000090*cos(2.72299804525 + 26880.3198130326*$t);
   $R0 += 0.00000000099*cos(0.90164266377 + 18635.9284545362*$t);
   $R0 += 0.00000000126*cos(4.78722177847 + 305281.94307104882*$t);
   $R0 += 0.00000000093*cos(0.21240380046 + 18139.2945014159*$t);
   $R0 += 0.00000000124*cos(5.00979495566 + 172146.97134054029*$t);
   $R0 += 0.00000000099*cos(5.67090026475 + 16522.6597160022*$t);
   $R0 += 0.00000000092*cos(2.28180963676 + 12491.3701014155*$t);
   $R0 += 0.00000000090*cos(4.50544881196 + 40077.61957352*$t);
   $R0 += 0.00000000100*cos(2.00639461612 + 12323.4230960088*$t);
   $R0 += 0.00000000095*cos(5.68801979087 + 14919.0178537546*$t);
   $R0 += 0.00000000087*cos(1.86043406047 + 27707.5424942948*$t);
   $R0 += 0.00000000105*cos(3.02903468417 + 22345.2603761082*$t);
   $R0 += 0.00000000087*cos(5.43970168638 + 6272.0301497275*$t);
   $R0 += 0.00000000089*cos(1.63389387182 + 33326.5787331742*$t);
   $R0 += 0.00000000082*cos(5.58298993353 + 10241.2022911672*$t);
   $R0 += 0.00000000094*cos(5.47749711149 + 9924.8104215106*$t);
   $R0 += 0.00000000082*cos(4.71988314145 + 15141.390794312*$t);
   $R0 += 0.00000000097*cos(5.61458778738 + 2787.0430238574*$t);
   $R0 += 0.00000000096*cos(3.89073946348 + 6379.0550772092*$t);
   $R0 += 0.00000000081*cos(3.13038482444 + 36147.4098773004*$t);
   $R0 += 0.00000000110*cos(4.89978492291 + 72140.62866668739*$t);
   $R0 += 0.00000000097*cos(5.20764563059 + 6303.4311693902*$t);
   $R0 += 0.00000000082*cos(5.26342716139 + 9814.6041002912*$t);
   $R0 += 0.00000000109*cos(2.35555589770 + 83286.91426955358*$t);
   $R0 += 0.00000000097*cos(2.58492958057 + 30666.1549584328*$t);
   $R0 += 0.00000000093*cos(1.32651591333 + 23020.65308658799*$t);
   $R0 += 0.00000000078*cos(3.99588630754 + 11293.4706743556*$t);
   $R0 += 0.00000000090*cos(0.57771932738 + 26482.1708096244*$t);
   $R0 += 0.00000000106*cos(3.92012705073 + 62883.3551395136*$t);
   $R0 += 0.00000000098*cos(2.94397773524 + 316.3918696566*$t);
   $R0 += 0.00000000076*cos(3.96310417608 + 29026.48522950779*$t);
   $R0 += 0.00000000078*cos(1.97068529306 + 90279.92316810328*$t);
   $R0 += 0.00000000076*cos(0.23027966596 + 21424.4666443034*$t);
   $R0 += 0.00000000080*cos(2.23099742212 + 266.6070417218*$t);
   $R0 += 0.00000000079*cos(1.46227790922 + 8982.810669309*$t);
   $R0 += 0.00000000102*cos(4.92129953565 + 5621.8429232104*$t);
   $R0 += 0.00000000100*cos(0.39243148321 + 24279.10701821359*$t);
   $R0 += 0.00000000071*cos(1.52014858474 + 33794.5437235286*$t);
   $R0 += 0.00000000076*cos(0.22880641443 + 57375.8019008462*$t);
   $R0 += 0.00000000091*cos(0.96515913904 + 48739.859897083*$t);
   $R0 += 0.00000000075*cos(2.77638585157 + 12964.300703391*$t);
   $R0 += 0.00000000077*cos(5.18846946344 + 11520.9968637952*$t);
   $R0 += 0.00000000068*cos(0.50006599129 + 4274.5183108324*$t);
   $R0 += 0.00000000075*cos(2.07323762803 + 15664.03552270859*$t);
   $R0 += 0.00000000074*cos(1.01884134928 + 6393.2821712108*$t);
   $R0 += 0.00000000077*cos(0.46665178780 + 16207.886271502*$t);
   $R0 += 0.00000000081*cos(4.10452219483 + 161710.61878623239*$t);
   $R0 += 0.00000000067*cos(3.83840630887 + 6262.7205305926*$t);
   $R0 += 0.00000000071*cos(3.91415523291 + 7875.6718636242*$t);
   $R0 += 0.00000000081*cos(0.91938383237 + 74.7815985673*$t);
   $R0 += 0.00000000083*cos(4.69916218791 + 23006.42599258639*$t);
   $R0 += 0.00000000063*cos(2.32556465878 + 6279.1945146334*$t);
   $R0 += 0.00000000065*cos(5.41938745446 + 28628.3362260996*$t);
   $R0 += 0.00000000065*cos(3.02336771694 + 5959.570433334*$t);
   $R0 += 0.00000000064*cos(3.31033198370 + 2636.725472637*$t);
   $R0 += 0.00000000064*cos(0.18375587519 + 1066.49547719*$t);
   $R0 += 0.00000000080*cos(5.81239171612 + 12341.8069042809*$t);
   $R0 += 0.00000000066*cos(2.15105504851 + 38.0276726358*$t);
   $R0 += 0.00000000062*cos(2.43313614978 + 10138.1095169486*$t);
   $R0 += 0.00000000060*cos(3.16153906470 + 5490.300961524*$t);
   $R0 += 0.00000000069*cos(0.30764736334 + 7018.9523635232*$t);
   $R0 += 0.00000000068*cos(2.24442548639 + 24383.0791084414*$t);
   $R0 += 0.00000000078*cos(1.39649386463 + 9411.4646150872*$t);
   $R0 += 0.00000000063*cos(0.72976362625 + 6286.9571853494*$t);
   $R0 += 0.00000000073*cos(4.95125917731 + 6453.7487206106*$t);
   $R0 += 0.00000000078*cos(0.32736023459 + 6528.9074962208*$t);
   $R0 += 0.00000000059*cos(4.95362151577 + 35707.7100829074*$t);
   $R0 += 0.00000000070*cos(2.37962727525 + 15508.6151232744*$t);
   $R0 += 0.00000000073*cos(1.35229143111 + 5327.4761083828*$t);
   $R0 += 0.00000000072*cos(5.91833527334 + 10881.0995774812*$t);
   $R0 += 0.00000000059*cos(5.36231868425 + 10239.5838660108*$t);
   $R0 += 0.00000000059*cos(1.63156134967 + 61306.0115970658*$t);
   $R0 += 0.00000000054*cos(4.29491690425 + 21947.11137270*$t);
   $R0 += 0.00000000057*cos(5.89190132575 + 34513.2630726828*$t);
   $R0 += 0.00000000074*cos(1.38235845304 + 9967.4538999816*$t);
   $R0 += 0.00000000053*cos(3.86543309344 + 32370.9789915656*$t);
   $R0 += 0.00000000055*cos(4.51794544854 + 34911.412076091*$t);
   $R0 += 0.00000000063*cos(5.41479412056 + 11502.8376165305*$t);
   $R0 += 0.00000000063*cos(2.34416220742 + 11510.7019230567*$t);
   $R0 += 0.00000000068*cos(0.77493931112 + 29864.334027309*$t);
   $R0 += 0.00000000060*cos(5.57024703495 + 5756.9080032458*$t);
   $R0 += 0.00000000072*cos(2.80863088166 + 10866.8724834796*$t);
   $R0 += 0.00000000061*cos(2.69736991384 + 82576.98122099529*$t);
   $R0 += 0.00000000063*cos(5.32068807257 + 3116.6594122598*$t);
   $R0 += 0.00000000052*cos(1.02278758099 + 6272.4391846416*$t);
   $R0 += 0.00000000069*cos(5.00698550308 + 25287.7237993998*$t);
   $R0 += 0.00000000066*cos(6.12047940728 + 12074.488407524*$t);
   $R0 += 0.00000000051*cos(2.59519527563 + 11396.5634485742*$t);
   $R0 += 0.00000000056*cos(2.57995973521 + 17892.93839400359*$t);
   $R0 += 0.00000000059*cos(0.44167237620 + 250570.67585721909*$t);
   $R0 += 0.00000000059*cos(3.84070143543 + 5483.254724826*$t);
   $R0 += 0.00000000049*cos(0.54704693048 + 22594.05489571199*$t);
   $R0 += 0.00000000065*cos(2.38423614501 + 52670.0695933026*$t);
   $R0 += 0.00000000069*cos(5.34363738671 + 66813.5648357332*$t);
   $R0 += 0.00000000057*cos(5.42770501007 + 310145.15282392364*$t);
   $R0 += 0.00000000053*cos(1.17760296075 + 149.5631971346*$t);
   $R0 += 0.00000000061*cos(4.02090887211 + 34596.3646546524*$t);
   $R0 += 0.00000000049*cos(4.18361320516 + 18606.4989460002*$t);
   $R0 += 0.00000000055*cos(0.83886167974 + 20452.8694122218*$t);
   $R0 += 0.00000000050*cos(1.46327331958 + 37455.7264959744*$t);
   $R0 += 0.00000000048*cos(4.53854727167 + 29822.7832363242*$t);
   $R0 += 0.00000000058*cos(3.34847975377 + 33990.6183442862*$t);
   $R0 += 0.00000000065*cos(1.45522693982 + 76251.32777062019*$t);
   $R0 += 0.00000000056*cos(2.35650663692 + 37724.7534197482*$t);
   $R0 += 0.00000000052*cos(2.61551081496 + 5999.2165311262*$t);
   $R0 += 0.00000000053*cos(0.17334326094 + 77717.29458646949*$t);
   $R0 += 0.00000000053*cos(0.79879700631 + 77710.24834977149*$t);
   $R0 += 0.00000000047*cos(0.43240779709 + 735.8765135318*$t);
   $R0 += 0.00000000053*cos(4.58763261686 + 11616.976091013*$t);
   $R0 += 0.00000000048*cos(6.20230111054 + 4171.4255366138*$t);
   $R0 += 0.00000000052*cos(1.09723616404 + 640.8776073822*$t);
   $R0 += 0.00000000057*cos(3.42008310383 + 50317.2034395308*$t);
   $R0 += 0.00000000053*cos(1.01528448581 + 149144.46708624958*$t);
   $R0 += 0.00000000047*cos(3.00924906195 + 52175.8062831484*$t);
   $R0 += 0.00000000052*cos(2.03254070404 + 6293.7125153412*$t);
   $R0 += 0.00000000048*cos(0.12356889734 + 13362.4497067992*$t);
   $R0 += 0.00000000045*cos(3.37963782356 + 10763.779709261*$t);
   $R0 += 0.00000000047*cos(5.50981287869 + 12779.4507954208*$t);
   $R0 += 0.00000000062*cos(5.45209070099 + 949.1756089698*$t);
   $R0 += 0.00000000061*cos(2.93237974631 + 5791.4125575326*$t);
   $R0 += 0.00000000044*cos(2.87440620802 + 8584.6616659008*$t);
   $R0 += 0.00000000046*cos(4.03141796560 + 10667.8004820432*$t);
   $R0 += 0.00000000047*cos(3.89902931422 + 3903.9113764198*$t);
   $R0 += 0.00000000046*cos(2.75700467329 + 6993.0088985497*$t);
   $R0 += 0.00000000045*cos(1.93386293300 + 206.1855484372*$t);
   $R0 += 0.00000000047*cos(2.57670800912 + 11492.542675792*$t);
   $R0 += 0.00000000044*cos(3.62570223167 + 63658.8777508376*$t);
   $R0 += 0.00000000051*cos(0.84536826273 + 12345.739057544*$t);
   $R0 += 0.00000000043*cos(0.01524970172 + 37853.8754993826*$t);
   $R0 += 0.00000000041*cos(3.27146326065 + 8858.3149443206*$t);
   $R0 += 0.00000000045*cos(3.03765521215 + 65236.2212932854*$t);
   $R0 += 0.00000000047*cos(1.44447548944 + 21393.5419698576*$t);
   $R0 += 0.00000000058*cos(5.45843180927 + 1975.492545856*$t);
   $R0 += 0.00000000050*cos(2.13285524146 + 12573.2652469836*$t);
   $R0 += 0.00000000041*cos(1.32190847146 + 2547.8375382324*$t);
   $R0 += 0.00000000047*cos(3.67579608544 + 28313.288804661*$t);
   $R0 += 0.00000000041*cos(2.24013475126 + 8273.8208670324*$t);
   $R0 += 0.00000000047*cos(6.21438985953 + 10991.3058987006*$t);
   $R0 += 0.00000000042*cos(3.01631817350 + 853.196381752*$t);
   $R0 += 0.00000000056*cos(1.09773690181 + 77376.20102240759*$t);
   $R0 += 0.00000000040*cos(2.35698541041 + 2699.7348193176*$t);
   $R0 += 0.00000000043*cos(5.28030898459 + 17796.9591667858*$t);
   $R0 += 0.00000000054*cos(2.59175932091 + 22910.44676536859*$t);
   $R0 += 0.00000000054*cos(0.88027764102 + 71960.38658322369*$t);
   $R0 += 0.00000000055*cos(0.07988899477 + 83467.15635301729*$t);
   $R0 += 0.00000000039*cos(1.12867321442 + 9910.583327509*$t);
   $R0 += 0.00000000040*cos(1.35670430524 + 27177.8515292002*$t);
   $R0 += 0.00000000039*cos(4.39624220245 + 5618.3198048614*$t);
   $R0 += 0.00000000042*cos(4.78798367468 + 7856.89627409019*$t);
   $R0 += 0.00000000047*cos(2.75482175292 + 18202.21671665939*$t);
   $R0 += 0.00000000039*cos(1.97008298629 + 24491.4257925834*$t);
   $R0 += 0.00000000042*cos(4.04346599946 + 7863.9425107882*$t);
   $R0 += 0.00000000038*cos(0.49178679251 + 38650.173506199*$t);
   $R0 += 0.00000000036*cos(4.86047906533 + 4157.1984426122*$t);
   $R0 += 0.00000000043*cos(5.64354880978 + 1062.9050485382*$t);
   $R0 += 0.00000000036*cos(3.98066313627 + 12565.1713789146*$t);
   $R0 += 0.00000000042*cos(2.30753932657 + 6549.6828917132*$t);
   $R0 += 0.00000000040*cos(5.39694918320 + 9498.2122306346*$t);
   $R0 += 0.00000000040*cos(3.30603243754 + 23536.11695768099*$t);
   $R0 += 0.00000000050*cos(6.15760345261 + 78051.34191383338*$t);
   return $R0;
}



   function Earth_R1($t) // 292 terms of order 1
{
   $R1  = 0.00103018608*cos(1.10748969588 + 6283.0758499914*$t);
   $R1 += 0.00001721238*cos(1.06442301418 + 12566.1516999828*$t);
   $R1 -= 0.00000702215;
   $R1 += 0.00000032346*cos(1.02169059149 + 18849.2275499742*$t);
   $R1 += 0.00000030799*cos(2.84353804832 + 5507.5532386674*$t);
   $R1 += 0.00000024971*cos(1.31906709482 + 5223.6939198022*$t);
   $R1 += 0.00000018485*cos(1.42429748614 + 1577.3435424478*$t);
   $R1 += 0.00000010078*cos(5.91378194648 + 10977.078804699*$t);
   $R1 += 0.00000008634*cos(0.27146150602 + 5486.777843175*$t);
   $R1 += 0.00000008654*cos(1.42046854427 + 6275.9623029906*$t);
   $R1 += 0.00000005069*cos(1.68613426734 + 5088.6288397668*$t);
   $R1 += 0.00000004985*cos(6.01401770704 + 6286.5989683404*$t);
   $R1 += 0.00000004669*cos(5.98724494073 + 529.6909650946*$t);
   $R1 += 0.00000004395*cos(0.51800238019 + 4694.0029547076*$t);
   $R1 += 0.00000003872*cos(4.74969833437 + 2544.3144198834*$t);
   $R1 += 0.00000003750*cos(5.07097685568 + 796.2980068164*$t);
   $R1 += 0.00000004100*cos(1.08424786092 + 9437.762934887*$t);
   $R1 += 0.00000003518*cos(0.02290216272 + 83996.84731811189*$t);
   $R1 += 0.00000003436*cos(0.94937019624 + 71430.69561812909*$t);
   $R1 += 0.00000003221*cos(6.15628775313 + 2146.1654164752*$t);
   $R1 += 0.00000003414*cos(5.41218322538 + 775.522611324*$t);
   $R1 += 0.00000002863*cos(5.48432847146 + 10447.3878396044*$t);
   $R1 += 0.00000002520*cos(0.24276941146 + 398.1490034082*$t);
   $R1 += 0.00000002201*cos(4.95216196651 + 6812.766815086*$t);
   $R1 += 0.00000002186*cos(0.41991743105 + 8031.0922630584*$t);
   $R1 += 0.00000002838*cos(3.42034351366 + 2352.8661537718*$t);
   $R1 += 0.00000002554*cos(6.13241878525 + 6438.4962494256*$t);
   $R1 += 0.00000001932*cos(5.31374608366 + 8429.2412664666*$t);
   $R1 += 0.00000002429*cos(3.09164528262 + 4690.4798363586*$t);
   $R1 += 0.00000001730*cos(1.53686208550 + 4705.7323075436*$t);
   $R1 += 0.00000002250*cos(3.68863633842 + 7084.8967811152*$t);
   $R1 += 0.00000002093*cos(1.28191783032 + 1748.016413067*$t);
   $R1 += 0.00000001441*cos(0.81656250862 + 14143.4952424306*$t);
   $R1 += 0.00000001483*cos(3.22225357771 + 7234.794256242*$t);
   $R1 += 0.00000001754*cos(3.22883705112 + 6279.5527316424*$t);
   $R1 += 0.00000001583*cos(4.09702349428 + 11499.6562227928*$t);
   $R1 += 0.00000001575*cos(5.53890170575 + 3154.6870848956*$t);
   $R1 += 0.00000001847*cos(1.82040335363 + 7632.9432596502*$t);
   $R1 += 0.00000001504*cos(3.63293385726 + 11513.8833167944*$t);
   $R1 += 0.00000001337*cos(4.64440864339 + 6836.6452528338*$t);
   $R1 += 0.00000001275*cos(2.69341415363 + 1349.8674096588*$t);
   $R1 += 0.00000001352*cos(6.15101580257 + 5746.271337896*$t);
   $R1 += 0.00000001125*cos(3.35673439497 + 17789.845619785*$t);
   $R1 += 0.00000001470*cos(3.65282991755 + 1194.4470102246*$t);
   $R1 += 0.00000001177*cos(2.57676109092 + 13367.9726311066*$t);
   $R1 += 0.00000001101*cos(4.49748696552 + 4292.3308329504*$t);
   $R1 += 0.00000001234*cos(5.65036509521 + 5760.4984318976*$t);
   $R1 += 0.00000000984*cos(0.65517395136 + 5856.4776591154*$t);
   $R1 += 0.00000000928*cos(2.32420318751 + 10213.285546211*$t);
   $R1 += 0.00000001077*cos(5.82812169132 + 12036.4607348882*$t);
   $R1 += 0.00000000916*cos(0.76613009583 + 16730.4636895958*$t);
   $R1 += 0.00000000877*cos(1.50137505051 + 11926.2544136688*$t);
   $R1 += 0.00000001023*cos(5.62076589825 + 6256.7775301916*$t);
   $R1 += 0.00000000851*cos(0.65709335533 + 155.4203994342*$t);
   $R1 += 0.00000000802*cos(4.10519132088 + 951.7184062506*$t);
   $R1 += 0.00000000857*cos(1.41661697538 + 5753.3848848968*$t);
   $R1 += 0.00000000994*cos(1.14418521187 + 1059.3819301892*$t);
   $R1 += 0.00000000813*cos(1.63948433322 + 6681.2248533996*$t);
   $R1 += 0.00000000662*cos(4.55200452260 + 5216.5803728014*$t);
   $R1 += 0.00000000644*cos(4.19478168733 + 6040.3472460174*$t);
   $R1 += 0.00000000626*cos(1.50767713598 + 5643.1785636774*$t);
   $R1 += 0.00000000590*cos(6.18277145205 + 4164.311989613*$t);
   $R1 += 0.00000000635*cos(0.52413263542 + 6290.1893969922*$t);
   $R1 += 0.00000000650*cos(0.97935690350 + 25132.3033999656*$t);
   $R1 += 0.00000000568*cos(2.30125315873 + 10973.55568635*$t);
   $R1 += 0.00000000547*cos(5.27256412213 + 3340.6124266998*$t);
   $R1 += 0.00000000547*cos(2.20144422886 + 1592.5960136328*$t);
   $R1 += 0.00000000526*cos(0.92464258226 + 11371.7046897582*$t);
   $R1 += 0.00000000490*cos(5.90951388655 + 3894.1818295422*$t);
   $R1 += 0.00000000478*cos(1.66857963179 + 12168.0026965746*$t);
   $R1 += 0.00000000516*cos(3.59803483887 + 10969.9652576982*$t);
   $R1 += 0.00000000518*cos(3.97914412373 + 17298.1823273262*$t);
   $R1 += 0.00000000534*cos(5.03740926442 + 9917.6968745098*$t);
   $R1 += 0.00000000487*cos(2.50545369269 + 6127.6554505572*$t);
   $R1 += 0.00000000416*cos(4.04828175503 + 10984.1923516998*$t);
   $R1 += 0.00000000538*cos(5.54081539805 + 553.5694028424*$t);
   $R1 += 0.00000000402*cos(2.16544019233 + 7860.4193924392*$t);
   $R1 += 0.00000000553*cos(2.32177369366 + 11506.7697697936*$t);
   $R1 += 0.00000000367*cos(3.39152532250 + 6496.3749454294*$t);
   $R1 += 0.00000000360*cos(5.34379853282 + 7079.3738568078*$t);
   $R1 += 0.00000000337*cos(3.61563704045 + 11790.6290886588*$t);
   $R1 += 0.00000000456*cos(0.30754294809 + 801.8209311238*$t);
   $R1 += 0.00000000417*cos(3.70009308674 + 10575.4066829418*$t);
   $R1 += 0.00000000381*cos(5.82033971802 + 7058.5984613154*$t);
   $R1 += 0.00000000321*cos(0.31988767355 + 16200.7727245012*$t);
   $R1 += 0.00000000364*cos(1.08414306177 + 6309.3741697912*$t);
   $R1 += 0.00000000294*cos(4.54798604957 + 11856.2186514245*$t);
   $R1 += 0.00000000290*cos(1.26473978562 + 8635.9420037632*$t);
   $R1 += 0.00000000399*cos(4.16998866302 + 26.2983197998*$t);
   $R1 += 0.00000000262*cos(5.08316906342 + 10177.2576795336*$t);
   $R1 += 0.00000000243*cos(2.25746091190 + 11712.9553182308*$t);
   $R1 += 0.00000000237*cos(1.05070575346 + 242.728603974*$t);
   $R1 += 0.00000000275*cos(3.45319481756 + 5884.9268465832*$t);
   $R1 += 0.00000000255*cos(5.38496831087 + 21228.3920235458*$t);
   $R1 += 0.00000000307*cos(4.24313526604 + 3738.761430108*$t);
   $R1 += 0.00000000216*cos(3.46037894728 + 213.299095438*$t);
   $R1 += 0.00000000196*cos(0.69029243914 + 1990.745017041*$t);
   $R1 += 0.00000000198*cos(5.16301829964 + 12352.8526045448*$t);
   $R1 += 0.00000000214*cos(3.91876200279 + 13916.0191096416*$t);
   $R1 += 0.00000000212*cos(4.00861198517 + 5230.807466803*$t);
   $R1 += 0.00000000184*cos(5.59805976614 + 6283.14316029419*$t);
   $R1 += 0.00000000184*cos(2.85275392124 + 7238.67559160*$t);
   $R1 += 0.00000000179*cos(2.54259058334 + 14314.1681130498*$t);
   $R1 += 0.00000000225*cos(1.64458698399 + 4732.0306273434*$t);
   $R1 += 0.00000000236*cos(5.58826125715 + 6069.7767545534*$t);
   $R1 += 0.00000000187*cos(2.72805985443 + 6062.6632075526*$t);
   $R1 += 0.00000000184*cos(6.04216273598 + 6283.0085396886*$t);
   $R1 += 0.00000000230*cos(3.62591335086 + 6284.0561710596*$t);
   $R1 += 0.00000000163*cos(2.19117396803 + 18073.7049386502*$t);
   $R1 += 0.00000000172*cos(0.97612950740 + 3930.2096962196*$t);
   $R1 += 0.00000000215*cos(1.04672844028 + 3496.032826134*$t);
   $R1 += 0.00000000169*cos(4.75084479006 + 17267.26820169119*$t);
   $R1 += 0.00000000152*cos(0.19390712179 + 9779.1086761254*$t);
   $R1 += 0.00000000182*cos(5.16288118255 + 17253.04110768959*$t);
   $R1 += 0.00000000149*cos(0.80944184260 + 709.9330485583*$t);
   $R1 += 0.00000000163*cos(2.19209570390 + 6076.8903015542*$t);
   $R1 += 0.00000000186*cos(5.01159497089 + 11015.1064773348*$t);
   $R1 += 0.00000000134*cos(0.97765485759 + 65147.6197681377*$t);
   $R1 += 0.00000000141*cos(4.38421981312 + 4136.9104335162*$t);
   $R1 += 0.00000000158*cos(4.60974280627 + 9623.6882766912*$t);
   $R1 += 0.00000000133*cos(3.30508592837 + 154717.60988768269*$t);
   $R1 += 0.00000000163*cos(6.11782626245 + 3.523118349*$t);
   $R1 += 0.00000000174*cos(1.58078542187 + 7.1135470008*$t);
   $R1 += 0.00000000141*cos(0.49976927274 + 25158.6017197654*$t);
   $R1 += 0.00000000124*cos(6.03440460031 + 9225.539273283*$t);
   $R1 += 0.00000000150*cos(5.30166336812 + 13517.8701062334*$t);
   $R1 += 0.00000000127*cos(1.92389511438 + 22483.84857449259*$t);
   $R1 += 0.00000000121*cos(2.37813129011 + 167283.76158766549*$t);
   $R1 += 0.00000000120*cos(3.98423684853 + 4686.8894077068*$t);
   $R1 += 0.00000000117*cos(5.81072642211 + 12569.6748183318*$t);
   $R1 += 0.00000000122*cos(5.60973054224 + 5642.1982426092*$t);
   $R1 += 0.00000000157*cos(3.40236426002 + 16496.3613962024*$t);
   $R1 += 0.00000000129*cos(2.10705116371 + 1589.0728952838*$t);
   $R1 += 0.00000000116*cos(0.55839966736 + 5849.3641121146*$t);
   $R1 += 0.00000000123*cos(1.52961392771 + 12559.038152982*$t);
   $R1 += 0.00000000111*cos(0.44848279675 + 6172.869528772*$t);
   $R1 += 0.00000000123*cos(5.81645568991 + 6282.0955289232*$t);
   $R1 += 0.00000000150*cos(4.26278409223 + 3128.3887650958*$t);
   $R1 += 0.00000000106*cos(2.27437761356 + 5429.8794682394*$t);
   $R1 += 0.00000000104*cos(4.42743707728 + 23543.23050468179*$t);
   $R1 += 0.00000000121*cos(0.39459045915 + 12132.439962106*$t);
   $R1 += 0.00000000104*cos(2.41842602527 + 426.598190876*$t);
   $R1 += 0.00000000110*cos(5.80381480447 + 16858.4825329332*$t);
   $R1 += 0.00000000100*cos(2.93805577485 + 4535.0594369244*$t);
   $R1 += 0.00000000097*cos(3.97935904984 + 6133.5126528568*$t);
   $R1 += 0.00000000110*cos(6.22339014386 + 12146.6670561076*$t);
   $R1 += 0.00000000098*cos(0.87576563709 + 6525.8044539654*$t);
   $R1 += 0.00000000098*cos(3.15248421301 + 10440.2742926036*$t);
   $R1 += 0.00000000095*cos(2.46168411100 + 3097.88382272579*$t);
   $R1 += 0.00000000088*cos(0.23371480284 + 13119.72110282519*$t);
   $R1 += 0.00000000098*cos(5.77016493489 + 7342.4577801806*$t);
   $R1 += 0.00000000092*cos(6.03915555063 + 20426.571092422*$t);
   $R1 += 0.00000000096*cos(5.56909292561 + 2388.8940204492*$t);
   $R1 += 0.00000000081*cos(1.32131147691 + 5650.2921106782*$t);
   $R1 += 0.00000000086*cos(3.94529200528 + 10454.5013866052*$t);
   $R1 += 0.00000000076*cos(2.70729716925 + 143571.32428481648*$t);
   $R1 += 0.00000000091*cos(5.64100034152 + 8827.3902698748*$t);
   $R1 += 0.00000000076*cos(1.80783856698 + 28286.9904848612*$t);
   $R1 += 0.00000000081*cos(1.90858992196 + 29088.811415985*$t);
   $R1 += 0.00000000075*cos(3.40955892978 + 5481.2549188676*$t);
   $R1 += 0.00000000069*cos(4.49936170873 + 17256.6315363414*$t);
   $R1 += 0.00000000088*cos(1.10098454357 + 11769.8536931664*$t);
   $R1 += 0.00000000066*cos(2.78285801977 + 536.8045120954*$t);
   $R1 += 0.00000000068*cos(3.88179770758 + 17260.1546546904*$t);
   $R1 += 0.00000000084*cos(1.59303306354 + 9380.9596727172*$t);
   $R1 += 0.00000000088*cos(3.88076636762 + 7477.522860216*$t);
   $R1 += 0.00000000061*cos(6.17558202197 + 11087.2851259184*$t);
   $R1 += 0.00000000060*cos(4.34824715818 + 6206.8097787158*$t);
   $R1 += 0.00000000082*cos(4.59843208943 + 9388.0059094152*$t);
   $R1 += 0.00000000079*cos(1.63131230601 + 4933.2084403326*$t);
   $R1 += 0.00000000078*cos(4.20905757484 + 5729.506447149*$t);
   $R1 += 0.00000000057*cos(5.48157926651 + 18319.5365848796*$t);
   $R1 += 0.00000000060*cos(1.01261781084 + 12721.572099417*$t);
   $R1 += 0.00000000056*cos(1.63031935692 + 15720.8387848784*$t);
   $R1 += 0.00000000055*cos(0.24926735018 + 15110.4661198662*$t);
   $R1 += 0.00000000061*cos(5.93059279661 + 12539.853380183*$t);
   $R1 += 0.00000000055*cos(4.84298966314 + 13095.8426650774*$t);
   $R1 += 0.00000000067*cos(6.11690589247 + 8662.240323563*$t);
   $R1 += 0.00000000054*cos(5.73750638571 + 3634.6210245184*$t);
   $R1 += 0.00000000074*cos(1.05466745829 + 16460.33352952499*$t);
   $R1 += 0.00000000053*cos(2.29084335688 + 16062.1845261168*$t);
   $R1 += 0.00000000064*cos(2.13513767927 + 7875.6718636242*$t);
   $R1 += 0.00000000067*cos(0.07096807518 + 14945.3161735544*$t);
   $R1 += 0.00000000051*cos(2.31511194429 + 6262.7205305926*$t);
   $R1 += 0.00000000057*cos(5.77055471237 + 12043.574281889*$t);
   $R1 += 0.00000000056*cos(4.41980790431 + 4701.1165017084*$t);
   $R1 += 0.00000000059*cos(5.87963500073 + 5331.3574437408*$t);
   $R1 += 0.00000000058*cos(2.30546168628 + 955.5997416086*$t);
   $R1 += 0.00000000049*cos(1.93839278478 + 5333.9002410216*$t);
   $R1 += 0.00000000048*cos(2.69973662261 + 6709.6740408674*$t);
   $R1 += 0.00000000064*cos(1.64379897981 + 6262.300454499*$t);
   $R1 += 0.00000000046*cos(3.98449608961 + 98068.53671630539*$t);
   $R1 += 0.00000000050*cos(3.68875893005 + 12323.4230960088*$t);
   $R1 += 0.00000000045*cos(3.30068569697 + 22003.9146348698*$t);
   $R1 += 0.00000000047*cos(1.26317154881 + 11919.140866668*$t);
   $R1 += 0.00000000045*cos(0.89150445122 + 51868.2486621788*$t);
   $R1 += 0.00000000043*cos(1.61526242998 + 6277.552925684*$t);
   $R1 += 0.00000000043*cos(5.74295325645 + 11403.676995575*$t);
   $R1 += 0.00000000044*cos(3.43070646822 + 10021.8372800994*$t);
   $R1 += 0.00000000056*cos(0.02481833774 + 15671.0817594066*$t);
   $R1 += 0.00000000055*cos(3.14274403422 + 33019.0211122046*$t);
   $R1 += 0.00000000045*cos(3.00877289177 + 8982.810669309*$t);
   $R1 += 0.00000000046*cos(0.73303568429 + 6303.4311693902*$t);
   $R1 += 0.00000000049*cos(1.60455690285 + 6303.8512454838*$t);
   $R1 += 0.00000000045*cos(0.40210030323 + 6805.6532680852*$t);
   $R1 += 0.00000000053*cos(0.94869680175 + 10988.808157535*$t);
   $R1 += 0.00000000041*cos(1.61122384329 + 6819.8803620868*$t);
   $R1 += 0.00000000055*cos(0.89439119424 + 11933.3679606696*$t);
   $R1 += 0.00000000045*cos(3.88495384656 + 60530.4889857418*$t);
   $R1 += 0.00000000040*cos(4.75740908001 + 38526.574350872*$t);
   $R1 += 0.00000000040*cos(1.49921251887 + 18451.07854656599*$t);
   $R1 += 0.00000000040*cos(3.77498297228 + 26087.9031415742*$t);
   $R1 += 0.00000000051*cos(1.70258603562 + 1551.045222648*$t);
   $R1 += 0.00000000039*cos(2.97100699926 + 2118.7638603784*$t);
   $R1 += 0.00000000053*cos(5.19854123078 + 77713.7714681205*$t);
   $R1 += 0.00000000047*cos(4.26356628717 + 21424.4666443034*$t);
   $R1 += 0.00000000037*cos(0.62902722802 + 24356.7807886416*$t);
   $R1 += 0.00000000036*cos(0.11087914947 + 10344.2950653858*$t);
   $R1 += 0.00000000036*cos(0.77037556319 + 12029.3471878874*$t);
   $R1 += 0.00000000035*cos(3.30933994515 + 24072.9214697764*$t);
   $R1 += 0.00000000035*cos(5.93650887012 + 31570.7996493912*$t);
   $R1 += 0.00000000036*cos(2.15108874765 + 30774.5016425748*$t);
   $R1 += 0.00000000036*cos(1.75078825382 + 16207.886271502*$t);
   $R1 += 0.00000000033*cos(5.06264177921 + 226858.23855437008*$t);
   $R1 += 0.00000000034*cos(6.16891378800 + 24491.4257925834*$t);
   $R1 += 0.00000000035*cos(3.19120695549 + 32217.2001810808*$t);
   $R1 += 0.00000000034*cos(2.31528650443 + 55798.4583583984*$t);
   $R1 += 0.00000000032*cos(4.21446357042 + 15664.03552270859*$t);
   $R1 += 0.00000000039*cos(1.24979117796 + 6418.1409300268*$t);
   $R1 += 0.00000000037*cos(4.11943655770 + 2787.0430238574*$t);
   $R1 += 0.00000000032*cos(1.62887710890 + 639.897286314*$t);
   $R1 += 0.00000000038*cos(5.89832942685 + 640.8776073822*$t);
   $R1 += 0.00000000032*cos(1.72442327688 + 27433.88921587499*$t);
   $R1 += 0.00000000031*cos(2.78828943753 + 12139.5535091068*$t);
   $R1 += 0.00000000035*cos(4.44608896525 + 18202.21671665939*$t);
   $R1 += 0.00000000034*cos(3.96287980676 + 18216.443810661*$t);
   $R1 += 0.00000000033*cos(4.73611335874 + 16723.350142595*$t);
   $R1 += 0.00000000034*cos(1.43910280005 + 49515.382508407*$t);
   $R1 += 0.00000000031*cos(0.23302920161 + 23581.2581773176*$t);
   $R1 += 0.00000000029*cos(2.02633840220 + 11609.8625440122*$t);
   $R1 += 0.00000000030*cos(2.54923230240 + 9924.8104215106*$t);
   $R1 += 0.00000000032*cos(4.91793198558 + 11300.5842213564*$t);
   $R1 += 0.00000000028*cos(0.26187189577 + 13521.7514415914*$t);
   $R1 += 0.00000000028*cos(3.84568936822 + 2699.7348193176*$t);
   $R1 += 0.00000000029*cos(1.83149729794 + 29822.7832363242*$t);
   $R1 += 0.00000000033*cos(4.60320094415 + 19004.6479494084*$t);
   $R1 += 0.00000000027*cos(4.46183450287 + 6702.5604938666*$t);
   $R1 += 0.00000000030*cos(4.46494072240 + 36147.4098773004*$t);
   $R1 += 0.00000000027*cos(0.03211931363 + 6279.7894925736*$t);
   $R1 += 0.00000000026*cos(5.46497324333 + 6245.0481773556*$t);
   $R1 += 0.00000000035*cos(4.52695674113 + 36949.2308084242*$t);
   $R1 += 0.00000000027*cos(3.52528177609 + 10770.8932562618*$t);
   $R1 += 0.00000000026*cos(1.48499438453 + 11080.1715789176*$t);
   $R1 += 0.00000000035*cos(2.82154380962 + 19402.7969528166*$t);
   $R1 += 0.00000000025*cos(2.46339998836 + 6279.4854213396*$t);
   $R1 += 0.00000000026*cos(4.97688894643 + 16737.5772365966*$t);
   $R1 += 0.00000000026*cos(2.36136541526 + 17996.0311682222*$t);
   $R1 += 0.00000000029*cos(4.15148654061 + 45892.73043315699*$t);
   $R1 += 0.00000000026*cos(4.50714272714 + 17796.9591667858*$t);
   $R1 += 0.00000000027*cos(4.72625223674 + 1066.49547719*$t);
   $R1 += 0.00000000025*cos(2.89309528854 + 6286.6662786432*$t);
   $R1 += 0.00000000027*cos(0.37462444357 + 12964.300703391*$t);
   $R1 += 0.00000000029*cos(4.94860010533 + 5863.5912061162*$t);
   $R1 += 0.00000000031*cos(3.93096113577 + 29864.334027309*$t);
   $R1 += 0.00000000024*cos(6.14987193584 + 18606.4989460002*$t);
   $R1 += 0.00000000024*cos(3.74225964547 + 29026.48522950779*$t);
   $R1 += 0.00000000025*cos(5.70460621565 + 27707.5424942948*$t);
   $R1 += 0.00000000025*cos(5.33928840652 + 15141.390794312*$t);
   $R1 += 0.00000000027*cos(3.02320897140 + 6286.3622074092*$t);
   $R1 += 0.00000000023*cos(0.28364955406 + 5327.4761083828*$t);
   $R1 += 0.00000000026*cos(1.34240461687 + 18875.525869774*$t);
   $R1 += 0.00000000024*cos(1.33998410121 + 19800.9459562248*$t);
   $R1 += 0.00000000025*cos(6.00172494004 + 6489.2613984286*$t);
   $R1 += 0.00000000022*cos(1.81777974484 + 6288.5987742988*$t);
   $R1 += 0.00000000022*cos(3.58603606640 + 6915.8595893046*$t);
   $R1 += 0.00000000029*cos(2.09564449439 + 15265.8865193004*$t);
   $R1 += 0.00000000022*cos(1.02173599251 + 11925.2740926006*$t);
   $R1 += 0.00000000022*cos(4.74660932338 + 28230.18722269139*$t);
   $R1 += 0.00000000021*cos(2.30688751432 + 5999.2165311262*$t);
   $R1 += 0.00000000021*cos(3.22654944430 + 25934.1243310894*$t);
   $R1 += 0.00000000021*cos(3.04956726238 + 6566.9351688566*$t);
   $R1 += 0.00000000027*cos(5.35653084499 + 33794.5437235286*$t);
   $R1 += 0.00000000028*cos(3.91168324815 + 18208.349942592*$t);
   $R1 += 0.00000000020*cos(1.52296293311 + 135.0650800354*$t);
   $R1 += 0.00000000022*cos(4.66462839521 + 13362.4497067992*$t);
   $R1 += 0.00000000019*cos(1.78121167862 + 156137.47598479928*$t);
   $R1 += 0.00000000019*cos(2.99969102221 + 19651.048481098*$t);
   $R1 += 0.00000000019*cos(2.86664273362 + 18422.62935909819*$t);
   $R1 += 0.00000000025*cos(0.94995632141 + 31415.379249957*$t);
   $R1 += 0.00000000019*cos(4.71432851499 + 77690.75950573849*$t);
   $R1 += 0.00000000019*cos(2.54227398241 + 77736.78343050249*$t);
   $R1 += 0.00000000020*cos(5.91915117116 + 48739.859897083*$t);
   return $R1*$t;
}



   function Earth_R2($t) // 139 terms of order 2
{
   $R2  = 0.00004359385*cos(5.78455133738 + 6283.0758499914*$t);
   $R2 += 0.00000123633*cos(5.57934722157 + 12566.1516999828*$t);
   $R2 -= 0.00000012341;
   $R2 += 0.00000008792*cos(3.62777733395 + 77713.7714681205*$t);
   $R2 += 0.00000005689*cos(1.86958905084 + 5573.1428014331*$t);
   $R2 += 0.00000003301*cos(5.47027913302 + 18849.2275499742*$t);
   $R2 += 0.00000001471*cos(4.48028885617 + 5507.5532386674*$t);
   $R2 += 0.00000001013*cos(2.81456417694 + 5223.6939198022*$t);
   $R2 += 0.00000000854*cos(3.10878241236 + 1577.3435424478*$t);
   $R2 += 0.00000001102*cos(2.84173992403 + 161000.6857376741*$t);
   $R2 += 0.00000000648*cos(5.47349498544 + 775.522611324*$t);
   $R2 += 0.00000000609*cos(1.37969434104 + 6438.4962494256*$t);
   $R2 += 0.00000000499*cos(4.41649242250 + 6286.5989683404*$t);
   $R2 += 0.00000000417*cos(0.90242451175 + 10977.078804699*$t);
   $R2 += 0.00000000402*cos(3.20376585290 + 5088.6288397668*$t);
   $R2 += 0.00000000351*cos(1.81079227770 + 5486.777843175*$t);
   $R2 += 0.00000000467*cos(3.65753702738 + 7084.8967811152*$t);
   $R2 += 0.00000000458*cos(5.38585314743 + 149854.40013480789*$t);
   $R2 += 0.00000000304*cos(3.51701098693 + 796.2980068164*$t);
   $R2 += 0.00000000266*cos(6.17413982699 + 6836.6452528338*$t);
   $R2 += 0.00000000279*cos(1.84120501086 + 4694.0029547076*$t);
   $R2 += 0.00000000260*cos(1.41629543251 + 2146.1654164752*$t);
   $R2 += 0.00000000266*cos(3.13832905677 + 71430.69561812909*$t);
   $R2 += 0.00000000321*cos(5.35313367048 + 3154.6870848956*$t);
   $R2 += 0.00000000238*cos(2.17720020018 + 155.4203994342*$t);
   $R2 += 0.00000000293*cos(4.61501268144 + 4690.4798363586*$t);
   $R2 += 0.00000000229*cos(4.75969588070 + 7234.794256242*$t);
   $R2 += 0.00000000211*cos(0.21868065485 + 4705.7323075436*$t);
   $R2 += 0.00000000201*cos(4.21905743357 + 1349.8674096588*$t);
   $R2 += 0.00000000195*cos(4.57808285364 + 529.6909650946*$t);
   $R2 += 0.00000000253*cos(2.81496293039 + 1748.016413067*$t);
   $R2 += 0.00000000182*cos(5.70454011389 + 6040.3472460174*$t);
   $R2 += 0.00000000179*cos(6.02897097053 + 4292.3308329504*$t);
   $R2 += 0.00000000186*cos(1.58690991244 + 6309.3741697912*$t);
   $R2 += 0.00000000170*cos(2.90220009715 + 9437.762934887*$t);
   $R2 += 0.00000000166*cos(1.99984925026 + 8031.0922630584*$t);
   $R2 += 0.00000000158*cos(0.04783713552 + 2544.3144198834*$t);
   $R2 += 0.00000000197*cos(2.01083639502 + 1194.4470102246*$t);
   $R2 += 0.00000000165*cos(5.78372596778 + 83996.84731811189*$t);
   $R2 += 0.00000000214*cos(3.38285934319 + 7632.9432596502*$t);
   $R2 += 0.00000000140*cos(0.36401486094 + 10447.3878396044*$t);
   $R2 += 0.00000000151*cos(0.95153163031 + 6127.6554505572*$t);
   $R2 += 0.00000000136*cos(1.48426306582 + 2352.8661537718*$t);
   $R2 += 0.00000000127*cos(5.48475435134 + 951.7184062506*$t);
   $R2 += 0.00000000126*cos(5.26866506592 + 6279.5527316424*$t);
   $R2 += 0.00000000125*cos(3.75754889288 + 6812.766815086*$t);
   $R2 += 0.00000000101*cos(4.95015746147 + 398.1490034082*$t);
   $R2 += 0.00000000102*cos(0.68468295277 + 1592.5960136328*$t);
   $R2 += 0.00000000100*cos(1.14568935785 + 3894.1818295422*$t);
   $R2 += 0.00000000129*cos(0.76540016965 + 553.5694028424*$t);
   $R2 += 0.00000000109*cos(5.41063597567 + 6256.7775301916*$t);
   $R2 += 0.00000000075*cos(5.84804322893 + 242.728603974*$t);
   $R2 += 0.00000000095*cos(1.94452244083 + 11856.2186514245*$t);
   $R2 += 0.00000000077*cos(0.69373708195 + 8429.2412664666*$t);
   $R2 += 0.00000000100*cos(5.19725292131 + 244287.60000722769*$t);
   $R2 += 0.00000000080*cos(6.18440483705 + 1059.3819301892*$t);
   $R2 += 0.00000000069*cos(5.25699888595 + 14143.4952424306*$t);
   $R2 += 0.00000000085*cos(5.39484725499 + 25132.3033999656*$t);
   $R2 += 0.00000000066*cos(0.51779993906 + 801.8209311238*$t);
   $R2 += 0.00000000055*cos(5.16878202461 + 7058.5984613154*$t);
   $R2 += 0.00000000051*cos(3.88759155247 + 12036.4607348882*$t);
   $R2 += 0.00000000050*cos(5.57636570536 + 6290.1893969922*$t);
   $R2 += 0.00000000061*cos(2.24359003264 + 8635.9420037632*$t);
   $R2 += 0.00000000050*cos(5.54441900966 + 1990.745017041*$t);
   $R2 += 0.00000000056*cos(4.00301078040 + 13367.9726311066*$t);
   $R2 += 0.00000000052*cos(4.13138898038 + 7860.4193924392*$t);
   $R2 += 0.00000000052*cos(3.90943054011 + 26.2983197998*$t);
   $R2 += 0.00000000041*cos(3.57128482780 + 7079.3738568078*$t);
   $R2 += 0.00000000056*cos(2.76959005761 + 90955.5516944961*$t);
   $R2 += 0.00000000042*cos(1.91461189199 + 7477.522860216*$t);
   $R2 += 0.00000000042*cos(0.42728171713 + 10213.285546211*$t);
   $R2 += 0.00000000042*cos(1.09413724455 + 709.9330485583*$t);
   $R2 += 0.00000000039*cos(3.93298068961 + 10973.55568635*$t);
   $R2 += 0.00000000038*cos(6.17935925345 + 9917.6968745098*$t);
   $R2 += 0.00000000049*cos(0.83021145241 + 11506.7697697936*$t);
   $R2 += 0.00000000053*cos(1.45828359397 + 233141.31440436149*$t);
   $R2 += 0.00000000047*cos(6.21568666789 + 6681.2248533996*$t);
   $R2 += 0.00000000037*cos(0.36359309980 + 10177.2576795336*$t);
   $R2 += 0.00000000035*cos(3.33024911524 + 5643.1785636774*$t);
   $R2 += 0.00000000034*cos(5.63446915337 + 6525.8044539654*$t);
   $R2 += 0.00000000035*cos(5.36033855038 + 25158.6017197654*$t);
   $R2 += 0.00000000034*cos(5.36319798321 + 4933.2084403326*$t);
   $R2 += 0.00000000033*cos(4.24722336872 + 12569.6748183318*$t);
   $R2 += 0.00000000043*cos(5.26370903404 + 10575.4066829418*$t);
   $R2 += 0.00000000042*cos(5.08837645072 + 11015.1064773348*$t);
   $R2 += 0.00000000040*cos(1.98334703186 + 6284.0561710596*$t);
   $R2 += 0.00000000042*cos(4.22496037505 + 88860.05707098669*$t);
   $R2 += 0.00000000029*cos(3.19088628170 + 11926.2544136688*$t);
   $R2 += 0.00000000029*cos(0.15217616684 + 12168.0026965746*$t);
   $R2 += 0.00000000030*cos(1.61904744136 + 9779.1086761254*$t);
   $R2 += 0.00000000027*cos(0.76388991416 + 1589.0728952838*$t);
   $R2 += 0.00000000036*cos(2.74712003443 + 3738.761430108*$t);
   $R2 += 0.00000000033*cos(3.08807829566 + 3930.2096962196*$t);
   $R2 += 0.00000000031*cos(5.34906619513 + 143571.32428481648*$t);
   $R2 += 0.00000000025*cos(0.10240267494 + 22483.84857449259*$t);
   $R2 += 0.00000000030*cos(3.47110495524 + 14945.3161735544*$t);
   $R2 += 0.00000000024*cos(1.10425016019 + 4535.0594369244*$t);
   $R2 += 0.00000000024*cos(1.58037259780 + 6496.3749454294*$t);
   $R2 += 0.00000000023*cos(3.87710321433 + 6275.9623029906*$t);
   $R2 += 0.00000000025*cos(3.94529778970 + 3128.3887650958*$t);
   $R2 += 0.00000000023*cos(3.44685609601 + 4136.9104335162*$t);
   $R2 += 0.00000000023*cos(3.83156029849 + 5753.3848848968*$t);
   $R2 += 0.00000000022*cos(1.86956128067 + 16730.4636895958*$t);
   $R2 += 0.00000000025*cos(2.42188933855 + 5729.506447149*$t);
   $R2 += 0.00000000020*cos(1.78208352927 + 17789.845619785*$t);
   $R2 += 0.00000000021*cos(4.30363087400 + 16858.4825329332*$t);
   $R2 += 0.00000000021*cos(0.49258939822 + 29088.811415985*$t);
   $R2 += 0.00000000025*cos(1.33030250444 + 6282.0955289232*$t);
   $R2 += 0.00000000027*cos(2.54785812264 + 3496.032826134*$t);
   $R2 += 0.00000000022*cos(1.11232521950 + 12721.572099417*$t);
   $R2 += 0.00000000021*cos(5.97759081637 + 7.1135470008*$t);
   $R2 += 0.00000000019*cos(0.80292033311 + 16062.1845261168*$t);
   $R2 += 0.00000000023*cos(4.12454848769 + 2388.8940204492*$t);
   $R2 += 0.00000000022*cos(4.92663152168 + 18875.525869774*$t);
   $R2 += 0.00000000023*cos(5.68902059771 + 16460.33352952499*$t);
   $R2 += 0.00000000023*cos(4.97346265647 + 17260.1546546904*$t);
   $R2 += 0.00000000023*cos(3.03021283729 + 66567.48586525429*$t);
   $R2 += 0.00000000016*cos(3.89740925257 + 5331.3574437408*$t);
   $R2 += 0.00000000017*cos(3.08268671348 + 154717.60988768269*$t);
   $R2 += 0.00000000016*cos(3.95085099736 + 3097.88382272579*$t);
   $R2 += 0.00000000016*cos(3.99041783945 + 6283.14316029419*$t);
   $R2 += 0.00000000020*cos(6.10644140189 + 167283.76158766549*$t);
   $R2 += 0.00000000015*cos(4.09775914607 + 11712.9553182308*$t);
   $R2 += 0.00000000016*cos(5.71769940700 + 17298.1823273262*$t);
   $R2 += 0.00000000016*cos(3.28894009404 + 5884.9268465832*$t);
   $R2 += 0.00000000015*cos(5.64785377164 + 12559.038152982*$t);
   $R2 += 0.00000000016*cos(4.43452080930 + 6283.0085396886*$t);
   $R2 += 0.00000000014*cos(2.31721603062 + 5481.2549188676*$t);
   $R2 += 0.00000000014*cos(4.43479032305 + 13517.8701062334*$t);
   $R2 += 0.00000000014*cos(4.73209312936 + 7342.4577801806*$t);
   $R2 += 0.00000000012*cos(0.64705975463 + 18073.7049386502*$t);
   $R2 += 0.00000000011*cos(1.51443332200 + 16200.7727245012*$t);
   $R2 += 0.00000000011*cos(0.88708889185 + 21228.3920235458*$t);
   $R2 += 0.00000000014*cos(4.50116508534 + 640.8776073822*$t);
   $R2 += 0.00000000011*cos(4.64339996198 + 11790.6290886588*$t);
   $R2 += 0.00000000011*cos(1.31064298246 + 4164.311989613*$t);
   $R2 += 0.00000000009*cos(3.02238989305 + 23543.23050468179*$t);
   $R2 += 0.00000000009*cos(2.04999402381 + 22003.9146348698*$t);
   $R2 += 0.00000000009*cos(4.91488110218 + 213.299095438*$t);
   return $R2*$t*$t;
}



   function Earth_R3($t) // 27 terms of order 3
{
   $R3  = 0.00000144595*cos(4.27319435148 + 6283.0758499914*$t);
   $R3 += 0.00000006729*cos(3.91697608662 + 12566.1516999828*$t);
   $R3 += 0.00000000774;
   $R3 += 0.00000000247*cos(3.73019298781 + 18849.2275499742*$t);
   $R3 += 0.00000000036*cos(2.80081409050 + 6286.5989683404*$t);
   $R3 += 0.00000000033*cos(5.62216602775 + 6127.6554505572*$t);
   $R3 += 0.00000000019*cos(3.71292621802 + 6438.4962494256*$t);
   $R3 += 0.00000000016*cos(4.26011484232 + 6525.8044539654*$t);
   $R3 += 0.00000000016*cos(3.50416887054 + 6256.7775301916*$t);
   $R3 += 0.00000000014*cos(3.62127621114 + 25132.3033999656*$t);
   $R3 += 0.00000000011*cos(4.39200958819 + 4705.7323075436*$t);
   $R3 += 0.00000000011*cos(5.22327127059 + 6040.3472460174*$t);
   $R3 += 0.00000000010*cos(4.28045254647 + 83996.84731811189*$t);
   $R3 += 0.00000000009*cos(1.56864096494 + 5507.5532386674*$t);
   $R3 += 0.00000000011*cos(1.37795688024 + 6309.3741697912*$t);
   $R3 += 0.00000000010*cos(5.19937959068 + 71430.69561812909*$t);
   $R3 += 0.00000000009*cos(0.47275199930 + 6279.5527316424*$t);
   $R3 += 0.00000000009*cos(0.74642756529 + 5729.506447149*$t);
   $R3 += 0.00000000007*cos(2.97374891560 + 775.522611324*$t);
   $R3 += 0.00000000007*cos(3.28615691021 + 7058.5984613154*$t);
   $R3 += 0.00000000007*cos(2.19184402142 + 6812.766815086*$t);
   $R3 += 0.00000000005*cos(3.15419034438 + 529.6909650946*$t);
   $R3 += 0.00000000006*cos(4.54725567047 + 1059.3819301892*$t);
   $R3 += 0.00000000005*cos(1.51104406936 + 7079.3738568078*$t);
   $R3 += 0.00000000007*cos(2.98052059053 + 6681.2248533996*$t);
   $R3 += 0.00000000005*cos(2.30961231391 + 12036.4607348882*$t);
   $R3 += 0.00000000005*cos(3.71102966917 + 6290.1893969922*$t);
   return $R3*$t*$t*$t;
}



   function Earth_R4($t) // 10 terms of order 4
{
   $R4  = 0.00000003858*cos(2.56384387339 + 6283.0758499914*$t);
   $R4 += 0.00000000306*cos(2.26769501230 + 12566.1516999828*$t);
   $R4 += 0.00000000053*cos(3.44031471924 + 5573.1428014331*$t);
   $R4 += 0.00000000015*cos(2.04794573436 + 18849.2275499742*$t);
   $R4 += 0.00000000013*cos(2.05688873673 + 77713.7714681205*$t);
   $R4 += 0.00000000007*cos(4.41218854480 + 161000.6857376741*$t);
   $R4 += 0.00000000005*cos(5.26154653107 + 6438.4962494256*$t);
   $R4 += 0.00000000005*cos(4.07695126049 + 6127.6554505572*$t);
   $R4 += 0.00000000006*cos(3.81514213664 + 149854.40013480789*$t);
   $R4 += 0.00000000003*cos(1.28175749811 + 6286.5989683404*$t);
   return $R4*$t*$t*$t*$t;
}



   function Earth_R5($t) // 3 terms of order 5
{
   $R5  = 0.00000000086*cos(1.21579741687 + 6283.0758499914*$t);
   $R5 += 0.00000000012*cos(0.65617264033 + 12566.1516999828*$t);
   $R5 += 0.00000000001*cos(0.38068797142 + 18849.2275499742*$t);
   return $R5*$t*$t*$t*$t*$t;
}
}