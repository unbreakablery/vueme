<template>
  <div class="container PhoneBack" style="background: #F9F9F9; padding: 80px 0px; margin-top:120px; margin-bottom:80px;" >
    <v-card 
    
    :style="[ !$vuetify.breakpoint.xsOnly ? {'width': '400px '}:{'margin': '0px 20px'}]"
    style="background: #fff;  !important; margin: auto; padding-bottom:25px">
      <v-card-text class="p-0">
        <div class="row m-0">
          <div class="col-12" style="padding-top:60px !important">
            <div
              class="px-2"
              style="font-size: 18px; color: #1F1E34; font-weight: 600; text-align:center"
            >
              Verify Your Phone Number
            </div>

            <div class="card-body p-0 p-lg-5 pt-1">
              <form
                @submit.prevent="verifyCode"
                class="registration_form pt-0 pb-0"
              >
                <div class="form-row mb-3" style="text-align:center">
                  <label
                    class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    style="
                      font-size: 14px !important;
                      color: #131220 !important;
                      font-weight: 600;
                      line-height: 26px;
                    "
                  >
                    Enter the Code We Texted You<br>
                    <label class="html_code" style="
                      font-size: 12px !important;
                      color: #949498 !important;
                      font-weight: 500;
                      line-height: 26px;
                    " v-html="notice"></label>
                  </label>

                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <input
                      id="verification_code"
                      v-model="code"
                      type="text"
                      style="max-width:270px; border: 1.5px solid rgb(148, 148, 148); margin:auto"
                      class="form-control"
                      background="#FFFF"
                      name="verification_code"
                      value=""
                      autocomplete="off"
                      placeholder="Verification Code"
                      autofocus
                    />
                    <span
                      v-if="errors['code']"
                      class="float-left text-danger small"
                      >{{ errors["code"][0] }}</span
                    >
                    <span v-if="error" class="float-left text-danger small">{{
                      error
                    }}</span>
                  </div>
                </div>

                <div class="form-row mb-0 mt-1"  style="">
                  <div class="col-12 text-left mb-5" style="font-size: 14px !important;
                      color: #43425D !important; font-weight: 500; text-align:center !important">
                      Didn’t Receive Your Code? 
                    <a
                      href="#" v-if="!saving" @click.prevent="resendCode()"
                      style="font-size: 14px; font-weight: 600; color: #9759FF"
                      >Resend</a
                    >
                  </div>
                  <div class="col-12 mb-5" style="text-align:center">
                    <v-btn
                      class="white--text mb-0 btn-block btn_submit"
                      type="submit"
                      rounded
                      style=""
                      min-width="84"
                      max-width="170"
                      color="#8EbEF8"
                      :loading="saving"
                      :disabled="saving"
                      >Submit</v-btn
                    >
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </v-card-text>
    </v-card>

   
  </div>
</template>
<style>
.html_code b{
color:#9759FF !important;
}
.btn_submit{
margin:auto;
background:#7272FF !important; 
border-color:#9759FF !important;
border-radius:12px; 
padding-top: 6px !important;
padding-bottom: 6px !important;
box-sizing: content-box !important;
}
.btn_submit span{
  font-size: 12px !important;
font-weight: 600 !important;
}
</style>
<script>
export default {
  props: ["notice", "phone", "user", "redirect"],
  data: function () {
    return {
      loading: true,
      saving: false,
      errors: [],
      code: "",
      error: "",
    };
  },
  mounted () {

        setTimeout(function () {
            window.scrollTo(0, 0);
            console.log('aqui++++ Mounted');
        },300);

  },
  ready(){},
  methods: {

  
    verifyCode() {
      this.saving = true;

      var input = { code: this.code };

      axios
        .post("/api/v1/user/verify/phone/code", input)
        .then((response) => {
          if (response.status === 200) {
            this.redirect ="/explore"
            if (this.redirect) window.location.href = this.redirect;
            else location.reload();
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }

          if (typeof error.response.data === "object") {
            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
              this.error = "";
            }

            if (error.response.data.error) {
              this.error = error.response.data.error.message;
              this.errors = [];
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.saving = false;
          this.message = "";
        });
    },
    resendCode() {
      this.saving = true;

      axios
        .post("/api/v1/user/resend/phone/code")
        .then((response) => {
          if (response.status === 200) {
            this.saving = false;
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }

          if (typeof error.response.data === "object") {
            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
              this.error = "";
            }

            if (error.response.data.error) {
              this.error = error.response.data.error.message;
              this.errors = [];
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.saving = false;
          this.message = "";
        });
    },
  },
};
</script>

<style>
.PhoneBack .form-control {
    background-color: #fff !important;
      border-radius: 5px;

}

.PhoneBackGround .v-application--wrap{
    background: #fff !important;
}
body { height: 100%; }
</style>