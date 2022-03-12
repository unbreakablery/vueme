<template>
  <div>
    <header>
      <div class="container p-0">
        <div class="row m-0">
          <div class="col-5">
            <div class="logo">
              <img src="/images/site-images/respectfully.png" alt="respectfully Logo" class="img-fluid" />
            </div>
          </div>
          <div v-if="guest" class="col-7 text-right">
            <a @click="signupDialog=true" class="btn btn-primary btn-mobile">Sign Up</a>
            <a href="/login" class="btn btn-primary btn-mobile ml-2">Login</a>
          </div>
          <div v-else-if="user!=null" class="col-6 text-right pt-2">
            <div class="d-inline-flex">
              <div class="mr-2">
                <text-chat-notifications color="#8c9eff" size="27px" :user="user"></text-chat-notifications>
              </div>
              <!-- <text-chat-notifications color="#4c4883" size="25px" :user="user"></text-chat-notifications>-->
              <toxbox-chat-notifications color="#8c9eff" size="27px" :user="user"></toxbox-chat-notifications>
            </div>
            <v-menu offset-y left>
              <template v-slot:activator="{ on }">
                <a v-on="on" class="ml-3">
                  <div
                    :aria-label="user.userProfile.display_name"
                    class="user_avatar_sm"
                    :style="{ 'background-image': 'url(' + user.userProfile.haedshot_path  + ')' }"
                  ></div>
                </a>
              </template>
              <v-card :min-width="300" :min-height="150">
                <v-list dense class v-if="user.role_id == 1">
                  <v-list-item-group color="primary">
                    <v-list-item dense class="px-5" href="/dashboard">
                      <v-list-item-icon>
                        <i class="far fa-calendar-alt mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Appointments</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item dense class="px-5" href="/dashboard/services">
                      <v-list-item-icon>
                        <i class="far fa-clock mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Schedule</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item class="px-5" href="/dashboard/reviews">
                      <v-list-item-icon>
                        <i class="far fa-star mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Reviews</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-5" href="/dashboard/payout">
                      <v-list-item-icon>
                        <i class="fas fa-dollar-sign mt-1 ml-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Money</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-5">
                      <v-list-item-icon>
                        <i class="far fa-chart-bar mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Analytics</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item class="px-5" @click.prevent="logout()" dense>
                      <v-list-item-icon>
                        <img src="/images/icons/logout.svg" />
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
                <v-list dense class v-else-if="user.role_id == 2">
                  <v-list-item-group color="primary">
                    <v-list-item dense class="px-5" href="/dashboard/appointments">
                      <v-list-item-icon>
                        <i class="far fa-calendar-alt mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Appointments</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item class="px-5" href="/dashboard/user/reviews">
                      <v-list-item-icon>
                        <i class="far fa-comment mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Reviews</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item dense class="px-5" href="/dashboard/favorites">
                      <v-list-item-icon>
                        <i class="far fa-star mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Favorites</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-5" href="/dashboard/transaction">
                      <v-list-item-icon>
                        <i class="fas fa-dollar-sign mt-1 ml-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Transactions</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="px-5">
                      <v-list-item-icon>
                        <i class="far fa-credit-card mt-1"></i>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>Payment</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item class="px-5" @click.prevent="logout()" dense>
                      <v-list-item-icon>
                        <img src="/images/icons/logout.svg" />
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
              </v-card>
            </v-menu>
          </div>
        </div>
      </div>
    </header>

    <v-dialog v-model="signupDialog" width="750">
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-btn icon light @click="signupDialog = false" class="right">
                <i class="far fa-times-circle fa-2x pink_icon"></i>
              </v-btn>
            </div>
            <div class="col-12">
              <div class="text-center">
                <h2>HAVE WHAT IT TAKES?</h2>
              </div>
              <div class="text-center">
                <h2>JOIN US TODAY</h2>
              </div>

              <div class="card-body p-0 p-lg-5 pt-3">
                <form method="POST" action class="registration_form">
                  <div class="form-row mb-3">
                    <label class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label">
                      Name
                      <span class="text-danger">*</span>
                    </label>

                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-5 mb-lg-0">
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser.name"
                        placeholder="First"
                      />
                      <span v-if="errors.name" class="float-left text-danger">{{ errors.name[0] }}</span>
                    </div>

                    <div class="col-md-6 col-12 col-sm-6 col-lg-6">
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser.last_name"
                        placeholder="Last"
                      />
                      <span
                        v-if="errors.last_name"
                        class="float-left text-danger"
                      >{{ errors.last_name[0] }}</span>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-lg-0 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Mobile
                          <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser.number"
                            placeholder="(555) 555 5555"
                          />
                          <span
                            v-if="errors.number"
                            class="float-left text-danger"
                          >{{ errors.number[0] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Email
                          <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0">
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser.email"
                            placeholder="gifted@respectfully.com"
                          />
                          <span
                            v-if="errors.email"
                            class="float-left text-danger"
                          >{{ errors.email[0] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <label class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label">
                      Display Name
                      <span class="text-danger">*</span>
                    </label>

                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser.display_name"
                        placeholder="Must only contain letters, numbers or dashes."
                      />
                      <span
                        v-if="errors.display_name"
                        class="float-left text-danger"
                      >{{ errors.display_name[0] }}</span>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Password
                          <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                          <input class="form-control" type="password" v-model="newuser.password" />
                          <span
                            v-if="errors.password"
                            class="float-left text-danger"
                          >{{ errors.password[0] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Confirm Password
                          <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0">
                          <input
                            class="form-control"
                            type="password"
                            v-model="newuser.c_password"
                            placeholder
                          />
                          <span
                            v-if="errors.c_password"
                            class="float-left text-danger"
                          >{{ errors.c_password[0] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          I Was Referred by
                          <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                          <input class="form-control" type="text" v-model="newuser.referral" />
                          <span
                            v-if="errors.referral"
                            class="float-left text-danger"
                          >{{ errors.referral[0] }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6"></div>
                  </div>

                  <div class="form-row mb-3">
                    <label class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label">
                      Select All That Apply
                      <span class="text-danger">*</span>
                    </label>

                    <div
                      class="col-md-3 col-12 col-sm-3 col-lg-3"
                      v-for="(item, index) in this.categories"
                      :key="index"
                    >
                      <v-checkbox
                        v-model="newuser.categories"
                        :label="item"
                        :value="index+1"
                        color="primary"
                      ></v-checkbox>
                    </div>
                    <span
                      v-if="errors.display_name"
                      class="float-left text-danger"
                    >{{ errors.categories[0] }}</span>
                  </div>

                  <div class="form-row mb-3 mt-5">
                    <div class="col-12">
                      <v-btn
                        class
                        color="primary"
                        :loading="loading"
                        :disabled="loading"
                        @click="register()"
                      >Sign Up</v-btn>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="messageDialog" width="600">
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-btn icon light @click="messageDialog = false" class="right">
                <i class="far fa-times-circle fa-2x primary--text"></i>
              </v-btn>
            </div>
            <div class="col-12">
              <div class="text-center p-5">
                <h1 class="mb-5">
                  THANK YOU
                  <br />FOR SIGNING UP!
                </h1>
                <p class="p-4 pt-0">{{message}}</p>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: ["user", "guest", "categories"],
  data: function () {
    return {
      loading: false,
      errors: [],
      signupDialog: false,
      message: "",
      messageDialog: "",
      newuser: {
        name: "",
        last_name: "",
        number: "",
        email: "",
        display_name: "",
        referral: "",
        categories: [],
        password: "",
        c_password: "",
      },
    };
  },
  mounted() {
    EventBus.$on("open_sign_up", () => (this.signupDialog = true));
  },
  ready() {
    EventBus.$on("open_sign_up", () => (this.signupDialog = true));
  },

  methods: {
    register() {
      this.loading = true;
      var input = this.newuser;
      axios
        .post("/api/v1/register", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            this.message = res.data.success.message;
            this.signupDialog = false;
            this.resetUser();
            this.messageDialog = true;
          }
          this.loading = false;
          this.errors = [];
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    resetUser() {
      this.newuser = {
        name: "",
        last_name: "",
        number: "",
        email: "",
        display_name: "",
        referral: "",
        categories: [],
        password: "",
        c_password: "",
      };
    },
    logout() {
      axios
        .post("/logout")
        .then((response) => {
          if (response.status === 200) {
            window.location = "/";
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
      // this.$refs.logoutform.submit()
    },
  },
};
</script>