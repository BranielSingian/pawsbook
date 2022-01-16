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
    <div id="map"></div>
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

<script>
  var map = L.map('map').setView([51.505, -0.09], 13);

  L.tileLayer('https://api.maptiler.com/maps/outdoor/?key=gcypTzmAMjrlMg46MJG3#7.0/46.67124/8.29951', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

  L.marker([51.5, -0.09]).addTo(map)
    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
    .openPopup();

</script>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->

</html>