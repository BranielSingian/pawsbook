<?php
require_once("process_index.php");
include("head.php");
$_SESSION['sidebar'] = "Pet Tracking";
?>
<title>
  PawsBook - Track Pet
</title>

<body class="g-sidenav-show  bg-gray-200">

  <?php include("aside.php"); ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include("navbar.php"); ?>
    <!-- End Navbar -->

    <!-- Vue App Here -->
    <span id="vueApp" class="show">

      <div class="container-fluid py-4">
        <div class="row mb-4">

          <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
              <div class="card-header pb-0 bg-gradient-success">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h6 class="text-white"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></h6>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <p class="m-4">Long: {{long}} <br>Lat: {{lat}}</p>
                <p class="m-4"><b>Please put this tracker safely into a harness. Thank you!</b></p>
                <div id="map"></div>
              </div>
            </div>
          </div>
        </div>

        <?php include("footer.php"); ?>
      </div>

    </span>
  </main>
  <?php //include("fixed-plugin.php"); 
  ?>
  <?php include("core-js-files.php"); ?>

</body>
<script>
  new Vue({
    el: "#vueApp",
    data() {
      return {
        isEdit: false,
        caption: null,
        captionHere: null,
        showSnackBar: false,
        snackBarMessage: null,
        addingPost: false,
        btnMessage: "Post",

        //Posts
        userPosts: [],

        //Friends
        friendSuggestions: [],
        linkRequests: [],
        requestId: null,

        //Sample
        long: 0,
        lat: 0,
      }
    },
    methods: {
      getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(this.showPosition, this.showError);
        } else {
          this.long = "Geolocation is not supported by this browser.";
        }
      },

      showPosition(position) {
        this.lat = position.coords.latitude;
        this.long = position.coords.longitude;
      },

      showError(error) {
        switch (error.code) {
          case error.PERMISSION_DENIED:
            this.long = "User denied the request for Geolocation."
            break;
          case error.POSITION_UNAVAILABLE:
            this.long = "Location information is unavailable."
            break;
          case error.TIMEOUT:
            this.long = "The request to get user location timed out."
            break;
          case error.UNKNOWN_ERROR:
            this.long = "An unknown error occurred."
            break;
        }
      }


    },

    async mounted() {
      this.getLocation();
    }
  });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly&channel=2" async></script>

<script>
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 8,
    center: { lat: 40.731, lng: -73.997 },
  });
  const geocoder = new google.maps.Geocoder();
  const infowindow = new google.maps.InfoWindow();

  document.getElementById("submit").addEventListener("click", () => {
    geocodeLatLng(geocoder, map, infowindow);
  });
}

function geocodeLatLng(geocoder, map, infowindow) {
  const input = document.getElementById("latlng").value;
  const latlngStr = input.split(",", 2);
  const latlng = {
    lat: parseFloat(latlngStr[0]),
    lng: parseFloat(latlngStr[1]),
  };

  geocoder
    .geocode({ location: latlng })
    .then((response) => {
      if (response.results[0]) {
        map.setZoom(11);

        const marker = new google.maps.Marker({
          position: latlng,
          map: map,
        });

        infowindow.setContent(response.results[0].formatted_address);
        infowindow.open(map, marker);
      } else {
        window.alert("No results found");
      }
    })
    .catch((e) => window.alert("Geocoder failed due to: " + e));
}

</script>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->

</html>