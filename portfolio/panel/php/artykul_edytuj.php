<?php
$skad = 'artykul_edytuj';
if ($usun_dodatek) {
    mysqli_query($conn, "DELETE FROM magazyn_dodatki WHERE id = " . $usun_dodatek . " LIMIT 1;");
    echo '<div class="text_duzy_niebieski" align="center">Dodatek został usunięty.</div>';
}

if ($usunac) {
    mysqli_query($conn, "DELETE FROM magazyn_artykuly WHERE id = " . $usunac . " LIMIT 1;");
    mysqli_query($conn, "DELETE FROM magazyn_dodatki WHERE artykul_id = " . $usunac . ";");
    echo '<div class="text_duzy_niebieski" align="center">Artykuł został usunięty.</div>';
}
if ($usun_id) {
    mysqli_query($conn, "DELETE FROM magazyn WHERE id = " . $usun_id . " LIMIT 1;");
    // echo 'usun_id='.$usun_id.'<br>';
    echo '<div class="text_duzy_niebieski" align="center">Pozycja została usunięta</div>';
}

if (($zapisz) && ($usunac == '')) {
    $result = true;
    $zachodzenie = change($zachodzenie);
    $szerokosc = change($szerokosc);
    $dlugosc = change($dlugosc);
    $wzmocnienie = change($wzmocnienie);
    $lacznik = change($lacznik);
    $zaslepka = change($zaslepka);
    $min_r_gwarancja = change($min_r_gwarancja);
    $min_r_bez_gwarancji = change($min_r_bez_gwarancji);

    $uploaddir = 'artykul/';
    //echo 'plik='.$_FILES['plik']['tmp_name'].'<br>';
    if (move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir . $_FILES['plik']['name'])) {
        $rysunek = $_FILES['plik']['name'];
    }

    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET uwagi = '" . $uwagi . "' WHERE id = " . $id . ";");

    if ($rysunek) {
        $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET rysunek = '" . $rysunek . "' WHERE id = " . $id . ";");
    }

    if ($usunac_zdjecie) {
        $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET rysunek = '' WHERE id = " . $id . ";");
    }

    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET zachodzenie = " . $zachodzenie . " WHERE id = " . $id . ";");
    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET szerokosc = " . $szerokosc . " WHERE id = " . $id . ";");
    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET dlugosc = " . $dlugosc . " WHERE id = " . $id . ";");
    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET min_r_gwarancja = " . $min_r_gwarancja . " WHERE id = " . $id . ";");
    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_artykuly SET min_r_bez_gwarancji = " . $min_r_bez_gwarancji . " WHERE id = " . $id . ";");

    $ilosc_dodatkow = 0;
    $pytanie33 = mysqli_query($conn, "SELECT * FROM magazyn_dodatki WHERE artykul_id=" . $id . " ORDER BY id ASC;");
    while ($wynik33 = mysqli_fetch_assoc($pytanie33)) {
        $ilosc_dodatkow++;
        $dodatek_id[$ilosc_dodatkow] = $wynik33['id'];
        $dodatek_symbol_profilu[$ilosc_dodatkow] = $wynik33['symbol_profilu'];
        $dodatek_artykul[$ilosc_dodatkow] = $wynik33['artykul'];
    }

    if ($ilosc_dodatkow) {
        for ($d = 1; $d <= $ilosc_dodatkow; $d++) {
            if ($dodatek[$d]) {
                //echo 'dod='.$dodatek[$d].'<br>';
                $pytanie = mysqli_query($conn, "SELECT element FROM magazyn WHERE symbol_profilu ='" . $dodatek[$d] . "';");
                while ($wynik = mysqli_fetch_assoc($pytanie)) {
                    $element_dodatek = $wynik['element'];
                }
                if ($element_dodatek) {
                    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_dodatki SET symbol_profilu = '" . $dodatek[$d] . "' WHERE id = " . $dodatek_id[$d] . ";");
                    $pytanie122 = mysqli_query($conn, "UPDATE magazyn_dodatki SET artykul = '" . $element_dodatek . "' WHERE id = " . $dodatek_id[$d] . ";");
                }
            }
        }
    }

    for ($dd = 1; $dd <= 3; $dd++) {
        if ($dodatek_extra[$dd]) {
            // echo 'dod extra='.$dodatek_extra[$dd].'<br>';
            $pytanie = mysqli_query($conn, "SELECT element FROM magazyn WHERE symbol_profilu ='" . $dodatek_extra[$dd] . "';");
            while ($wynik = mysqli_fetch_assoc($pytanie)) {
                $element_dodatek = $wynik['element'];
            }

            if ($element_dodatek) {
                $query = "INSERT INTO magazyn_dodatki (`artykul_id`, `symbol_profilu`, `artykul`) values ('$id', '$dodatek_extra[$dd]', '$element_dodatek');";
                mysqli_query($conn, $query);
            }
        }
    }

    echo '<div class="text_duzy_niebieski" align="center">Artykuł został zmieniony.</div>';
}

if (!$zapisz) {
    $pytanie = mysqli_query($conn, "SELECT * FROM magazyn_artykuly WHERE id=" . $artykul_id . ";");
    while ($wynik = mysqli_fetch_assoc($pytanie)) {
        //echo 'id='.$id.'<br>';
        $system = $wynik['system'];
        $artykul = $wynik['artykul'];
        $symbol_profilu = $wynik['symbol_profilu'];
        $rysunek = $wynik['rysunek'];
        $zachodzenie = $wynik['zachodzenie'];
        $szerokosc = $wynik['szerokosc'];
        $dlugosc = $wynik['dlugosc'];
        $uwagi = $wynik['uwagi'];
        $min_r_gwarancja = $wynik['min_r_gwarancja'];
        $min_r_bez_gwarancji = $wynik['min_r_bez_gwarancji'];
    }

    echo '<table width="1200px" align="center" border="0" cellpadding="3" align="left"><tr><td width="90%" align="center" valign="top">';
    echo '<div class="text_duzy" align="center">Edytuj artykuł</div>';
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
    echo '<INPUT type="hidden" name="id" value="' . $artykul_id . '">';
    echo '<INPUT type="hidden" name="jak" value="' . $jak . '">';
    echo '<INPUT type="hidden" name="wg_czego" value="' . $wg_czego . '">';
    echo '<input type="hidden" name="SORT_SYSTEM" value="' . $SORT_SYSTEM . '">';
    echo '<input type="hidden" name="SORT_ELEMENT" value="' . $SORT_ELEMENT . '">';
    echo '<input type="hidden" name="SORT_KOLOR" value="' . $SORT_KOLOR . '">';
    echo '<input type="hidden" name="SORT_SYMBOL_KOLORU" value="' . $SORT_SYMBOL_KOLORU . '">';
    echo '<input type="hidden" name="SORT_SYMBOL_PROFILU" value="' . $SORT_SYMBOL_PROFILU . '">';
    echo '<input type="hidden" name="SORT_KOLOR_USZCZELEK" value="' . $SORT_KOLOR_USZCZELEK . '">';
    echo '<input type="hidden" name="pokaz" value="' . $pokaz . '">';
    echo '<input type="hidden" name="page" value="artykul_edytuj">';

    //rysunek
    echo '<tr align="center"><td align="center" class="text" colspan="2">';
    if ($rysunek) {
        echo '<table border="2" align="center" BORDERCOLOR="black" frame="box" RULES="all" cellpadding="10" cellspacing="10"><tr align="center"><td><font color="red" size="+1">Nazwa pliku : ' . $rysunek . '</font><br><br>';
        echo '<div class="text_red" align="center">Zaznacz, aby usunąć zdjęcie <input type="checkbox" name="usunac_zdjecie" value="' . $artykul_id . '"></div><br>';
        echo '<img src="artykul/' . $rysunek . '" width="500">';
        echo '</td></tr></table>';
    }

    echo '<br><br><table border="0" align="center" cellspacing="0" cellpadding="0" class="text_duzy"><tr ><td align="center">Wybierz plik do przesłania (tylko pliki JPG)</td></tr><tr align="center"><td><br>';
    echo '<input type="file" name="plik" accept="image/jpeg">';
    echo '</td></tr></table><br>';
    echo '</td></tr>';

    //wymiary
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;Wymiary<br>';
    echo '<table border="0" width="300px" align="left" cellpadding="2" cellspacing="2" class="text">';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="zachodzenie" value="' . $zachodzenie . '"></td>';
    echo '<td align="left" width="90%"> - Zachodzenie</td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="szerokosc" value="' . $szerokosc . '"></td>';
    echo '<td align="left" width="90%"> - Szerokość</td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="dlugosc" value="' . $dlugosc . '"></td>';
    echo '<td align="left" width="90%"> - Długość</td></tr>';
    echo '</table>';
    echo '</td></tr>';

    //dodatki
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;Dodatki<br>';
    echo '<table border="0" width="300px" align="left" cellpadding="2" cellspacing="2" class="text">';
    // wyszukujemy dodatki
    $ilosc_dodatkow = 0;
    $pytanie33 = mysqli_query($conn, "SELECT * FROM magazyn_dodatki WHERE artykul_id=" . $artykul_id . " ORDER BY id ASC;");
    while ($wynik33 = mysqli_fetch_assoc($pytanie33)) {
        $ilosc_dodatkow++;
        $dodatek_id[$ilosc_dodatkow] = $wynik33['id'];
        $dodatek_symbol_profilu[$ilosc_dodatkow] = $wynik33['symbol_profilu'];
        $dodatek_artykul[$ilosc_dodatkow] = $wynik33['artykul'];
    }
    //echo 'ilosc_dodatkow='.$ilosc_dodatkow.'<br>';
    if ($ilosc_dodatkow) {
        for ($d = 1; $d <= $ilosc_dodatkow; $d++) {
            echo '<tr height="30px" valign="middle"><td width="5px"><a href="index.php?page=artykul_edytuj&artykul_id=' . $artykul_id . '&usun_dodatek=' . $dodatek_id[$d] . '&jak=' . $jak . '&wg_czego=' . $wg_czego . '&pokaz=' . $pokaz . '&SORT_SYSTEM=' . $SORT_SYSTEM . '&SORT_KLIENT_NAZWA=' . $SORT_KLIENT_NAZWA . '&SORT_ELEMENT=' . $SORT_ELEMENT . '&SORT_KOLOR=' . $SORT_KOLOR . '&SORT_SYMBOL_KOLORU=' . $SORT_SYMBOL_KOLORU . '&SORT_SYMBOL_PROFILU=' . $SORT_SYMBOL_PROFILU . '&SORT_KOLOR_USZCZELEK=' . $SORT_KOLOR_USZCZELEK . '">' . $image_delete . '</a></td>';
            echo '<td><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek[' . $d . ']" value="' . $dodatek_symbol_profilu[$d] . '"> - ';
            //szukamy dodatku w artykułach
            $pytanie33 = mysqli_query($conn, "SELECT * FROM magazyn_artykuly WHERE system='" . $system . "' AND symbol_profilu='" . $dodatek_symbol_profilu[$d] . "';");
            while ($wynik33 = mysqli_fetch_assoc($pytanie33)) {
                $dodatek_artykul_id = $wynik33['id'];
            }
            if ($dodatek_artykul_id) {
                echo '<a href="index.php?page=artykul_edytuj&artykul_id=' . $dodatek_artykul_id . '&jak=' . $jak . '&wg_czego=' . $wg_czego . '&pokaz=' . $pokaz . '&SORT_SYSTEM=' . $SORT_SYSTEM . '&SORT_KLIENT_NAZWA=' . $SORT_KLIENT_NAZWA . '&SORT_ELEMENT=' . $SORT_ELEMENT . '&SORT_KOLOR=' . $SORT_KOLOR . '&SORT_SYMBOL_KOLORU=' . $SORT_SYMBOL_KOLORU . '&SORT_SYMBOL_PROFILU=' . $SORT_SYMBOL_PROFILU . '&SORT_KOLOR_USZCZELEK=' . $SORT_KOLOR_USZCZELEK . '"><font color="blue">' . $dodatek_artykul[$d] . '</font></a>';
            } else {
                echo '<a href="index.php?page=artykul_dodaj&system=' . $system . '&artykul=' . $dodatek_artykul[$d] . '&symbol_profilu=' . $dodatek_symbol_profilu[$d] . '&jak=' . $jak . '&wg_czego=' . $wg_czego . '&pokaz=' . $pokaz . '&SORT_SYSTEM=' . $SORT_SYSTEM . '&SORT_KLIENT_NAZWA=' . $SORT_KLIENT_NAZWA . '&SORT_ELEMENT=' . $SORT_ELEMENT . '&SORT_KOLOR=' . $SORT_KOLOR . '&SORT_SYMBOL_KOLORU=' . $SORT_SYMBOL_KOLORU . '&SORT_SYMBOL_PROFILU=' . $SORT_SYMBOL_PROFILU . '&SORT_KOLOR_USZCZELEK=' . $SORT_KOLOR_USZCZELEK . '">' . $dodatek_artykul[$d] . '</a>';
            }

            echo '</td></tr>';
        }
    }

    for ($dd = 1; $dd <= 3; $dd++) {
        echo '<tr><td colspan="2"><input autocomplete="off" type="text" size="10" class="pole_input" name="dodatek_extra[' . $dd . ']"></td></tr>';
    }

    echo '</table>';
    echo '</td></tr>';

    //min R
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;Minimalny R<br>';
    echo '<table border="0" width="300px" align="left" cellpadding="2" cellspacing="2" class="text">';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="min_r_gwarancja" value="' . $min_r_gwarancja . '"></td>';
    echo '<td align="left" width="90%"> - z gwarancją</td></tr>';
    echo '<tr><td><input autocomplete="off" type="text" size="10" class="pole_input" name="min_r_bez_gwarancji" value="' . $min_r_bez_gwarancji . '"></td>';
    echo '<td align="left" width="90%"> - bez gwarancji</td></tr>';
    echo '</table>';
    echo '</td></tr>';

    //tabela z produktami z magazynu
    if (($system != '') && ($artykul != '') && ($symbol_profilu != '')) {
        echo '<tr align="center"><td align="left" class="text" colspan="2">';
        include "php/artykul_tabelka.php";
        echo '</td></tr>';
    }

    //uwagi
    echo '<tr align="center"><td align="left" class="text" colspan="2">&nbsp;&nbsp;' . $kol_uwagi . '<br>';
    echo '<textarea name="uwagi" cols="89" rows="5" class="pole_input_biale_ramka_uwagi">' . $uwagi . '</textarea>';
    echo '</td></tr>';

    echo '<tr class="Text"><td align="center" colspan="2" class="text_red">Zaznacz, aby usunąć artykuł <input type="checkbox" name="usunac" value="' . $artykul_id . '"><br></td></tr>';

    echo '<tr class="Text"><td align="center" colspan="2">';
    echo '<INPUT type="submit" name="zapisz" value="Zapisz">';
    echo '</td></tr></table>';
    echo '</FORM>';

    echo '</td></tr></table>';
}
echo $powrot_do_magazynu;
