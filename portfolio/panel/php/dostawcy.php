<?php
$warunek = "";

if ($SORT_DOSTAWCA_NAZWA != "") {
    if ($warunek == "") {
        $warunek .= 'WHERE dostawca_nazwa = "' . $SORT_DOSTAWCA_NAZWA . '"';
    } else {
        $warunek .= ' AND dostawca_nazwa = "' . $SORT_DOSTAWCA_NAZWA . '"';
    }

}

$ilosc_dostawcow = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM dostawcy ORDER BY dostawca_nazwa ASC;");
while ($wynik = mysqli_fetch_assoc($pytanie)) {
    $ilosc_dostawcow++;
    $SORT_dostawca_nazwa[$ilosc_dostawcow] = $wynik['dostawca_nazwa'];
}

$ulica = [];
$miasto = [];
$kod_pocztowy = [];
$zamawiany_towar = [];
$dostawca_id = [];
$dostawca_nazwa = [];
$osoba_1 = [];
$stanowisko_1 = [];
$telefon_1 = [];
$email_1 = [];
$dzial_1 = [];
$osoba_2 = [];
$stanowisko_2 = [];
$telefon_2 = [];
$email_2 = [];
$dzial_2 = [];
$osoba_3 = [];
$stanowisko_3 = [];
$telefon_3 = [];
$email_3 = [];
$dzial_3 = [];
$osoba_4 = [];
$stanowisko_4 = [];
$telefon_4 = [];
$email_4 = [];
$dzial_4 = [];
$osoba_5 = [];
$stanowisko_5 = [];
$telefon_5 = [];
$email_5 = [];
$dzial_5 = [];

$i = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM dostawcy " . $warunek . " ORDER BY " . $wg_czego . " " . $jak . ";");
while ($wynik = mysqli_fetch_assoc($pytanie)) {
    $i++;
    $dostawca_id[$i] = $wynik['id'];
    $dostawca_nazwa[$i] = $wynik['dostawca_nazwa'];
    $osoba_1[$i] = $wynik['osoba_1'];
    $stanowisko_1[$i] = $wynik['stanowisko_1'];
    $telefon_1[$i] = $wynik['telefon_1'];
    $email_1[$i] = $wynik['email_1'];
    $dzial_1[$i] = $wynik['dzial_1'];

    $osoba_2[$i] = $wynik['osoba_2'];
    $stanowisko_2[$i] = $wynik['stanowisko_2'];
    $telefon_2[$i] = $wynik['telefon_2'];
    $email_2[$i] = $wynik['email_2'];
    $dzial_2[$i] = $wynik['dzial_2'];

    $osoba_3[$i] = $wynik['osoba_3'];
    $stanowisko_3[$i] = $wynik['stanowisko_3'];
    $telefon_3[$i] = $wynik['telefon_3'];
    $email_3[$i] = $wynik['email_3'];
    $dzial_3[$i] = $wynik['dzial_3'];

    $osoba_4[$i] = $wynik['osoba_4'];
    $stanowisko_4[$i] = $wynik['stanowisko_4'];
    $telefon_4[$i] = $wynik['telefon_4'];
    $email_4[$i] = $wynik['email_4'];
    $dzial_4[$i] = $wynik['dzial_4'];

    $osoba_5[$i] = $wynik['osoba_5'];
    $stanowisko_5[$i] = $wynik['stanowisko_5'];
    $telefon_5[$i] = $wynik['telefon_5'];
    $email_5[$i] = $wynik['email_5'];
    $dzial_5[$i] = $wynik['dzial_5'];

    $ulica[$i] = $wynik['ulica'];
    $miasto[$i] = $wynik['miasto'];
    $kod_pocztowy[$i] = $wynik['kod_pocztowy'];
    $zamawiany_towar[$i] = $wynik['zamawiany_towar'];
}

//sortowanie
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="dostawcy">';
echo '<input type="hidden" name="jak" value="' . $jak . '">';
echo '<input type="hidden" name="wg_czego" value="' . $wg_czego . '">';
echo '<input type="hidden" name="pokaz" value="1">';

echo '<table align="left" class="tabela" width="1850px"><tr align="center" bgcolor="' . $kolor_tabeli . '" class="text">';
if ($pokaz == 1) {
    echo '<td width="5%">' . $kol_lp . '<br><a href="index.php?page=dostawcy&jak=DESC&wg_czego=id">' . $image_close . '</a></td>';
} else {
    echo '<td width="5%">' . $kol_lp . '</td>';
}

echo '<td></td>';
echo '<td ' . $rowspan . ' width="10%">Dostawca<div align="right"><a href="index.php?page=dostawcy&jak=DESC&wg_czego=dostawca_nazwa">' . $image_arrow_down . '</a><a href="index.php?page=dostawcy&jak=ASC&wg_czego=dostawca_nazwa">' . $image_arrow_up . '</a></div>';
echo '<select name="SORT_DOSTAWCA_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
echo '<option></option>';
for ($k = 1; $k <= $ilosc_dostawcow; $k++) {
    if ($SORT_dostawca_nazwa[$k] == $SORT_DOSTAWCA_NAZWA) {
        echo '<option value="' . $SORT_dostawca_nazwa[$k] . '" selected="selected">' . $SORT_dostawca_nazwa[$k] . '</option>';
    } else {
        echo '<option value="' . $SORT_dostawca_nazwa[$k] . '">' . $SORT_dostawca_nazwa[$k] . '</option>';
    }
}

echo '</select>';
echo '</td>';
echo '<td width="15%">Adres</td>';
echo '<td width="10%">Zamawiany towar</td>';
echo '<td width="15%">Osoba do kontaktu</td>';
echo '<td width="10%">Stanowisko</td>';
echo '<td width="10%">Dział</td>';
echo '<td width="15%">Telefon</td>';
echo '<td width="15%">E-mail</td></tr>';

for ($x = 1; $x <= $i; $x++) {
    echo '<tr class="text" align="center" bgcolor="' . $kolor_bialy . '"><td bgcolor="' . $kolor_tabeli . '" class="text" align="center">' . $x . '</td>';

    echo '<td><a href="index.php?page=zamowienia_do_dostawcow_dodaj&klient=' . $dostawca_id[$x] . '&etap=2&jak=ASC&wg_czego=system&naglowek=TAK">' . $image_plusik . '</a></td>';

    echo '<td><a href="index.php?page=dostawcy_edytuj&dostawca_id=' . $dostawca_id[$x] . '">' . $dostawca_nazwa[$x] . '</a></td>';

    echo '<td align="center" class="text">' . $ulica[$x] . '<br>' . $kod_pocztowy[$x] . ' ' . $miasto[$x] . '</td>';
    echo '<td align="center" class="text">' . $zamawiany_towar[$x] . '</td>';

    // osoba
    echo '<td valign="top">';
    echo '<table border="0" width="100%" class="text" cellpadding="0" cellspacing="0">';
    if (($osoba_1[$x] != '') || ($stanowisko_1[$x] != '') || ($dzial_1[$x] != '') || ($telefon_1[$x] != '') || ($email_1[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $osoba_1[$x] . '</td></tr>';
    }

    if (($osoba_2[$x] != '') || ($stanowisko_2[$x] != '') || ($dzial_2[$x] != '') || ($telefon_2[$x] != '') || ($email_2[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $osoba_2[$x] . '</td></tr>';
    }

    if (($osoba_3[$x] != '') || ($stanowisko_3[$x] != '') || ($dzial_3[$x] != '') || ($telefon_3[$x] != '') || ($email_3[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $osoba_3[$x] . '</td></tr>';
    }

    if (($osoba_4[$x] != '') || ($stanowisko_4[$x] != '') || ($dzial_4[$x] != '') || ($telefon_4[$x] != '') || ($email_4[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $osoba_4[$x] . '</td></tr>';
    }

    if (($osoba_5[$x] != '') || ($stanowisko_5[$x] != '') || ($dzial_5[$x] != '') || ($telefon_5[$x] != '') || ($email_5[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $osoba_5[$x] . '</td></tr>';
    }

    echo '</table>';
    echo '</td>';

    // stanowisko
    echo '<td valign="top">';
    echo '<table border="0" width="100%" class="text" cellpadding="0" cellspacing="0">';
    if (($osoba_1[$x] != '') || ($stanowisko_1[$x] != '') || ($dzial_1[$x] != '') || ($telefon_1[$x] != '') || ($email_1[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $stanowisko_1[$x] . '</td></tr>';
    }

    if (($osoba_2[$x] != '') || ($stanowisko_2[$x] != '') || ($dzial_2[$x] != '') || ($telefon_2[$x] != '') || ($email_2[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $stanowisko_2[$x] . '</td></tr>';
    }

    if (($osoba_3[$x] != '') || ($stanowisko_3[$x] != '') || ($dzial_3[$x] != '') || ($telefon_3[$x] != '') || ($email_3[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $stanowisko_3[$x] . '</td></tr>';
    }

    if (($osoba_4[$x] != '') || ($stanowisko_4[$x] != '') || ($dzial_4[$x] != '') || ($telefon_4[$x] != '') || ($email_4[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $stanowisko_4[$x] . '</td></tr>';
    }

    if (($osoba_5[$x] != '') || ($stanowisko_5[$x] != '') || ($dzial_5[$x] != '') || ($telefon_5[$x] != '') || ($email_5[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $stanowisko_5[$x] . '</td></tr>';
    }

    echo '</table>';
    echo '</td>';

    // dzial
    echo '<td valign="top">';
    echo '<table border="0" width="100%" class="text" cellpadding="0" cellspacing="0">';
    if (($osoba_1[$x] != '') || ($stanowisko_1[$x] != '') || ($dzial_1[$x] != '') || ($telefon_1[$x] != '') || ($email_1[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $dzial_1[$x] . '</td></tr>';
    }

    if (($osoba_2[$x] != '') || ($stanowisko_2[$x] != '') || ($dzial_2[$x] != '') || ($telefon_2[$x] != '') || ($email_2[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $dzial_2[$x] . '</td></tr>';
    }

    if (($osoba_3[$x] != '') || ($stanowisko_3[$x] != '') || ($dzial_3[$x] != '') || ($telefon_3[$x] != '') || ($email_3[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $dzial_3[$x] . '</td></tr>';
    }

    if (($osoba_4[$x] != '') || ($stanowisko_4[$x] != '') || ($dzial_4[$x] != '') || ($telefon_4[$x] != '') || ($email_4[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $dzial_4[$x] . '</td></tr>';
    }

    if (($osoba_5[$x] != '') || ($stanowisko_5[$x] != '') || ($dzial_5[$x] != '') || ($telefon_5[$x] != '') || ($email_5[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $dzial_5[$x] . '</td></tr>';
    }

    echo '</table>';
    echo '</td>';

    // telefon
    echo '<td valign="top">';
    echo '<table border="0" width="100%" class="text" cellpadding="0" cellspacing="0">';
    if (($osoba_1[$x] != '') || ($stanowisko_1[$x] != '') || ($dzial_1[$x] != '') || ($telefon_1[$x] != '') || ($email_1[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $telefon_1[$x] . '</td></tr>';
    }

    if (($osoba_2[$x] != '') || ($stanowisko_2[$x] != '') || ($dzial_2[$x] != '') || ($telefon_2[$x] != '') || ($email_2[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $telefon_2[$x] . '</td></tr>';
    }

    if (($osoba_3[$x] != '') || ($stanowisko_3[$x] != '') || ($dzial_3[$x] != '') || ($telefon_3[$x] != '') || ($email_3[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $telefon_3[$x] . '</td></tr>';
    }

    if (($osoba_4[$x] != '') || ($stanowisko_4[$x] != '') || ($dzial_4[$x] != '') || ($telefon_4[$x] != '') || ($email_4[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $telefon_4[$x] . '</td></tr>';
    }

    if (($osoba_5[$x] != '') || ($stanowisko_5[$x] != '') || ($dzial_5[$x] != '') || ($telefon_5[$x] != '') || ($email_5[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $telefon_5[$x] . '</td></tr>';
    }

    echo '</table>';
    echo '</td>';

    // email
    echo '<td valign="top">';
    echo '<table border="0" width="100%" class="text" cellpadding="0" cellspacing="0">';
    if (($osoba_1[$x] != '') || ($stanowisko_1[$x] != '') || ($dzial_1[$x] != '') || ($telefon_1[$x] != '') || ($email_1[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $email_1[$x] . '</td></tr>';
    }

    if (($osoba_2[$x] != '') || ($stanowisko_2[$x] != '') || ($dzial_2[$x] != '') || ($telefon_2[$x] != '') || ($email_2[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $email_2[$x] . '</td></tr>';
    }

    if (($osoba_3[$x] != '') || ($stanowisko_3[$x] != '') || ($dzial_3[$x] != '') || ($telefon_3[$x] != '') || ($email_3[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $email_3[$x] . '</td></tr>';
    }

    if (($osoba_4[$x] != '') || ($stanowisko_4[$x] != '') || ($dzial_4[$x] != '') || ($telefon_4[$x] != '') || ($email_4[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $email_4[$x] . '</td></tr>';
    }

    if (($osoba_5[$x] != '') || ($stanowisko_5[$x] != '') || ($dzial_5[$x] != '') || ($telefon_5[$x] != '') || ($email_5[$x] != '')) {
        echo '<tr><td align="center" class="text">&nbsp;' . $email_5[$x] . '</td></tr>';
    }

    echo '</table>';
    echo '</td>';
    echo '</tr>';
}
echo '</table>';
echo '</form>';
