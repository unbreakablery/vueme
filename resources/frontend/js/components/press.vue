<template>
  <div  style="background: #FFFFFF 0% 0% no-repeat padding-box; opacity: 1;">
    <v-img
      alt="Press"
      :height="$vuetify.breakpoint.smAndDown ? '153' : '298'"
      :src="$vuetify.breakpoint.smAndDown ? '/images/site-images/press-mobile.png' :  '/images/site-images/press-desktop.png'"
      aspect-ratio="1.7"
      class="w-100 d-flex justify-center align-center px-5 text-center"
    >
      <h1
        style="color: #f0f0f7; font-weight:bold"
        :style="{fontSize: $vuetify.breakpoint.smAndDown ? '18px' : '30px'}"
      >Respectfully Newsroom</h1>
      <h2
        style="color: #f0f0f7; font-weight:normal"
        :style="{fontSize: $vuetify.breakpoint.smAndDown ? '12px' : '18px'}"
      >Latest Industry Buzz Featuring Our Popular Models</h2>
    </v-img>

    <div :style="$vuetify.breakpoint.smAndDown ? 'margin-top: 11px;' : 'margin-top: 15px;'" style="padding-top: 6px;" class="container pb-0 mb-0">
      
        <div :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 11px;' : 'margin-bottom: 15px;'" class="d-flex justify-end">  
            <span class="mt-0 pt-0 d-flex align-center" style="color: #43425D; font: normal normal 600 14px/18px Montserrat; cursor: pointer" @click="dialog2 = true;">
              <p style="margin-right: 10px">PR Contact</p>
              <i><img :src=press_icon /></i>
            </span>  
        </div>

        <div class="row" id="videoWidth">
          <div class="cols-12 col-md-6" v-for="(i,index) in pressRow" :key="i.name">
            <div class="d-flex justify-center align-center w-100 h-100" 
            style="position: absolute; object-fit: contain; right: 5px; bottom: 10px" >
              <i v-if="i.vid"><img :style="$vuetify.breakpoint.smAndDown ? 'width: 66px !important;' : ''" :src=play_icon /></i>
            </div>
            <div
              @click="(i.vid || i.pdf) ? showImage(i) : openLink(i)"
              :id="'cover' + index"
              class="cover text-center d-flex justify-center align-center"
              :style="$vuetify.breakpoint.smAndDown ? 'margin-top: 20px !important;' : 'margin-top: 30px !important;'"
            >
            </div>
            
            <img
              :alt="i.title"
              :id="'press' + index"
              :src="'/images/press/' + i.name"
              class="w-100"
              :style="$vuetify.breakpoint.smAndDown ? 'margin-top: 20px !important;' : 'margin-top: 30px !important;'"
              style="cursor: pointer;"
              @load="onImgLoaded(index)"
            />
            <div class="m-auto" :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 10px !important;' : 'margin-bottom: 15px !important;'" style="color: #A2A2A2; font-size: 12px; text-align: left;">
              <div style="color: black; font-size: 18px; font-weight: bold; margin-top: 10px;">{{i.title}}</div>
              <div>{{i.date}}</div>
            </div> 
          </div>
        </div>
    </div>
    <div class="d-flex justify-content-center pb-2">
      <v-btn
        style="background-color: #ffffff; font: normal normal 600 14px/18px Montserrat; letter-spacing: 0.28px; color: #43425D; opacity: 1;"
        :loading="loadingPress"
        :disabled="loadingPress"
        v-if="this.fullPress.length > this.pressRow.length"
        @click="showMore()"
        >Show More ▽</v-btn
      >
      <v-btn
        style="background-color: #ffffff; font: normal normal 600 14px/18px Montserrat; letter-spacing: 0.28px; color: #43425D; opacity: 1;"
        :loading="loadingPress"
        :disabled="loadingPress"
        v-if="this.pressRow.length > this.numberArticles"
        @click="showLess()"
        >Show Less △</v-btn
      >
    </div>
    <div
      style="background: #F4F4F4 0% 0% no-repeat padding-box; opacity: 1;"
      :style="$vuetify.breakpoint.smAndDown ? 'padding: 20px 45px;' : 'padding: 30px 98px;'"
      class="w-100 d-flex justify-center align-center mt-3"
    >
      <p
        :style="$vuetify.breakpoint.smAndDown ? 'color: #656B72; text-align: left; font: normal normal medium 12px/22px Montserrat; letter-spacing: 0px; opacity: 1; line-height: 22px' : 'color: #656B72; font: normal normal medium 14px/26px Montserrat; letter-spacing: 0px; opacity: 1; line-height: 22px; text-align: center;'+`max-width: ${this.textWidth}px;`">Respectfully is an exponentially growing newcomer, transforming the psychic services industry and tech scene! Since we launched in January of 2020, the world has been buzzing about our intuitive and tech-forward platform that’s easy for anyone to use, as well as our modern business model and 2,000+ highly rated spiritual advisors. We’ve connected in-demand famous models, mediums, tarot readers, palm readers, astrologists, and more with real people all over the globe.</p>
    </div>

    <v-dialog content-class="overflow-visible" v-model="dialog2" max-width="600">
      <div class="text-right">
        <i
          class="fa fa-times close-button contact-close"
          style="z-index: 100;"
          @click="dialog2 = false;"
          aria-hidden="true"
        ></i>
      </div>
      <v-card style="border-radius: 30px !important;">
        <v-card-text class="p-5">
          <p style="color: #43425D;">Public Relations Inquiries:</p>
          <p></p>
          
          <p>
            <a
              href="mailto:press@respectfully.com"
              style="color: #43425D; cursor: pointer"
            >
              Contact
              <i><img :src=press_icon /></i>
            </a>
          </p>
          <p></p>
          <div class="border-top my-3"></div>
          <p style="color: #43425D;">Marketing Inquiries:</p>
          <p></p>
          <p>
            <a
              href="mailto:marketing@respectfully.com"
              style="color: #43425D;; cursor: pointer"
            >
              Contact
              <i><img :src=press_icon /></i>
            </a>
          </p>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog content-class="no-overflow" v-model="dialog" :max-width="image.vid ? width : '500'">
      <div class="text-right mb-5">
        <i
          class="fa fa-times close-button"
          style="z-index: 100;"
          @click="dialog = false;"
          aria-hidden="true"
        ></i>
      </div>
      <v-card elevation="0" style="background-color: transparent;">
        <v-card-text>
          <div class="row">
            <div v-if="image.vid" class="col-12">
              <iframe
                :src=image.vid
                loading="lazy"
                :width="width - 20"
                :height="height"
                frameborder="0"
                allow="autoplay; fullscreen"
                allowfullscreen
              ></iframe>
            </div>
            <div v-else-if="image.pdf" class="col-12">
              <v-img
                :alt="image.title"
                :max-height="maxHeight"
                contain
                :src="'/images/press/' + image.pdf"
              ></v-img>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-center">
              <div style="color: white; font-weight: bold; margin-top: 10px;">{{image.title}}</div>
            </div>
            <div class="col-12 text-center">
              <div style="color: white;">{{image.date}}</div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      press_icon: "/images/icons/press_email_icon.svg",
      play_icon: "/images/icons/play_icon.png",
      loadingPress: false,
      numberArticles: 0,
      numberSlicer: 0,
      width: false,
      textWidth: false,
      height: false,
      dialog: false,
      dialog2: false,
      image: false,
      maxHeight: window.innerHeight - 100,
      fullPress: [
        {
          name: "ExtraTV.png",
          title: "Extra Tv",
          date: "October 31, 2020",
          vid: "https://www.youtube.com/embed/VOJkPWcQ-k0",
        },
        {
          name: "Refinery29.png",
          title: "Refinery29",
          date: "November 6, 2020",
          link: "https://www.refinery29.com/en-us/2020/11/10139800/cuffing-season-2020-astrology-meaning",
        },
        {
          name: "Yahoo.png",
          title: "Yahoo! Life",
          date: "November 6, 2020",
          link: "https://www.yahoo.com/lifestyle/3-zodiac-signs-best-cuffing-174645092.html",
        },
        {
          name: "MSN.png",
          title: "MSN",
          date: "November 6, 2020",
          link: "https://www.msn.com/en-in/lifestyle/horoscope/these-3-zodiac-signs-are-about-to-have-the-best-cuffing-season-ever/ar-BB1aLxlP?li=BB12xKdA&srcref=rss",
        },
        {
          name: "LaOpinion.png",
          title: "La Opinión",
          date: "November 8, 2020",
          link: "https://laopinion.com/2020/11/08/la-astrologia-augura-que-3-signos-del-zodiaco-encontraran-el-amor-en-noviembre/",
        },
        {
          name: "Authority.png",
          title: "Authority Magazine",
          date: "October 21, 2020",
          link: "https://medium.com/authority-magazine/psychic-eva-white-surround-yourself-with-people-who-are-not-afraid-to-accept-their-faults-and-66d9d16cfb14",
        },
        {
          name: "ExtraTV_1.png",
          title: "Extra Tv",
          date: "April 12, 2020",
          vid: "https://www.youtube.com/embed/EOsrLsUqerc",
        },
        {
          name: "Ok_Magazine.png",
          title: "Ok! Magazine",
          date: "February 10, 2020",
          pdf: "4.jpg",
        },
        {
          name: "National_Enquirer_2020.png",
          title: "National Enquirer",
          date: "January 6, 2020",
          pdf: "3.jpg",
        },
        {
          name: "Globe_Magazine.png",
          title: "Globe Magazine",
          date: "January 6, 2020",
          pdf: "2.jpg",
        },
         {
          name: "NationalEnquirer_Magazine.png",
          title: "National Enquirer",
          date: "December 30, 2019",
          pdf: "1.png",
        },
      ],
      pressRow: [],
    };
  },
  computed: {
    heightImg: () => screen.height - 100,
  },
  methods: {
    showMore() {
      this.loadingReviews = true;
      this.numberSlicer += 2;
      this.pressRow = this.fullPress.slice(0,this.numberSlicer)
    },
    showLess() {
      this.loadingReviews = true;
      this.numberSlicer = this.numberArticles
      this.pressRow = this.fullPress.slice(0,this.numberSlicer)
    },
    onImgLoaded(i) {
      document.getElementById("cover" + i).style.width =
        document.getElementById("press" + i).width + "px";
      document.getElementById("cover" + i).style.height =
        document.getElementById("press" + i).height + "px";
    },
    showImage(image) {
      this.image = image;
      this.dialog = true;
    },
    openLink(i) {
      window.open(i.link, "_blank");
    }
  },
  mounted() {
    this.numberArticles = (this.$vuetify.breakpoint.smAndDown) ? 5 : 6
    this.numberSlicer = (this.$vuetify.breakpoint.smAndDown) ? 5 : 6
    this.pressRow = (this.$vuetify.breakpoint.smAndDown) ? this.fullPress.slice(0,this.numberSlicer) : this.fullPress.slice(0,this.numberSlicer)
    const div = document.getElementById("videoWidth");
    this.textWidth = div.offsetWidth
    this.width = (this.$vuetify.breakpoint.smAndDown) ? div.offsetWidth : div.offsetWidth / 1.5;
    if (this.$vuetify.breakpoint.smAndDown) this.width = this.width - 30;
    this.height = this.width / 1.777;
    console.log(div.offsetWidth);
  },
};
</script>
<style>
.no-overflow {
  overflow: hidden;
}
.close-button {
  position: absolute;
  margin-left: 18px;
  padding: 5px 7px;
  border: 2px solid white;
  border-radius: 50%;
  font-size: 14px;
  color: white;
  cursor: pointer;
}
.cover {
  position: absolute;
  object-fit: contain;
  cursor: pointer;
  background-color: rgba(0, 0, 0, 0.5);
}
@media (hover: hover) {
  .cover {
    opacity: 0;
  }
}
@media (hover: none) {
  .cover {
    opacity: 1;
    background: none;
  }
  .close-button {
    margin-left: -32px;
    margin-top: -20px;
  }
  .close-button.contact-close {
    margin-left: -12px;
  }
}
.cover:hover {
  opacity: 1;
}
</style>
