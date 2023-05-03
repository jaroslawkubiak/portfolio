<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Oferta indywidualna</div><br>';

echo '<table border="0" width="100%" align="center"><tr><td>';

if ($nowy_opis != '') {
    $pytanie121 = mysqli_query($conn, "UPDATE oferta_indywidualna_pliki SET opis = '" . $nowy_opis . "' WHERE id = " . $zmien_opis . ";");
    echo '<div align="center" class="text_duzy_niebieski">Opis zmieniony.</div><br>';
}

if ($usun_na_stale) {
    //echo 'usuwam plik z dysku';
    $deletedir = '../panel_dane/oferta_indywidualna_pliki/';
    $pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki where id = " . $usun_na_stale . ";");
    while ($wynik = mysqli_fetch_assoc($pytanie)) {
        $usun_plik = $wynik['plik_nazwa'];
        $link_folder = $wynik['link'];
    }

    $sciezka_usun = $deletedir . $link_folder . '/' . $usun_plik;
    if (unlink($sciezka_usun)) //usuwam plik, jak usuniety to usuwam folder i wpis z bazy
    {
        rmdir($deletedir . $link_folder); //usuwam folder
        mysqli_query($conn, "DELETE FROM oferta_indywidualna_pliki WHERE id = " . $usun_na_stale . " LIMIT 1;");
        echo '<div align="center" class="text_duzy_niebieski">Plik został usunięty z serwera.</div><br>';

    } else {
        echo '< p class="error" align="center">Nie udało się usunąć piku</p>';
    }

}

if ($usunac != '') {
    $pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki where id = " . $usunac . ";");
    while ($wynik = mysqli_fetch_assoc($pytanie)) {
        $usun_link = $wynik['plik_nazwa'];
    }
    echo '<div align="center" class="text_duzy_niebieski">Plik zarchiwizowany.</div><br>';
    //azchiwizacja pliku
    $dzis_godzina = date('d-m-Y___H_i_s', $time);
    $folder = $zalogowany_user . '___' . $dzis_godzina;
    mkdir("../panel_dane/oferta_indywidualna_pliki/$folder", 0777);

    rename('../panel_dane/oferta_indywidualna_pliki/' . $usun_link, '../panel_dane/oferta_indywidualna_pliki/' . $folder . '/' . $usun_link);
    $pytanie121 = mysqli_query($conn, "UPDATE oferta_indywidualna_pliki SET typ = 'archiwum' WHERE id = " . $usunac . ";");
    $pytanie121 = mysqli_query($conn, "UPDATE oferta_indywidualna_pliki SET link = '" . $folder . "' WHERE id = " . $usunac . ";");

    $pytanie121 = mysqli_query($conn, "UPDATE oferta_indywidualna_pliki SET user_id = " . $zalogowany_user . " WHERE id = " . $usunac . ";");
    $data = date('d-m-Y', $time);
    $pytanie121 = mysqli_query($conn, "UPDATE oferta_indywidualna_pliki SET data = '" . $data . "' WHERE id = " . $usunac . ";");

}

if ($usun != '') {
    $pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki where id = " . $usun . ";");
    while ($wynik = mysqli_fetch_assoc($pytanie)) {
        $usun_opis = $wynik['opis'];
        $usun_link = $wynik['plik_nazwa'];
    }
    echo '<div align="center" class="text_duzy">Czy na pewno zarchiwizować poniższy plik?</div><br>';
    echo '<div align="center" class="text_duzy_zielony">' . $usun_link . '</div><br>';
    echo '<div align="center"><a href="index.php?page=ustawienia_oferta_indywidualna&usunac=' . $usun . '"><font color="red" size="+2">ZARCHIWIZUJ PLIK</font></a></div><br><br>';
}
if ($zmiana_danych == 1) {

    mysqli_query($conn, "UPDATE suwaki SET opis = '" . $tytul_oferty . "' WHERE typ = 'tytul_oferty_indywidualnej';");
    mysqli_query($conn, "UPDATE suwaki SET opis = '" . $tresc_oferty_indywidualnej . "' WHERE typ = 'tresc_oferty_indywidualnej';");
}

//pobieram tutyl oferty z ustawien
$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki where typ = 'tytul_oferty_indywidualnej';");
while ($wynik3 = mysqli_fetch_assoc($pytanie3)) {
    $tytul_oferty = $wynik3['opis'];
}

$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki where typ = 'tresc_oferty_indywidualnej';");
while ($wynik3 = mysqli_fetch_assoc($pytanie3)) {
    $tresc_oferty_indywidualnej = $wynik3['opis'];
}

echo '<FORM action="index.php?page=ustawienia_oferta_indywidualna&zmiana_danych=1" method="post">';
echo '<table border="0" width="1000px" align="center">';
echo '<tr class="text"><td width="20%" align="right">Tytuł oferty : </td>';
echo '<td width="50%" colspan="2"><input type="text" name="tytul_oferty" value="' . $tytul_oferty . '" class="pole_input" size="120" maxlength="150" autocomplete="off"></td></tr>';

echo '<tr class="text"><td align="right">Treść oferty : </td><td>';
echo '<textarea name="tresc_oferty_indywidualnej" cols="80" rows="8" class="pole_input_szare_ramka_uwagi">' . $tresc_oferty_indywidualnej . '</textarea></td>';

echo '<td width="30%" valign="top"><font color="blue">Pomoc:</font><br>';
echo 'Aby użyć Enter wpisz: &lt;br&gt;<br><br>';
echo 'Aby pogrubić czcionkę umieść na początku: &lt;b&gt;<br>';
echo 'a na końcu: &lt;/b&gt;<br>';
echo '&lt;b&gt;PRZYKŁAD&lt;/b&gt;</td></tr>';

echo '<tr><td colspan="3" align="center"><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr></table>';

echo '<hr width="40%"><br>';
echo '</form>';

if (!$archiwum) {
    include "php/oferta_indywidualna_zaladuj_plik.php";
}

echo '</td></tr><tr><td>';

if ($archiwum == 1) {
    $szukany_typ_pliku = 'archiwum';
    $kolor_czcionki = 'red';
    echo '<div align="center"><a href="index.php?page=ustawienia_oferta_indywidualna"><font size="+1" color="blue">POKAŻ ZWYKŁE PLIKI</font></a></div><br>';
} else {
    $szukany_typ_pliku = 'staly';
    $kolor_czcionki = 'blue';
    echo '<div align="center"><a href="index.php?page=ustawienia_oferta_indywidualna&archiwum=1"><font size="+1" color="red">POKAŻ ARCHIWUM PLIKÓW</font></a></div><br>';
}

// tabela z plikami
$plik_link = [];
$id = [];
$kolejnosc = [];
$plik_opis = [];
$plik_nazwa = [];
$plik_link = [];
$ilosc_plikow = 0;
$pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki WHERE typ = '" . $szukany_typ_pliku . "' ORDER BY kolejnosc DESC;");
while ($wynik = mysqli_fetch_assoc($pytanie)) {
    $ilosc_plikow++;
    $id[$ilosc_plikow] = $wynik['id'];
    $kolejnosc[$ilosc_plikow] = $wynik['kolejnosc'];
    $plik_opis[$ilosc_plikow] = $wynik['opis'];
    $plik_nazwa[$ilosc_plikow] = $wynik['plik_nazwa'];

    if ($archiwum == 1) {
        $plik_link[$ilosc_plikow] = $wynik['link'];
        $plik_link[$ilosc_plikow] = '/' . $plik_link[$ilosc_plikow];
    }

    $plik_zarchiwizowal[$ilosc_plikow] = $wynik['user_id'];
    if ($plik_zarchiwizowal[$ilosc_plikow] != '') {
        $plik_zarchiwizowany_data[$ilosc_plikow] = $wynik['data'];
        $pytanie177 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = " . $plik_zarchiwizowal[$ilosc_plikow] . ";");
        while ($wynik177 = mysqli_fetch_assoc($pytanie177)) {
            $imie_temp = $wynik177['imie'];
            $nazwisko_temp = $wynik177['nazwisko'];
            $plik_zarchiwizowal[$ilosc_plikow] = $imie_temp . ' ' . $nazwisko_temp;
        }
    }
}

echo '<table border="1" align="center" BORDERCOLOR="black" frame="box" RULES="all" class="text" cellpadding="3" cellspacing="3">';
echo '<tr bgcolor="' . $kolor_tabeli . '">';
//echo '<td width="120px">Kolejnosc</td>';
echo '<td width="400px">Opis pliku</td>';
echo '<td width="280px">Nazwa plik + podgląd (kliknij w nazwę)</td>';
if ($archiwum == 0) {
    echo '<td width="180px" align="center">Archiwizuj</td>';
}

if ($archiwum == 1) {
    echo '<td width="120px" align="center">Użytkownik</td><td width="100px" align="center">Data zarchiwizowania</td><td>Usuń na stałe</td>';
}

echo '</tr>';

for ($x = 1; $x <= $ilosc_plikow; $x++) {
    echo '<tr bgcolor="' . $kolor_bialy . '" height="50px">';
    //echo '<td>'.$kolejnosc[$x].'</td>';
    echo '<td>' . $plik_opis[$x] . '</td>';
    echo '<td><a href="http://' . $adres_serwera_do_faktur . '/panel_dane/oferta_indywidualna_pliki' . $plik_link[$x] . '/' . $plik_nazwa[$x] . '" target="_blank"><font color="' . $kolor_czcionki . '">' . $plik_nazwa[$x] . '</font></a></td>';
    if ($archiwum == 0) {
        echo '<td align="center"><a href="index.php?page=ustawienia_oferta_indywidualna&usun=' . $id[$x] . '">' . $image_archiwum . '</a></td>';
    }

    if ($archiwum == 1) {
        echo '<td align="center">' . $plik_zarchiwizowal[$x] . '</td><td align="center">' . $plik_zarchiwizowany_data[$x] . '</td>';
    }

    if ($archiwum == 1) {
        echo '<td align="center"><a href="index.php?page=ustawienia_oferta_indywidualna&usun_na_stale=' . $id[$x] . '">' . $image_trash . '</a></td>';
    }

    echo '</tr>';
}
echo '</table>';

echo '</td></tr></table>';

echo '</td></tr></table>';
