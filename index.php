<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LED ON/OFF</title>
    <style>
      body { font-family: system-ui, sans-serif; padding: 32px; text-align: center; }
      a { font-size: 32px; margin: 10px; text-decoration: none; }
      a:hover { color: blue; }
      pre { background: #f3f3f3; padding: 10px; text-align: left; }
    </style>
  </head>

  <body>
    <h1>Kontrol LED via ThingSpeak</h1>
    <p>Klik link di bawah untuk ON / OFF LED.</p>

    <div>
      <b>
        LED 1 = &nbsp;
        <a href="https://api.thingspeak.com/update?api_key=8PJBRCJGV5DU4MJM&field1=1" data-field="1" data-value="1">ON</a> /
        <a href="https://api.thingspeak.com/update?api_key=8PJBRCJGV5DU4MJM&field1=0" data-field="1" data-value="0">OFF</a>
      </b>
    </div>
    <br>
    <div>
      <b>
        LED 2 = &nbsp;
        <a href="https://api.thingspeak.com/update?api_key=8PJBRCJGV5DU4MJM&field2=1" data-field="2" data-value="1">ON</a> /
        <a href="https://api.thingspeak.com/update?api_key=8PJBRCJGV5DU4MJM&field2=0" data-field="2" data-value="0">OFF</a>
      </b>
    </div>

    <h3>Log:</h3>
    <pre id="output"></pre>

    <script>
      const API_KEY = "8PJBRCJGV5DU4MJM";
      let lastUpdate = 0;

      document.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", async (e) => {
          e.preventDefault(); // cegah pindah halaman

          const field = e.target.dataset.field;
          const value = e.target.dataset.value;

          const now = Date.now();
          if (now - lastUpdate < 15000) {
            document.getElementById("output").textContent += 
              `Tunggu 15 detik sebelum update lagi!\n`;
            return;
          }

          const url = `https://api.thingspeak.com/update?api_key=${API_KEY}&field${field}=${value}`;
          try {
            const r = await fetch(url);
            const res = await r.text();
            document.getElementById("output").textContent += 
              `LED${field} set to ${value} → Entry ${res}\n`;
            lastUpdate = now;
          } catch (err) {
            document.getElementById("output").textContent += `Error: ${err}\n`;
          }
        });
      });
    </script>
  </body>
</html>