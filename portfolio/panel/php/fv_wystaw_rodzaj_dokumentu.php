<?php	
if($rodzaj_dokumentu == 'faktura') $gdzie = 'fv_wystaw';
if($rodzaj_dokumentu == 'proforma') $gdzie = 'fv_wystaw_proforme';
if($rodzaj_dokumentu == 'proforma_euro') $gdzie = 'fv_wystaw_proforme_euro';

if($rodzaj_dokumentu != '') echo '<meta http-equiv="refresh" content="0.1; URL=index.php?page='.$gdzie.'&zamowienie_id='.$zamowienie_id.'&id_zlec_transp='.$id_zlec_transp.'&jak='.$jak.'&wg_czego='.$wg_czego.'&skad='.$skad.'">';
else
	{
	$pytanie = mysqli_query($conn, "SELECT kurs_euro FROM zamowienia WHERE id=$zamowienie_id;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$kurs_euro = $wynik['kurs_euro'];
		}

	echo '<FORM action="index.php?page=fv_wystaw_rodzaj_dokumentu" method="post">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	echo '<input type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
		
	if(($kurs_euro != '') && ($kurs_euro != 0))
		{
		echo '<table border="0" width="20%" align="center" class="text_duzy" cellspacing="5" cellpadding="5">';
		echo '<tr><td width="100%" align="center" colspan="2">WYBIERZ RODZAJ DOKUMENTU</td></tr>';
		echo '<tr><td width="5%" align="center"><input type="radio" name="rodzaj_dokumentu" value="faktura" checked></td><td width="95%" align="left">FAKTURA PLN</td></tr>';
		echo '<tr><td width="5%" align="center"><input type="radio" name="rodzaj_dokumentu" value="proforma_euro"></td><td width="95%" align="left">PROFORMA EURO</td></tr>';
		echo '<tr><td width="100%" align="center" colspan="2"><input type="submit" name="submit" value="Dalej"></td></tr>';
		echo '</table>';
		}
	else
		{
		echo '<table border="0" width="20%" align="center" class="text_duzy" cellspacing="5" cellpadding="5">';
		echo '<tr><td width="100%" align="center" colspan="2">WYBIERZ RODZAJ DOKUMENTU</td></tr>';
		echo '<tr><td width="5%" align="center"><input type="radio" name="rodzaj_dokumentu" value="faktura" checked></td><td width="95%" align="left">FAKTURA</td></tr>';
		echo '<tr><td width="5%" align="center"><input type="radio" name="rodzaj_dokumentu" value="proforma"></td><td width="95%" align="left">PROFORMA</td></tr>';
		echo '<tr><td width="100%" align="center" colspan="2"><input type="submit" name="submit" value="Dalej"></td></tr>';
		echo '</table>';
		}

	echo '</form>';
	}
?>