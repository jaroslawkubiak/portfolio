<?php
//tabela do mniejszych stron
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Dodaj zamówienie</div><br>';

	echo '<table align="center" class="text" width="500px" cellpadding="5" cellspacing="5" border="0">';

		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_produkt&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy produkt</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_grupa_produktow&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nową grupę produktów</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_system&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy system profili</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_kolor_profili&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy kolor profili</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_magazyn&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy magazyn</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_stan&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy stan</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_kolor_uszczelek&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy kolor uszczelek</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_rodzaj_okuc&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy rodzaj okuć</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_rodzaj_szyb&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy rodzaj szyb</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_status&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowy status zamówienia</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_uwagi&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowe uwagi</div></a></td></tr>';
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td align="center"><a href="index.php?page=ustawienia_dz_uwagi_do_listy_materialow&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"><div bgcolor="'.$kolor_tabeli.'" class="text_duzy">Dodaj nowe uwagi - lista materiałów</div></a></td></tr>';

		if($zamowienie_id != '') 
			{
			if($skad == 'zamowienie_dodaj') echo '<tr align="center"><td align="center">'.$powrot_do_wystawiania_zamowienia_dodaj.'</td></tr>';
			if($skad == 'zamowienie_wycena') echo '<tr align="center"><td align="center">'.$powrot_do_wystawiania_zamowienia_wycena.'</td></tr>';
			if($skad == 'zamowienie_edycja') echo '<tr align="center"><td align="center">'.$powrot_do_wystawiania_zamowienia_edycja.'</td></tr>';
			}
			
		
	echo '</table>';

echo '</td></tr></table>';

?>