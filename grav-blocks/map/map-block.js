jQuery(document).ready(function($){

    // Setup map_blocks array
    var map_blocks = [];

    $('.block-map.block-container').each(function() {
            var block_index = $(this).attr('data-block-index');
            map_blocks.push(block_index);
    })

    function initMap(block_index) {
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            mapTypeControl: false,
            mapTypeId: 'roadmap',
            draggable: true,
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            scrollwheel: false,
            streetViewControl: false,

        styles: [
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#dab139"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#75b6be"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#75b6be"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#75b6be"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#75b6be"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#dab139"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#18273f"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#dab139"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#509ba5"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "weight": "1.00"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#75b6be"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#18273f"
                    },
                    {
                        "weight": "1.50"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": "0.75"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#18273f"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#dbdbdb"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#0d1d37"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "color": "#dab139"
                    },
                    {
                        "visibility": "off"
                    },
                    {
                        "weight": "3.59"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#aecaca"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#76a1b2"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#36455c"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#aecaca"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ]


        };

        // Display a map on the page
        map = new google.maps.Map(document.getElementById(block_index + "_map"), mapOptions);
        map.setTilt(45);

        //google map custom marker icon - .png fallback for IE11
        // TODO: Add in this IE11 check
        // var is_internetExplorer11= navigator.userAgent.toLowerCase().indexOf('trident') > -1;
        // var marker_url = ( is_internetExplorer11 ) ? '/library/images/icon.png' : '/library/images/icon.svg';

        var gravMarker = {
            url: marker_url,
        }

        // var locations = $('#' + block_index + '_map').data('locations');
        // console.log(locations);
        locations = locations.replace(/'/g, '"');

        gravMarkerLocations = JSON.parse("[" + locations + "]");

        //Array for infoWindow
        // var infoWindows = $('#' + block_index + '_map').data('infowindows');
        infoWindows = infoWindows.replace(/'/g, '"').replace('<br />', '');

        var InfoWindowContent = JSON.parse("[" + infoWindows + "]");
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;

         // Loop through our array of markers & place each one on the map
         for( i = 0; i < gravMarkerLocations.length; i++ ) {
             var position = new google.maps.LatLng(
                 gravMarkerLocations[i][1],
                 gravMarkerLocations[i][2]
             );
             bounds.extend(position);
             marker = new google.maps.Marker({
                 icon: gravMarker,
                 position: position,
                 map: map,
                 title: gravMarkerLocations[i][0]
             });

             // Allow each marker to have an info window
             google.maps.event.addListener(marker, 'click', (function(marker, i) {
                 return function() {
                     infoWindow.setContent('<div class="info_content">' + InfoWindowContent[i][0] + '<p><a href="https://www.google.com/maps/dir/Current+Location/' + gravMarkerLocations[i][1] +',' +gravMarkerLocations[i][2] +'" target="_blank">Get Directions</a></p></div>');
                     infoWindow.open(map, marker);
                 }
             })(marker, i));

             // Automatically center the map fitting all markers on the screen
             map.fitBounds(bounds);
         }

         // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
         var zoomOffest = $('#' + block_index + '_map').data('zoom');

         var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {

            var theZoom = this.getZoom();

            this.setZoom(theZoom - zoomOffest);
    
            google.maps.event.removeListener(boundsListener);

        });

         google.maps.event.addDomListener(window, 'resize', function() {
              map.fitBounds(bounds);
             //function to get current zoom and set map to zoom - 1
             var theZoom = map.getZoom();
             map.setZoom(theZoom - zoomOffest);

         });
      }

      for (var i = 0; i < map_blocks.length; i++) {
          $('#' + map_blocks[i] + '_map').css('padding-bottom', '75%');
          initMap(map_blocks[i]);
      }

});
