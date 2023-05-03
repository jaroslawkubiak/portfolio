<?php

$szerokosc_tabeli_glowej = 1200;
$sciezka = '../panel_dane/wycena_wstepna_rysunki';
//$sciezka = 'wzmocnienia';
echo '<table width="'.$szerokosc_tabeli_glowej.'px" align="left" border="0" cellspacing="5" cellpadding="5">';
echo '<tr><td>';

if($nowy_opis != '')
	{
	$pytanie121 = mysqli_query($conn, "UPDATE rysunki SET opis = '".$nowy_opis."' WHERE id = ".$zmien_opis.";");
	echo '<div align="center" class="text_duzy_niebieski">Opis zmieniony.</div><br>';
	}

if($usunac != '')
	{
	$pytanie = mysqli_query($conn, "SELECT * FROM rysunki where id = ".$usunac.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$usun_link=$wynik['link'];
		}
	$sql = mysqli_query($conn, "DELETE FROM rysunki WHERE id = ".$usunac.";");
	$plik ="../panel_dane/wycena_wstepna_rysunki/".$usun_link;
	unlink($plik);
	echo '<div align="center" class="text_duzy_niebieski">Rysunek usunięty.</div><br>';
	}

if($usun != '')
	{
	$pytanie = mysqli_query($conn, "SELECT * FROM rysunki where id = ".$usun.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$usun_opis=$wynik['opis'];
		$usun_link=$wynik['link'];
		}
	
	echo '<div align="center" class="text_duzy">Czy na pewno usunąć poniższy rysunek?</div><br>';
	echo '<div align="center" class="text_duzy"><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$usun_link.'" width="300px"></div><br>';
	echo '<div align="center"><a href="index.php?page=wycena_wstepna_rysunki&usunac='.$usun.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="red" size="+4">USUŃ RYSUNEK</font></a></div><br><br>';
	}


	//###############################################################   przesyłanie plików na serwer ###############################################################
	$uploaddir = '../panel_dane/wycena_wstepna_rysunki/';
	$rysunek = $_FILES['plik']['name'];
	if(preg_match("/.jpg/", $rysunek))
	{
		// plik to jpg, przesylamy na serwer
		$opis_temp = $rysunek;
		//usuwamy polskie znaki z nazwy pliku
		$rysunek = usun_polskie($rysunek);
		//usuwamy spacje z nazw i zmniejszamy wszystkie znaki do malych liter
		$rysunek = zamien_dowolne_znaki($rysunek, ' ', '_');

		//sprawdzamy czy taki plik już nie istnieje
		$taki_plik_istnieje = 0;
		if ($handle = opendir($sciezka)) 
			{
			while (false !== ($file = readdir($handle))) 
				{
				if ($file != "." && $file != "..") 
					{
					if($file == $rysunek) $taki_plik_istnieje = 1;		
					}
				}
			closedir($handle);
		}	
	
		if($taki_plik_istnieje == 0)
			{
			//szukamy kolejnego numeru do kolejnosci
			$pytanie = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY kolejnosc DESC LIMIT 1;");
			while($wynik= mysqli_fetch_assoc($pytanie))
				{
				$nastepny_numer_kolejnosc=$wynik['kolejnosc'];
				}
			$nastepny_numer_kolejnosc++;

			//plik nie istnieje
			if(move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir.$rysunek))
				{
				//jak brak opisu to dajemy nazwę pliku
				if($opis == '') 
					{
					$opis = $opis_temp;
					if (preg_match("/.jpg/", $opis)) $opis = str_replace(".jpg", "", $opis);
					}
				echo '<div align="center" class="text_duzy_niebieski">Plik został przesłany na serwer</div>';
				$query = mysqli_query($conn, "INSERT INTO rysunki (`kolejnosc`, `opis`, `link`) VALUES ('$nastepny_numer_kolejnosc', '$opis', '$rysunek');");
				}	
			}
		else
			{
			//taki plik istnieje
			echo '<div align="center" class="text_duzy_czerwony">Plik o nazwie <font color="blue">'.$rysunek.'</font> już istnieje, proszę zmienić nazwę pliku.</div><br>';
			}
	}
	elseif($rysunek != '')
	{
	//wybrany plik to nie jpg
	echo '<div align="center" class="text_duzy_czerwony">Wybrany plik <font color="blue">'.$rysunek.'</font> NIE jest plikiem JPG.</div><br>';
	}
	

	echo '<br><br><form action="index.php?page=wycena_wstepna_rysunki" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="jak" value="'.$jak.'">';
		echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	
	echo '<table border="0" align="center" cellspacing="3" cellpadding="3" class="text_duzy"><tr ><td align="center">Wybierz plik do przesłania (tylko pliki JPG)</td></tr>';
		echo '<tr align="center"><td><input type="text" size="60" maxlenght="30" name="opis" autocomplete="off" placeholder="Tutaj wpisz nazwę dla rysunku"></td></tr>';
	
		echo '<tr align="center"><td><input type="file" name="plik" accept="image/jpeg">';
		echo '<INPUT type="submit" value="Prześlij">';
	echo '</td></tr></table>';
	echo '</form>';

//############################################################### koniec przesyłanie plików na serwer ################################################################


$ilosc_rysunkow = 0;
$id = [];
$kolejnosc = [];
$rysunek_opis = [];
$link = [];
$link2 = [];
$pytanie = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_rysunkow++;
	$id[$ilosc_rysunkow]=$wynik['id'];
	$kolejnosc[$ilosc_rysunkow]=$wynik['kolejnosc'];
	$rysunek_opis[$ilosc_rysunkow]=$wynik['opis'];
	$link[$ilosc_rysunkow]=$wynik['link'];

	//zmiana spacji na podkreślniki w bazie danych
	// $test = zamien_dowolne_znaki($link[$ilosc_rysunkow], ' ', '_');
	// $sql = mysqli_query($conn, "update rysunki SET link = '".$test."' WHERE id = ".$id[$ilosc_rysunkow].";");

	}


echo '</td></tr><tr><td>';




	echo '<table width="'.$szerokosc_tabeli_glowej.'px" align="left" border="0" cellspacing="5" cellpadding="5">';
		$ilosc_kolumn = 4;
		$szerokosc_kolumny = 100/$ilosc_kolumn;
		$szerokosc_obrazkow = $szerokosc_tabeli_glowej/$ilosc_kolumn;
		
		// wiersz z sortowaniem
		echo '<tr class="text" bgcolor="'.$kolor_tabeli.'"><td colspan="'.$ilosc_kolumn.'">';
			echo '<table border="0" class="text" cellpadding="3" cellspacing="3">';
			echo '<tr><td>Kolejność</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=ASC&wg_czego=kolejnosc">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=DESC&wg_czego=kolejnosc">'.$image_arrow_up.'</a></td>';
			echo '<td>&nbsp;</td><td>Opis</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=ASC&wg_czego=opis">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=DESC&wg_czego=opis">'.$image_arrow_up.'</a></td>';
			echo '<td>&nbsp;</td><td>Nazwa pliku</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=ASC&wg_czego=link">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=DESC&wg_czego=link">'.$image_arrow_up.'</a></td>';
			echo '<td>&nbsp;</td><td>Data dodania</td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=ASC&wg_czego=id">'.$image_arrow_down.'</a></td>';
			echo '<td><a href="index.php?page=wycena_wstepna_rysunki&jak=DESC&wg_czego=id">'.$image_arrow_up.'</a></td>';
			echo '</tr></table>';
		echo '</td></tr>';
		
		
		$licz = 0;
		for($x=1; $x<=$ilosc_rysunkow; $x++) 
			{
			if($licz == 0) echo '<tr>';	
			if($licz < $ilosc_kolumn)
				{
				if($edytuj_opis == $id[$x]) echo '<FORM action="index.php?page='.$page.'&zmien_opis='.$edytuj_opis.'&jak='.$jak.'&wg_czego='.$wg_czego.'" method="post">';
				$licz++;
				echo '<td class="text_duzy" width="'.$szerokosc_kolumny.'%" valign="top">';
					echo '<table align="center" border="0" width="100%" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'"><td class="text_duzy">';
							echo '<table align="center" border="0" width="100%" class="text"><tr align="center"><td class="text_duzy" width="5%">';
							echo '<a href="index.php?page=wycena_wstepna_rysunki_zmien_kolejnosc&jak='.$jak.'&wg_czego='.$wg_czego.'"><table align="center" border="0" width="50px" height="50px" background="images/kolejnosc2.png" cellpadding="4"><tr align="center"><td class="text_duzy" align="right">'.$kolejnosc[$x];
							echo '</td></tr></table></a>';
					echo '</td><td width="90%" align="center">';
					if($edytuj_opis == $id[$x]) 
						{
						echo '<table align="center" border="0" class="text"><tr align="center"><td align="right">';
						echo '<input type="text" autocomplete="off" size="25" maxlength="100" class="pole_input_edycja" name="nowy_opis" value="'.$rysunek_opis[$x].'">';
						echo '</td><td align="left">';
						echo '<INPUT type="submit" name="submit" value="->">';
						echo '</td></tr></table>';
						}
					else echo '<a href="index.php?page=wycena_wstepna_rysunki&edytuj_opis='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'" title="Opis" alt="Opis">'.$rysunek_opis[$x].'</a>';
					echo '</td><td width="5%">';
					echo '<a href="index.php?page=wycena_wstepna_rysunki&usun='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_trash.'</a>';
					echo '</td></tr>';
					echo '</table>';
				echo '</td></tr><tr align="center" bgcolor="'.$kolor_bialy.'"><td>';
					echo '<center><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/wycena_wstepna_rysunki/'.$link[$x].'" width="'.$szerokosc_obrazkow.'px"></center>';
				echo '</td></tr>';
				echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td class="text_duzy">';
					echo '<div title="Nazwa pliku" alt="Nazwa pliku">'.$link[$x].'</div>';
				echo '</td></tr></table>';
			echo '</td>';
			if($edytuj_opis == $id[$x]) echo '</form>';
			}
		if($licz == $ilosc_kolumn) 
			{
			echo '</tr>';	
			$licz=0;
			}
		}
	echo '</table>';
echo '</td></tr></table>';

?>