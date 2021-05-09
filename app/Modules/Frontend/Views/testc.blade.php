@extends('Frontend::layouts.frontend')
@section('content')


    <div class="col cont_sec2 mrg-bot-10 bg_grey" style="min-height:50vh;">
                <div class="blank"></div>
                <div class="col-xs-12 col-sm-12">
                <h4>Location selection from database </h4>
                <select name="country" class="countries" id="countryId">
    <option value="">Select Country</option>
</select>
<select name="state" class="states" id="stateId">
     <option value="">Select State</option>
</select>
<select name="city" class="cities" id="cityId">
   <option value="">Select City</option>
</select>
<!-- Maps related code -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9ZxHaV_cEegOJfb8FnF_qcNUPIMDQ0A&libraries=places"></script>
 
<br/><br/> 
<h5>Google Map</h5>
<input type="text" id="searchInMap" style="width: 250px" placeholder="Enter a location" />

                     <input type="text" id="PlaceName" name="PlaceName" />
         <input type="text" id="cityLat" name="cityLat" />
         <input type="text" id="cityLng" name="cityLng" /> 

         <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('searchInMap'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
            /*    var latitude = place.geometry.location.A;
                var longitude = place.geometry.location.F;*/
                document.getElementById('PlaceName').value = address;
        document.getElementById('cityLat').value = place.geometry.location.lat();
        document.getElementById('cityLng').value = place.geometry.location.lng();
                
            });
        });
    </script>
<!-- End Maps related code -->
            </div>
            </div>
           


@endsection
