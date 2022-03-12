<template>
  <div class="model-profile-container">
    <div
          class="d-flex align-center justify-center mb-5"
          v-if="todoPercent && $vuetify.breakpoint.mdAndUp"
          style="background-color: #f1f1f1; height: 200px; width: 100%"
        >
          <div class="w-100">
            <div class="d-flex align-center justify-center">
              <span style="color: #1f1e34; font-size: 16px; font-weight: 600"
                >To-Do Items</span
              >
              <div
                class="ml-2"
                style="
                  background-color: #d6f0d3;
                  height: 16px;
                  width: 175px;
                  position: relative;
                  text-align: center;
                "
              >
                <span
                  class="d-flex aling-center justify-center"
                  style="color: #1f1e34; font-size: 10px; font-weight: 600"
                >
                  <span style="margin-top: 1px; z-index: 2"
                    >{{ todoPercent }}%</span
                  ></span
                >
                <span
                  style="
                    top: 0px;
                    position: absolute;
                    background-color: #74cc6b;
                    height: 16px;
                    left: 0;
                  "
                  :style="{ width: `${parseInt((todoPercent * 175) / 100)}px` }"
                ></span>
              </div>
            </div>
            <div
              class="mt-1"
              style="
                color: #131220;
                font-size: 14px;
                font-weight: 600;
                text-align: center;
              "
            >
              Complete these steps to go live and start earning $!
            </div>

            <div class="mt-5">
              <div
                class="row"
                style="max-width: 740px; margin: auto !important"
              >
                <div class="col-4" style="font-size: 16px; font-weight: 600">
                  <div v-if="todoList.haedshot_path.missing">
                    <a
                      :href="todoList.haedshot_path.link"
                      style="color: #9759ff"
                      >• Add a profile photo</a
                    >
                  </div>
                  <div v-else style="color: #74cc6b">
                    • Add a profile photo
                    <v-icon color="#74CC6B">mdi-check</v-icon>
                  </div>
                </div>
                <div
                  class="col-4"
                  style="font-size: 16px; color: #9759ff; font-weight: 600"
                >
                  <div v-if="todoList.rate.missing">
                    <a :href="todoList.rate.link" style="color: #9759ff"
                      >• Set your rates</a
                    >
                  </div>
                  <div v-else style="color: #74cc6b">
                    • Set your rates
                    <v-icon color="#74CC6B">mdi-check</v-icon>
                  </div>
                </div>
                <div
                  class="col-4"
                  style="font-size: 16px; color: #9759ff; font-weight: 600"
                >
                  <div v-if="todoList.live.missing">
                    <a @click.prevent="createLiveStream" style="color: #9759ff"
                      >• Go Live</a
                    >
                  </div>
                  <div v-else style="color: #74cc6b">
                    • Go Live
                    <v-icon color="#74CC6B">mdi-check</v-icon>
                  </div>
                </div>
              </div>
              <div
                class="row mt-4"
                style="max-width: 740px; margin: auto !important"
              >
                <div
                  class="col-4"
                  style="font-size: 16px; color: #9759ff; font-weight: 600"
                >
                  <div v-if="todoList.description.missing">
                    <a :href="todoList.description.link" style="color: #9759ff"
                      >• Add a bio</a
                    >
                  </div>
                  <div v-else style="color: #74cc6b">
                    • Add a bio
                    <v-icon color="#74CC6B">mdi-check</v-icon>
                  </div>
                </div>
                <div
                  class="col-4"
                  style="font-size: 16px; color: #9759ff; font-weight: 600"
                >
                  <div v-if="todoList.bank_account.missing">
                    <a :href="todoList.bank_account.link" style="color: #9759ff"
                      >• Connect a bank account</a
                    >
                  </div>
                  <div v-else style="color: #74cc6b">
                    • Connect a bank account
                    <v-icon color="#74CC6B">mdi-check</v-icon>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <h1 class="txt">Edit Profile</h1>
    <div class="change-main card-box-shadow">
      <div class="userimg">

        <div class="col-lg-4 col-12" style="left: 20px;">
          <div
            v-if="image.search('AVATAR_DEFAULT.png') >= 0"
            class="col-12 mt-5 text-center justify-center d-flex"
          >
            <div style="position: relative; margin-bottom: 20px">
              <div
                id="profile-pic2"
                class="overlay-upload-btn d-flex align-center"
              >
                <image_cropper
                  :visible="avatarBlob"
                  :empty="true"
                  :profile="user.profile"
                  @onImageCropped="assignBlob"
                  target-preview-element="profile-img"
                  outputWidth="250"
                  outputHeight="250"
                  ratioX="1"
                  ratioY="1"
                  blobRef="avatarBlob"
                >
                  <img
                    :alt="user.profile.display_name"
                    id="profile-img"
                    v-bind:src="image"
                    class="profile-input-img"
                  />
                </image_cropper>
                <span
                  v-if="this.saveImageMsn"
                  id="saveImageMsn"
                  class="hover-text-success text-center"
                >
                  {{ message_upload }}</span
                >
              </div>
              <div
                v-if="this.saveImage & !this.saveImageMsn"
                class="sfSavePic hover hoverProfile text-center sfSavePic"
                style="
                  position: absolute !important;
                  top: 115px;
                  right: 20px;
                "
              >
                <v-btn
                  :loading="savingImage"
                  :disabled="savingImage"
                  depressed
                  small
                  text
                  class="white--text"
                  color="primary"
                  @click="saveAvatar()"
                  >Save</v-btn
                >
              </div>
            </div>

          </div>
          <div v-else class="col-12 mt-5 text-center justify-center d-flex">
            <div style="position: relative; margin-bottom: 20px">
              <div
                id="profile-pic2"
                class="overlay-upload-btn d-flex align-center"
              >
                <image_cropper
                  :profile="user.profile"
                  @onImageCropped="assignBlob"
                  target-preview-element="profile-img"
                  outputWidth="250"
                  outputHeight="250"
                  ratioX="1"
                  ratioY="1"
                  blobRef="avatarBlob"
                >
                  <img
                    :alt="user.profile.display_name"
                    id="profile-img"
                    v-bind:src="image"
                    class="profile-input-img"
                    style="box-shadow: 0px 3px 6px #0000000d"
                  />
                </image_cropper>
                <span
                  v-if="this.saveImageMsn"
                  id="saveImageMsn"
                  class="hover-text-success text-center"
                >
                  {{ message_upload }}</span
                >
              </div>
              <div
                v-if="this.saveImage & !this.saveImageMsn"
                class="sfSavePic hover hoverProfile text-center sfSavePic"
                style="
                  position: absolute !important;
                  top: 115px;
                  right: 5px;
                "
              >
                <v-btn
                  :loading="savingImage"
                  :disabled="savingImage"
                  color="primary"
                  outlined
                  small
                  text
                  class="white--text"
                  :class="{
                    'xs-save-photo': $vuetify.breakpoint.xsOnly,
                    'sm-save-photo': $vuetify.breakpoint.smOnly,
                    'md-save-photo': $vuetify.breakpoint.mdOnly,
                    'lg-save-photo': $vuetify.breakpoint.lgAndUp,
                  }"
                  style="width: 90px !important"
                  @click="saveAvatar()"
                  >Save</v-btn
                >
              </div>
            </div>

          </div>

          <image_cropper_label
            :visible="avatarBlob"
            :empty="true"
            :profile="user.profile"
            @onImageCropped="assignBlob"
            target-preview-element="profile-img"
            outputWidth="250"
            outputHeight="250"
            ratioX="1"
            ratioY="1"
            blobRef="avatarBlob"
          />

        </div>


        <!-- Video upload -->
        <div class="col-lg-4 col-12" style="right: 20px;">
          <div
            v-if="video"
            class="col-12 mt-5 text-center justify-center d-flex media_uploader sfProfileFormVideo"
          >
            <div style="position: relative; margin-bottom: 20px; border-radius: 5px;">
              
              <v-btn
                class="no-background-hover p-0 m-0"
                text
                style="height: 104px; cursor: default;"
                v-if="video"
                @click.stop="
                  videoPlay = true;
                  videoDialog = true;
                "
              >
                <video
                  class="p-0 m-0"
                  style="border-radius: 16px;height: 99px;width: 96px;"
                  v-if="video != ''"
                  v-bind:src="video"
                  preload="auto"
                ></video>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error != ''">
                {{ format_error }}
              </div>


            </div>

          </div>
          

          <div v-else
              class="sfProfileVideo_model sfProfileVideotOP_model sfProfileVideoIco_model d-flex align-center justify-center">
            <div class="buttons-area text-center">
              <div
                class="grey--text mb-3"
                :key="file.name"
                v-for="file in files"
              >
                <video
                  class="p-0 m-0"
                  style="border-radius: 16px;height: 99px;width: 96px;"
                  v-if="video != ''"
                  v-bind:src="video"
                  preload="auto"
                ></video>
              </div>
              <div v-if="files.length == 0">

                  <v-btn style="cursor: default;" v-if="format_error == ''">
                    <div style="padding-bottom: 10px">
                      <img class="null_video" src="/images/profile/video_thumbnail.png" style="height: 99px;width: 96px;" />
                    </div>
                  </v-btn>

                  
              </div>
              <div class=" text-danger msnInput" v-if="format_error != ''">
                {{ format_error }}
              </div>
            </div>
          </div>
          

          <div
              class="sfProfileFormVideo">
            <file-upload
              v-show="files.length == 0"
              input-id="video_upload_top1"
              post-action="/api/v1/user/profile/video/upload"
              ref="upload"
              v-model="files"
              :drop="!$refs.upload || !$refs.upload.active"
              :disabled="$refs.upload && $refs.upload.active"
              @input-filter="inputFilter"
              @input="updatetValue"
              @input-file="inputFile"
              :headers="{ 'X-CSRF-TOKEN': token }"
            >

              <v-btn
              v-if="
                (!$refs.upload || !$refs.upload.active) && files.length > 0
              "
              class="buttonVideoSub"
              style="letter-spacing: 0;z-index: 2;text-align: center;top: -5px;left: 52px;"
              @click.prevent="$refs.upload.active = true"
              
              >Start</v-btn>
              <!-- <v-btn  v-else>Update </v-btn> -->
              <div 
                  v-if="
                  ($refs.upload) && files.length <= 0
                  " class="fan-image-font btn-upload-wrapper" style="text-align: center; cursor: pointer;">
            

                <div
                  class="fan-image-font"
                  style="margin: auto 0px;">
                  <h4
                    style="font-size: 14px; font-weight: 600; 
                    color: #f77f98; text-align: center"
                  >
                    Change / Edit
                  </h4>
                </div>

              </div>


              <v-progress-circular
              class="buttonVideoSub"
              style="letter-spacing: 0;z-index: 2;text-align: center;top: -5px;left: 52px;"
                v-if="$refs.upload && $refs.upload.active"
                :width="2"
                color="primary"
                indeterminate
              ></v-progress-circular>

            </file-upload>
          </div>
          
        </div>         
        
        <!-- <button @click="inputClick">Change / Edit</button>
        <input class="filechange" type="file" @change="onFileChange" hidden> -->
      </div>

      <div class="buttonbar edit-buttonbar">
        <button class="account" @click="accountShow">
          <span>Account</span>
        </button>
        <button class="profile" @click="profileShow">
          <span>Profile</span>
        </button>
      </div>
    </div>

    <div
      class="form-container model-profile-main card-box-shadow"
      id="profilemain"
    >
      <h2 class="info-txt">Profile Infomation</h2>
      <form @submit="(e) => e.preventDefault()">
        <div class="profileinfo pd-none row" style="padding-left:0 !important; padding-right:0 !important">
          <div class="col-md-6 col-sm-12 col-12 " style="padding-left:0; padding-right:0">
            <h3>Profile Link<span >  *</span>
            </h3>
            <input
              type="text"
              readonly disabled
              style="color: #848484!important;
              background-color: #eee!important;
              border-color: #eee;"
              placeholder=""
              maxlength="20"
              v-model="user.profile.profile_link"
            />



                                <div class="iconbar"  style="float:left; margin-top:10px; padding-left:0 ">
          <a @click.stop="share('facebook')">
            <i class="fab fa-facebook-square"></i>
          </a>
          <a @click.stop="share('twitter')">
            <i class="fab fa-twitter"></i>
          </a>
          <a @click.stop="copyUrl()">
            <i class="fa fa-copy"></i>
          </a>
        </div>


          </div>



          <div  class="col-md-6 col-sm-12 col-12 "  style="padding-left:0; padding-right:0">
            <h3>Wishlist (Optional)<span> </span></h3>
            <input
              type="text"
              placeholder="https://www.amazon.com/hz/wishlist/.."
              maxlength="150"
              v-model="user.profile.social_link_three"
            />
          </div>


          <div  class="col-md-6 col-sm-12 col-12 "  style="padding-left:0; padding-right:0">
            <h3>Social Link #1<span> </span></h3>
            <input
              type="text"
              placeholder="https://www.instagram.com/profile/"
              maxlength="120"
              v-model="user.profile.social_link_one"
            />
          </div>
          <div  class="col-md-6 col-sm-12 col-12 "  style="padding-left:0; padding-right:0">
            <h3>Social Link #2<span> </span></h3>
            <input
              type="text"
              placeholder="https://www.facebook.com/profile/"
              maxlength="150"
              v-model="user.profile.social_link_two"
            />
          </div>
        </div>

        <div class="descriptions pd-none col-md-12 col-sm-12 col-12 ">
          <h3>Description<span> *</span></h3>
          <v-textarea
            id="profile_description"
            v-model="user.profile.description"
            @input="
              textErr = [];
              errors = [];
            "
            @keyup="
              user.profile.description = validateText(
                user.profile.description,
                5
              )
            "
            solo
            :maxlength="400"
            background-color="#fff"
            class="sfInputBackgroundClass"
            filled
            flat
            width="730"
            name="input-7-4"
            hide-details
            label=""
          ></v-textarea>
          <div
                  v-if="this.errors != [] && this.errors['profile.description']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.description"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[5] }}
                </div>
                <span
                  v-if="!this.textErr[5] && !this.errors['profile.description']"
                >
                  <div 
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.description"
                  >
                    400 characters left
                  </div>
                  <div
                    class="sfHelperCharacters"
                    v-else-if="
                      this.user.profile.description &&
                      parseInt(this.user.profile.description.length) > 400
                    "
                    style="color: red"
                  >
                    {{ parseInt(this.user.profile.description.length) - 400 }}
                    characters over
                  </div>
                  <div class="sfHelperCharacters" v-else>
                    {{ 400 - parseInt(this.user.profile.description.length) }}
                    characters left
                  </div>
          </span>
        </div>
        <div class="subtitle-1 mb-0 pd-none">
          <v-btn
            class="py-5 px-6"
            style="
              min-width: auto !important;
              background: linear-gradient(256deg, #7272ff 0%, #9759ff 100%);
              box-shadow: 0 2px 4px #9759ff4d;
              border-radius: 12px;
              outline: none;
            "
            type="submit"
            color="primary"
            :loading="savingProfile"
            :disabled="savingProfile"
            rounded
            @click="updateProfile(3)"
          >
            <span style="font-size: 12px; letter-spacing: 0.43px"
              >Save Information</span
            >
          </v-btn>
          <span style="color: #01bf16; font-size: 75%" v-if="profileSaved[3]"
            >Successfully Saved.</span
          >
        </div>
      </form>
    </div>
    <div
      class="form-container model-profile-main card-box-shadow mb-30"
      id="accountmain"
    >
      <h2 class="info-txt">Account Information</h2>
      <form @submit="(e) => e.preventDefault()">
        <v-row align="center">
          <v-col class="d-flex pd-none" cols="12" sm="12">
            <div class="input" style="width: 100%">
              <h3>Display Name<span> *</span></h3>
              <v-text-field
                id="profile_display_name"
                label="Display Name"
                :maxlength="46"
                @input="
                  textErr = [];
                  errors = [];
                "
                solo
                flat
                dense
                hide-details
                background-color="#fff"
                :filled="user.profile.displayNameEdit == 1"
                :class="[
                  user.profile.displayNameEdit
                    ? 'sfInputClass'
                    : 'sfInputClassInactive',
                ]"
                v-model="user.profile.display_name"
              >
              </v-text-field>
              <p class="display-limit">45 characters left</p>
            </div>
          </v-col>
          <v-col class="d-flex pd-none" cols="12" sm="12" md="6">
            <div class="input" style="width: 100%">
              <h3>First Name<span> *</span></h3>
              <v-text-field
                id="profile_name"
                label="First Name"
                solo
                @input="
                  textErr = [];
                  errors = [];
                "
                @keyup="user.profile.name = validateText(user.profile.name, 1)"
                :maxlength="50"
                background-color="#fff"
                dense
                filled
                hide-details
                v-model="user.profile.name"
                class="sfInputClass"
              ></v-text-field>
            </div>
          </v-col>
          <v-col class="d-flex pd-none" cols="12" sm="12" md="6">
            <div class="input" style="width: 100%">
              <h3>Last Name<span> *</span></h3>
              <v-text-field
                id="profile_last_name"
                label="Last Name"
                :maxlength="50"
                @input="
                  textErr = [];
                  errors = [];
                "
                @keyup="
                  user.profile.last_name = validateText(
                    user.profile.last_name,
                    2
                  )
                "
                background-color="#fff"
                solo
                flat
                dense
                hide-details
                filled
                v-model="user.profile.last_name"
                class="sfInputClass"
              ></v-text-field>
            </div>
          </v-col>
          <v-col class="d-flex pd-none" cols="12" sm="12" md="6">
            <div class="input" style="width: 100%">
              <h3>Email<span> *</span></h3>
              <v-text-field
                id="email"
                label="Email Address"
                solo
                flat
                disabled
                dense
                background-color="#fff"
                hide-details
                filled
                v-model="user.email"
                class="sfInputClassInactive"
              ></v-text-field>
            </div>
          </v-col>
          <v-col class="d-flex pd-none" cols="5" sm="6" md="3">
            <div class="input" style="width: 100%">
              <h3>Country Code<span> *</span></h3>

              <v-select
                id="phone_numbers_0_code2"
                :items="country_all"
                label="Select"
                class="checkRigth right-align"
                filled
                flat
                background-color="#fff"
                item-text="prefix"
                item-value="code2"
                hide-details
                disabled
                dense
                solo
                auto
                autocomplete
                v-model="user.phone_numbers[0].code2"
                :menu-props="{ contentClass: 'checkList-lineBlue' }"
              >
                <template slot="selection" slot-scope="data">
                  <!-- // HTML that describe how select should render selected items -->
                  +{{ data.item.prefix }} - {{ data.item.code3 }}
                </template>
                <template slot="item" slot-scope="data">
                  <!-- // HTML that describe how select should render items when the select is open -->
                  +{{ data.item.prefix }} - {{ data.item.code3 }}
                </template>
              </v-select>
              <span
                v-if="errors['phone_numbers.0.code2']"
                class="float-left text-danger small"
                >{{ errors["phone_numbers.0.code2"][0] }}</span
              >
            </div>
          </v-col>
          <v-col class="d-flex pd-none" cols="7" sm="6" md="3">
            <div class="input" style="width: 100%">
              <h3>Mobile<span> *</span></h3>
              <v-text-field
                id="phone_numbers_0_number"
                label="(555) 555-5555"
                background-color="#fff"
                solo
                flat
                dense
                disabled
                hide-details
                filled
                type="tel"
                class="sfInputClassInactive sfInputClassLeft"
                v-model="user.phone_numbers[0].number"
              ></v-text-field>
            </div>
          </v-col>
          <v-col  cols="12" sm="6">
            <div class="input" style="width: 100%">
            <h3>Timezone<span> *</span></h3>
              <v-select
                :items="timezonesSelect"
                label="Select"
                class="checkRigth right-align"
                filled
                flat
                background-color="#fff"
                hide-details
                dense
                solo
                auto
                autocomplete
                v-model="user.profile.timezone"
                :menu-props="{ contentClass: 'checkList-lineBlue' }"
              ></v-select>
            </div>
          </v-col>
        </v-row>
        <div class="subtitle-1 mb-0 model-save-btn">
          <v-btn
            class="py-5 px-6"
            style="
              min-width: auto !important;
              background: linear-gradient(256deg, #7272ff 0%, #9759ff 100%);
              box-shadow: 0 2px 4px #9759ff4d;
              border-radius: 12px;
              margin-left: 10px;
              outline: none;
            "
            type="submit"
            color="primary"
            :loading="savingProfile"
            :disabled="savingProfile"
            rounded
            @click="updateProfile(1)"
          >
            <span style="font-size: 12px; letter-spacing: 0.43px"
              >Save Information</span
            >
          </v-btn>
          <span style="color: #01bf16; font-size: 75%" v-if="profileSaved[1]"
            >Successfully Saved.</span
          >
        </div>
      </form>
    </div>
    <div
      class="form-container model-profile-main card-box-shadow"
      id="accountadditional"
    >
      <h2 class="info-txt">Categories</h2>
      <form @submit="(e) => e.preventDefault()">
        <div class="categories-info pd-none mb-6">
          <div class="row mb-5 m-0">
            <div
              class="col-md-3 col-12 col-sm-4 col-lg-3 p-0 sfProfileList"
              :key="index"
              v-for="(item, index) in categories"
            >
              <v-checkbox
                v-model="user.categories"
                :label="item.name"
                :value="item"
                color="primary"
              ></v-checkbox>
            </div>
          </div>
        </div>
        <div class="pd-none">
          <v-btn
            class="py-5 px-6"
            style="
              min-width: auto !important;
              background: linear-gradient(256deg, #7272ff 0%, #9759ff 100%);
              box-shadow: 0 2px 4px #9759ff4d;
              border-radius: 12px;
              outline: none;
            "
            type="submit"
            color="primary"
            :loading="savingProfile"
            :disabled="savingProfile"
            rounded
            @click="updateProfile(2)"
          >
            <span style="font-size: 12px; letter-spacing: 0.43px"
              >Save Information</span
            >
          </v-btn>
          <span style="color: #01bf16; font-size: 75%" v-if="profileSaved[2]"
            >Successfully Saved.</span
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import moment from "moment";
const csrf = $('meta[name="csrf-token"]').attr("content");
import image_cropper from "./psychic/image_cropper";
import image_cropper_label from "./psychic/image_cropper_labeltext";
export default {
  components: { image_cropper, image_cropper_label },
  props: [
    "countries",
    "states",
    "categories",
    "specialties",
    "tools",
    "styles",
    "languages",
    "timezones",
    "country_all",
    "todoList",
    "tab_select",
  ],
  data() {
    return {
      textErr: [],
      regex: /^[a-z\d,.!'’?\-_\s]+$/i,
      loading: true,
      savingProfile: false,
      profileSaved: [false, false, false],
      user: {
        phone_numbers: [{ number: "" }],
        profile: [{ description: "" }],
      },
      profileObj: {},
      profile: {},
      errors: [],
      message: "",
      format_error: "",
      format_error_audio: "",
      message_upload: "",
      message_upload_cover: "",
      gender: ["Male", "Female", "Prefer Not to Say"],
      test: [],
      saveImage: false,
      saveCover: false,
      savingImage: false,
      savingCover: false,
      saveImageMsn: false,
      fileUploadFormData: new FormData(),
      fileUploadFormDataCover: new FormData(),
      image: "",
      cover_path: "",
      edit_abilities: false,
      edit_specialties: false,
      edit_tools: false,
      edit_styles: false,
      edit_languages: false,
      files: [],
      filesAudio: [],
      fileAudio: {},
      token: csrf,
      video: "",
      audio: "",
      upload_is_active: false,
      message_blob: {
        image: "",
        type: "",
      },
      edit_video: false,
      edit_audio: false,
      avatarBlob: "",
      fullBodyBlob: "",
      categoryList: [
        { label: "Instagram Models", value: true },
        { label: "Female Models", value: true },
        { label: "Foot Models", value: true },
        { label: "Cosplay", value: true },
        { label: "Fitness Models", value: true },
        { label: "Dancers", value: true },
        { label: "Male Models", value: true },
        { label: "Actresses", value: true },
      ],
      
      video: "",
      videoPlay: false,
      videoDialog: false,
      edit_video: false,
      format_error: "",
      timezonesSelect: []

    };
  },
  computed: {
    todoPercent() {
      if (!this.todoList) return null;

      let count = 0,
        items = 0;
      for (const property in this.todoList) {
        items++;
        if (!this.todoList[property].missing) {
          count++;
        }
      }
      return count != items ? parseInt((100 * count) / items) : null;
    },
  },
  watch: {
    avatarBlob(val) {
      this.saveImage = true;
    },
    fullBodyBlob(val) {
      this.saveCover = true;
    },
    saveImage(val) {
      var up = document.getElementsByClassName("hoverProfile");
      if (up.length > 0) {
        if (val == true && !this.saveImageMsn) {
          up[0].style.border = "none";
        } else up[0].style.border = "1px solid #910f24";
      }
    },
  },
  methods: {
    processImage(event) {

      var reader = new FileReader();

      reader.onload = (e) => {
        this.image = e.target.result;
        this.cropDialog = true;

        this[event.target.getAttribute("data-img")] = e.target.result;

        if (this.$refs[event.target.getAttribute("data-img")]) {
          this.$refs[event.target.getAttribute("data-img")].replace(
            e.target.result
          );
        }
      };
      
    },
    copy_streaming_key() {
      this.$refs.streaming_key.select();
      document.execCommand("copy");
    },
    inputClick() {
      document.getElementsByClassName("filechange")[0].click();
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let image = new Image();
      let reader = new FileReader();
      let vm = this;

      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    accountShow() {
      document.getElementById("accountmain").style.display = "block";
      document.getElementById("accountadditional").style.display = "block";
      document.getElementById("profilemain").style.display = "none";
      document.getElementsByClassName("account")[0].style.backgroundColor =
        "#ceb5fa";
      document.getElementsByClassName("profile")[0].style.backgroundColor =
        "transparent";
      document.getElementsByClassName("account")[0].style.color = "#131220";
      document.getElementsByClassName("profile")[0].style.color = "#949498";
    },
    profileShow() {
      document.getElementById("accountmain").style.display = "none";
      document.getElementById("accountadditional").style.display = "none";
      document.getElementById("profilemain").style.display = "block";
      document.getElementsByClassName("account")[0].style.backgroundColor =
        "transparent";
      document.getElementsByClassName("profile")[0].style.backgroundColor =
        "#ceb5fa";
      document.getElementsByClassName("account")[0].style.color = "#949498";
      document.getElementsByClassName("profile")[0].style.color = "#131220";
    },
    getProfile() {
      axios
        .get("/api/v1/user/profile")
        .then((response) => {
          this.user = response.data.success.profile;
          this.image = this.user.profile.profile_headshot_url;
          this.cover_path = this.user.profile.cover_path;
          this.saveCover = false;
          this.video = this.user.profile.intro_video_path;
          this.thumbnail = this.user.profile.intro_video_thumbnail;
          this.audio = this.user.profile.intro_audio_path;
          this.loading = false;
          if (this.video == "") {
            this.edit_video = true;
          }
          if (this.audio == "") {
            this.edit_audio = true;
          }

          //this.setupDragDrop();
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    updateProfile(action) {
      this.user.profile.profile_headshot_url = this.image;
      this.savingProfile = true;
      this.textErr = [];
      var input = this.user;
      let tab = 1;

      if (action == 2) {
        tab = 2;
      }

      if (action == 3) {
        tab = 3;
      }
       let thas = this;
      axios
        .post(`/api/v1/user/profile/save?tab=${tab}`, input)
        .then((response) => {
          setTimeout(() => {
            this.savingProfile = false;
            this.profileSaved[action] = true;
            setTimeout(() => {
              this.profileSaved[action] = false;
            }, 2000);
          }, 1000);
          thas.$root.$emit('change_name_display', {name:input.profile.display_name});



          this.user.profile.profile_link =
            response.data.success.profile.profile_link;

          document.querySelector("#view_profile")
            ? (document.querySelector("#view_profile").href =
                "/" + response.data.success.profile.profile_link)
            : (document.querySelector("#view_profile_mobile").href =
                "/" + response.data.success.profile.profile_link);
          this.message = response.data.message;
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
            var key = Object.keys(this.errors)[0];
            var str = key.replace(/\./g, "_");


            if (str == "profile_link" || str == "profile_description") {
              this.active_tab = 1;
            }

            if (
              str == "profile_display_name" ||
              str == "profile_name" ||
              str == "profile_last_name" ||
              str == "profile_birth_date"
            ) {
              this.active_tab = 0;
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.savingProfile = false;
          this.message = "";
        });
    },

    assignBlob(data) {
      this[data.ref] = data.file;
    },

    changeImage() {
      this.$root.$emit("change_profile_image", {});
    },
    editImage() {
      this.$root.$emit("edit_profile_image", {});
    },

    saveAvatar() {
      var fd = new FormData();

      fd.append("headshot", this.avatarBlob);
      this.savingImage = true;
      axios
        .post("/api/v1/user/profile/images/save", fd)
        .then((response) => {
          setTimeout(() => {
            this.savingImage = false;
            this.saveImage = false;
            this.message_upload = "Image saved";
            setTimeout(() => (this.message_upload = ""), 2000);
          }, 1000);

          this.message = response.data.message;
          this.errors = [];
          location.reload();
        })
        .catch((error) => {
          this.savingImage = true;
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
          this.message = "";
        });
    },
    copyUrl() {
      const str = "https://respectfully.com/" + this.user.profile.profile_link;
      var $temp = $("<input>");
        $("div.iconbar").append($temp);
        $temp.val(str).select();
        document.execCommand("copy");
        $temp.remove();
    },

    validateText(inputString, n) {
      if (inputString.length == 1) {
        if (!this.regex.test(inputString)) {
          this.textErr[n] = `Symbol ${inputString} is not permitted`;
          return "";
        } else {
          return inputString;
        }
      } else if (inputString.length > 1 && !this.regex.test(inputString)) {
        const notValidArr = inputString.split("");
        const validArr = [];

        notValidArr.map((char) =>
          this.regex.test(char)
            ? validArr.push(char)
            : (this.textErr[n] = `Symbol ${char} is not permitted`)
        );

        return validArr.join("");
      } else {
        return inputString;
      }
    },

    share(type) {
      this.dialog = false;
      var top = window.screen.height - 400;
      top = top > 0 ? top / 2 : 0;

      var left = window.screen.width - 400;
      left = left > 0 ? left / 2 : 0;

      if (type == "facebook") {
        window.open(
          "https://www.facebook.com/sharer.php?u=https://www.respectfully.com/" +
            this.user.profile.display_name,
          "respectfully.com",
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      } else if (type == "twitter") {
        window.open(
          "https://twitter.com/share?url=https://www.respectfully.com/" +
            this.user.profile.display_name,
          "respectfully.com",
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      } else if (type == "linkedin") {
        window.open(
          "https://www.linkedin.com/shareArticle?mini=true&url=https://www.respectfully.com/" +
            this.user.profile.display_name,
          "respectfully.com",
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      }
    },



    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;
      this.createImage(files[0]);
    },
    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage: function (e) {
      this.image = '';
    },

    
    /**
     * Pretreatment
     * @param  Object|undefined   newFile   Read and write
     * @param  Object|undefined   oldFile   Read only
     * @param  Function           prevent   Prevent changing
     * @return undefined
     */
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(mp4|mov|wmv|avi|flv|f4v|mpeg|mpg)$/i.test(newFile.name)) {
          console.log("Not permitted");
          this.format_error = "File type not supported";
          return prevent();
        }


        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
          this.format_error = "";
        }
        
        this.video = newFile.blob
      }
    },
    updatetValue(value) {
      this.file = value[value.length - 1];
    },
    /**
     * Has changed
     * @param  Object|undefined   newFile   Read only
     * @param  Object|undefined   oldFile   Read only
     * @return undefined
     */
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        if (newFile.xhr) {
          //  Get the response status code
          if ((newFile.xhr.status == 200) || (newFile.xhr.status == 0)) {
            this.video = newFile.response.success.video_path;
            this.files = [];
            this.edit_video = false;
            this.thumbnail = this.thumbnail.slice(0, this.thumbnail.lastIndexOf('/') + 1) + newFile.response.success.video_path_thumbnail;
          }
        }
      }
    },


  },

  mounted() {

    this.getProfile();
    document.getElementsByClassName("account")[0].style.backgroundColor =
      "#ceb5fa";
    document.getElementsByClassName("account")[0].style.color = "#131120";
    $(".v-input--checkbox .v-label").wrapInner("<h5></h5>");

      if(this.tab_select ==0){
        this.accountShow();
        
      }else{
        this.profileShow();
      }

    Object.entries(this.timezones).forEach((the_s) => {
      this.timezonesSelect.push({
        text: the_s[0],
        value: the_s[1],
      });
    });


  },
};
</script>
<style lang="scss">

#profilemain div.col-md-6.col-sm-12.col-12{ 
  padding-left: 12px !important;
  padding-right: 12px !important;
}
.sfHelperCharacters{
  
  text-align: right;
}
.model-profile-main {
  &.mb-30 {
    margin-bottom: 30px;
    @media (max-width: 576px) {
      margin-bottom: 10px;
    }
  }
  .mdi-checkbox-marked::before {
    background: url("/images/checkbox-selected.svg");
    background-repeat: no-repeat;
    background-position: bottom 5px right;
  }
  .mdi-checkbox-blank-outline::before {
    background: url("/images/checkbox-unselected.svg");
    background-repeat: no-repeat;
    background-position: bottom 5px right;
  }
  &#accountadditional {
    margin-bottom: 60px;
    padding-top: 30px !important;
    @media (max-width: 576px) {
      padding-top: 25px !important;
    }
    .info-txt {
      margin-bottom: 10px;
    }
  }
  &#profilemain {
    margin-bottom: 60px;
  }
  .categories-info {
    display: flex;
    flex-wrap: wrap;
    .v-input--checkbox {
      margin: 0;
      padding: 0;
      .v-input__slot {
        margin: 0;
      }
      .v-messages {
        display: none;
      }
      @media (max-width: 576px) {
        width: 50%;
      }
    }
  }
  .v-input--checkbox .v-label {
    h5 {
      color: #131220;
      font-size: 12px;
      font-weight: 500;
      margin-bottom: 1px;
    }
  }
  .profileinfo,
  .descriptions,
  .input {
    h3 {
      font-size: 12px;
      color: #131220;
      padding-bottom: 5px;
      margin-bottom: 0;
      font-weight: 600;
      span {
        color: #e31616;
      }
    }
    .sfInputBackgroundClass {
      margin-top: 5px;
    }
  }
  padding: 25px 12px !important;
  .pd-none {
    padding-left: 12px !important;
    padding-right: 12px !important;
  }
  .row {
    margin: 0px !important;
    .v-text-field {
      .v-input__slot {
        padding: 0px !important;
        .v-label {
          padding-left: 10px !important;
        }
      }
    }
  }
  .v-textarea {
    .v-input__control > .v-input__slot {
      padding-left: 0px !important;
      padding-right: 0px !important;
      .v-text-field__slot {
        margin-right: 0px !important;
      }
      textarea {
        margin: 0px !important;
        padding: 5px 10px;
      }
    }
  }
}

@media (max-width: 576px) {
  .model-profile-main {
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
}
.model-profile-container {
  margin: 40px;
  max-width: 780px;
  .edit-buttonbar {
    max-width: 366px;
    height: 38px;
    border-radius: 38px;
    button {
      width: 178px;
      border-radius: 38px;
      font-size: 14px;
      color: #949498;
    }
  }
  .model-save-btn {
    margin-top: 7px;
  }
}
@media (max-width: 991px) {
  .model-profile-container {
    margin-left: auto;
    margin-right: auto;
  }
}
@media (max-width: 860px) {
  .model-profile-container {
    margin-left: 40px;
    margin-right: 40px;
  }
}
@media (max-width: 576px) {
  .info-txt {
    font-size: 16px !important;
  }
  .change-main {
    margin-bottom: 10px !important;
  }
  .model-profile-container {
    .txt {
      font-size: 20px !important;
    }
    margin-left: 15px;
    margin-right: 15px;
    .model-save-btn {
      margin-top: 14px;
    }
    .edit-buttonbar {
      max-width: 170px;
      button {
        width: 82px;
      }
    }
    .form-container {
      .descriptions {
        margin-bottom: 44px;
      }
    }
  }
}
</style>
<style>
.v-input__slot {
  padding: 0 !important;
}
#profilemain {
  display: none;
}
.container {
  padding: 0;
  padding: 40px 0;
}
.txt {
  font-size: 24px;
  font-family: 500;
  color: #42424d;
  margin-bottom: 20px;
  line-height: 24px;
}
.change-main {
  width: 100%;
  background: white;
  padding: 20px 57px;
  margin-bottom: 30px;
}
.buttonbar {
  margin: auto;
  max-width: 486px;
  height: 31px;
  border-radius: 14px;
  background-color: #d8d8d8;
  display: flex;
  justify-content: space-between;
}
.buttonbar button {
  /* cursor: pointer; */
  outline: none;
  border: none;
  width: 46%;
  font-size: 12px;
  color: #131220;
  font-weight: 600;
  line-height: 30px;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 14px;
}
.userimg {
  display: flex;
  justify-content: center;
  place-items: center;
  margin-bottom: 21px;
}
.userimg img:not(.null_video) {
  width: 104px;
  height: 104px;
  vertical-align: middle;
  margin-right: 0px;
}
#profile-img{
  border-radius: 50%;
}
#profile-vid{
  border-radius: 17%;
}
.userimg button {
  /* cursor: pointer; */
  outline: none;
  border: none;
  background: transparent;
  color: #f77f98;
  line-height: 18px;
  font-size: 14px;
  font-weight: 600;
}

.form-container {
  padding: 36px 24px 20px 24px;
  background: white;
  border-radius: 6px;
  box-shadow: 0 3px 6px #0000000d;
}
.profileinfo {
  display: flex;
  justify-content: space-between;
}
.profileinfo > div {
  width: 50%;
  margin-bottom: 15px;
}
.profileinfo label {
  padding-left: 0;
}
.info-txt {
  font-size: 18px;
  font-weight: 600;
  font-family: montserrat;
  padding-left: 12px;
  color: #131220;
  line-height: 22px;
  margin-bottom: 18px;
}
label {
  font-size: 16px;
  letter-spacing: -1px;
  font-weight: 600;
  line-height: 19px;
  color: #545454;
}
label span {
  color: #e31616;
}
.display-limit {
  padding-top: 4px;
  font-size: 12px;
  line-height: 13px;
  margin: 0;
  text-align: right;
  color: #131220;
  font-family: montserrat;
  font-weight: 600;
}
.iconbar {
  margin-top:0px;
  margin-bottom: 0px;
  padding-left: 20px;
  display:inline-block;
}
.iconbar i {
  font-size: 20px;
  color: #9759ff;
  margin-right: 16px;
}
input,
textarea {
  border: rgba(19, 18, 32, 0.4) 1px solid;
  border-radius: 5px;
  line-height: 30px;
  width: 100%;
  font-size: 14px;
  font-family: montserrat;
  padding: 0 10px;
  margin: 5px 0;
}
textarea::placeholder {
  color: #545454;
  font-size: 12px;
}
.descriptions {
  margin-bottom: 20px;
}
form > button {
  /* cursor: pointer; */
  outline: none;
  border: none;
  font-size: 12px;
  line-height: 40px;
  color: white;
  font-weight: 600;
  width: 160px;
  background: linear-gradient(256deg, #7272ff, #9759ff) 0% 0%;
  box-shadow: 0 2px 4px #9759ff4d;
  border-radius: 12px;
}

#profile-pic2.overlay-upload-btn .hover {
  display: none;
  background: rgba(0, 0, 0, 0.6);
  margin: 0 1em 1em 0;
  border-bottom-left-radius: 90px;
  border-bottom-right-radius: 90px;
  width: 104px;
  height: 55px;
  position: absolute;
  bottom: -10px;
  left: 0px;
  text-align: center;
  /* cursor: pointer; */
}
.input {
  margin-bottom: 15px;
}
#phone_numbers_0_code2 {
  border: none !important;
}
input {
  line-height: 30px !important;
  padding-left: 10px !important;
}
.v-select__slot {
  border: rgba(19, 18, 32, 0.4) 1px solid;
  border-radius: 5px;
  height: 32px;
  padding-left: 10px !important;
}
@media screen and (max-width: 800px) {
  .profileinfo {
    flex-direction: column;
  }
  .profileinfo > div {
    width: 100%;
  }
}



/* video  */

.sfProfileFormVideo .file-uploads,
.buttonVideoSub,.buttonVideo {
  overflow: unset !important;
  display: block !important;
}

.buttonVideoSub {
  width: 90px !important;
}
.buttonVideoSub .v-btn__content {
  padding-bottom: 4px;
  
}

.sfProfileFormVideo .file-uploads .v-btn
{
  padding-left: 0px !important;
  padding-right: 0px !important;
  background: transparent !important;
  
}


.buttonVideoSub {
  padding-left: 0px !important;
  padding-right: 0px !important;
  background: transparent !important;

}



.sfProfileFormVideo .file-uploads .v-btn span,
.buttonVideoSub span {
  /* font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 1;
  font-weight: 500;
  background: rgba(67, 66, 93, 0.5);
  padding-bottom: 5px;
  height: 40px;
  padding-top: 14px; */
  font-size: 14px; 
  font-weight: 600; 
  color: #f77f98; 
  text-align: center;
}

.sfProfileFormVideo video {
  object-fit: cover;
  border-radius: 16px !important;
}

.no-background-hover::before {
  background-color: transparent !important;
}

.no-background-hover:focus {
  outline: 0 !important;
}
.sfFormProfileMo .float-left.text-danger.small,
.sfFormProfile .float-left.text-danger.small {
  font-size: 12px;
}
.msnInput{
  font-size: 10px;
  text-align: center;
  margin-top: 36px !important;
  line-height: 11px;
}

.sfProfileVideo {
  background: #f4f4f4 0% 0% no-repeat padding-box;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 5px;
  opacity: 1;
  height: 104px;
  width: 104px;
}


.sfProfileVideoIco, 
.sfProfileAudioIco
{
margin-top: 25px;
}

.sfProfileVideoBox .grey--text,
.sfProfileAudioBox .grey--text,
.sfProfileAudio .grey--text,
.sfProfileVideoIco .grey--text,
.sfProfileAudioIco .grey--text{
  font-size: 8px;
    line-height: 10px;
    margin-top: 13px;
    word-break: break-all;
}

.buttonVideox .v-btn__content{
      left: 22px;
    bottom: 17px !important;
}



.sfProfileVideo .v-btn__content,
.sfProfileAudio .v-btn__content {
  padding-top: 10px;
  display: block;
  /* margin-left: -15px; */
  /* cursor: pointer; */
}


.sfProfileVideoIco .theme--light.v-btn:hover::before,
.sfProfileAudioIco .theme--light.v-btn:hover::before{
  display: none;
}

.sfProfileVideoIco, .sfProfileAudioIco,
.sfProfileVideoIco .v-btn__content,
.sfProfileAudioIco .v-btn__content
{
  color:#a09fad !important;
  background: #fff !important;    font-size: 12px !important;
}
.sfProfileVideoIco .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined),
.sfProfileAudioIco  .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){
  padding: 0px;
  color: #a09fad;
  font-size: 12px;
  top: 20px;
}

.sfProfileVideoIco .file-uploads,
.sfProfileAudioIco .file-uploads{
border-radius: 5px;
height: 90px;
}

.sfProfileAudio {
  background: #f4f4f4 0% 0% no-repeat padding-box;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 5px;
  opacity: 1;
  height: 90px;
  width: 140px;
}

.sfProfileVideo .buttons-area,
.sfProfileVideo .file-uploads,
.sfProfileVideo button,
.sfProfileVideo .v-btn__content {
  height: 90px;
  
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px;
  /* cursor: pointer; */
}



.sfProfileVideo_model {
  background: #f4f4f4 0% 0% no-repeat padding-box;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 5px;
  opacity: 1;
  height: 90px;
  width: 90px;
  margin: auto;
  margin-bottom: 24px;
}

.sfProfileVideoIco_model
{
margin-top: 25px;
}

.sfProfileVideoIco_model .grey--text{
    font-size: 8px;
    line-height: 10px;
    margin-top: 13px;
    word-break: break-all;
}

.sfProfileVideoIco_model .theme--light.v-btn:hover::before{
  display: none;
}

.sfProfileVideoIco_model,
.sfProfileVideoIco_model .v-btn__content
{
  color:#a09fad !important;
  background: #fff !important;    font-size: 12px !important;
}
.sfProfileVideoIco_model .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){
   color: #a09fad;
  font-size: 12px;
  
}
.sfProfileVideoIco_model .file-uploads{
border-radius: 5px;
height: 90px;
}

.sfProfileVideo_model .buttons-area,
.sfProfileVideo_model .file-uploads,
.sfProfileVideo_model button,
.sfProfileVideo_model .v-btn__content {
  height: 90px;
  
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px;
  /* cursor: pointer; */
}

.sfProfileVideo_model button {
  display: block;
}



.sfProfileVideotOP_model .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){
    padding: 0px;
}


.buttonVideoSub_model.v-btn .v-btn__content {
    position: absolute;
    bottom: 0px;
    width: 100%;
    height: 40px;
    text-align: center;
    border-radius: 0px 0px 5px 5px;
    z-index: 0;
    opacity: 1;
    background: rgba(67, 66, 93, 0.5) !important;
    color: #fff  !important;
    font-family: "Montserrat", sans-serif !important;
}

.buttonVideoSub_model,.buttonVideo {
    overflow: unset !important;
    position: absolute !important;
    text-align: center !important;
    display: block !important;
    /* left: 15px !important;  */
    z-index: 0 !important;
    top: 38px;
}


.buttonVideoSub_model {
    width: 90px !important;
  }
.buttonVideoSub_model .v-btn__content {
padding-bottom: 4px;

}

.buttonVideoSub_model {
  padding-left: 0px !important;
  padding-right: 0px !important;
  background: transparent !important;

}



.buttonVideoSub_model span {
  font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 1;
  font-weight: 500;
  background: rgba(67, 66, 93, 0.5);
  padding-bottom: 5px;
  height: 40px;
  padding-top: 14px;
}


.buttonVideoSub.v-btn .v-btn__content {
    /* left: -3px !important; */
    bottom: 2px;
}


.buttonVideoSubEmpty_model.v-btn:not(.v-btn--round).v-size--default{
    height: 0px !important;
    top: 115px;
 }

.file-uploads.file-uploads-html5 label {
  cursor: pointer;
}

</style>
