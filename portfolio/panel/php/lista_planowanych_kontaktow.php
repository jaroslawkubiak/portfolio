<?php

$ilosc = 0;
$sql = "SELECT * FROM historia_wspolpracy WHERE kontakt_data_time <> '' ORDER BY kontakt_data_time ASC;";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) 
    while ($wynik = mysqli_fetch_assoc($result)) 
        {
        $ilosc++;
        $wpis_id[$ilosc]=$wynik['id'];
        $data_baza[$ilosc] = date('d-m-Y', $wynik['data']);

        $klient_id_baza[$ilosc]=$wynik['klient_id'];
        $user_id_baza[$ilosc]=$wynik['user_id'];
        $opis_baza[$ilosc]=$wynik['opis'];
        $kontakt_data_baza[$ilosc]=$wynik['kontakt_data'];
        

        $sql2 = "SELECT imie, nazwisko FROM uzytkownicy WHERE id = ".$user_id_baza[$ilosc].";";
        $result2 = mysqli_query($conn, $sql2);
        if(mysqli_num_rows($result2) > 0) 
            while ($wynik2 = mysqli_fetch_assoc($result2)) 
                {
                $user_baza_imie[$ilosc]=$wynik2['imie'];
                $user_baza_nazwisko[$ilosc]=$wynik2['nazwisko'];
                }

        $sql3 = "SELECT nazwa FROM klienci WHERE id = ".$klient_id_baza[$ilosc].";";
        $result3 = mysqli_query($conn, $sql3);
        if(mysqli_num_rows($result3) > 0) 
            while ($wynik3 = mysqli_fetch_assoc($result3)) 
                {
                $klient_nazwa_baza[$ilosc]=$wynik3['nazwa'];
                }
        }

if($ilosc != 0)
{

    echo '<table align="center" class="tabela" width="1500px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
    echo '<td width="15px">'.$kol_lp.'</td>';
    echo '<td width="200px" align="center">Klient</td>';
    echo '<td width="200px">Użytkownik</td>';
    echo '<td width="150px">Data kontaktu</td>';
    echo '<td width="120px">Data dodania</td>';
    echo '<td>Opis</td>';
    echo '</tr>';
    
    for ($x=1; $x<=$ilosc; $x++)
	{
        echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text" align="center">'.$x.'</td>';
        echo '<td align="center"><a href="index.php?page=klienci_edycja2&id='.$klient_id_baza[$x].'&jak=DESC&wg_czego=id&pod_page=klienci_edycja_historia_wspolpracy&usun_wpis='.$wpis_id[$x].'">'.$klient_nazwa_baza[$x].'</a></td>';
        echo '<td align="center">'.$user_baza_imie[$x].' '.$user_baza_nazwisko[$x].'</td>';
        echo '<td align="center">'.$kontakt_data_baza[$x].'</td>';
        echo '<td align="center">'.$data_baza[$x].'</td>';
        echo '<td align="center">'.$opis_baza[$x].'</td>';
        echo '</tr>';
	}
    echo '</table>';
} else {
    echo '<div class="text_duzy_zielony"  align="center">Brak planowanych kontaktów.</div>';
}
    
?>