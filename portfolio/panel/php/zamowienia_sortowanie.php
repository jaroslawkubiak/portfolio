<?php

if($user_id != 1) 
	{
	$rowspan = 'rowspan="2"'; 
	$dlugosc_tabeli = 2800;
	}
else 
	{
	$rowspan = '';
	$dlugosc_tabeli = 1900;
	}

echo '<FORM action="index.php?page=zamowienia" method="post">';

echo '<INPUT type="hidden" name="page" value="zamowienia">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
echo '<INPUT type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZLECENIA_TRANSPORTOWEGO" value="'.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'">';
echo '<INPUT type="hidden" name="SORT_STREFA" value="'.$SORT_STREFA.'">';
echo '<INPUT type="hidden" name="SORT_STAN" value="'.$SORT_STAN.'">';
echo '<INPUT type="hidden" name="szukaj" value="1">';
echo '<INPUT type="hidden" name="SORT_PROFIL" value="'.$SORT_PROFIL.'">';
echo '<INPUT type="hidden" name="SORT_RODZAJ_SZYB" value="'.$SORT_RODZAJ_SZYB.'">';
echo '<INPUT type="hidden" name="SORT_RODZAJ_OKUC" value="'.$SORT_RODZAJ_OKUC.'">';
echo '<INPUT type="hidden" name="SORT_MAGAZYN" value="'.$SORT_MAGAZYN.'">';
echo '<INPUT type="hidden" name="SORT_KOLOR_PROFILI" value="'.$SORT_KOLOR_PROFILI.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA" value="'.$SORT_NR_ZAMOWIENIA.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA_KLIENTA" value="'.$SORT_NR_ZAMOWIENIA_KLIENTA.'">';
echo '<INPUT type="hidden" name="SORT_ZAMOWIONY_PRODUKT" value="'.$SORT_ZAMOWIONY_PRODUKT.'">';
echo '<INPUT type="hidden" name="SORT_TERMIN_REALIZACJI" value="'.$SORT_TERMIN_REALIZACJI.'">';
echo '<INPUT type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
echo '<INPUT type="hidden" name="SORT_DATA_PRZYJECIA" value="'.$SORT_DATA_PRZYJECIA.'">';
echo '<INPUT type="hidden" name="SORT_DATA_DOSTAWY" value="'.$SORT_DATA_DOSTAWY.'">';
echo '<INPUT type="hidden" name="SORT_STATUS" value="'.$SORT_STATUS.'">';


echo '<table width="'.$dlugosc_tabeli.'px" align="left" cellspacing="0" cellpadding="0" border="0" bgcolor="'.$kolor_tabeli.'"><tr align="center" class="text_duzy"><td align="left">';

    echo '<table width="700px" align="left" cellspacing="2" cellpadding="2" border="0" bgcolor="'.$kolor_tabeli.'"><tr align="center" class="text_duzy">';
	echo '<td>Data początkowa - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_poczatkowa" id="f_data_poczatkowa" value="'.$data_poczatkowa.'"></td>';
	echo '<td>Data końcowa - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_koncowa" id="f_data_koncowa" value="'.$data_koncowa.'"></td>';
	echo '<td><input type="submit" name="pokaz" value="Pokaż"></td>';
    echo '</tr></table>';

echo '</td></tr><tr><td>';
echo '</form>';
?>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_data_poczatkowa",     // id of the input field
        ifFormat       :    "%d-%m-%Y",      // format of the input field
        button         :    "f_data_poczatkowa",  // trigger for the calendar (button ID)
        singleClick    :    true
    });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_data_koncowa",     // id of the input field
        ifFormat       :    "%d-%m-%Y",      // format of the input field
        button         :    "f_data_koncowa",  // trigger for the calendar (button ID)
        singleClick    :    true
    });
</script>
