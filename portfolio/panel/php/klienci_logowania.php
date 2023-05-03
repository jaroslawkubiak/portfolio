<?php
if($tylko_nieudane == 'tak') $WARUNEK = " WHERE status_logowania = 'false' "; else $WARUNEK = "";
$i=0;
$nieudane_proby = 0;


$data = [];
$login = [];
$haslo = [];
$adres_ip_logowania = [];
$przegladarka = [];
$system_operacyjny = [];
$host = [];
$user_agent = [];
$status_logowania = [];


$pytanie = mysqli_query($conn, "SELECT * FROM logowania_klientow2 ".$WARUNEK." ORDER BY ID DESC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$data[$i]=$wynik['data'];
	$login[$i]=$wynik['login'];
	$haslo[$i]=$wynik['haslo'];
	$adres_ip_logowania[$i]=$wynik['adres_ip'];
	$przegladarka[$i]=$wynik['przegladarka'];
	$system_operacyjny[$i]=$wynik['system_operacyjny'];
	$host[$i]=$wynik['host'];
	$user_agent[$i]=$wynik['user_agent'];
	$status_logowania[$i]=$wynik['status_logowania'];
	if($status_logowania[$i] == 'false') $nieudane_proby++;
	}
  
if($tylko_nieudane == 'tak') echo '<div align="center"><a href="index.php?page=klienci_logowania&tylko_nieudane=nie">Pokaż wszystko</a></div><br>';
else echo '<div align="center"><a href="index.php?page=klienci_logowania&tylko_nieudane=tak">Pokaż tylko nieudane próby</a></div><br>';

echo '<div align="center" class="text2">Ilość nieudanych prób logowania : '.$nieudane_proby.'</div><br>';
echo '<table width="100%" align="center" border="0" class="tabela" cellpadding="1" cellspacing="1"><tr align="center" bgcolor="'.$kolor_szary.'" class="text">';
echo '<td width="3%">'.$kol_lp.'</td>';
echo '<td width="4%">Data</td>';
echo '<td width="4%">Godzina</td>';
echo '<td width="4%">Wpisany login</td>';
echo '<td width="4%">Wpisane hasło</td>';
echo '<td width="7%">Adres IP</td>';
echo '<td width="20%">Host</td>';
echo '<td width="7%">Przeglądarka</td>';
echo '<td width="7%">System operacyjny</td>';
echo '<td width="30%">User Agent</td></tr>';

	for ($x=1; $x<=$i; $x++)
		{
		if($status_logowania[$x] == 'true') $kolor_logowania = $kolor_bialy; else $kolor_logowania = '#e35757';
		echo '<tr class="text" align="center" bgcolor="'.$kolor_logowania.'"><td bgcolor="'.$kolor_szary.'" class="text">'.$x.'</td>';
		$data2 = date('d-m-Y', $data[$x]);
		$godzina = date('H:i:s', $data[$x]);
		echo '<td>'.$data2.'</td>';
		echo '<td>'.$godzina.'</td>';
		echo '<td>'.$login[$x].'</td>';
		echo '<td>'.$haslo[$x].'</td>';
		echo '<td>'.$adres_ip_logowania[$x].'</td>';
		echo '<td align="left">'.$host[$x].'</td>';
		echo '<td>'.$przegladarka[$x].'</td>';
		echo '<td>'.$system_operacyjny[$x].'</td>';
		echo '<td align="left">'.$user_agent[$x].'</td></tr>';
		}
echo '</table>';
?>