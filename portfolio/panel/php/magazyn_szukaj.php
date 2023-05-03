<?php
if($szukaj_symbol_profilu)
	{
	//szukam czy istnieje taki symbol profilu
	$pytanie = mysqli_query($conn, "SELECT * FROM magazyn WHERE symbol_profilu='".$szukaj_symbol_profilu."' LIMIT 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$artykul=$wynik['element'];
		$system=$wynik['system'];
		$symbol_profilu=$szukaj_symbol_profilu;
		}
	}

//jak istnieje, to szukamy w bazie artykułów
if(($artykul != '') && ($system != '') &&($szukaj_symbol_profilu != ''))
	{
	$pytanie44 = mysqli_query($conn, "SELECT id FROM magazyn_artykuly WHERE symbol_profilu = '".$szukaj_symbol_profilu."';");
	while($wynik44= mysqli_fetch_assoc($pytanie44))
		{
		$artykul_id=$wynik44['id'];
		}
	}

if($artykul_id != '') include_once "php/artykul_edytuj.php";
if(($artykul != '') && ($system != '') && ($artykul_id == '')) include_once "php/artykul_dodaj.php";

if(($artykul == '') && ($system == '')) 
	{
	echo '<div class="text_error_duzy" align="center">Nie znaleziono symbolu profilu : '.$szukaj_symbol_profilu.'</div>';
	echo $powrot_do_magazynu;
	}
?>