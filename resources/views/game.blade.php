@extends('template.base')
@section('content')
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
@endsection
@section('js')
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ920_mAj7Lcw2Mc6JOqrxbJEKHQS0BRE&libraries=places&callback=initMap">
    </script>
@endsection