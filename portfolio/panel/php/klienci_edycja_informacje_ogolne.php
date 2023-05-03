<?php
echo '<br><div align="center" class="text_duzy_zielony">Informacje ogólne</div>';

if($zmien == 1) {

    $sql = mysqli_query($conn, "update klienci SET opiekun_handlowy = '".$opiekun_handlowy."' WHERE id = ".$id.";");
	$sql = mysqli_query($conn, "update klienci SET wojewodztwo = '".$wojewodztwo."' WHERE id = ".$id.";");

	echo '<div class="text_blue" align="center">'.$kom_informacje_ogolne_zmienione.'</div><br>';
}

if(!$submit) {

    $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opiekun_handlowy, wojewodztwo FROM klienci WHERE id = ".$id.";"));
    $klient_opiekun_handlowy = $sql['opiekun_handlowy'];
    $klient_wojewodztwo = $sql['wojewodztwo'];

    $user_id = [];
    $user_imie_nazwisko = [];
    $ilosc_userow = 0;

$pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id <> 1 ORDER BY ID ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_userow++;
	$user_id[$ilosc_userow]=$wynik['id'];
	$user_imie_nazwisko[$ilosc_userow]= $wynik['imie'].' '.$wynik['nazwisko'];
	}
    
    echo '<FORM action="index.php?page=klienci_edycja2&id='.$id.'&pod_page=klienci_edycja_informacje_ogolne" method="post">';
    echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
    echo '<INPUT type="hidden" name="id" value="'.$id.'">';
    echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
    echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
    echo '<INPUT type="hidden" value="'.$page.'">';
    echo '<INPUT type="hidden" name="zmien" value="1">';


    echo '<table border="0" width="500px">';
    echo '<tr align="center" class="text" height="50px"><td align="right">Opiekun handlowy : </td>';

    echo '<td align="left"><select name="opiekun_handlowy" class="pole_input" style="width: 100%">';
		echo '<option></option>';
        for($i=1; $i<=$ilosc_userow; $i++) {
            if($klient_opiekun_handlowy == $user_imie_nazwisko[$i]) $selected = 'selected="selected" '; else $selected = '';
            echo '<option '.$selected.'>'.$user_imie_nazwisko[$i].'</option>';
        }

	echo '</select></td></tr>';
    
    echo '<tr align="center" class="text" height="50px"><td align="right">Województwo : </td>';
    
        echo '<td align="left"><select name="wojewodztwo" class="pole_input" style="width: 100%">';
            echo '<option></option>';
            for($i=0; $i<count($wojewodztwa); $i++) 
            {
                if($klient_wojewodztwo == $wojewodztwa[$i]) $selected = 'selected="selected" '; else $selected = '';
                echo '<option '.$selected.'>'.$wojewodztwa[$i].'</option>';
            }
	echo '</select></td></tr>';
    echo '<tr><td colspan="2" align="center"><button type="submit" class="text" name="submit">Zapisz</button></td></tr>';

    echo '</table>';
    echo '</form>';
}

    


?>