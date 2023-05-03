<?php

echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Cennik osobisty</div><br>';
echo '<div class="text_duzy_czerwony" align="center">Zmiana w tym cenniku spowoduje zmianę ceny dla każdego klienta!</div><br>';


if(($zmiana_danych == 1) && ($id_ceny != ''))
	{
		$nowa_cena = change($nowa_cena);
        //zmieniamy cene w cenniku osobistym
		$ins=mysqli_query($conn, "update cennik_osobisty set cena=".$nowa_cena." WHERE id = ".$id_ceny.";");

        //pobieram nazwe uslugi dla której zmienić cene w cenniku klientów
        $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis_uslugi FROM cennik_osobisty WHERE id = ".$id_ceny.";"));
        $opis_uslugi = $sql['opis_uslugi'];
        
        if($opis_uslugi)
        {
            //zmieniamy cene dla kazdego klienta
            $ins=mysqli_query($conn, "update klienci set ".$opis_uslugi."=".$nowa_cena.";");
        }

    // echo 'id_ceny='.$id_ceny.'<br>';
    // echo 'opis_uslugi='.$opis_uslugi.'<br>';
    // echo 'nowa_cena='.$nowa_cena.'<br>';
	echo '<div class="text_duzy_niebieski" align="center">Cenink osobisty został zmieniony dla każdego klienta.</div><br>';
    $id_ceny = '';
	}


if($id_ceny == "") $napis_zmien = 'Zmień'; else $napis_zmien = '';

$i = 0;
$opis = [];
$cena = [];
$id_cennik = [];
$pytanie = mysqli_query($conn, "SELECT * FROM cennik_osobisty ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$opis[$i]=$wynik['opis'];
	$cena[$i]=$wynik['cena'];
	$id_cennik[$i]=$wynik['id'];
	$cena[$i] = number_format($cena[$i], 2,'.','');
	}
		
	echo '<table border="0" align="center" cellpadding="5px" cellspacing="5px">';
	echo '<INPUT type="hidden" name="ilosc" value="'.$i.'">';
	$z=0;
		for ($x=1; $x<=$i; $x++)
			{
			if($z == 4) 
				{
				$z = 0;
				echo '<tr class="text" align="right"><td width="100%" colspan="3">&nbsp;</td></tr>';
				}
			$z++;
			$cenka = 'cenka['.$x.']';		
            if($id_ceny == $id_cennik[$x]) 
            {
                echo '<FORM action="index.php?page=ustawienia_cennik_osobisty&zmiana_danych=1&id_ceny='.$id_ceny.'" method="post">';

                echo '<tr class="text" align="right"><td width="340px">'.$opis[$x].' :</td><td align="left" width="100px"><input type="text" size="8" maxlength="10" class="pole_input_edycja" autocomplete="off" name="nowa_cena" value="'.$cena[$x].'"> zł</td><td width="100px" align="left"><a href="index.php?page=ustawienia_cennik_osobisty&id_ceny='.$id_cennik[$x].'"><INPUT type="submit" class="text" name="submit" value="Zapisz"></a></td></tr>';
                echo '</form>';

            }
            else  echo '<tr class="text" align="right"><td width="340px">'.$opis[$x].' :</td><td align="left" width="100px">'.$cena[$x].' zł</td><td width="100px" align="left"><a href="index.php?page=ustawienia_cennik_osobisty&id_ceny='.$id_cennik[$x].'">'.$napis_zmien.'</a></td></tr>';
			
        
            }
		
	echo '</table>';

echo '</td></tr></table>';
?>