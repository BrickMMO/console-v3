<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=PAGE_TITLE?> | <?=APP_NAME?> | BrickMMO Console </title>

        
    <!-- W3 School CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

    <!-- BrickMMO Exceptions -->
    <link rel="stylesheet" href="https://cdn.brickmmo.com/exceptions@1.0.0/w3.css" />
    <link rel="stylesheet" href="https://cdn.brickmmo.com/exceptions@1.0.0/fontawesome.css" />

    <!-- BrickMMO Icons -->
    <link rel="stylesheet" href="https://cdn.brickmmo.com/fonticons@1.0.0/fonticons.css" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Script JavaScript File -->
    <script src="/script.js"></script>

    <?php if(!isset($_SESSION['timezone'])): ?>

      <script>

      let timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

      let now = new Date();
      let offset = now.getTimezoneOffset();

      async function setTimezone() {
        const response = await fetch('/ajax/timezone/'+offset+'/'+timezone);
      }

      setTimezone();

      </script>

    <?php endif; ?>

  </head>
  <body>
