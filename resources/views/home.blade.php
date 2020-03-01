<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
     
        <meta name="author" content="roland ahimbisibwe" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="theme-color" content="#393856" />
        <base href="/" />
    
        <title>My Rentals</title>

        <!-- Scripts -->
        <script>
            window.App = { user:  {!! json_encode($user) !!} ,currencies:["UGX","USD"]};
        </script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">

        <!-- Splash Screen CSS -->
        <style type="text/css">
           #app-splash-screen {
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #2d323d;
                z-index: 99999;
                pointer-events: none;
            }

           #app-splash-screen .center {
                display: block;
                width: 100%;
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
            }

           #app-splash-screen .logo {
                width: 128px;
                margin: 0 auto;
            }

           #app-splash-screen .logo img {
                filter: drop-shadow(0px 10px 6px rgba(0, 0, 0, 0.2));
            }
        </style>

    </head>
    <body>
        <noscript>
            You need to enable JavaScript to run this app.
        </noscript>
        <div id="root" class="flex">
            <div id="app-splash-screen">
                <div class="center">
                    <div class="logo">
                        <img width="128" src="/assets/rent.svg" alt="logo" />
                    </div>
                </div>
            </div>
       
        </div>
    </body>
</html>
