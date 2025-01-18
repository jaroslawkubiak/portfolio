function logUserData() {
  const browser = navigator.userAgent;
  let operatingSystem = "Nieznany system";

  if (navigator.userAgent.indexOf("Windows NT 10.0") !== -1) {
    operatingSystem = "Windows 10";
  } else if (navigator.userAgent.indexOf("Macintosh") !== -1) {
    operatingSystem = "macOS";
  } else if (navigator.userAgent.indexOf("Linux") !== -1) {
    operatingSystem = "Linux";
  } else if (navigator.userAgent.indexOf("Android") !== -1) {
    operatingSystem = "Android";
  } else if (
    navigator.userAgent.indexOf("iPhone") !== -1 ||
    navigator.userAgent.indexOf("iPad") !== -1
  ) {
    operatingSystem = "iOS";
  }

  const userData = {
    browser: browser,
    operating_system: operatingSystem,
    ip_address: null, 
  };

  fetch("https://jaroslawkubiak.pl/api/index.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  })
    .then((response) => response.json())
    .catch((error) => {});
}

logUserData();
