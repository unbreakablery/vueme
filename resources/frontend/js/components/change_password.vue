<template>
  <div class="container PhoneBack change_pass" style="background: #F9F9F9; padding: 80px 0px; margin-top:120px; margin-bottom:80px;" >
    <v-card 
    
    :style="[ !$vuetify.breakpoint.xsOnly ? {'width': '400px '}:{'margin': '0px 20px'}]"
    style="margin: auto; box-shadow: none !important;  background:none; padding-bottom:25px">
        <h2 style="font-size:24px; font-weight:500; color:#42424D">Set New Password</h2>
      <v-card-text class="p-0" style="width:100%; margin-top:20px; background: #fff;  !important;  box-shadow: 2px 1px 15px -9px rgb(162 162 162) !important;">
        <div class="row m-0">
          <div class="col-12" style="padding-top:20px !important">


            <div class="card-body p-0 p-lg-5 pt-1">
              <form
                @submit.prevent="verifyCode"
                class="registration_form pt-0 pb-0"
              >
                <div class="form-row mb-3" style="text-align:center;">

                  <label
                    class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    style="
                      font-size: 14px !important;
                      color: #131220 !important;
                      font-weight: 600;
                      line-height: 26px;
                      text-align:left;
                       margin-top:10px

                    "
                  >
                    Email Address <span style="color:red">*</span>
                  </label>

                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <input
                      id="verification_code"
                      v-model="email_addres"
                      type="email"
                      style="border: 1.5px solid rgb(148, 148, 148); margin:auto"
                      class="form-control"
                      background="#FFFF"
                      name="verification_code"
                      value=""
                      required
                      autocomplete="off"
                      autofocus
                    />
                    <span
                      v-if="errors['email_addres']"
                      class="float-left text-danger small"
                      >{{ errors["email_addres"][0] }}</span
                    >
                    <span v-if="error" class="float-left text-danger small">{{
                      error
                    }}</span>
                  </div>




                    
                  <label
                    class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    style="
                      font-size: 14px !important;
                      color: #131220 !important;
                      font-weight: 600;
                      line-height: 26px;
                      text-align:left;
                       margin-top:10px
                    "
                  >
                   Password<span style="color:red">*</span>
                  </label>

                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <input
                     id="new_password"
                      v-model="new_password"
                      type="password"
                      style="border: 1.5px solid rgb(148, 148, 148); margin:auto"
                      class="form-control"
                      background="#FFFF"
                      name="verification_code"
                      value=""
                      required
                      autocomplete="off"
                      autofocus
                    />
 

          <span
            v-if="errors['new_password']"
            class="float-left text-danger small"
            >{{ errors["new_password"][0] }}</span
          >
                  </div>




                    
                  <label
                    class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    style="
                      font-size: 14px !important;
                      color: #131220 !important;
                      font-weight: 600;
                      line-height: 26px;
                      text-align:left;
                       margin-top:10px
                    "
                  >
                    Confirm New Password <span style="color:red">*</span>
                  </label>

                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <input
                      id="current_password"
                      v-model="current_password"
                      type="password"
                      style="border: 1.5px solid rgb(148, 148, 148); margin:auto"
                      class="form-control"
                      background="#FFFF"
                      name="verification_code"
                      value=""
                      required
                      autocomplete="off"
                      autofocus
                    />
                    
  



            <span
            v-if="errors['current_password']"
            class="float-left text-danger small"
            >{{ errors["current_password"][0] }}</span
          >
                  </div>

                </div>

                <div class="form-row mb-0 mt-1"  style="">
                 
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
                      >Change Password</v-btn
                    >
                    <br>
                    <div style="width:100%; text-align:center; margin-top:10px">
                                <span
            class="text-danger small" style="color: #01bf16 !important"
            >{{ message_action }}</span
          >
                    </div>
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
  props: ["notice", "phone", "user", "redirect", "token_user", "email_user"],
  data: function () {
    return {
      loading: true,
      saving: false,
      errors: [],
      code: "",
      message_action:"",
      email_addres:"",
      error: "",
      current_password:"",
      new_password:"",
      regex: /^[a-z\d,.'"’?\-_\s]+$/i,
      regexSix: /^.{6,}$/, 
      regexUpper: /[A-Z]/,
      regexNumber: /[0-9]/,
      regexChar: /[!@#$%^&*]/,
    };
  },
  mounted () {
this.email_addres = this.email_user;
        setTimeout(function () {
            window.scrollTo(0, 0);
            console.log('aqui++++ Mounted');
        },300);

  },
  ready(){},
  methods: {

  
    verifyCode() {
      

        this.errors=[];

        
        if(this.email_user != this.email_addres){
          this.errors["email_addres"] = ["Invalid email"];
          return;
        }

        if(this.new_password != this.current_password){
          this.errors["new_password"] = ["La confirmación de la contraseña no es válida"];
          this.errors["current_password"] = ["La confirmación de la contraseña no es válida"];
          return;
        }

        this.saving = true;
      var input = {token:this.token_user, email:this.email_addres, 
      current_password:this.current_password,
      new_password:this.new_password };

      axios
        .post("/password/changepass", input)
        .then((response) => {
          if (response.status === 200) {
            this.redirect ="/"
            this.message_action="Password reset successfully";
            this.saving = false;
            setTimeout(function(){
                window.location.href="/";
            },1500)
            
  
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
.change_pass .my-helper{
    text-align:left !important;
}
body { height: 100%; }
</style>