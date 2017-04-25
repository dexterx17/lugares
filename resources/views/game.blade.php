<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <title>
                    place API Google Mapss
                </title>
                <meta content="width=device-width, initial-scale=1" name="viewport">
                    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
                    </script>
                    <script src="{{ asset('js/bootstrap.min.js') }}">
                    </script>
                    <style>
                        #mapa{
            width: 100%;
            height: 500px;
        }

        #controles{
        }

        #lugares .media:hover{
            border: 2px dashed black;
        }
        #detail img{
            width: 100%;
            height:180px;
        }
                    </style>
                </meta>
            </meta>
        </meta>
    </head>
    <body>
        <div class="container">
            <div id="fb-root">
            </div>
            <!-- Welcome screen -->
            <div id="welcome">
                <h1>
                    Welcome
                    <span class="first_name">
                        ...
                    </span>
                </h1>
                <img class="profile" src="images/profile.png"/>
                <ul class="stats">
                    <li>
                        <img alt="Puntos" src="images/coin40.png"/>
                        <span class="me coins">
                            ...
                        </span>
                    </li>
                    <li>
                        <img alt="Lugares" class="buybomb" src="images/buybomb40.png"/>
                        <span class="me bombs">
                            ...
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ920_mAj7Lcw2Mc6JOqrxbJEKHQS0BRE&libraries=places&callback=initMap">
        </script>
    </body>
</html>