<?php
if($submit)
{
	echo '<div class="text_duzy_niebieski" align="center">Stawki podstawowe dla pracowników produkcji zostały zmienione.</div><br>';
    //wyciagam aktywnych uzytkownikow z bazy
    $pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' AND aktywny = 'on';");
    while($wynik= mysqli_fetch_assoc($pytanie))
        {
        $uzytkownik_id=$wynik['id'];
        //zamiana przecinkow na kropki
        $nazwa_wydane_profile[$uzytkownik_id] = change($nazwa_wydane_profile[$uzytkownik_id]);
        $nazwa_wygiete_profile_pvc[$uzytkownik_id] = change($nazwa_wygiete_profile_pvc[$uzytkownik_id]);
        $nazwa_wyfrezowane_odwodnienia[$uzytkownik_id] = change($nazwa_wyfrezowane_odwodnienia[$uzytkownik_id]);
        $nazwa_zgrzane_profile[$uzytkownik_id] = change($nazwa_zgrzane_profile[$uzytkownik_id]);
        $nazwa_wstawione_slupki[$uzytkownik_id] = change($nazwa_wstawione_slupki[$uzytkownik_id]);
        $nazwa_okute_elementy[$uzytkownik_id] = change($nazwa_okute_elementy[$uzytkownik_id]);
        $nazwa_zaszklone_elementy[$uzytkownik_id] = change($nazwa_zaszklone_elementy[$uzytkownik_id]);
        $nazwa_spakowane_wyroby[$uzytkownik_id] = change($nazwa_spakowane_wyroby[$uzytkownik_id]);
        $nazwa_dociete_listwy[$uzytkownik_id] = change($nazwa_dociete_listwy[$uzytkownik_id]);
        $nazwa_dociecie_kompletu_listew_przyszybowych[$uzytkownik_id] = change($nazwa_dociecie_kompletu_listew_przyszybowych[$uzytkownik_id]);

        //update dla wszystkich wartosci
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET wydane_profile = ".$nazwa_wydane_profile[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET wygiete_profile_pvc = ".$nazwa_wygiete_profile_pvc[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET wyfrezowane_odwodnienia = ".$nazwa_wyfrezowane_odwodnienia[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET zgrzane_profile = ".$nazwa_zgrzane_profile[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET wstawione_slupki = ".$nazwa_wstawione_slupki[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET okute_elementy = ".$nazwa_okute_elementy[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET zaszklone_elementy = ".$nazwa_zaszklone_elementy[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET spakowane_wyroby = ".$nazwa_spakowane_wyroby[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET dociete_listwy = ".$nazwa_dociete_listwy[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        $result = mysqli_query($conn, "UPDATE uzytkownicy SET dociecie_kompletu_listew_przyszybowych = ".$nazwa_dociecie_kompletu_listew_przyszybowych[$uzytkownik_id]." WHERE id = ".$uzytkownik_id.";");
        }
    echo '<div align="center"><a href="index.php?page=stawka_podstawowa">Powrót.</a></div><br>';
}
else
{
    //deklaracja pustych tablic
    $uzytkownik_id = [];
    $imie = [];
    $nazwisko = [];
    $wydane_profile = [];
    $wygiete_profile_pvc = [];
    $wyfrezowane_odwodnienia = [];
    $zgrzane_profile = [];
    $wstawione_slupki = [];
    $okute_elementy = [];
    $zaszklone_elementy = [];
    $spakowane_wyroby = [];
    $haslo = [];
    $dociete_listwy = [];
    $dociecie_kompletu_listew_przyszybowych = [];

    //wyciagam aktywnych uzytkownikow z bazy
    $pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' AND aktywny = 'on' ORDER BY ID ASC;");
    while($wynik= mysqli_fetch_assoc($pytanie))
        {
        $i++;
        $uzytkownik_id[$i]=$wynik['id'];
        $haslo[$i]=$wynik['haslo'];
        $imie[$i]=$wynik['imie'];
        $nazwisko[$i]=$wynik['nazwisko'];
        $wydane_profile[$i]=$wynik['wydane_profile'];
        $wygiete_profile_pvc[$i]=$wynik['wygiete_profile_pvc'];
        $wyfrezowane_odwodnienia[$i]=$wynik['wyfrezowane_odwodnienia'];
        $zgrzane_profile[$i]=$wynik['zgrzane_profile'];
        $wstawione_slupki[$i]=$wynik['wstawione_slupki'];
        $okute_elementy[$i]=$wynik['okute_elementy'];
        $zaszklone_elementy[$i]=$wynik['zaszklone_elementy'];
        $spakowane_wyroby[$i]=$wynik['spakowane_wyroby'];
        $dociete_listwy[$i]=$wynik['dociete_listwy'];
        $dociecie_kompletu_listew_przyszybowych[$i]=$wynik['dociecie_kompletu_listew_przyszybowych'];
        }
    
    echo '<div class="text_duzy" align="center">Stawki podstawowe dla pracowników produkcji</div><br>';

	echo '<FORM action="index.php?page=stawka_podstawowa" method="post">';

    //wyswietlam liste aktywnych uzytkowników
    $szerokosc_pola_input_ilosc = '40px';
    $szerokosc_kolumny = 100;
    echo '<table align="center" class="tabela" cellpadding="4"  ><tr height="50px" align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
    echo '<td width="30px">'.$kol_lp.'</td>';
    echo '<td width="250px">'.$kol_imie_nazwisko.'</td>';
    echo '<td width="80px">Hasło</td>';

    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_wydane_profile.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_wygiete_profile_pvc.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_wyfrezowane_odwodnienia.'</td>';

    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_zgrzane_profile.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_wstawione_slupki.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_dociete_listwy.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_dociecie_kompletu_listew_przyszybowych.'</td>';

    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_okute_elementy.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_zaszklone_elementy.'</td>';
    echo '<td width="'.$szerokosc_kolumny.'"px>'.$kol_spakowane_wyroby.'</td>';
    echo '</tr>';

    for ($x=1; $x<=$i; $x++)
        {
        echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
        echo '<td>'.$imie[$x].' '.$nazwisko[$x].'</td>';
        echo '<td>'.$haslo[$x].'</td>';

        $nazwa_wydane_profile = 'nazwa_wydane_profile['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_wydane_profile.'" value="'.$wydane_profile[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_wygiete_profile_pvc = 'nazwa_wygiete_profile_pvc['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_wygiete_profile_pvc.'" value="'.$wygiete_profile_pvc[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_wyfrezowane_odwodnienia = 'nazwa_wyfrezowane_odwodnienia['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_wyfrezowane_odwodnienia.'" value="'.$wyfrezowane_odwodnienia[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_zgrzane_profile = 'nazwa_zgrzane_profile['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_zgrzane_profile.'" value="'.$zgrzane_profile[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_wstawione_slupki = 'nazwa_wstawione_slupki['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_wstawione_slupki.'" value="'.$wstawione_slupki[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_dociete_listwy = 'nazwa_dociete_listwy['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_dociete_listwy.'" value="'.$dociete_listwy[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';
        
        $nazwa_dociecie_kompletu_listew_przyszybowych = 'nazwa_dociecie_kompletu_listew_przyszybowych['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych.'" value="'.$dociecie_kompletu_listew_przyszybowych[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_okute_elementy = 'nazwa_okute_elementy['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_okute_elementy.'" value="'.$okute_elementy[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_zaszklone_elementy = 'nazwa_zaszklone_elementy['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_zaszklone_elementy.'" value="'.$zaszklone_elementy[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';

        $nazwa_spakowane_wyroby = 'nazwa_spakowane_wyroby['.$uzytkownik_id[$x].']';
        echo '<td align="center"><input type="text" name="'.$nazwa_spakowane_wyroby.'" value="'.$spakowane_wyroby[$x].'" style="width: '.$szerokosc_pola_input_ilosc.'" class="pole_input_biale_ramka" autocomplete="off">'.$waluta.'</td>';
        echo '</tr>';
        }
    echo '</table>';
    echo '<br><div align="center"><INPUT type="submit" class="text" name="submit" value="Zapisz"></div>';
    echo '</form>';
}

?>