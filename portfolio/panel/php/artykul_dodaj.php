<?php
$skad = 'artykul_dodaj';
if ($usun_id) {
    mysqli_query($conn, "DELETE FROM magazyn WHERE id = " . $usun_id . " LIMIT 1;");
    // echo 'usun_id='.$usun_id.'<br>';
    echo '<div class="text_duzy_niebieski" align="center">Pozycja została usunięta</div>';
}

if ($zapisz) {

    $result = true;

    $zachodzenie = change($zachodzenie);
    $szerokosc = change($szerokosc);
    $dlugosc = change($dlugosc);
    $min_r_gwarancja = change($min_r_gwarancja);
    $min_r_bez_gwarancji = change($min_r_bez_gwarancji);

    $uploaddir = 'artykul/';
    //echo 'plik='.$_FILES['plik']['tmp_name'].'<br>';
    if (move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir . $_FILES['plik']['name'])) {
        $rysunek = $_FILES['plik']['name'];
    }

    $query = mysqli_query($conn, "INSERT INTO magazyn_artykuly (`system`, `artykul`, `symbol_profilu`, `rysunek`, `zachodzenie`, `szerokosc`, `dlugosc`, `min_r_gwarancja`, `min_r_bez_gwarancji`, `uwagi`) values ('$system', '$artykul', '$symbol_profilu', '$rysunek', '$zachodzenie', '$szerokosc', '$dlugosc', '$min_r_gwarancja', '$min_r_bez_gwarancji', '$uwagi');");

    $artykul_id = mysqli_insert_id($conn);

    for ($d = 1; $d <= 6; $d++) {
        if ($dodatek[$d]) {
            $pytanie = mysqli_query($conn, "SELECT element FROM magazyn WHERE symbol_profilu ='" . $dodatek[$d] . "';");
            while ($wynik = mysqli_fetch_assoc($pytanie)) {
                $element_dodatek = $wynik['element'];
            }
            if ($element_dodatek) {
                $query = mysqli_query($conn, "INSERT INTO magazyn_dodatki (`artykul_id`, `symbol_profilu`, `artykul`) values ('$artykul_id', '$dodatek[$d]', '$element_dodatek');");
            }

        }
    }
    echo '<div class="text_duzy_niebieski" align="center">Artykuł został dodany.</div>';
}

if (!$zapisz) {

    $warunek = "";
    $SORTOWANIE_DIV = '';

    echo '<table width="1200px" align="center" border="0" cellpadding="3" align="left"><tr><td width="90%" align="center" valign="top">';
    echo '<div class="text_duzy" align="center">Dodaj nowy artykuł</div>';

    echo '<table width=100% align="center" border="0" cellpadding="5" cellspacing="5">';
    // system
    echo '<tr align="center" class="text"><td align="left" width="20%">' . $kol_system_prolifi . ' : </td><td width="80%" align="left">';
    echo $system;
    echo '</td></tr>';

    // Artykuł
    echo '<tr align="center" class="text"><td align="left">Artykuł : </td><td align="left">';
    echo $artykul;
    echo '</td></tr>';

    // symbol profilu
    echo '<tr align="center" class="text"><td align="left">' . $kol_symbol_profilu . ' : </td><td align="left">';
    echo $symbol_profilu;
    echo '</td></tr>';

    echo '<tr align="center" class="text"><td align="left" colspan="2">';
    //szukaj
    echo '<FORM name="szukaj">';
    echo '<input type="hidden" name="page" value="magazyn_szukaj">';
    echo '<input type="hidden" name="jak" value="' . $jak . '">';
    echo '<input type="hidden" name="wg_czego" value="' . $wg_czego . '">';
    echo '<input type="hidden" name="szukaj_symbol_profilu" value="' . $szukaj_symbol_profilu . '">';
    echo '<input type="hidden" name="SORT_ELEMENT" value="' . $SORT_ELEMENT . '">';
    echo '<input type="hidden" name="SORT_SYSTEM" value="' . $SORT_SYSTEM . '">';
    echo '<input type="hidden" name="SORT_KOLOR" value="' . $SORT_KOLOR . '">';
    echo '<input type="hidden" name="SORT_SYMBOL_KOLORU" value="' . $SORT_SYMBOL_KOLORU . '">';
    echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="' . $SORT_SYMBOL_PROFILU . '">';
    echo '<input type="hidden" name="SORT_KOLOR_USZCZELEK" value="' . $SORT_KOLOR_USZCZELEK . '">';
    echo '<input type="hidden" name="pokaz" value="' . $pokaz . '">';
    echo '<input type="hidden" name="SORT_KLIENT_NAZWA" value="' . $SORT_KLIENT_NAZWA . '">';

    echo '<table border="0" cellspacing="0" cellpadding="0" align="left"><tr class="text_ogromny"><td align="right">Szukaj symbolu profilu :&nbsp;</td>';
    echo '<td><input type="text" id="szukaj" autocomplete="off" size="5" class="pole_input_wzmocnienia" name="szukaj_symbol_profilu" value="' . $szukaj_symbol_profilu . '"></td>';
    echo '<td align="left"><INPUT type="image" name="submit" src="images/lupa.png"></td>';
    echo '</tr></table>';
    echo '</form>';
    echo '</td></tr>';

    echo '<FORM action="index.php" method="post" enctype="multipart/form-data">';
    echo '<INPUT type="hidden" name="jak" value="' . $jak . '">';
    echo '<INPUT type="hidden" name="wg_czego" value="' . $wg_czego . '">';
    echo '<input type="hidden" name="SORT_SYSTEM" value="' . $SORT_SYSTEM . '">';
    echo '<input type="hidden" name="SORT_ELEMENT" value="' . $SORT_ELEMENT . '">';
    echo '<input type="hidden" name="SORT_KOLOR" value="' . $SORT_KOLOR . '">';
    echo '<input type="hidden" name="SORT_SYMBOL_KOLORU" value="' . $SORT_SYMBOL_KOLORU . '">';
    echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="' . $SORT_SYMBOL_PROFILU . '">';
    echo '<input type="hidden" name="SORT_KOLOR_USZCZELEK" value="' . $SORT_KOLOR_USZCZELEK . '">';
    echo '<input type="hidden" name="SORT_KLIENT_NAZWA" value="' . $SORT_KLIENT_NAZWA . '">';
    echo '<input type="hidden" name="pokaz" value="' . $pokaz . '">';
    echo '<input type="hidden" name="page" value="artykul_dodaj">';
    echo '<input type="hidden" name="system" value="' . $system . '">';
    echo '<input type="hidden" name="artykul" value="' . $artykul . '">';
    echo '<input type="hidden" name="symbol_profilu" value="' . $symbol_profilu . '">';

    //rysunek
    echo '<tr align="center"><td align="left" class="text" colspan="2">';
    echo '<br><table border="0" align="center" cellspacing="0" cellpadding="0" class="text_duzy"><tr ><td align="center">Wybierz plik do przesłania (tylko pliki JPG)</td></tr><tr align="center"><td><br>';
    echo '<input type="file" name="plik" accept="image/jpeg">';
    echo '</td></tr></table><br>';
    echo '</td></tr>';

    //wymiary
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;Wymiary<br>';
    echo '<table border="0" width="300px" align="left" cellpadding="2" cellspacing="2" class="text">';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="zachodzenie"></td>';
    echo '<td align="left" width="90%"> - Zachodzenie</td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="szerokosc"></td>';
    echo '<td align="left" width="90%"> - Szerokość</td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dlugosc"></td>';
    echo '<td align="left" width="90%"> - Długość</td></tr>';
    echo '</table>';
    echo '</td></tr>';

    //dodatki
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;Dodatki<br>';
    echo '<table border="0" width="300px" align="left" cellpadding="2" cellspacing="2" class="text">';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[1]"></td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[2]"></td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[3]"></td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[4]"></td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[5]"></td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[6]"></td></tr>';
    echo '</table>';
    echo '</td></tr>';

    //min R
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;Minimalny R<br>';
    echo '<table border="0" width="300px" align="left" cellpadding="2" cellspacing="2" class="text">';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="min_r_gwarancja"></td>';
    echo '<td align="left" width="90%"> - z gwarancją</td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="min_r_bez_gwarancji"></td>';
    echo '<td align="left" width="90%"> - bez gwarancji</td></tr>';
    echo '</table>';
    echo '</td></tr>';

    echo '<tr align="center"><td align="left" class="text" colspan="2">';
    include "php/artykul_tabelka.php";
    echo '</td></tr>';

    //uwagi
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;' . $kol_uwagi . '<br>';
    echo '<textarea name="uwagi" cols="89" rows="5" class="pole_input_szare_ramka_uwagi">' . $uwagi . '</textarea>';
    echo '</td></tr>';

    echo '<tr class="Text"><td align="center" colspan="2">';
    echo '<INPUT type="submit" name="zapisz" value="Zapisz">';
    echo '</td></tr></table>';
    echo '</FORM>';

    echo '</td></tr></table>';
}

echo $powrot_do_magazynu;
