<template>
  <div class="sfHoverdiv">
    <div
      v-if="empty"
      :style="visible ? '' : 'opacity: 0'"
      class="hover hoverProfile"
    >
      <div class="btn-upload-wrapper mx-1 w-auto">
        <input
          ref="imageFile"
          type="file"
          name="source_img"
          accept="image/*"
          @change="processImage($event)"
          data-img="target-preview-element"
        />
        <a
          href="#"
          style="
            display: block;
            margin-top: 10px;
            font-size: 14px; font-weight: 500;
            cursor: pointer;
            color: #43425D; letter-spacing: 0.28px;
          "
          >Add Photo
        </a>
      </div>
    </div>

    <div v-else class="hover hoverProfile">
      <div class="btn-upload-wrapper mx-1 w-auto">
        <input
          ref="imageFile"
          type="file"
          name="source_img"
          accept="image/*"
          @change="processImage($event)"
          data-img="target-preview-element"
        />
        <a
          href="#"
          style="
            display: block;
            margin-top: 15px;
            font-size: 12px;
            cursor: pointer;
          "
        >
          <i class="far ico-edit-img"></i><br />
          Edit
        </a>
      </div>
    </div>
    <slot></slot>
    <v-dialog v-model="cropDialog" width="800">
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-icon class="right mt-3" @click="cropDialog = false"
                >mdi-close
              </v-icon>
            </div>
            <div class="col-12">
              <div class="text-center mb-5">
                <h4 class="mb-5">Edit photo</h4>
                <v-btn
                  class="btn-rotate"
                  small
                  depressed
                  color="primary"
                  rounded
                  min-width="35"
                  width="35"
                  @click="zoomImage('target-preview-element', -0.1)"
                >
                  <i class="fa fa-minus"></i>
                </v-btn>
                <v-btn
                  class="btn-rotate"
                  depressed
                  small
                  color="primary"
                  rounded
                  min-width="35"
                  width="35"
                  @click="zoomImage('target-preview-element', 0.1)"
                >
                  <i class="fa fa-plus"></i>
                </v-btn>
                <v-btn
                  class="btn-rotate"
                  depressed
                  small
                  color="primary"
                  rounded
                  min-width="35"
                  width="35"
                  @click="rotateImage('target-preview-element', -5)"
                >
                  <i class="fa fa-undo"></i>
                </v-btn>
                <v-btn
                  small
                  depressed
                  color="primary"
                  rounded
                  min-width="35"
                  width="35"
                  @click="rotateImage('target-preview-element', 5)"
                >
                  <i class="fa fa-redo"></i>
                </v-btn>
                <br />
                <v-btn
                  class="mr-2"
                  depressed
                  color="primary"
                  rounded
                  min-width="115"
                  @click="cropImage"
                >
                  Apply
                </v-btn>
                <v-btn
                  class=""
                  depressed
                  color="primary"
                  rounded
                  min-width="115"
                  @click="openSelectFileDialog"
                >
                  Change
                </v-btn>
              </div>
              <div class="text-center">
                <vue-cropper
                  ref="target-preview-element"
                  :src="image"
                  alt="Source Image"
                  :aspectRatio="ratioX / ratioY"
                  :containerStyle="containerStyle"
                  :viewMode="1"
                  :checkCrossOrigin="false"
                >
                </vue-cropper>
                <br />
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";

export default {
  props: [
    "targetPreviewElement",
    "refName",
    "outputWidth",
    "outputHeight",
    "ratioX",
    "ratioY",
    "blobRef",
    "profile",
    "empty",
    "visible",
  ],
  components: { VueCropper },
  data() {
    return {
      cropDialog: "",
      image: "",
      imageBlob: "",
      containerStyle: {
        width: "100%",
        height: "100%",
      },
      imgStyle: {
        width: "500px",
        height: "500px",
      },
      originalImageForUpload: "",
    };
  },
  methods: {
    imageReceived(downloadedImg) {
      downloadedImg.addEventListener("load", (e) => {
        /**---------------------------------------------------------------------
                         In order for crossorigin to work we need to add crossorigin attribute
                         to the dynamically created img element
                         ---------------------------------------------------------------------*/
        fetch(this.image)
          .then((response) => {
            let canvasImg = window.document.querySelector("img.cropper-hide");
            let src = canvasImg.getAttribute("src");
            canvasImg.setAttribute("crossorigin", "anonymous");
            /* Somehow src needs to be set again in order for crossorigin to work */
            canvasImg.setAttribute("src", src);
            // convert img address to blob
            return response.blob();
          })
          .then((blob) => {
            // here the image is a blob
            this.originalImageForUpload = blob;
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      });
    },
    editImage() {
      // This API enables cross-origin requests to anywhere
      var proxyUrl = "https://cors-anywhere.herokuapp.com/";
      let targetUrl = "";
      if (this.targetPreviewElement == "profile-img") {
        targetUrl = this.profile.profile_headshot_url.replace(
          /(\.[\w\d_-]+)$/i,
          "-orig$1"
        );
      } else {
        targetUrl = this.profile.cover_path.replace(
          /(\.[\w\d_-]+)$/i,
          "-orig$1"
        );
      }

      let imageURL = proxyUrl + targetUrl;
      let downloadedImg = new Image();
      downloadedImg.crossOrigin = "Anonymous";

      // check if original image exists
      fetch(imageURL).then((response) => {
        if (response.status == 200) {
          downloadedImg.src = imageURL;
        } else {
          // if not remove -orig
          imageURL = imageURL.replace("-orig", "");
          downloadedImg.src = imageURL;
        }
        this.imageReceived(downloadedImg);
        this.image = imageURL;
        this.cropDialog = true;
      });
    },
    processImage(event) {
      this.originalImageForUpload = event.target.files[0];

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
      if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
      }
    },
    cropImage() {
      let croppedCanvas = this.$refs["target-preview-element"].getCroppedCanvas(
        {
          width: this.outputWidth,
          height: this.outputHeight,
          minWidth: this.outputWidth,
          minHeight: this.outputHeight,
        }
      );
      // creating cropped blob
      let blob = croppedCanvas.toBlob((blob) => {
        // let file = new File([blob], this.$refs.imageFile.files[0].name);
        this.imageBlob = blob;
        this.passFileToParent();
      }, "image/jpeg");
      let croppedImageURL = croppedCanvas.toDataURL("image/jpeg");

      this.image = croppedImageURL;

      document
        .getElementById(this.targetPreviewElement)
        .setAttribute("src", croppedImageURL);

      [].forEach.call(
        document.querySelectorAll(".btn-upload-wrapper"),
        function (el) {
          el.style.visibility = "hidden";
        }
      );

      this.cropDialog = false;
    },
    rotateImage(ref, degree) {
      this.$refs[ref].rotate(degree);
    },
    zoomImage(ref, amount) {
      this.$refs[ref].relativeZoom(amount);
    },
    openSelectFileDialog() {
      this.$refs.imageFile.click();
    },
    openCropDialog() {
      this.cropDialog = true;
    },
    openCropBodyShotDialog() {
      this.cropDialog = true;
    },
    passFileToParent() {
      this.$emit("onImageCropped", {
        file: this.imageBlob,
        ref: this.blobRef,
      });
    },
  },
};
</script>
<style>
button.btn-rotate {
  margin: 15px 10px;
}
#the_top_bar {
  z-index: 200;
}
.v-dialog__content--active {
  opacity: 1 !important;
  -webkit-backdrop-filter: blur(10px);
  backdrop-filter: blur(10px);
}

.ico-edit-img {
  background: url(/images/icons/edit-img.svg);
  background-position: center;
  height: 12px;
  width: 15px;
  background-repeat: no-repeat;
  margin-bottom: -3px;
  margin-right: 7px;
  color: #fff;
  background-size: 21px;
}
</style>