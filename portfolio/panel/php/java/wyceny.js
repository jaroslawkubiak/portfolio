function Skopiuj_date_faktury() {
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;

  var pozycja_transport = document.getElementById("id_pozycja_transport").value;
  if (pozycja_transport == "tak") ilosc_pozycji++;

  var data_faktury = document.getElementById("id_data_faktury_1").value;

  for (var x = 2; x <= ilosc_pozycji; x++) {
    var data_faktury_temp = document.getElementById(
      "id_data_faktury_" + x
    ).value;
    //alert('poz '+x+' = '+data_faktury_temp);
    if (data_faktury_temp == "")
      document.getElementById("id_data_faktury_" + x).value = data_faktury;
  }
}

function Skopiuj_nr_faktury() {
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;

  var pozycja_transport = document.getElementById("id_pozycja_transport").value;
  if (pozycja_transport == "tak") ilosc_pozycji++;

  var nr_faktury = document.getElementById("id_nr_faktury_1").value;

  if (nr_faktury == "") document.getElementById("id_data_faktury_1").value = "";

  for (var x = 2; x <= ilosc_pozycji; x++) {
    var numer_faktury = document.getElementById("id_nr_faktury_" + x).value;
    //alert('poz '+x+' = '+numer_faktury);
    if (numer_faktury == "")
      document.getElementById("id_nr_faktury_" + x).value = nr_faktury;
  }
}

function Skasuj_date_faktury(pozycja) {
  var nr_faktury = document.getElementById("id_nr_faktury_" + pozycja).value;

  if (nr_faktury == "")
    document.getElementById("id_data_faktury_" + pozycja).value = "";
}

function ObliczSumeNetto() {
  var temp = 0;
  document.getElementById("id_suma_netto").value = temp;
  var suma_netto = 0;
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;
  for (var x = 1; x <= ilosc_pozycji; x++) {
    var wart_netto = document.getElementById("id_wartosc_netto_" + x).value;
    if (wart_netto != 0) {
      suma_netto = Number(suma_netto) + Number(wart_netto);
      var result = suma_netto.toFixed(2);
      document.getElementById("id_suma_netto").value = result;
    }
  }

  // pobieram i dodaj wartosc netto pozycji transportowej
  var wartosc_netto_pozycja_transport = document.getElementById(
    "id_wartosc_netto_pozycja_transport"
  ).value;
  if (wartosc_netto_pozycja_transport != 0) {
    var suma_netto = document.getElementById("id_suma_netto").value;

    suma_netto = Number(suma_netto) + Number(wartosc_netto_pozycja_transport);
    var result = suma_netto.toFixed(2);
    document.getElementById("id_suma_netto").value = result;
  }
}

function ObliczSumeBrutto() {
  //alert('brutto');
  var temp = 0;
  document.getElementById("id_suma_brutto").value = temp;
  var suma_brutto = 0;
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;

  for (var x = 1; x <= ilosc_pozycji; x++) {
    var wart_brutto = document.getElementById("id_wartosc_brutto_" + x).value;
    if (wart_brutto != 0) {
      suma_brutto = Number(suma_brutto) + Number(wart_brutto);
      var result = suma_brutto.toFixed(2);
      document.getElementById("id_suma_brutto").value = result;
    }
  }

  // pobieram i dodaj wartosc brutto pozycji transportowej
  var wartosc_brutto_pozycja_transport = document.getElementById(
    "id_wartosc_brutto_pozycja_transport"
  ).value;
  if (wartosc_brutto_pozycja_transport != 0) {
    var suma_brutto = document.getElementById("id_suma_brutto").value;

    suma_brutto =
      Number(suma_brutto) + Number(wartosc_brutto_pozycja_transport);
    var result = suma_brutto.toFixed(2);
    document.getElementById("id_suma_brutto").value = result;
  }
}

function ObliczWartoscBrutto() {
  // alert('ObliczWartoscBrutto');
  var wartosc_brutto = 0;
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;

  for (var x = 1; x <= ilosc_pozycji; x++) {
    var wartosc_netto = document.getElementById("id_wartosc_netto_" + x).value;
    var vat = document.getElementById("id_vat_" + x).value;
    if (vat == "NP") vat = 0;
    wartosc_brutto =
      Number(wartosc_netto) + (Number(wartosc_netto) * Number(vat)) / 100;
    var result = wartosc_brutto.toFixed(2);
    document.getElementById("id_wartosc_brutto_" + x).value = result;
  }
  ObliczSumeNetto();
  ObliczSumeBrutto();
}

function CzyMoznaZapisac() {
//   console.log("CzyMoznaZapisac()");
  //sprawdzamy czy robimy edycje wyceny czy korekte fv
  let status = document.getElementById("status").value;

  var sprawdz = document.getElementById("sprawdz").value;
  if (sprawdz == "tak") {
    var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
    var ilosc_pozycji = ilosc_pozycjiInput.value;
    var zapisz = 0;
    var zapisywac = ilosc_pozycji * 2;
    for (var x = 1; x <= ilosc_pozycji; x++) {
      var ilosc = document.getElementById("id_ilosc_sztuk_" + x).value;
      var produkt = document.getElementById("id_nazwa_produktu_" + x).value;
      //alert('ilosc='+ilosc+', produkt='+produkt);
      if (ilosc != 0) zapisz = zapisz + 1;
      if (produkt != 0) zapisz = zapisz + 1;
    }

    if (zapisz == zapisywac && status != "Dostarczone") {
      document.getElementById("zapisz1").removeAttribute("disabled");
      document.getElementById("zapisz2").removeAttribute("disabled");
      document.getElementById("zapisz3").removeAttribute("disabled");
      document.getElementById("zapisz4").removeAttribute("disabled");
    } else {
      document.getElementById("zapisz1").setAttribute("disabled", "disabled");
      document.getElementById("zapisz2").setAttribute("disabled", "disabled");
      document.getElementById("zapisz3").setAttribute("disabled", "disabled");
      document.getElementById("zapisz4").setAttribute("disabled", "disabled");
    }
  }
}
CzyMoznaZapisac();

function ObliczNettoZaSztuke() {
  // alert('ObliczNettoZaSztuke');
  var suma = 0;
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;

  for (var x = 1; x <= ilosc_pozycji; x++) {
    var ilosc = document.getElementById("id_ilosc_sztuk_" + x).value;
    var suma = document.getElementById("id_wartosc_netto_" + x).value;
    if (ilosc != 0) {
      cenazasztuke = Number(suma) / Number(ilosc);
      var result = cenazasztuke.toFixed(2);
      document.getElementById("id_cena_netto_za_sztuke_" + x).value = result;
    }
  }
  CzyMoznaZapisac();
}

function ObliczWartoscNetto() {
  // alert('func = ObliczWartoscNetto');
  var wartosc_netto = 0;
  var ilosc_pozycjiInput = document.getElementById("id_ilosc_pozycji");
  var ilosc_pozycji = ilosc_pozycjiInput.value;
  var pozycja_transportInput = document.getElementById("id_pozycja_transport");
  var pozycja_transport = pozycja_transportInput.value;

  for (var x = 1; x <= ilosc_pozycji; x++) {
    var wart1 = document.getElementById(
      "id_wygiecie_ramy_z_pvc_wartosc_" + x
    ).value;
    var wart2 = document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_wartosc_" + x
    ).value;
    var wart3 = document.getElementById(
      "id_wygiecie_listwy_z_pvc_wartosc_" + x
    ).value;
    var wart4 = document.getElementById(
      "id_wygiecie_innego_elementu_z_pvc_wartosc_" + x
    ).value;

    var wart5 = document.getElementById(
      "id_wygiecie_ramy_z_alu_wartosc_" + x
    ).value;
    var wart6 = document.getElementById(
      "id_wygiecie_skrzydla_z_alu_wartosc_" + x
    ).value;
    var wart7 = document.getElementById(
      "id_wygiecie_listwy_z_alu_wartosc_" + x
    ).value;
    var wart8 = document.getElementById(
      "id_wygiecie_innego_elementu_z_alu_wartosc_" + x
    ).value;

    var wart9 = document.getElementById(
      "id_wygiecie_wzmocnienia_okiennego_wartosc_" + x
    ).value;
    var wart10 = document.getElementById(
      "id_wygiecie_innego_elementu_ze_stali_wartosc_" + x
    ).value;

    var wart11 = document.getElementById("id_zgrzanie_wartosc_" + x).value;
    var wart12 = document.getElementById(
      "id_wyfrezowanie_odwodnienia_wartosc_" + x
    ).value;
    var wart13 = document.getElementById(
      "id_wstawienie_slupka_wartosc_" + x
    ).value;
    var wart42 = document.getElementById(
      "id_wstawienie_slupka_ruchomego_wartosc_" + x
    ).value;
    var wart14 = document.getElementById(
      "id_dociecie_listwy_przyszybowej_wartosc_" + x
    ).value;
    var wart43 = document.getElementById(
      "id_dociecie_kompletu_listew_przyszybowych_wartosc_" + x
    ).value;
    var wart15 = document.getElementById("id_okucie_wartosc_" + x).value;
    var wart16 = document.getElementById("id_zaszklenie_wartosc_" + x).value;
    var wart17 = document.getElementById(
      "id_wykonanie_innej_uslugi_wartosc_" + x
    ).value;

    var wart18 = document.getElementById("id_oscieznica_wartosc_" + x).value;
    var wart19 = document.getElementById("id_skrzydlo_wartosc_" + x).value;
    var wart20 = document.getElementById("id_listwa_wartosc_" + x).value;
    var wart21 = document.getElementById("id_slupek_wartosc_" + x).value;
    var wart22 = document.getElementById(
      "id_wzmocnienie_do_ramy_wartosc_" + x
    ).value;
    var wart23 = document.getElementById(
      "id_wzmocnienie_do_skrzydla_wartosc_" + x
    ).value;
    var wart24 = document.getElementById(
      "id_wzmocnienie_do_slupka_wartosc_" + x
    ).value;
    var wart25 = document.getElementById(
      "id_wzmocnienie_do_luku_wartosc_" + x
    ).value;
    var wart26 = document.getElementById("id_okucia_wartosc_" + x).value;
    var wart27 = document.getElementById("id_szyby_wartosc_" + x).value;
    var wart28 = document.getElementById("id_inny_element_wartosc_" + x).value;

    var wart29 = document.getElementById("id_okna_wartosc_" + x).value;
    var wart30 = document.getElementById(
      "id_drzwi_wewnetrzne_wartosc_" + x
    ).value;
    var wart31 = document.getElementById(
      "id_drzwi_zewnetrzne_wartosc_" + x
    ).value;
    var wart32 = document.getElementById("id_bramy_wartosc_" + x).value;
    var wart33 = document.getElementById("id_parapety_wartosc_" + x).value;
    var wart34 = document.getElementById("id_montaz_wartosc_" + x).value;
    var wart35 = document.getElementById("id_moskitiery_wartosc_" + x).value;
    var wart36 = document.getElementById(
      "id_rolety_wewnetrzne_wartosc_" + x
    ).value;
    var wart37 = document.getElementById(
      "id_rolety_zewnetrzne_wartosc_" + x
    ).value;

    var wart38 = document.getElementById("id_odpady_z_pvc_wartosc_" + x).value;
    var wart39 = document.getElementById(
      "id_odpady_ze_stali_wartosc_" + x
    ).value;
    var wart40 = document.getElementById("id_transport_wartosc_" + x).value;
    var wart41 = document.getElementById("id_inne_wartosc_" + x).value;
    wartosc_netto =
      Number(wart1) +
      Number(wart2) +
      Number(wart3) +
      Number(wart4) +
      Number(wart5) +
      Number(wart6) +
      Number(wart7) +
      Number(wart8) +
      Number(wart9) +
      Number(wart10) +
      Number(wart11) +
      Number(wart12) +
      Number(wart13) +
      Number(wart14) +
      Number(wart15) +
      Number(wart16) +
      Number(wart17) +
      Number(wart18) +
      Number(wart19) +
      Number(wart20) +
      Number(wart21) +
      Number(wart22) +
      Number(wart23) +
      Number(wart24) +
      Number(wart25) +
      Number(wart26) +
      Number(wart27) +
      Number(wart28) +
      Number(wart29) +
      Number(wart30) +
      Number(wart31) +
      Number(wart32) +
      Number(wart33) +
      Number(wart34) +
      Number(wart35) +
      Number(wart36) +
      Number(wart37) +
      Number(wart38) +
      Number(wart39) +
      Number(wart40) +
      Number(wart41) +
      Number(wart42) +
      Number(wart43);

    var result = wartosc_netto.toFixed(2);
    document.getElementById("id_wartosc_netto_" + x).value = result;
  }
  ObliczNettoZaSztuke();
  ObliczWartoscBrutto();
}

function ObliczWartoscNettoPozycjaTransport() {
  //alert('func = ObliczWartoscNettoPozycjaTransport');
  var iloscInput = document.getElementById("id_pozycja_transport_wartosc");
  var ilosc = iloscInput.value;
  ilosc = String(ilosc);
  ilosc = ilosc.replace(",", ".");
  iloscInput.value = ilosc;
  document.getElementById("id_pozycja_transport_wartosc").value = ilosc;

  var wartosc_netto = 0;
  var wart_transp = document.getElementById(
    "id_pozycja_transport_wartosc"
  ).value;
  wartosc_netto = Number(wart_transp);

  var result = wartosc_netto.toFixed(2);
  document.getElementById("id_wartosc_netto_pozycja_transport").value = result;
  var wartosc_brutto = 0;
  var wartosc_netto = document.getElementById(
    "id_wartosc_netto_pozycja_transport"
  ).value;

  var vat = document.getElementById("id_vat_pozycja_transport").value;
  if (vat == "NP") vat = 0;
  wartosc_brutto =
    Number(wartosc_netto) + (Number(wartosc_netto) * Number(vat)) / 100;
  var result = wartosc_brutto.toFixed(2);
  document.getElementById("id_wartosc_brutto_pozycja_transport").value = result;

  ObliczSumeNetto();
  ObliczSumeBrutto();
  CzyMoznaZapisac();
}

function Zamien_przecinek_odpady_z_pvc() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_odpady_z_pvc_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_odpady_z_pvc_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_odpady_ze_stali() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_odpady_ze_stali_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_odpady_ze_stali_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_transport() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_transport_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_transport_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_inne() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_inne_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_inne_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_okna() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_okna_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_okna_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_drzwi_wewnetrzne() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_drzwi_wewnetrzne_wartosc_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_drzwi_wewnetrzne_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_drzwi_zewnetrzne() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_drzwi_zewnetrzne_wartosc_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_drzwi_zewnetrzne_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_bramy() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_bramy_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_bramy_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_parapety() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_parapety_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_parapety_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_montaz() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_montaz_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_montaz_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_moskitiery() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_moskitiery_wartosc_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_moskitiery_wartosc_" + i).value = ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_rolety_wewnetrzne() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_rolety_wewnetrzne_wartosc_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_rolety_wewnetrzne_wartosc_" + i).value =
        ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Zamien_przecinek_rolety_zewnetrzne() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_rolety_zewnetrzne_wartosc_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;
      document.getElementById("id_rolety_zewnetrzne_wartosc_" + i).value =
        ilosc;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}
//############################################################################################################################################################################################################################
//##############################################################################################################################################################################################################################################
//###############################################################################################################################################################################################################################################

function Sprawdz_czy_kopiowac_wzmocnienie_okienne(pozycja) {
  var korekta = document.getElementById("czy_to_korekta").value;

  //  alert('korekta=' + korekta);
  //to wykonujemy tylko w przypadku normalnych wycen, nie w przypadku korekty
  if (korekta != "tak") {
    if (
      document.getElementById(
        "id_wygiecie_wzmocnienia_okiennego_ptaszek_" + pozycja
      ).checked
    )
      return true;
    else return false;
  } else return false;
}

function Oblicz_wygiecie_ramy_z_pvc(pozycja, ilosc_pozycj) {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_ramy_z_pvc_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_ramy_" + i);
    var korekta = document.getElementById("czy_to_korekta").value;

    //  alert('korekta=' + korekta);
    //to wykonujemy tylko w przypadku normalnych wycen, nie w przypadku korekty
    if (korekta != "tak") {
      //spr czy mamy to kopiowac do skrzydla
      if (
        document.getElementById("id_wygiecie_skrzydla_ptaszek_" + pozycja)
          .checked
      ) {
        var ilosc_mInput = document.getElementById(
          "id_wygiecie_ramy_z_pvc_ilosc_m_" + pozycja
        );
        var ilosc_m = ilosc_mInput.value;
        ilosc_m = String(ilosc_m);
        ilosc_m = ilosc_m.replace(",", ".");
        ilosc_mInput.value = ilosc_m;

        var cena_skrzydlaInput = document.getElementById(
          "id_cena_skrzydla_" + pozycja
        );
        var cena_skrzydla = cena_skrzydlaInput.value;
        cena_skrzydla = String(cena_skrzydla);
        cena_skrzydla = cena_skrzydla.replace(",", ".");
        cena_skrzydlaInput.value = cena_skrzydla;

        var result_wartosc = cena_skrzydla * ilosc_m;
        result_wartosc = result_wartosc.toFixed(2);
        document.getElementById(
          "id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja
        ).value = ilosc_m;
        document.getElementById(
          "id_wygiecie_skrzydla_z_pvc_wartosc_" + pozycja
        ).value = result_wartosc;
        //dajemy atrybuty tylko do odczytu
        document
          .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja)
          .setAttribute("readonly", "readonly");
        document
          .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja)
          .setAttribute("readonly", "readonly");
      }
      //spr czy mamy to kopiowac do listwy
      if (
        document.getElementById("id_wygiecie_listwy_ptaszek_" + pozycja).checked
      ) {
        var ilosc_mInput = document.getElementById(
          "id_wygiecie_ramy_z_pvc_ilosc_m_" + pozycja
        );
        var ilosc_m = ilosc_mInput.value;
        ilosc_m = String(ilosc_m);
        ilosc_m = ilosc_m.replace(",", ".");
        ilosc_mInput.value = ilosc_m;

        var cena_listwyInput = document.getElementById(
          "id_cena_listwy_" + pozycja
        );
        var cena_listwy = cena_listwyInput.value;
        cena_listwy = String(cena_listwy);
        cena_listwy = cena_listwy.replace(",", ".");
        cena_listwyInput.value = cena_listwy;

        var result_wartosc = cena_listwy * ilosc_m;
        result_wartosc = result_wartosc.toFixed(2);
        document.getElementById(
          "id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja
        ).value = ilosc_m;
        document.getElementById(
          "id_wygiecie_listwy_z_pvc_wartosc_" + pozycja
        ).value = result_wartosc;
        //dajemy atrybuty tylko do odczytu
        document
          .getElementById("id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja)
          .setAttribute("readonly", "readonly");
        document
          .getElementById("id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja)
          .setAttribute("readonly", "readonly");
      }
    }

    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wygiecie_ramy_z_pvc_wartosc_" + i).value =
        result;

      var wynik = Sprawdz_czy_kopiowac_wzmocnienie_okienne(pozycja);
      if (wynik == true && pozycja == i) {
        // alert("zaznaczony");
        //###############################################################################################################################################################################################################################
        // dodaj wygicie ramy z pvc (metry) i wygicie skrzyda z pvc (metry) wpisywana jest do wygicie wzmocnienia okiennego (metry) oraz do materiau wzmocnienie do ukw (ilo)
        //automatycznie dodawao dugo "wygicie ramy z pvc" + "wygicie skrzyda z pvc" i t warto wpisywao do "wygicie wzmocnienia okiennego" i do materiaw "wzmocnienie do ukw".
        var ilosc_skrzydloInput = document.getElementById(
          "id_wygiecie_skrzydla_z_pvc_ilosc_m_" + i
        );
        var ilosc_skrzydlo = ilosc_skrzydloInput.value;
        ilosc_skrzydlo = String(ilosc_skrzydlo);
        ilosc_skrzydlo = ilosc_skrzydlo.replace(",", ".");
        ilosc_skrzydloInput.value = ilosc_skrzydlo;
        //alert("ilosc_skrzydlo="+ilosc_skrzydlo);
        var num2 = Number(ilosc) + Number(ilosc_skrzydlo);
        var result = num2.toFixed(2);
        document.getElementById(
          "id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + i
        ).value = result;
        document.getElementById("id_wzmocnienie_do_luku_ilosc_m_" + i).value =
          result;

        var cenaInput = document.getElementById(
          "id_cena_wzmocnienia_okiennego_" + i
        );
        var cena = cenaInput.value;
        cena = String(cena);
        cena = cena.replace(",", ".");
        cenaInput.value = cena;
        //alert('ilosc='+result+' cena='+cena);
        var num = result * cena;
        var result_wygiecie_wzmocnienia_okiennego = num.toFixed(2);
        document.getElementById(
          "id_wygiecie_wzmocnienia_okiennego_wartosc_" + i
        ).value = result_wygiecie_wzmocnienia_okiennego;

        var cenaInput = document.getElementById(
          "id_cena_wzmocnienie_do_luku_" + i
        );
        var cena = cenaInput.value;
        cena = String(cena);
        cena = cena.replace(",", ".");
        cenaInput.value = cena;
        var num = result * cena;
        var result_wzmocnienie_do_luku = num.toFixed(2);
        document.getElementById("id_wzmocnienie_do_luku_wartosc_" + i).value =
          result_wzmocnienie_do_luku;

        //dajemy atrybuty tylko do odczytu
        document
          .getElementById(
            "id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + pozycja
          )
          .setAttribute("readonly", "readonly");
        document
          .getElementById(
            "id_wygiecie_wzmocnienia_okiennego_ilosc_szt_" + pozycja
          )
          .setAttribute("readonly", "readonly");
        document
          .getElementById("id_wzmocnienie_do_luku_ilosc_m_" + pozycja)
          .setAttribute("readonly", "readonly");

        // koniec     #########################################################################################################################################################################################################
        //###############################################################################################################################################################################################################################
      }
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

// kopiujemy sztuki z wygiecia ramy i wygiecia skrzydła do wygiecia wzmocnienia okiennego
function Oblicz_sztuki_wygiecie_wzmocnienia_okiennego(pozycja, ilosc_pozycji) {
  var korekta = document.getElementById("czy_to_korekta").value;

  //  alert('korekta=' + korekta);
  //to wykonujemy tylko w przypadku normalnych wycen, nie w przypadku korekty
  if (korekta != "tak") {
    //spr czy mamy to kopiowac do skrzydla
    if (
      document.getElementById("id_wygiecie_skrzydla_ptaszek_" + pozycja).checked
    ) {
      // alert(document.getElementById('id_wygiecie_skrzydla_ptaszek_'+pozycja).checked);
      var ilosc_sztInput = document.getElementById(
        "id_wygiecie_ramy_z_pvc_ilosc_szt_" + pozycja
      );
      var ilosc_szt = ilosc_sztInput.value;
      ilosc_szt = String(ilosc_szt);
      ilosc_szt = ilosc_szt.replace(",", ".");
      ilosc_sztInput.value = ilosc_szt;

      document.getElementById(
        "id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja
      ).value = ilosc_szt;
      //dajemy atrybuty tylko do odczytu
      document
        .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja)
        .setAttribute("readonly", "readonly");
      document
        .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja)
        .setAttribute("readonly", "readonly");
    }

    //spr czy mamy to kopiowac do listwy
    if (
      document.getElementById("id_wygiecie_listwy_ptaszek_" + pozycja).checked
    ) {
      var ilosc_sztInput = document.getElementById(
        "id_wygiecie_ramy_z_pvc_ilosc_szt_" + pozycja
      );
      var ilosc_szt = ilosc_sztInput.value;
      ilosc_szt = String(ilosc_szt);
      ilosc_szt = ilosc_szt.replace(",", ".");
      ilosc_sztInput.value = ilosc_szt;

      document.getElementById(
        "id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja
      ).value = ilosc_szt;
      //dajemy atrybuty tylko do odczytu
      document
        .getElementById("id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja)
        .setAttribute("readonly", "readonly");
      document
        .getElementById("id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja)
        .setAttribute("readonly", "readonly");
    }

    //Zaznaczenie_checkboxa_wzmocnienie_okienne(pozycja, ilosc_pozycj);
    var wynik_checkbox = Sprawdz_czy_kopiowac_wzmocnienie_okienne(pozycja);
    if (wynik_checkbox == true) {
      // alert("zaznaczyles kopiowanie wzmocnienia");
      var ilosc_ramyInput = document.getElementById(
        "id_wygiecie_ramy_z_pvc_ilosc_szt_" + pozycja
      );
      var ilosc_skrzydlaInput = document.getElementById(
        "id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja
      );

      var ilosc_ramy = ilosc_ramyInput.value;
      ilosc_ramy = String(ilosc_ramy);
      ilosc_ramy = ilosc_ramy.replace(",", ".");
      ilosc_ramyInput.value = ilosc_ramy;

      var ilosc_skrzydla = ilosc_skrzydlaInput.value;
      ilosc_skrzydla = String(ilosc_skrzydla);
      ilosc_skrzydla = ilosc_skrzydla.replace(",", ".");
      ilosc_skrzydlaInput.value = ilosc_skrzydla;

      var wynik = Number(ilosc_skrzydla) + Number(ilosc_ramy);
      var result = wynik.toFixed(2);
      document.getElementById(
        "id_wygiecie_wzmocnienia_okiennego_ilosc_szt_" + pozycja
      ).value = result;

      Oblicz_wygiecie_ramy_z_pvc(pozycja);
      // po tym juz nic nie dawac, bo przerywa dzialanie
    } else {
      // alert("odznaczyles kopiowanie wzmocnienia");
      //tutaj wykasujemy wszystkie wartosci, bo odznaczylismy checkboxa
      var num = 0;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + pozycja
      ).value = result;
      document.getElementById(
        "id_wygiecie_wzmocnienia_okiennego_ilosc_szt_" + pozycja
      ).value = result;
      document.getElementById(
        "id_wygiecie_wzmocnienia_okiennego_wartosc_" + pozycja
      ).value = result;
      document.getElementById(
        "id_wzmocnienie_do_luku_ilosc_m_" + pozycja
      ).value = result;
      document.getElementById(
        "id_wzmocnienie_do_luku_wartosc_" + pozycja
      ).value = result;
    }
  }
}

// Oblicz_sztuki_wygiecie_wzmocnienia_okiennego(pozycja, ilosc_pozycji);
// Oblicz_wygiecie_ramy_z_pvc(pozycja);
function Zaznaczenie_checkboxa_wzmocnienie_okienne(pozycja, ilosc_pozycji) {
  // alert("zaznaczyles poz=" + pozycja + ", ilosc pozycji=" + ilosc_pozycji);
  var wynik_checkbox = Sprawdz_czy_kopiowac_wzmocnienie_okienne(pozycja);
  if (wynik_checkbox == true) {
    //dajemy atrybuty tylko do odczytu
    document
      .getElementById("id_wzmocnienie_do_luku_ilosc_m_" + pozycja)
      .setAttribute("readonly", "readonly");
    document
      .getElementById("id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + pozycja)
      .setAttribute("readonly", "readonly");
    document
      .getElementById("id_wygiecie_wzmocnienia_okiennego_ilosc_szt_" + pozycja)
      .setAttribute("readonly", "readonly");
    Oblicz_sztuki_wygiecie_wzmocnienia_okiennego(pozycja, ilosc_pozycji);
    Oblicz_wygiecie_ramy_z_pvc(pozycja);
    // po tym juz nic nie dawac, bo przerywa dzialanie
  } else {
    // alert("odznaczyles");
    //tutaj wykasujemy wszystkie wartosci, bo odznaczylismy checkboxa
    var num = 0;
    var result = num.toFixed(2);
    document.getElementById(
      "id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + pozycja
    ).value = result;
    document.getElementById(
      "id_wygiecie_wzmocnienia_okiennego_ilosc_szt_" + pozycja
    ).value = result;
    document.getElementById(
      "id_wygiecie_wzmocnienia_okiennego_wartosc_" + pozycja
    ).value = result;
    document.getElementById("id_wzmocnienie_do_luku_ilosc_m_" + pozycja).value =
      result;
    document.getElementById("id_wzmocnienie_do_luku_wartosc_" + pozycja).value =
      result;
    //sciagamy atrybuty tylko do odczytu
    document
      .getElementById("id_wzmocnienie_do_luku_ilosc_m_" + pozycja)
      .removeAttribute("readonly");
    document
      .getElementById("id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + pozycja)
      .removeAttribute("readonly");
    document
      .getElementById("id_wygiecie_wzmocnienia_okiennego_ilosc_szt_" + pozycja)
      .removeAttribute("readonly");
  }
}

function Zaznaczenie_checkboxa_wygiecie_listwy(pozycja, ilosc_pozycji) {
  if (
    document.getElementById("id_wygiecie_listwy_ptaszek_" + pozycja).checked
  ) {
    // alert("zaznaczyles, poz=" + pozycja + ", dla wygiecie listwy");
    //dajemy atrybuty tylko do odczytu
    document
      .getElementById("id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja)
      .setAttribute("readonly", "readonly");
    document
      .getElementById("id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja)
      .setAttribute("readonly", "readonly");

    var ilosc_mInput = document.getElementById(
      "id_wygiecie_ramy_z_pvc_ilosc_m_" + pozycja
    );
    var ilosc_sztInput = document.getElementById(
      "id_wygiecie_ramy_z_pvc_ilosc_szt_" + pozycja
    );

    var ilosc_m = ilosc_mInput.value;
    ilosc_m = String(ilosc_m);
    ilosc_m = ilosc_m.replace(",", ".");
    ilosc_mInput.value = ilosc_m;
    var ilosc_szt = ilosc_sztInput.value;
    ilosc_szt = String(ilosc_szt);
    ilosc_szt = ilosc_szt.replace(",", ".");
    ilosc_sztInput.value = ilosc_szt;

    var cena_listwyInput = document.getElementById("id_cena_listwy_" + pozycja);
    var cena_listwy = cena_listwyInput.value;
    cena_listwy = String(cena_listwy);
    cena_listwy = cena_listwy.replace(",", ".");
    cena_listwyInput.value = cena_listwy;

    var result_wartosc = cena_listwy * ilosc_m;
    result_wartosc = result_wartosc.toFixed(2);
    document.getElementById(
      "id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja
    ).value = ilosc_szt;
    document.getElementById(
      "id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja
    ).value = ilosc_m;
    document.getElementById(
      "id_wygiecie_listwy_z_pvc_wartosc_" + pozycja
    ).value = result_wartosc;
  } else {
    // alert("odznaczyles, poz=" + pozycja + ", dla wygiecie listwy");
    //tutaj wykasujemy wszystkie wartosci, bo odznaczylismy checkboxa
    var num = 0;
    var result = num.toFixed(2);
    document.getElementById(
      "id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja
    ).value = result;
    document.getElementById(
      "id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja
    ).value = result;
    document.getElementById(
      "id_wygiecie_listwy_z_pvc_wartosc_" + pozycja
    ).value = result;
    //sciagamy atrybuty tylko do odczytu
    document
      .getElementById("id_wygiecie_listwy_z_pvc_ilosc_m_" + pozycja)
      .removeAttribute("readonly");
    document
      .getElementById("id_wygiecie_listwy_z_pvc_ilosc_szt_" + pozycja)
      .removeAttribute("readonly");
  }
}

function Oblicz_wygiecie_skrzydla_z_pvc(pozycja) {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_skrzydla_" + i);
    var ilosc_ramyInput = document.getElementById(
      "id_wygiecie_ramy_z_pvc_ilosc_m_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var ilosc_ramy = ilosc_ramyInput.value;
      ilosc_ramy = String(ilosc_ramy);
      ilosc_ramy = ilosc_ramy.replace(",", ".");
      ilosc_ramyInput.value = ilosc_ramy;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wygiecie_skrzydla_z_pvc_wartosc_" + i).value =
        result;

      var wynik = Sprawdz_czy_kopiowac_wzmocnienie_okienne(pozycja);
      if (wynik == true && pozycja == i) {
        //###############################################################################################################################################################################################################################
        // dodaj wygicie ramy z pvc (metry) i wygicie skrzyda z pvc (metry) wpisywana jest do wygicie wzmocnienia okiennego (metry) oraz do materiau wzmocnienie do ukw (ilo)
        var licz = Number(ilosc) + Number(ilosc_ramy);
        var result2 = licz.toFixed(2);
        document.getElementById(
          "id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + i
        ).value = result2;
        document.getElementById("id_wzmocnienie_do_luku_ilosc_m_" + i).value =
          result2;

        var cenaInput = document.getElementById(
          "id_cena_wzmocnienie_do_luku_" + i
        );
        var cena = cenaInput.value;
        cena = String(cena);
        cena = cena.replace(",", ".");
        cenaInput.value = cena;
        var num = result2 * cena;
        var result = num.toFixed(2);
        document.getElementById("id_wzmocnienie_do_luku_wartosc_" + i).value =
          result;

        var cenaInput = document.getElementById(
          "id_cena_wzmocnienia_okiennego_" + i
        );
        var cena = cenaInput.value;
        cena = String(cena);
        cena = cena.replace(",", ".");
        cenaInput.value = cena;
        var num = result2 * cena;
        var result = num.toFixed(2);
        document.getElementById(
          "id_wygiecie_wzmocnienia_okiennego_wartosc_" + i
        ).value = result;
        // koniec
        //###############################################################################################################################################################################################################################
      }

      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

// Oblicz_sztuki_wygiecie_wzmocnienia_okiennego(pozycja, ilosc_pozycji);
// Oblicz_wygiecie_ramy_z_pvc(pozycja);
function Zaznaczenie_checkboxa_wygiecie_skrzydla(pozycja, ilosc_pozycji) {
  if (
    document.getElementById("id_wygiecie_skrzydla_ptaszek_" + pozycja).checked
  ) {
    // alert("zaznaczyles, poz=" + pozycja + ", dla wygiecie skrzydla");
    //dajemy atrybuty tylko do odczytu
    document
      .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja)
      .setAttribute("readonly", "readonly");
    document
      .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja)
      .setAttribute("readonly", "readonly");

    var ilosc_mInput = document.getElementById(
      "id_wygiecie_ramy_z_pvc_ilosc_m_" + pozycja
    );
    var ilosc_sztInput = document.getElementById(
      "id_wygiecie_ramy_z_pvc_ilosc_szt_" + pozycja
    );

    var ilosc_m = ilosc_mInput.value;
    ilosc_m = String(ilosc_m);
    ilosc_m = ilosc_m.replace(",", ".");
    ilosc_mInput.value = ilosc_m;
    var ilosc_szt = ilosc_sztInput.value;
    ilosc_szt = String(ilosc_szt);
    ilosc_szt = ilosc_szt.replace(",", ".");
    ilosc_sztInput.value = ilosc_szt;

    var cena_skrzydlaInput = document.getElementById(
      "id_cena_skrzydla_" + pozycja
    );
    var cena_skrzydla = cena_skrzydlaInput.value;
    cena_skrzydla = String(cena_skrzydla);
    cena_skrzydla = cena_skrzydla.replace(",", ".");
    cena_skrzydlaInput.value = cena_skrzydla;

    var result_wartosc = cena_skrzydla * ilosc_m;
    result_wartosc = result_wartosc.toFixed(2);
    document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja
    ).value = ilosc_szt;
    document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja
    ).value = ilosc_m;
    document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_wartosc_" + pozycja
    ).value = result_wartosc;

    Oblicz_sztuki_wygiecie_wzmocnienia_okiennego(pozycja, ilosc_pozycji);
    Oblicz_wygiecie_ramy_z_pvc(pozycja);
  } else {
    // alert("odznaczyles, poz=" + pozycja + ", dla wygiecie skrzydla");
    //tutaj wykasujemy wszystkie wartosci, bo odznaczylismy checkboxa
    var num = 0;
    var result = num.toFixed(2);
    document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja
    ).value = result;
    document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja
    ).value = result;
    document.getElementById(
      "id_wygiecie_skrzydla_z_pvc_wartosc_" + pozycja
    ).value = result;

    //sciagamy atrybuty tylko do odczytu
    document
      .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_m_" + pozycja)
      .removeAttribute("readonly");
    document
      .getElementById("id_wygiecie_skrzydla_z_pvc_ilosc_szt_" + pozycja)
      .removeAttribute("readonly");
    Oblicz_sztuki_wygiecie_wzmocnienia_okiennego(pozycja, ilosc_pozycji);
    Oblicz_wygiecie_ramy_z_pvc(pozycja);
  }
}

function Oblicz_wygiecie_wzmocnienia_okiennego() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_wzmocnienia_okiennego_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wzmocnienia_okiennego_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wygiecie_wzmocnienia_okiennego_wartosc_" + i
      ).value = result;

      //kopiujemy wartosc do wzmocnienia do  luku
      document.getElementById("id_wzmocnienie_do_luku_ilosc_m_" + i).value =
        ilosc;
      var cena_lukuInput = document.getElementById(
        "id_cena_wzmocnienie_do_luku_" + i
      );
      var cena_luku = cena_lukuInput.value;
      cena_luku = String(cena_luku);
      cena_luku = cena_luku.replace(",", ".");
      cena_lukuInput.value = cena_luku;
      var num2 = ilosc * cena_luku;
      var result2 = num2.toFixed(2);
      document.getElementById("id_wzmocnienie_do_luku_wartosc_" + i).value =
        result2;

      // jezeli skasujemy ilosc wygiecie_wzmocnienia_okiennego_ilosc_m to zerujemy te wzmocnienie_do_luku_ilosc
      if (ilosc == 0) {
        // alert('ilosc='+ilosc);
        document.getElementById(
          "id_wzmocnienie_do_luku_ilosc_m_" + i
        ).value = 0;
        document.getElementById(
          "id_wzmocnienie_do_luku_wartosc_" + i
        ).value = 0;
      }

      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wzmocnienie_do_luku() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wzmocnienie_do_luku_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_wzmocnienie_do_luku_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wzmocnienie_do_luku_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_listwy_z_pvc() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_listwy_z_pvc_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_listwy_" + i);

    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wygiecie_listwy_z_pvc_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_innego_elementu_z_pvc() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_innego_elementu_z_pvc_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_innego_elementu_" + i);
    // alert("ilosc="+iloscInput);

    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wygiecie_innego_elementu_z_pvc_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_ramy_z_alu() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_ramy_z_alu_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_ramy_alu_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wygiecie_ramy_z_alu_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_skrzydla_z_alu() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_skrzydla_z_alu_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_skrzydla_alu_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wygiecie_skrzydla_z_alu_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_listwy_z_alu() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_listwy_z_alu_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_listwy_alu_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wygiecie_listwy_z_alu_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_innego_elementu_z_alu() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_innego_elementu_z_alu_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_innego_elementu_alu_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wygiecie_innego_elementu_z_alu_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wygiecie_innego_elementu_ze_stali() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wygiecie_innego_elementu_ze_stali_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wygiecie_innego_elementu_ze_stali_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wygiecie_innego_elementu_ze_stali_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_zgrzanie() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_zgrzanie_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_zgrzanie_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_zgrzanie_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wyfrezowanie_odwodnienia() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wyfrezowanie_odwodnienia_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wyfrezowanie_odwodnienia_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wyfrezowanie_odwodnienia_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wstawienie_slupka() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wstawienie_slupka_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_wstawienie_slupka_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wstawienie_slupka_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wstawienie_slupka_ruchomego() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wstawienie_slupka_ruchomego_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wstawienie_slupka_ruchomego_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_wstawienie_slupka_ruchomego_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_dociecie_listwy_przyszybowej() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_dociecie_listwy_przyszybowej_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_dociecie_listwy_przyszybowej_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_dociecie_listwy_przyszybowej_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_dociecie_kompletu_listew_przyszybowych() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_dociecie_kompletu_listew_przyszybowych_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_dociecie_kompletu_listew_przyszybowych_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById(
        "id_dociecie_kompletu_listew_przyszybowych_wartosc_" + i
      ).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_okucie() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_okucie_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_okucie_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_okucie_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_zaszklenie() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_zaszklenie_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_zaszklenie_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_zaszklenie_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wykonanie_innej_uslugi() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wykonanie_innej_uslugi_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wykonanie_innej_uslugi_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wykonanie_innej_uslugi_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_oscieznica() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_oscieznica_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_oscieznica_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_oscieznica_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_skrzydlo() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_skrzydlo_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_skrzydlo_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_skrzydlo_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_listwa() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_listwa_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_listwa_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_listwa_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_slupek() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_slupek_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_slupek_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_slupek_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wzmocnienie_do_ramy() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wzmocnienie_do_ramy_ilosc_m_" + i
    );
    var cenaInput = document.getElementById("id_cena_wzmocnienie_do_ramy_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wzmocnienie_do_ramy_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wzmocnienie_do_skrzydla() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wzmocnienie_do_skrzydla_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wzmocnienie_do_skrzydla_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wzmocnienie_do_skrzydla_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_wzmocnienie_do_slupka() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById(
      "id_wzmocnienie_do_slupka_ilosc_m_" + i
    );
    var cenaInput = document.getElementById(
      "id_cena_wzmocnienie_do_slupka_" + i
    );
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_wzmocnienie_do_slupka_wartosc_" + i).value =
        result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_okucia() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_okucia_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_okucia_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_okucia_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_szyby() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_szyby_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_szyby_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_szyby_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}

function Oblicz_inny_element() {
  var stop = false;
  var i = 1;
  while (!stop) {
    var iloscInput = document.getElementById("id_inny_element_ilosc_m_" + i);
    var cenaInput = document.getElementById("id_cena_inny_element_" + i);
    if (iloscInput != null) {
      var ilosc = iloscInput.value;
      ilosc = String(ilosc);
      ilosc = ilosc.replace(",", ".");
      iloscInput.value = ilosc;

      var cena = cenaInput.value;
      cena = String(cena);
      cena = cena.replace(",", ".");
      cenaInput.value = cena;

      var num = ilosc * cena;
      var result = num.toFixed(2);
      document.getElementById("id_inny_element_wartosc_" + i).value = result;
      i++;
    } else {
      break;
    }
  }
  ObliczWartoscNetto();
}
