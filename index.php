<?php
require_once("process_index.php");
include("head.php");
$_SESSION['sidebar'] = "newsfeed";
?>
<title>
  PawsBook - Dashboard
</title>

<body class="g-sidenav-show  bg-gray-200">

  <?php include("aside.php"); ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include("navbar.php"); ?>
    <!-- End Navbar -->

    <!-- Vue App Here -->
    <span id="vueApp" class="show">

      <!-- Snackbar -->
      <div class="snack-wrap" v-if="showSnackBar" @click="showSnackBar=false">
        <input type="checkbox" class="snackclose animated" id="close" /><label class="snacklable animated" for="close"></label>
        <div class="snackbar animated">
          <p><strong>Notice:</strong> {{snackBarMessage}} <br>
            <span style="font-size: 12px !important;">Click to dismiss.</span>
          </p>
        </div>
      </div>
      <!-- End Snackbar -->
      <div class="container-fluid py-4">
        <div class="row mb-4">

          <div class="col-lg-8 col-md-8 mb-md-0 mb-4">
            <div class="card">
              <div class="card-header pb-0 bg-gradient-success">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h6 class="text-white"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></h6>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <form @submit.prevent="postCaption">
                  <!-- <div class="card p-2 m-2"> -->
                    <div class="card-body px-0 pb-2 m-2">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="ms-3">
                            <h6>What is in your mind?</h6>
                            <textarea class="form-control" minlength="4" rows="4" style="border: 1px solid" v-model="caption"></textarea>
                          </div><br>
                          <div class="text-end">
                            <button class="btn btn-sm btn-success" type="submit" :disabled="addingPost"> {{btnMessage}}</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->
                </form>
                <!-- Posts will be shown here -->
                <div class="card p-2 m-2">
                  <div class="card-body px-0 pb-2 m-2">
                    <div class="">Caption here</div>
                    <div class="text-end">00-00-0000</div>
                  </div>
                </div>
                <!-- End posts here -->
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-4">
            <div class="card h-100">
              <div class="card-header pb-0">
                <h6>Friends</h6>
                <!-- <p class="text-sm">
                <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                <span class="font-weight-bold">24%</span> this month
              </p> -->
              </div>
              <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-success text-gradient">notifications</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-danger text-gradient">code</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-info text-gradient">shopping_cart</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-warning text-gradient">credit_card</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-primary text-gradient">key</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                    </div>
                  </div>
                  <div class="timeline-block">
                    <span class="timeline-step">
                      <i class="material-icons text-dark text-gradient">payments</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
                    </div>
                  </div>
                </div>
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
      }
    },
    methods: {
      editInformation() {
        this.isEdit = !this.isEdit;

      },

      //Post Caption
      async postCaption() {
        this.addingPost = true;
        this.btnMessage = "Posting..."
        const options = {
          method: "POST",
          url: "process_profile.php?postCaption=" + <?php echo $_SESSION['user_id']; ?>,
          headers: {
            Accept: "application/json",
          },
          data: {
            caption: this.caption,
          },
        };
        await axios
          .request(options)
          .then((response) => {
            this.showSnackBar = true;
            this.snackBarMessage = response.data.response;
            this.caption = "";
          })
          .catch((error) => {
            console.log('error!')
          });
        this.addingPost = false;
        this.btnMessage = "Post";
        await this.getCaption();
      },

      //Get Caption
      async getCaption() {
        const options = {
          method: "POST",
          url: "process_profile.php?getCaption=" + <?php echo $_SESSION['user_id']; ?>,
          headers: {
            Accept: "application/json",
          },
        };
        await axios
          .request(options)
          .then((response) => {
            console.log(response);
            this.userPosts = response.data
          })
          .catch((error) => {
            this.showSnackBar = true;
            this.snackBarMessage = "There is an error getting the information. Please try again.";
          });
      },


    },
    mounted() {
      this.getCaption();
    }
  });
</script>

</html>