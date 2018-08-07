@extends('layouts.adminv2')
@section('title')
 | عرض الطلب
@endsection
@section('content')
<style>
    table {
        font-family: sans-serif;
        width: 100%;
        border-spacing: 0;
        border-collapse: separate;
        table-layout: fixed;
        margin-bottom: 50px;
        direction: ltr;
    }
    table thead tr th {
        background: #626E7E;
        color: #d1d5db;
        padding: 0.5em;
        overflow: hidden;
        text-align: center;
    }
    table thead tr th:first-child {
        border-radius: 3px 0 0 0;
    }
    table thead tr th:last-child {
        border-radius: 0 3px  0 0;
    }
    table thead tr th .day {
        display: block;
        font-size: 1.2em;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        margin: 0 auto 5px;
        padding: 5px;
        line-height: 1.8;
    }
    table thead tr th .day.active {
        background: #d1d5db;
        color: #626E7E;
    }
    table thead tr th .short {
        display: none;
    }
    table thead tr th i {
        vertical-align: middle;
        font-size: 2em;
    }
    table tbody tr {
        background: #d1d5db;
    }
    table tbody tr:nth-child(odd) {
        background: #c8cdd4;
    }
    table tbody tr:nth-child(4n+0) td {
        border-bottom: 1px solid #626E7E;
    }
    table tbody tr td {
        text-align: center;
        vertical-align: middle;
        border-left: 1px solid #626E7E;
        position: relative;
        height: 32px;
        cursor: pointer;
    }
    table tbody tr td:last-child {
        /*border-right: 1px solid #626E7E;*/
    }
    table tbody tr td.hour {
        font-size: 2em;
        padding: 0;
        color: #626E7E;
        background: #fff;
        border-bottom: 1px solid #626E7E;
        border-collapse: separate;
        min-width: 100px;
        cursor: default;
    }
    table tbody tr td.hour span {
        display: block;
    }
    @media (max-width: 60em) {
        table thead tr th .long {
            display: none;
        }
        table thead tr th .short {
            display: block;
        }
        table tbody tr td.hour span {
            transform: rotate(270deg);
            -webkit-transform: rotate(270deg);
            -moz-transform: rotate(270deg);
        }
    }
    @media (max-width: 27em) {
        table thead tr th {
            font-size: 65%;
        }
        table thead tr th .day {
            display: block;
            font-size: 1.2em;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            margin: 0 auto 5px;
            padding: 5px;
        }
        table thead tr th .day.active {
            background: #d1d5db;
            color: #626E7E;
        }
        table tbody tr td.hour {
            font-size: 1.7em;
        }
        table tbody tr td.hour span {
            transform: translateY(16px) rotate(270deg);
            -webkit-transform: translateY(16px) rotate(270deg);
            -moz-transform: translateY(16px) rotate(270deg);
        }
    }

</style>

@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> الخريطة

                </div>
                <div class="portlet-body form">
                    <form action="{{url('/vendors/branch/add')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                        <input type="hidden" id="branchLat" name="branchLat" @if(old('branchLat')) value="{{old('branchLat')}}" @else value="{{@$branch->branch_lat}}" @endif />
                        <input type="hidden" id="branchLong" name="branchLong" @if(old('branchLong')) value="{{old('branchLong')}}" @else value="{{@$branch->branch_long}}" @endif/>
                        <input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
                        <div id="googleMap" style="width:100%;height:400px;"></div>
                        </br>
                        <button type="submit" class="btn btn-success  mr-10"> تسجيل</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('footer')
@parent
<script>
    var marker = null , map;
    function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '22px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Click to recenter the map';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '16px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = '<i class="zmdi zmdi-gps-dot"></i>';
        controlUI.appendChild(controlText);

        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener('click', function() {
            /*map.setCenter(chicago);*/
            navigator.geolocation.getCurrentPosition(function (position) {
                console.log(position.coords.latitude);
                initialMarkerLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                if (marker==null) {
                    marker = new google.maps.Marker({
                        position : initialMarkerLocation,
                        map: map
                    });
                } else {
                    marker.setPosition(initialMarkerLocation);
                }

                map.setCenter(initialMarkerLocation);
                map.setZoom(16);
                document.getElementById('branchLat').value = position.coords.latitude;
                document.getElementById('branchLong').value = position.coords.longitude;
            });
        });

    }

    function initAutocomplete() {
        var order_lat = document.getElementById('branchLat').value;
        var order_long = document.getElementById('branchLong').value;

        map = new google.maps.Map(document.getElementById('googleMap'), {
            center: {lat: 24.782765, lng: 46.782498},
            zoom: 13,
            mapTypeId: 'roadmap',
            gestureHandling: "greedy"
        });

        // Create the DIV to hold the control and call the CenterControl()
        // constructor passing in this DIV.
        var centerControlDiv = document.createElement('div');
        var centerControl = new CenterControl(centerControlDiv, map);

        centerControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(centerControlDiv);

        if(order_lat && order_long){

            var position = new google.maps.LatLng(order_lat,order_long);
            marker = new google.maps.Marker({
                position : new google.maps.LatLng(order_lat,order_long),
                map: map
            });

            initialLocation = new google.maps.LatLng(order_lat, order_long);
            map.setCenter(initialLocation);
            map.setZoom(16);

        }else if (navigator.geolocation) {
             navigator.geolocation.getCurrentPosition(function (position) {
             initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                                 map.setCenter(initialLocation);
                             });
        }


        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];



            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }


                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });


        google.maps.event.addListener(map, 'dblclick', function(event) {
            if (marker==null) {
                marker = new google.maps.Marker({
                    position : event.latLng,
                    map: map
                });
            } else {
                marker.setPosition(event.latLng);
            }
            document.getElementById('branchLat').value = event.latLng.lat();
            document.getElementById('branchLong').value = event.latLng.lng();
        });
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgIKx-8qqL3I3a-cVETwnf2UbgVzm1zus&libraries=places&language=ar&callback=initAutocomplete"></script>
@endsection