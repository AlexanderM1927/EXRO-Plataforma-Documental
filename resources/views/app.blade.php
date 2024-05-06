<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @routes
    @inertiaHead
    <style>
        html {
            font-size: 16px; /* Sets the base font size to 16px */
        }
    </style>
  </head>
  <body>
    @inertia
  </body>
</html>
