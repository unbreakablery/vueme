<template>
<div>
  <section style="background: #fff">
    <div class="container">
      <div class="row mt-10">
        <div class="col sfSign">
          <h1>Join for Free!</h1>
        </div>
      </div>
      <div
        class="row"
        style="margin-bottom: 50px"
      >
        <div class=" sfSign" :class="$vuetify.breakpoint.xsOnly ? 'col-12' : 'col-6'" :style="[ $vuetify.breakpoint.xsOnly ? {'order': '1'}:{'order': '0'}]">
          <h2>Why Join Respectfully.com</h2>
          <!-- <h3>Top Quality Network</h3>
          <p>
            Our top-tier network of experienced and compassionate professionals
            is here to give you the direct attention you deserve.
          </p>

          <h3>Always Available</h3>
          <p>
            Anywhere in the world, anytime of day - our experts are here for you
            when you need them the most. Providing best in class readings,
            answers and advice.
          </p>

          <h3>Simple Upfront Rates</h3>
          <p>
            No guessing games and no surprise charges later on. Just clear
            Services and Rates on each profile so you know exactly how much
            you’re spending.
          </p>

          <h3>Clarity Where You Need It</h3>
          <p>
            Our growing gallery of Models, Mediums, Healers and Astrologers
            offers everything you’re looking for – from spiritual readings to
            relationship guidance to dream interpretation and horoscope
            navigation. It’s all here.
          </p> -->
        </div>
        <div class=""  :class="$vuetify.breakpoint.xsOnly ? 'col-12' : 'col-6'" :style="[ $vuetify.breakpoint.xsOnly ? {'order': '0', 'margin-bottom': '40px'}:{'order': '1'}]">
          <v-card
            style="
              background: #f4f4f4;
              border-radius: 30px !important;
              margin: auto;
              width: 439px;
            "
          >
               
          <v-card-text class="p-0">
            <div class="row m-0">
              

              <div class="col-12 px-3">
                <div class="card-body px-0 pt-8">
                  <form method="POST" action class="registration_form">
                    
                    <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <div class="form-row m-0">
                          <label
                            class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"  style="font-size:12px!important;color:#A2A2A2!important"
                          >
                            Create Account
                          </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0">
                            <v-text-field
                            label=""
                            placeholder="Email"
                            v-model="user_new.email"
                            hide-details
                            flat
                            height="40"
                            solo
                          
                            class="inputClass1"
                          >
                          <template v-slot:prepend-inner>
                              
                                  <img
                                    width="32"
                                    height="32"
                                    src="/images/icons/email.svg"
                                    alt=""
                                  >
                            
                            </template>
                          </v-text-field>
                             <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                        <span  v-if="errors1.email">{{ errors1.email[0] }}</span>
                        </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <div class="form-row m-0">
                          

                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                             <v-text-field
                        label=""
                        placeholder="Password"
                         v-model="user_new.password"
                        hide-details
                        flat
                        height="40"
                        solo
                        type="password"
                        class="inputClass1"
                      >
                      
                           <template v-slot:prepend-inner>
                           
                              <img
                                width="32"
                                height="32"
                                src="/images/icons/password.svg"
                                alt=""
                              >
                         
                         </template>
                    
                          
                      </v-text-field>
                      <span v-if="!errors1.password" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                        <span style="line-height:18pt;">uppercase letter, number & special character required</span>
                      </span>
                      <span class="float-right text-danger"  style="min-height:25px;font-size:12px">
                        <span   v-if="errors1.password">{{ errors1.password[0] }}</span>
                        </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-row mb-5">
                      <div class="col-6  mb-lg-0 pr-2">
                        <div class="form-row m-0">
                         

                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                         
                            <v-select
                              v-model="user_new.code"
                              :items="country_all"
                              item-text="country"
                              item-value="id"
                              label="Select"
                              filled
                              background-color="#FFFFFF"
                              class="whiteCheckList"
                              :menu-props="{contentClass: 'checkList-lineGrey'}"
                              dense
                              solo
                              :height="40"
                            >
                              <template
                                slot="selection"
                                slot-scope="data"
                              ><span style="font-size:14px!important;color: rgba(0, 0, 0, 0.87)!important;">{{data.item.code2}} (+ {{data.item.prefix}} )</span></template>
                              <template
                                slot="item"
                                slot-scope="data"
                              >{{data.item.country}} (+ {{data.item.prefix}} )</template>
                            </v-select>

                            <span
                              v-if="errors1.code"
                              class="float-left text-danger" style="font-size:12px"
                            >{{ errors1.code[0] }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-6  mb-lg-0 pl-2">
                        <div class="form-row m-0">
                          
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">

                           <v-text-field
                            label=""
                            placeholder="Mobile"
                            v-model="user_new.number"
                            hide-details
                            flat
                            height="40"
                            solo
                          
                            class="inputClass1"
                          >
                          <template v-slot:prepend-inner>
                              
                                  <img
                                    width="32"
                                    height="32"
                                    src="/images/icons/mobile.svg"
                                    alt=""
                                  >
                            
                            </template>
                          </v-text-field>
                            
                          </div>
                        </div>
                      </div>
                    
                       <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                         <span v-if="!errors1.number" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                          <span style="line-height:18pt;">numbers only</span>
                        </span>
                           <span class="float-right text-danger" style="font-size:12px">
                            <span   v-if="errors1.number">{{ errors1.number[0] }}</span>
                           </span>
                        </div>
                    </div>

                    <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                        <div class="form-row m-0">
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                            <v-checkbox
                              class="float-left age"
                              style="display: inline-block;"
                              v-model="user_new.age"
                              hide-details
                            >
                              <!--<template v-slot:label>
                                                            <label>
                                                                By signing up, you certify that you are 18 years old or older, and you agree to our
                                                                <a
                                                                        href="/terms"
                                                                >Terms & Conditions</a>.
                                                                <span class="text-danger">*</span>
                                                            </label>
                              </template>-->
                            </v-checkbox>

                            <label style="width: 88%;color:#43425D!important;font-size:12px!important;font-weight: 400;line-height:18pt;">
                              By signing up, you certify that you are 18 years old or older, and you agree to our
                              <a style="color: #8EbEF8" target="_blank"
                                href="/terms"
                              >Terms & Conditions</a>.                              
                            </label>
                          </div>
                          <div
                            class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0 mt-0"
                          >
                            <span v-if="errors1.age" class="text-danger float-right" style="font-size:12px">{{ errors1.age[0] }}</span>
                          </div>
                          <div
                            style="font-size: 10px;"
                            v-if="errors1.spam"
                            class="mt-3 col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0 mt-0"
                          >
                            <span class="text-danger float-right" style="font-size:12px">{{ errors1.spam[0] }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row mb-0 mt-0">
               
                      <div class="col-12">
                        
                      <v-btn
                         
                          class="mb-0 btn-block"
                          
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="70"
                          :loading="loading"
                          :disabled="loading"
                          @click="registerUser()"
                        >
                          <span style="color: #ffffff">Join Now</span>
                        </v-btn>
                        
                      </div>
                      <div class="col-12 text-center" style="margin-top:24px">
                      <label style="width: 88%;color:#43425D!important;font-size:12px!important;font-weight: 400;line-height:18pt;">
                              Already have an account ?
                              <a style="color: #8EbEF8" 
                               @click.prevent="f_open_login"
                              ><b>Log In</b></a>                             
                            </label>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        
          </v-card>
        </div>

      </div>

 <div class="row">
        <div class="col sfSign">
          <h3 style="opacity: 0.6; color: #43425d; text-align: center">
            As Featured In
          </h3>
        </div>
      </div>
      <div class="row">
        <div
          class="col sfFeatured"
          style="text-align: center"
          v-if="!$vuetify.breakpoint.xsOnly"
        >
          <img
            style="height: 22px"
            src="/images/press/extra_new.png"
            alt="Extra New"
          />
          <img
            style="height: 16px"
            src="/images/press/refinery29.svg"
            alt="Refinery29"
          />
          <img style="height: 70px" src="/images/press/yahoo.png" alt="" />
          <img style="height: 24px" src="/images/press/msn.svg" alt="" />
          <img
            style="height: 32px"
            src="/images/press/authority_magazine_logo.png"
            alt=""
          />
          <img
            style="height: 18px"
            src="/images/press/la_opinions.png"
            alt=""
          />
          <img style="height: 25px" src="/images/press/ok.png" alt="" />
          <img style="height: 17px" src="/images/press/enquirer.png" alt="" />
        </div>
        <div class="col sfFeaturedMo" v-else>
          <div class="row">
            <div class="col-6" style="text-align: center; height: 70px">
              <img
                style="height: 30px"
                src="/images/press/extra_new.png"
                alt="Extra New"
              />
            </div>
            <div class="col-6" style="text-align: center; height: 70px">
              <img
                style="height: 20px"
                src="/images/press/refinery29.svg"
                alt="Refinery29"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-6" style="text-align: center; height: 70px">
              <img style="height: 70px" src="/images/press/yahoo.png" alt="" />
            </div>
            <div class="col-6" style="text-align: center; height: 70px">
              <img style="height: 32px" src="/images/press/msn.svg" alt="" />
            </div>
          </div>
          <div class="row">
            <div class="col-6" style="text-align: center; height: 70px">
              <img
                style="height: 32px"
                src="/images/press/authority_magazine_logo.png"
                alt=""
              />
            </div>
            <div class="col-6" style="text-align: center; height: 70px">
              <img
                style="height: 23px"
                src="/images/press/la_opinions.png"
                alt=""
              />
            </div>
          </div>
          <div class="row">
            <div class="col-6" style="text-align: center; height: 70px">
              <img style="height: 25px" src="/images/press/ok.png" alt="" />
            </div>
            <div class="col-6" style="text-align: center; height: 70px">
              <img
                style="height: 22px"
                src="/images/press/enquirer.png"
                alt=""
              />
            </div>
          </div>
        </div>
      </div>
      <hr style="margin: 40px 0px" v-if="$vuetify.breakpoint.xsOnly" />


    </div>
  </section>
  

  </div>
</template>

<script>
export default {
  props: ["country_all"],

  data() {
    return {
      errors1: [],
      errors: [],
      error: "",
      email: "",
      message: "",
      loading: false,
      loadingLogin: false,
      loginDialog: false,
       password: "",
      user_new: {
        age: false,
        name: "",
        email: "",
        password: "",
        code: 215,
        number: "",
        token: "",
      },
    };
  },
  computed: {},
  methods: {
     f_open_login(){
                 EventBus.$emit('open_login',  {});
             },
     login() {
      this.loadingLogin = true;
      this.error = "";
      var input = { email: this.email, password: this.password };
      axios
        .post("/ajax/login", input)
        .then((res) => {
          if (res.status == 200) {
            //Created

            if (this.same_page_login) {
              location.reload();
            } else {
              if (res.data.success.url) window.location = res.data.success.url;
              else location.reload();
            }
          }
        })
        .catch((error) => {
          this.loadingLogin = false;

          this.errors = [];

          if (typeof error.response.data === "object") {
            if (error.response.data.error) {
              this.error = error.response.data.error;
            }

            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.message = "There is something wrong.";
        });
    },
    registerUser() {
      var input = this.user_new;
      axios
        .post("/register/user", input)
        .then((res) => {
          if (res.status == 201) {
            window.location = "/dashboard";
          }
          this.loading = false;
          this.errors1 = [];
        })
        .catch((error) => {
          this.user_new.token = "";
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors1 = error.response.data.errors;
          } else {
            this.errors1 = ["Something went wrong. Please try again."];
          }
          this.show = false;
          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    resetUser() {


      this.user_new = {
        name: "",
        last_name: "",
        email: "",
        password: "",
        c_password: "",
        age: false,
        promo_code: "",
      };
    },


    getTokenUser() {
      this.loading = true;
      const self = this;
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6LdkjDkbAAAAALWQ22etlp5ioqqNbeJmLJAtJv93", {
            action: "registerUser",
          })
          .then(function (token) {
            if (token) {
              self.user_new.token = token;
              self.registerUser();
            }
          });
      });
    },
  },
  mounted() {},
};
</script>
<style>

.sfFeatured img {
  margin: 0px 20px;
}

.sfFeaturedMo .row .col-6 {
  height: 70px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sfSign h1 {
  color: #1f1e34;
  text-align: center;
  letter-spacing: 0.64px;
  line-height: 35px;
  font-size: 32px;
  font-weight: 500;
  padding: 40px 0px;
}

.sfSign h2 {
  color: #1f1e34;
  text-align: left;
  letter-spacing: 0.5px;
  line-height: 35px;
  font-size: 25px;
  font-weight: 600;
  padding-bottom: 10px;
}
.sfSign h3 {
  color: #1f1e34;
  text-align: left;
  letter-spacing: 0px;
  line-height: 26px;
  font-size: 16px;
  padding-top: 10px;
}

.sfSign p {
  color: #5a6066;
  text-align: left;
  letter-spacing: 0px;
  line-height: 26px;
  font-size: 16px;
  padding-bottom: 10px;
}
</style>
