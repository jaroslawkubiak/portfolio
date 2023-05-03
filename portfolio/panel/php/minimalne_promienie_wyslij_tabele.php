<?php
 echo '<table width="1300px" align="left"><tr><td>';
	
$warunek = "";
$SORTOWANIE_DIV = '';

if($SORT_SYSTEM != "") 
	{
	if($warunek == "") $warunek .= 'WHERE system = "'.$SORT_SYSTEM.'"';
	else $warunek .= ' AND system = "'.$SORT_SYSTEM.'"';
	$SORTOWANIE_DIV .= '&SORT_SYSTEM='.$SORT_SYSTEM;
	} 
	         
if($SORT_SYMBOL_PROFILU != "") 
	{
	if($warunek == "") $warunek .= 'WHERE symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	else $warunek .= ' AND symbol_profilu = "'.$SORT_SYMBOL_PROFILU.'"';
	$SORTOWANIE_DIV .= '&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU;
	}          

 
 
$id = [];
$system = [];
$symbol_profilu = [];
$promien_z_gwa = [];
$promien_bez_gwa = [];
	

$i=0;
$pytanie = mysqli_query($conn, "SELECT * FROM minimalne_promienie ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$id[$i]=$wynik['id'];
	$system[$i]=$wynik['system'];
	$symbol_profilu[$i]=$wynik['symbol_profilu'];
	$promien_z_gwa[$i]=$wynik['promien_z_gwa'];
	$promien_bez_gwa[$i]=$wynik['promien_bez_gwa'];
	}

if($wyslij == 1)
	{
	include('php/minimalne_promienie_tabela_pdf.php');
	}
else
	{
	echo '<FORM action="index.php?page=minimalne_promienie_wyslij_tabele" method="post">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="'.$SORT_SYMBOL_PROFILU.'">';                                
	echo '<input type="hidden" name="SORT_SYSTEM" value="'.$SORT_SYSTEM.'">';                                
	echo '<input type="hidden" name="klient" value="'.$klient.'">';                                
	echo '<input type="hidden" name="klient_wysylka" value="'.$klient_wysylka.'">';                                
								  
	
	$klient_nazwa = [];
	$klient_id = [];
	$ilosc_klientow = 0;
	$pytanie1 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC;");
	while($wynik1= mysqli_fetch_assoc($pytanie1))
		{
		$ilosc_klientow++;
		$klient_id[$ilosc_klientow] = $wynik1['id'];
		$klient_nazwa[$ilosc_klientow]=$wynik1['nazwa'];
		}

	echo '<table width="60%" align="center" border="0" cellpadding="5" cellspacing="5">';
	if($klient == '')
		{
		echo '<tr align="center"><td align="right" width="50%" class="text">Wybierz klienta : </td><td align="left" width="50%">';
		echo '<select name="klient" class="pole_input" style="width: 200px" onchange="submit();">';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_klientow; $k++) 
		if($klient == $klient_id[$k]) echo '<option selected="selected" value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
		else echo '<option value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
		echo '</select></td></tr>';
		}
	else
		{
		$klient_email = [];
		include ("php/lista_emaili_minimalne_promienie.php");


		echo '<tr class="text"><td align="right" width="50%">Klient : </td><td align="left" width="50%">';
			echo '<select name="klient" class="pole_input" style="width: 200px" onchange="submit();">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_klientow; $k++) 
			if($klient == $klient_id[$k]) echo '<option selected="selected" value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
			else echo '<option value="'.$klient_id[$k].'">'.$klient_nazwa[$k].'</option>';
			echo '</select></td></tr>';
			
		echo '<tr class="text"><td align="right" width="50%">Wybierz adres : </td><td align="left" width="50%">';
		
			echo '<select name="klient_wysylka" class="pole_input" style="width: 200px" onchange="submit();">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_email; $k++) 
			if($klient_wysylka == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			elseif($linia_rozdzielajaca == $klient_email[$k]) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
			else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			echo '</select>';
		echo '</td></tr>';
		
		if($klient_wysylka != '') echo '<tr align="center"><td colspan="2"><div align="center" ><a href="index.php?page=minimalne_promienie_wyslij_tabele&wyslij=1&klient='.$klient.'&klient_wysylka='.$klient_wysylka.'&klient_wybrany_nazwa='.$klient_wybrany_nazwa.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><div class="text_duzy_zielony">Wyślij wysortowaną tabelę do <font color="blue">'.$klient_wybrany_nazwa.'</font> na adres <font color="blue">'.$klient_wysylka.'</font></div></a></div></td></tr>';
		
		}
		
		echo '</table>';
	
	echo '</form>';
} // do else

echo $powrot_do_minimalne_promienie;

echo '</td></tr></table>';
?>