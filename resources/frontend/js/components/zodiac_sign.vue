<template>
  <div class="homepage">
    <div class="pa-0">
      <v-img
        alt="Home Banner Image"
        style="z-index: 1"
        :src="
          mobile
            ? '/images/horoscopes/horoscope_sign_mobile.png'
            : '/images/horoscopes/horoscope_sign.png'
        "
        aspect-ratio="1"
        :max-height="mobile ? 295 : 359"
        class="align-sm-center justify-sm-center home_hero"
      >
        <div
          class="justify-center text-center"
          :style="
            $vuetify.breakpoint.xsOnly
              ? 'margin-top: 100px;'
              : 'top:45%;position: absolute;width: 100%;margin-top: -50px; padding: 0 47px;'
          "
        >
          <div
            :style="
              $vuetify.breakpoint.xsOnly
                ? ''
                : 'margin: auto; display: flex; width: 310px; text-align: left'
            "
          >
            <v-img
              v-if="!$vuetify.breakpoint.xsOnly"
              max-height="125"
              max-width="136"
              :src="'/images/horoscopes/' + horoscope.logo"
            ></v-img>

            <div>
              <h2
                :style="
                  $vuetify.breakpoint.xsOnly
                    ? ''
                    : 'margin-top: 24px; margin-left: 40px; margin-bottom: 15px'
                "
              >
                {{ horoscope.name }}
              </h2>
              <h3
                :style="
                  $vuetify.breakpoint.xsOnly
                    ? 'margin-bottom: 0px  !important'
                    : 'margin-left: 40px'
                "
              >
                {{ horoscope.start_period }} - {{ horoscope.end_period }}
              </h3>
              <div v-if="$vuetify.breakpoint.xsOnly" style="text-align: center">
                <img
                  height="125"
                  width="136"
                  :src="'/images/horoscopes/' + horoscope.logo"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="container p-0">
          <div
            class="align-center text-center-md justify-sm-center home_banner p-0"
            style="
              position: absolute;
              background: transparent !important;
            "
            :style="mobile ? 'top:30px; margin-left:20px' : 'bottom: 30px'"
          >
            <v-btn
              class="mb-0 btn-block SubscribeFree"
              style="margin-left:5px;text-decoration: none;"
              depressed
              rounded
              href="#SubscribeHoroscope" 
              
            >
              <v-icon style="">ico-profile-astrology_icon</v-icon>
              <span style="color: #ffffff; text-transform: none; margin-left:7px">Subscribe for Free</span>
            </v-btn>
          </div>
        </div>
      </v-img>
    </div>

    <v-layout row class="mt-0 front m-0" v-if="weekhoroscope">
      <v-flex style="background: #f4f4f4; text-align: center">
        <v-container
          class="p-0"
          :style="$vuetify.breakpoint.xsOnly ? 'max-width: 295px;' : ''"
        >
          <div
            class="align-center text-center-md justify-sm-center home_banner"
            style="padding: 20px 0px"
          >
            <h2 class="h2Horoscope" style="margin-bottom: 10px">
              {{ weekhoroscope.startWeek }}
            </h2>
            <h3 class="mb-5">{{ horoscope.name }} Weekly Horoscope</h3>
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
              :style="
                $vuetify.breakpoint.xsOnly
                  ? '    font-size: 12px !important'
                  : '    font-size: 14px !important'
              "
            >
              {{ weekhoroscope.content }}
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

    <v-container
      class="py-0 front mb-12 pl- pr-0"
      
      v-if="weekhoroscope && !$vuetify.breakpoint.xsOnly"
    >
      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-12 ' : 'mt-8 '"
        class="mb-2"
      >
        <v-col cols="6" class="h3 mb-0">
          <h4>This Week’s Matches</h4>
        </v-col>
        <v-col cols="6" class="h3 mb-0 px-0 px-lg-3">
          <h4>This Week’s Mood</h4>
        </v-col>
      </v-row>
      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-0 ' : 'mt-0 '"
        class="mb-2"
        id="SubscribeHoroscope"
      >
        <v-col cols="6" class="h3 mb-0">
          <v-row>
            <div
              class="my-2 mb-10 ability_card"
              style="height: auto; margin: 0px 0px; width: auto"
            >
              <v-hover v-slot:default="{ hover }">
                <a
                  :href="'/horoscope/' + weekhoroscope.match1.slug"
                  style="text-decoration: none"
                >
                  <v-row class="">
                    <v-col cols="12" class="p-0">
                      <img
                        :alt="weekhoroscope.match1.name + ' Zodiac Sign'"
                        :src="'/images/horoscopes/' + (hoverImg1 ? 'link_' : '') + weekhoroscope.match1.logo"
                        @mouseover="hoverImg1 = true"
                        @mouseleave="hoverImg1 = false"


                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'width: 125px; height: 136px;'
                            : ''
                        "
                      />
                    </v-col>
                  </v-row>
                  <v-row class="">
                    <v-col cols="12" class="align-center text-center p-0 mt-1">
                      <div
                        class="description"
                        style="font-weight: 600; color: #43425d; opacity: 1"
                      >
                        {{ weekhoroscope.match1.name }}
                      </div>
                      <div
                        class="description"
                        style="
                          font-weight: 400;
                          color: #43425d;
                          font-weight: 500;
                          opacity: 1;
                          margin-top: 5px;
                        "
                      >
                        {{ weekhoroscope.subject1 }}
                      </div>
                    </v-col>
                  </v-row>
                </a>
              </v-hover>
            </div>
            <div
              class="my-2 mb-10 ability_card"
              style="height: auto; margin: 0px 62px; width: auto"
            >
              <v-hover v-slot:default="{ hover }">
                <a
                  :href="'/horoscope/' + weekhoroscope.match2.slug"
                  style="text-decoration: none"
                >
                  <v-row class="">
                    <v-col cols="12" class="p-0">
                      <img
                        :alt="weekhoroscope.match2.name + ' Zodiac Sign'"
                        :src="'/images/horoscopes/' + (hoverImg2 ? 'link_' : '') + weekhoroscope.match2.logo"
                        @mouseover="hoverImg2 = true"
                        @mouseleave="hoverImg2 = false"
                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'width: 125px; height: 136px;'
                            : ''
                        "
                      />
                    </v-col>
                  </v-row>
                  <v-row class="">
                    <v-col cols="12" class="align-center text-center p-0 mt-1">
                      <div
                        class="description"
                        style="font-weight: 600; color: #43425d; opacity: 1"
                      >
                        {{ weekhoroscope.match2.name }}
                      </div>
                      <div
                        class="description"
                        style="
                          font-weight: 400;
                          color: #43425d;
                          font-weight: 500;
                          opacity: 1;
                          margin-top: 5px;
                        "
                      >
                        {{ weekhoroscope.subject2 }}
                      </div>
                    </v-col>
                  </v-row>
                </a>
              </v-hover>
            </div>
            <div
              class="my-2 mb-10 ability_card"
              style="height: auto; margin: 0px 0px; width: auto"
            >
              <v-hover v-slot:default="{ hover }">
                <a
                  :href="'/horoscope/' + weekhoroscope.match3.slug"
                  style="text-decoration: none"
                >
                  <v-row class="">
                    <v-col cols="12" class="p-0">
                      <img
                        :alt="weekhoroscope.match3.name + ' Zodiac Sign'"
                        :src="'/images/horoscopes/' + (hoverImg3 ? 'link_' : '') + weekhoroscope.match3.logo"
                        @mouseover="hoverImg3 = true"
                        @mouseleave="hoverImg3 = false"
                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'width: 125px; height: 136px;'
                            : ''
                        "
                      />
                    </v-col>
                  </v-row>
                  <v-row class="">
                    <v-col cols="12" class="align-center text-center p-0 mt-1">
                      <div
                        class="description"
                        style="font-weight: 600; color: #43425d; opacity: 1"
                      >
                        {{ weekhoroscope.match3.name }}
                      </div>
                      <div
                        class="description"
                        style="
                          font-weight: 400;
                          color: #43425d;
                          font-weight: 500;
                          opacity: 1;
                          margin-top: 5px;
                        "
                      >
                        {{ weekhoroscope.subject3 }}
                      </div>
                    </v-col>
                  </v-row>
                </a>
              </v-hover>
            </div>
          </v-row>
        </v-col>
        <v-col
          cols="6"
          class="h3 mb-0 px-0 px-lg-3"
          style="padding-right: 0px !important"
        >
          <v-card
            class="sfProfileRating sfWeekhoroscope elevation-0 pl-0"
            outlined
            color="transparent"
          >
            <v-card-text class="pb-0 pl-0 pr-0">
              <v-row style="margin-bottom: 30px">
                <v-col
                  cols="3"
                  class="d-flex align-center"
                  style="margin-left: -3px"
                >
                  <label style="color: #43425d !important">Hustle</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.hustle"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
              <v-row style="margin-bottom: 30px">
                <v-col
                  cols="3"
                  class="d-flex align-center"
                  style="margin-left: -3px"
                >
                  <label style="color: #43425d !important">Love</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.love"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
              <v-row style="margin-bottom: 30px">
                <v-col
                  cols="3"
                  class="d-flex align-center"
                  style="margin-left: -3px"
                >
                  <label style="color: #43425d !important">Outlook</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.outlook"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
              <v-row style="margin-bottom: 30px">
                <v-col
                  cols="3"
                  class="d-flex align-center"
                  style="margin-left: -3px"
                >
                  <label style="color: #43425d !important">Vibe</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.vibe"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <v-container
      class="front"
      v-if="weekhoroscope && $vuetify.breakpoint.xsOnly"
      :style="$vuetify.breakpoint.xsOnly ? 'max-width: 295px;' : ''"
      style="padding: 30px 0px"
      
    >
      <v-row class="m-0">
        <v-col cols="12" class="h3 m-0 p-0">
          <h4>This Week’s Matches</h4>
        </v-col>
      </v-row>

      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-0 ' : 'mt-0 '"
        class="mb-2"
      >
        <v-col cols="12" class="h3 mb-0">
          <v-row>
            <div
              class="my-2 ability_card"
              style="height: 150px"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? 'width: 33%;'
                  : 'margin: 0px 31px;width: 125px;'
              "
            >
              <v-hover v-slot:default="{ hover }">
                <a
                  :href="'/horoscope/' + weekhoroscope.match1.slug"
                  style="text-decoration: none"
                >
                  <v-row class="ma-0 text-center">
                    <v-col
                      cols="12"
                      class="align-sm-center justify-sm-center sm4 p-0"
                    >
                      <img
                        :alt="weekhoroscope.match1.name + ' Zodiac Sign'"
                        :src="'/images/horoscopes/' + (hoverImg1 ? 'link_' : '') + weekhoroscope.match1.logo"
                        @mouseover="hoverImg1 = true"
                        @mouseleave="hoverImg1 = false"
                        @click="hoverImg1 = true"
                        style=""
                      />
                    </v-col>
                    <v-col cols="12" class="align-center text-center p-0 mt-1">
                      <div
                        class="description"
                        style="font-size: 12px; font-weight: 600; opacity: 1"
                      >
                        {{ weekhoroscope.match1.name }}
                      </div>
                      <div
                        class="description"
                        style="
                          font-weight: 400;
                          color: #43425d;
                          font-size: 12px;
                          font-weight: 500;
                          opacity: 1;
                          margin-top: 5px;
                        "
                      >
                        {{ weekhoroscope.subject1 }}
                      </div>
                    </v-col>
                  </v-row>
                </a>
              </v-hover>
            </div>
            <div
              class="my-2 ability_card"
              style="height: 150px"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? 'width: 33%;'
                  : 'margin: 0px 31px;width: 125px;'
              "
            >
              <v-hover v-slot:default="{ hover }">
                <a
                  :href="'/horoscope/' + weekhoroscope.match2.slug"
                  style="text-decoration: none"
                >
                  <v-row class="ma-0 text-center">
                    <v-col
                      cols="12"
                      class="align-sm-center justify-sm-center sm4 p-0"
                    >
                      <img
                        :alt="weekhoroscope.match2.name + ' Zodiac Sign'"
                        :src="'/images/horoscopes/' + (hoverImg2 ? 'link_' : '') + weekhoroscope.match2.logo"
                        @mouseover="hoverImg2 = true"
                        @mouseleave="hoverImg2 = false"
                        @click="hoverImg2 = true"
                        style=""
                      />
                    </v-col>
                    <v-col cols="12" class="align-center text-center p-0 mt-1">
                      <div
                        class="description"
                        style="font-size: 12px; font-weight: 600; opacity: 1"
                      >
                        {{ weekhoroscope.match2.name }}
                      </div>
                      <div
                        class="description"
                        style="
                          font-weight: 400;
                          color: #43425d;
                          font-weight: 500;
                          opacity: 1;
                          margin-top: 5px;
                          font-size: 12px;
                        "
                      >
                        {{ weekhoroscope.subject2 }}
                      </div>
                    </v-col>
                  </v-row>
                </a>
              </v-hover>
            </div>
            <div
              class="my-2 ability_card"
              style="height: 150px"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? 'width: 33%;'
                  : 'margin: 0px 31px;width: 125px;'
              "
            >
              <v-hover v-slot:default="{ hover }">
                <a
                  :href="'/horoscope/' + weekhoroscope.match3.slug"
                  style="text-decoration: none"
                >
                  <v-row class="ma-0 text-center">
                    <v-col
                      cols="12"
                      class="align-sm-center justify-sm-center sm4 p-0"
                    >
                      <img
                        :alt="weekhoroscope.match3.name + ' Zodiac Sign'"
                        :src="'/images/horoscopes/' + (hoverImg3 ? 'link_' : '') + weekhoroscope.match3.logo"
                        @mouseover="hoverImg3 = true"
                        @mouseleave="hoverImg3 = false"
                        @click="hoverImg3 = true"
                        style=""
                      />
                    </v-col>
                    <v-col cols="12" class="align-center text-center p-0 mt-1">
                      <div
                        class="description"
                        style="font-size: 12px; font-weight: 600; opacity: 1"
                      >
                        {{ weekhoroscope.match3.name }}
                      </div>
                      <div
                        class="description"
                        style="
                          font-weight: 400;
                          color: #43425d;
                          font-weight: 500;
                          opacity: 1;
                          margin-top: 5px;
                          font-size: 12px;
                        "
                      >
                        {{ weekhoroscope.subject3 }}
                      </div>
                    </v-col>
                  </v-row>
                </a>
              </v-hover>
            </div>
          </v-row>
        </v-col>
      </v-row>
      <v-row justify="space-around" class="m-0 mt-5">
        <v-col cols="12" class="h3 mb-0 px-0 px-lg-3">
          <h4>This Week’s Mood</h4>
        </v-col>
      </v-row>
      <v-row justify="space-around" class="m-0" >
        <v-col cols="12" class="h3 mb-0 px-0 px-lg-3">
          <v-card
            class="sfProfileRating sfWeekhoroscope elevation-0 pl-0"
            outlined
            color="transparent"
          >
            <v-card-text class="pb-0 pl-0 pr-0">
              <v-row style="margin-bottom: 10px">
                <v-col cols="3" class="d-flex align-center">
                  <label style="color: #43425d !important">Hustle</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.hustle"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
              <v-row style="margin-bottom: 10px">
                <v-col cols="3" class="d-flex align-center">
                  <label style="color: #43425d !important">Love</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.love"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
              <v-row style="margin-bottom: 10px">
                <v-col cols="3" class="d-flex align-center">
                  <label style="color: #43425d !important">Outlook</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.outlook"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
              <v-row style="margin-bottom: 0px" id="SubscribeHoroscope">
                <v-col cols="3" class="d-flex align-center">
                  <label style="color: #43425d !important">Vibe</label>
                </v-col>
                <v-col cols="9" class="d-flex justify-center align-center">
                  <v-progress-linear
                    class="d-inline reviews-bars"
                    :value="weekhoroscope.vibe"
                    color="#8EBEF8"
                    background-color="#F4F4F4"
                    height="15"
                    reactive
                  ></v-progress-linear>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <section style="background: #f4f4f4" class="p-0" >
      <div
        class="container"
        :style="$vuetify.breakpoint.xsOnly ? 'max-width: 295px;' : ''"
        style="padding: 20px 0px"
        
      >
        <div class="row p-0 m-0">
          <div
            class="sfSign p-0"
            :class="$vuetify.breakpoint.xsOnly ? 'col-12' : 'col-4'"
            :style="[
              $vuetify.breakpoint.xsOnly ? { order: '0' } : { order: '0' },
            ]"
            
          >
            <h3
              style="color: #43425d; font-weight: 600"
              class="p-0"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? '    font-size: 14px !important'
                  : '    font-size: 16px !important'
              "
            >
              Get Your Personal Weekly Horoscope Delivered Right to Your Inbox
              for Free!
            </h3>
          </div>
          <div
            class="m-0 p-0"
            :class="$vuetify.breakpoint.xsOnly ? 'col-12' : 'col-8 pr-0'"
            :style="[
              $vuetify.breakpoint.xsOnly
                ? { order: '0', 'margin-bottom': '40px' }
                : { order: '1' },
            ]"
          >
            <v-card
              class="elevation-0 pl-0 m-0"
              style="
                background: #f4f4f4;
                border-radius: 30px !important;
                margin: auto;
                width: auto;
                float: rigth;
              "
              :style="
                $vuetify.breakpoint.smAndUp ? 'width: 630px;float: right;' : ''
              "
              outlined
              color="transparent"
            >
              <v-card-text class="p-0">
                <form method="POST" action class="registration_form">
                  <div class="form-row m-0">
                    <div
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-4 pl-0 pr-0"
                      :style="
                        $vuetify.breakpoint.smAndUp
                          ? 'max-width: 295px; width: 295px;;height: 40px;'
                          : ''
                      "
                      style="margin-bottom: 20px"
                    >
                      <v-text-field
                        label=""
                        placeholder="First Name"
                        v-model="user_horoscope.name"
                        hide-details
                        flat
                        height="40"
                        solo
                        class="inputClass1"
                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'max-width: 295px; width: 295px;;height: 40px;'
                            : ''
                        "
                      >
                        <template v-slot:prepend-inner>
                          <img
                            width="32"
                            height="32"
                            src="/images/profile/finger_print.svg"
                            alt=""
                          />
                        </template>
                      </v-text-field>
                      <span
                        class="float-right text-danger"
                        style="font-size: 12px"
                      >
                        <span v-if="errors1.name">{{ errors1.name[0] }}</span>
                      </span>
                    </div>

                    <div
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-6 pr-0"
                      :style="
                        $vuetify.breakpoint.mdAndDown
                          ? 'padding-left: 0px !important;'
                          : 'padding-left: 34px !important; max-width: 295px; width: 295px;;'
                      "
                    >
                      <v-text-field
                        placeholder="Birthday"
                        label="Birthday"
                        v-model="user_horoscope.birth_date"
                        v-mask="'##/##/####'"
                        hide-details
                        flat
                        height="40"
                        solo
                        class="inputClass1"
                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'max-width: 295px; width: 295px;;height: 40px;'
                            : ''
                        "
                      >
                        <template v-slot:prepend-inner>
                          <img
                            width="32"
                            height="32"
                            src="/images/profile/birthday.svg"
                            alt=""
                          />
                        </template>
                      </v-text-field>
                      <div
                        class="text-danger"
                        style="font-size: 12px; width: 100%; text-align: right"
                        v-if="errors1.birth_date"
                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'max-width: 295px; width: 295px;'
                            : ''
                        "
                      >
                        {{ errors1.birth_date[0] }}
                      </div>
                    </div>
                  </div>

                  <div class="form-row m-0">
                    <div
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-6 pl-0 pr-0 p-0"
                    >
                      <label
                        class="sfFormHoroscopeLabel"
                        style="
                          font-size: 12px !important;
                          color: #43425d !important;
                          margin-top: 10px;
                        "
                        >Send My Horoscope via Email</label
                      >
                      <v-text-field
                        label=""
                        placeholder="Email"
                        v-model="user_horoscope.email"
                        hide-details
                        flat
                        height="40"
                        solo
                        class="inputClass1"
                        :style="
                          $vuetify.breakpoint.smAndUp
                            ? 'max-width: 295px; width: 295px;;height: 40px;'
                            : ''
                        "
                      >
                        <template v-slot:prepend-inner>
                          <img
                            width="32"
                            height="32"
                            src="/images/icons/email.svg"
                            alt=""
                          />
                        </template>
                      </v-text-field>
                      <div
                        class="float-right text-danger"
                        style="font-size: 12px; margin-right: 20px"
                        v-if="errors1.email"
                      >
                        {{ errors1.email[0] }}
                      </div>
                    </div>

                    <div
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-6 pr-0"
                      :style="
                        $vuetify.breakpoint.mdAndDown
                          ? 'padding: 0px 5px !important'
                          : 'padding-left: 20px !important;max-width: 295px; width: 295px;'
                      "
                    >
                      <label
                        class="sfFormHoroscopeLabel"
                        style="
                          font-size: 12px !important;
                          color: #43425d !important;
                          margin-top: 10px;
                        "
                        >Actually, I Prefer Text Instead!</label
                      >
                      <div
                        class="form-row mb-0"
                        :style="
                          $vuetify.breakpoint.mdAndDown
                            ? ''
                            : 'max-width: 295px; width: 295px;'
                        "
                      >
                        <div
                          class="col-md-4 col-4 col-sm-4 col-lg-4 pl-0"
                          :style="
                            $vuetify.breakpoint.smAndUp
                              ? 'max-width: 99px;'
                              : ''
                          "
                        >
                          <v-select
                            v-model="user_horoscope.code"
                            :items="country_all"
                            item-text="country"
                            item-value="id"
                            label="Select"
                            filled
                            background-color="#FFFFFF"
                            class="whiteCheckList"
                            :menu-props="{
                              contentClass: 'checkList-lineGrey',
                            }"
                            dense
                            :style="
                              $vuetify.breakpoint.smAndUp
                                ? 'width: 99px;height: 40px;'
                                : ''
                            "
                            solo
                            :height="40"
                          >
                            <template slot="selection" slot-scope="data"
                              ><span
                                style="
                                  font-size: 10px !important;
                                  color: rgba(0, 0, 0, 0.87) !important;
                                "
                                >{{ data.item.code2 }} (+
                                {{ data.item.prefix }} )</span
                              ></template
                            >
                            <template slot="item" slot-scope="data"
                              >{{ data.item.country }} (+
                              {{ data.item.prefix }} )</template
                            >
                          </v-select>

                          <span
                            v-if="errors1.code"
                            class="float-left text-danger"
                            style="font-size: 10px"
                            >{{ errors1.code[0] }}</span
                          >
                        </div>
                        <div
                          class="col-md-8 col-8 col-sm-8 col-lg-8 pr-0 pl-0"
                          :style="
                            $vuetify.breakpoint.smAndUp
                              ? '    max-width: 186px;height: 40px;margin-left: 10px;'
                              : ''
                          "
                        >
                          <v-text-field
                            label=""
                            placeholder="Mobile"
                            v-model="user_horoscope.number"
                            hide-details
                            flat
                            height="40"
                            solo
                            class="inputClass1"
                            :style="
                              $vuetify.breakpoint.smAndUp
                                ? 'width: 186px;height: 40px;'
                                : ''
                            "
                          >
                            <template v-slot:prepend-inner>
                              <img
                                width="32"
                                height="32"
                                src="/images/icons/mobile.svg"
                                alt=""
                              />
                            </template>
                          </v-text-field>

                          <div
                            class="col-md-12 col-12 col-sm-12 col-lg-12 float-right text-danger pr-0"
                            style="
                              min-height: 25px;
                              font-size: 12px;
                              text-align: right;
                            "
                            v-if="errors1.number"
                          >
                            {{ errors1.number[0] }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div
                    class="form-row ml-0 mr-0"
                    style="margin-top: 5px; margin-bottom: 30px"
                  >
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                      <v-checkbox
                        class="float-left age"
                        style="display: inline-block"
                        v-model="user_horoscope.age"
                        hide-details
                      >
                        <template v-slot:label>
                          <label
                            style="
                              width: 100%;
                              color: #43425d !important;
                              font-size: 10px !important;
                              font-weight: 400;
                            "
                          >
                            By signing up, you certify that you are 18 years old
                            or older, and you agree to our
                            <a href="/terms" style="color: #8ebef8"
                              >Terms & Conditions</a
                            >.
                            <span class="text-danger">*</span>
                          </label>
                        </template>
                      </v-checkbox>
                    </div>
                    <div
                      class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0 mt-0 text-danger float-right"
                      v-if="errors1.age"
                      style="font-size: 12px; text-align: right"
                    >
                      {{ errors1.age[0] }}
                    </div>
                    <div
                      style="font-size: 10px"
                      v-if="errors1.spam"
                      class="mt-3 col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0 mt-0"
                    >
                      <span
                        class="text-danger float-right"
                        style="font-size: 12px"
                        >{{ errors1.spam[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="form-rows mb-0 mt-0" style="padding-bottom: 10px">
                    <div class="col-12" style="text-align: center">
                      <v-btn
                        class="mb-0 btn-block"
                        color="#8EbEF8"
                        depressed
                        rounded
                        min-width="112"
                        width="112"
                        :loading="loading"
                        :disabled="loading"
                        @click="getTokenUser()"
                      >
                        <span style="color: #ffffff">Subscribe</span>
                      </v-btn>
                    </div>
                  </div>
                </form>
              </v-card-text>
            </v-card>
          </div>
        </div>
      </div>
    </section>

    <div class="p-0" v-if="glances[horoscope.id]" style="margin-top: 20px">
      <v-img
        alt="Home Banner Image"
        style="z-index: 1"
        src="/images/horoscopes/AtAGlanceNew.png"
        aspect-ratio="1"
        :max-height="mobile ? 600 : 359"
        class="align-sm-center justify-sm-center home_hero"
      >
        <v-container
          class="p-0"
          :style="$vuetify.breakpoint.xsOnly ? 'max-width: 295px;' : ''"
        >
          <div
            class="align-sm-center text-center-md justify-sm-center pl-0 pr-0 sfAglance"
          >
            <h3
              class="mb-5 mt-5"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? '    text-align: left; !important; font-size: 14px !important'
                  : '    text-align: center; !important; font-size: 16px !important'
              "
            >
              At A Glance
            </h3>
            <div
              v-if="!$vuetify.breakpoint.xsOnly"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? 'padding-left: 0px !important'
                  : 'padding-left: 0px !important'
              "
            >
              <v-col class="p-0">
                <h2>Dates</h2>
                <p>{{ horoscope.start_period }} - {{ horoscope.end_period }}</p>
              </v-col>
              <v-col
                class="p-0"
                v-for="(glance_value, glance_index) in glances[horoscope.id]"
                :key="glance_index"
                v-if="!horoscope.glance_1"
              >
                <h2>{{ glance_index }}</h2>
                <p>{{ glance_value }}</p>
              </v-col>

              <v-col class="p-0" v-if="horoscope.glance_1">
                <h2>Symbol</h2>
                <p>{{ horoscope.glance_1 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_2">
                <h2>Sociability Scale</h2>
                <p>{{ horoscope.glance_2 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_3">
                <h2>Optimist Scale</h2>
                <p>{{ horoscope.glance_3 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_4">
                <h2>Best Day of Week</h2>
                <p>{{ horoscope.glance_4 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_5">
                <h2>Element Energy</h2>
                <p>{{ horoscope.glance_5 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_6">
                <h2>Chinese Zodiac</h2>
                <p>{{ horoscope.glance_6 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_7">
                <h2>Keeps Your Secrets</h2>
                <p>{{ horoscope.glance_7 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_8">
                <h2>Romance Month</h2>
                <p>{{ horoscope.glance_8 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_9">
                <h2>Key Body Area</h2>
                <p>{{ horoscope.glance_9 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_10">
                <h2>Ruling Planet</h2>
                <p>{{ horoscope.glance_10 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_11">
                <h2>Karmic Love Partner</h2>
                <p>{{ horoscope.glance_11 }}</p>
              </v-col>
              <v-col class="p-0" v-if="horoscope.glance_12">
                <h2>Zodiac Birthstone</h2>
                <p>{{ horoscope.glance_12 }}</p>
              </v-col>
            </div>

            <div
              v-else
              :style="
                $vuetify.breakpoint.xsOnly
                  ? 'padding-left: 0px !important'
                  : 'padding-left: 50px !important'
              "
            >
              <v-row class="m-0">
                <v-col class="mb-5 p-0">
                  <h2
                    class="mb-0"
                    :style="
                      $vuetify.breakpoint.xsOnly ? 'font-size: 12px;' : ''
                    "
                  >
                    Dates:
                  </h2>
                </v-col>
                <v-col class="mb-5 p-0">
                  <p class="mb-0">
                    {{ horoscope.start_period }} - {{ horoscope.end_period }}
                  </p>
                </v-col>
              </v-row>
              <v-row
                class="m-0"
                v-for="(glance_value, glance_index) in glances[horoscope.id]"
                :key="glance_index"
              >
                <v-col class="mb-5 p-0">
                  <h2
                    class="mb-0"
                    :style="
                      $vuetify.breakpoint.xsOnly ? 'font-size: 12px;' : ''
                    "
                  >
                    {{ glance_index }}:
                  </h2>
                </v-col>
                <v-col class="mb-5 p-0">
                  <p class="mb-0">{{ glance_value }}</p>
                </v-col>
              </v-row>
            </div>
          </div>
        </v-container>
      </v-img>
    </div>

    <v-layout
      row
      class="front m-0"
      v-if="horoscope.about"
      style="background: #f4f4f4; margin-top: 20px !important"
    >
      <v-flex
        :style="
          $vuetify.breakpoint.xsOnly ? 'padding: 10px 20px;' : 'padding: 5px'
        "
        style="background: #f4f4f4"
      >
        <v-container
          class="p-0"
          :style="$vuetify.breakpoint.xsOnly ? 'max-width: 295px;' : ''"
        >
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner pl-0 pr-0"
            style="padding: 20px 0px"
          >
            <h3
              class="mb-5"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? 'font-size: 14px !important'
                  : 'font-size: 16px !important'
              "
            >
              About {{ horoscope.name }}
            </h3>
            <p
              class="text-center-md"
              style="color: #656b72; font-weight: 500"
              :style="
                $vuetify.breakpoint.xsOnly
                  ? '    font-size: 12px !important'
                  : '    font-size: 14px !important'
              "
            >
              {{ horoscopeabout }}
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

    <v-container class="py-0 front">
      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-12 px-4' : 'mt-8 px-4'"
        class="mb-2"
      >
        <v-col cols="9" class="h3 mb-0">
          <h4>Popular Model Advisors</h4>
        </v-col>
        <v-col class="mb-0 text-lg-right cursor-pointer px-0 px-lg-3" style="line-height: 18px;">
          <a href="/search?sortBy=popular">
            <span class="grey--text" style="font-size: 14px;font-weight:600;color: #43425D !important;opacity: 0.5;">Show All</span>
          </a>
        </v-col>
      </v-row>
      <ListItems :guest="guest" :cols="3" :perPageProp ="2"  :rows="!mobile ? 2 : null"  bottomOff="true" :filters="{ popular: true }" />
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./specialtie_user_list.vue";

import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import "swiper/swiper-bundle.css";

export default {
  data() {
    return {
      window: 0,
      window1: 0,
      online: true,
      featured: true,
      hoverImg1: false,hoverImg2: false,hoverImg3: false,
      categories: [],
      items: [],
      user_horoscope: {
        age: false,
        name: "",
        email: "",
        code: 215,
        number: "",
        token: "",
        age: true,
      },
      errors1: [],
      errors: [],
      error: "",
      email: "",
      message: "",
      loading: false,
      loadingLogin: false,
      loginDialog: false,

      glances: {
        1: {
          Symbol: "Ram",
          "Sociability Scale": "Mild Extrovert",
          "Optimist Scale": "Mild Pessimist",
          "Best Day of Week": "Thursday",
          "Element Energy": "Spark",
          "Chinese Zodiac": "The Rat",
          "Keeps Your Secrets": "Taurus & Scorpio",
          "Romance Month": "August",
          "Key Body Area": "The Head",
          "Ruling Planet": "Mars",
          "Karmic Love Partner": "Libra",
          "Zodiac Birthstone": "Diamond",
        },
        2: {
          Symbol: "Bull",
          "Sociability Scale": "Deep Introvert",
          "Optimist Scale": "Mild Optimist",
          "Best Day of Week": "Wednesday",
          "Element Energy": "Stone",
          "Chinese Zodiac": "The Ox",
          "Keeps Your Secrets": "Gemini & Sagittarius",
          "Romance Month": "September",
          "Key Body Area": "Throat",
          "Ruling Planet": "Venus",
          "Karmic Love Partner": "Scorpio",
          "Zodiac Birthstone": "Emerald",
        },
        3: {
          Symbol: "Twins",
          "Sociability Scale": "Extreme Extrovert",
          "Optimist Scale": "Mild Pessimist",
          "Best Day of Week": "Tuesday",
          "Element Energy": "Cool Breeze",
          "Chinese Zodiac": "The Tiger",
          "Keeps Your Secrets": "Cancer & Capricorn",
          "Romance Month": "October",
          "Key Body Area": "Arms",
          "Ruling Planet": "Mercury",
          "Karmic Love Partner": "Sagittarius",
          "Zodiac Birthstone": "Pearl",
        },
        4: {
          Symbol: "Crab",
          "Sociability Scale": "Mild Introvert",
          "Optimist Scale": "Optimist",
          "Best Day of Week": "Monday",
          "Element Energy": "Stone",
          "Chinese Zodiac": "The Rabbit",
          "Keeps Your Secrets": "Leo & Aquarius",
          "Romance Month": "November",
          "Key Body Area": "Hands",
          "Ruling Planet": "Moon",
          "Karmic Love Partner": "Capricorn",
          "Zodiac Birthstone": "Ruby",
        },
        5: {
          Symbol: "Lion",
          "Sociability Scale": "Extreme Extrovert",
          "Optimist Scale": "Optimist",
          "Best Day of Week": "Sunday",
          "Element Energy": "Bonfire",
          "Chinese Zodiac": "The Dragon",
          "Keeps Your Secrets": "Virgo & Pisces",
          "Romance Month": "December",
          "Key Body Area": "Heart",
          "Ruling Planet": "Sun",
          "Karmic Love Partner": "Aquarius",
          "Zodiac Birthstone": "Peridot",
        },
        6: {
          Symbol: "Virgin",
          "Sociability Scale": "Mild Introvert",
          "Optimist Scale": "Mild Pessimist",
          "Best Day of Week": "Tuesday",
          "Element Energy": "Landslide",
          "Chinese Zodiac": "The Snake",
          "Keeps Your Secrets": "Libra & Aries",
          "Romance Month": "January",
          "Key Body Area": "Stomach",
          "Ruling Planet": "Mercury",
          "Karmic Love Partner": "Pisces",
          "Zodiac Birthstone": "Sapphire",
        },
        7: {
          Symbol: "Scales",
          "Sociability Scale": "Mild Extrovert",
          "Optimist Scale": "Mild Optimist",
          "Best Day of Week": "Wednesday",
          "Element Energy": "Exhaling Air",
          "Chinese Zodiac": "The Horse",
          "Keeps Your Secrets": "Scorpio & Taurus",
          "Romance Month": "February",
          "Key Body Area": "Kidneys",
          "Ruling Planet": "Venus",
          "Karmic Love Partner": "Aries",
          "Zodiac Birthstone": "Opal",
        },
        8: {
          Symbol: "Scorpion",
          "Sociability Scale": "Deep Introvert",
          "Optimist Scale": "Deep Pessimist",
          "Best Day of Week": "Thursday",
          "Element Energy": "Ice",
          "Chinese Zodiac": "The Sheep",
          "Keeps Your Secrets": "Sagittarius & Gemini",
          "Romance Month": "March",
          "Key Body Area": "Pelvis",
          "Ruling Planet": "Pluto & Mars",
          "Karmic Love Partner": "Taurus",
          "Zodiac Birthstone": "Topaz",
        },
        9: {
          Symbol: "Archer",
          "Sociability Scale": "Mild Extrovert",
          "Optimist Scale": "Deep Optimist",
          "Best Day of Week": "Friday",
          "Element Energy": "Wildfire",
          "Chinese Zodiac": "The Monkey",
          "Keeps Your Secrets": "Capricorn & Cancer",
          "Romance Month": "April",
          "Key Body Area": "Thighs",
          "Ruling Planet": "Jupiter",
          "Karmic Love Partner": "Gemini",
          "Zodiac Birthstone": "Turquoise",
        },
        10: {
          Symbol: "Goat",
          "Sociability Scale": "Mild Introvert",
          "Optimist Scale": "Mild Optimist",
          "Best Day of Week": "Saturday",
          "Element Energy": "Meteor",
          "Chinese Zodiac": "The Rooster",
          "Keeps Your Secrets": "Aquarius & Leo",
          "Romance Month": "May",
          "Key Body Area": "Legs",
          "Ruling Planet": "Saturn",
          "Karmic Love Partner": "Cancer",
          "Zodiac Birthstone": "Garnet",
        },
        11: {
          Symbol: "Water-bearer",
          "Sociability Scale": "Extreme Extrovert",
          "Optimist Scale": "Extreme Optimist",
          "Best Day of Week": "Sunday",
          "Element Energy": "Deep Breath",
          "Chinese Zodiac": "The Dog",
          "Keeps Your Secrets": "Pisces & Virgo",
          "Romance Month": "June",
          "Key Body Area": "Ankles",
          "Ruling Planet": "Uranus & Saturn",
          "Karmic Love Partner": "Leo",
          "Zodiac Birthstone": "Amethyst",
        },
        12: {
          Symbol: "Two Fish",
          "Sociability Scale": "Deep Introvert",
          "Optimist Scale": "Extreme Optimist",
          "Best Day of Week": "Friday",
          "Element Energy": "Flood",
          "Chinese Zodiac": "The Pig",
          "Keeps Your Secrets": "Aries & Libra",
          "Romance Month": "July",
          "Key Body Area": "Feet",
          "Ruling Planet": "Neptune & Jupiter",
          "Karmic Love Partner": "Virgo",
          "Zodiac Birthstone": "Aquamarine",
        },
      },
      links: [
        "/specialty/psychic",
        "/specialty/medium",
        "/specialty/astrology",
        "/specialty/palm-reading",
        "/specialty/tarot-card-reader",
        "/specialty/clairvoyant",
        "/specialty/spiritual-healer",
      ],
      filter: false,
      swiperOptions: {
        loop: true,
        breakpoints: {
          // when window width is >= 320px
          320: {
            slidesPerView: 5,
          },
          // when window width is >= 960
          960: {
            slidesPerView: 6,
          },
          // when window width is >= 1264
          1264: {
            slidesPerView: 9,
          },
        },
      },
      swiperOptions2: {
        loop: true,
        breakpoints: {
          // when window width is >= 320
          320: {
            slidesPerView: 3,
          },
          768: {
            slidesPerView: 6,
          },
          // when window width is >= 960
          960: {
            slidesPerView: 6,
          },
          // when window width is >= 1264
          1264: {
            slidesPerView: 9,
          },
        },
      },
    };
  },
  props: {
    country_all: {
      require: true,
    },
    horoscope: {
      require: true,
    },
    weekhoroscope: {
      require: true,
    },
    datetoday: {
      require: true,
    },
    guest: {
      default: true,
    },
    user: {
      default: false,
    },
  },
  components: {
    ListItems,
    Swiper,
    SwiperSlide,
  },
  computed: {
    swiper() {
      return this.$refs.mySwiper.$swiper;
    },
    swiper2() {
      return this.$refs.mySwiper2.$swiper;
    },
    ...mapGetters({
      mobile: "util/mobile",
      paginate: "category/items",
      paginate1: "specialty/items",
    }),
  },

  watch: {},
  methods: {

    getSubscribe(){
        window.open('/#SubscribeHoroscope');
    },

    getTokenUser() {
      this.loading = true;
      const self = this;
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6LdkjDkbAAAAAEKr_DU5nNYOQW5GrZpPB8mNvgHd", {
            action: "registerUser",
          })
          .then(function (token) {
            if (token) {
              self.user_horoscope.token = token;
              self.registerUser();
            }
          });
      });
    },
    registerUser() {
      var input = this.user_horoscope;
      axios
        .post("/register/user-horoscope", input)
        .then((res) => {
          console.log(res);
          if (res.status == 201) {
            // window.location = "/";
            this.$root.$emit("open_standard_dialog", {
              buttom_text: "Got It",
              title: "You're Subscribed!",
              subtitle: "We'll deliver your horoscope each Monday.",
            });
          }

          this.loading = false;
          this.errors1 = [];
          this.resetUser();
        })
        .catch((error) => {
          this.user_horoscope.token = "";
          this.message =
            "There is something wrong, please check that all form fields are correct.";

          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (error.response.status === 422) {
            this.errors1 = error.response.data.errors;
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
      this.user_horoscope = {
        age: false,
        name: "",
        email: "",
        code: 215,
        number: "",
        token: "",
      };
    },
    nextAbilities() {
      this.swiper.slideNext();
    },
    nextSpecialties() {
      this.swiper2.slideNext();
    },
    getLoadingArray() {
      let array = [];
      for (let i = 0; i < 6; i++) array.push({ loading: true });
      return array;
    },
    setFeatured(val) {
      this.featured = val;
    },
    f_open_login() {
      EventBus.$emit("open_sign_up_user", {});
    },
  },
  created() {
    const chunk = (arr, size) =>
      Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
        arr.slice(i * size, i * size + size)
      );

    this.$store.dispatch("util/setUser", this.user);
  },
};
</script>
<style>
.v-expansion-panel:before {
  box-shadow: none;
}

.theme--light.v-expansion-panels .v-expansion-panel {
  background-color: transparent;
}

.v-expansion-panel-header__icon i {
  color: #9759FF !important;
  font-size: 45px !important;
}

.h2Horoscope {
  font-weight: 500 !important;
  font-size: 12px !important;
  color: #1f1e34 !important;
  opacity: 0.5;
  letter-spacing: 0.24px;
  line-height: 22px;
}
.sfAglance h3 {
  text-align: center;
  font-size: 16px;
  line-height: 22px;
  font-weight: 600;
  opacity: 1;
  letter-spacing: 0.32px;
}
.sfAglance h2 {
  font-size: 14px;
  line-height: 18px;
  letter-spacing: 0px;
  color: #fff;
  opacity: 1;
  font-weight: 600;
}

.sfAglance p {
  font-size: 12px;
  color: #fff;
  opacity: 1;
  letter-spacing: 0px;
  line-height: 18px;
  font-weight: 500;
  margin-bottom: 40px !important;
}
.sfAglance .col {
  max-width: 226px;
  display: inline-block;
}

.sfFormHoroscopeLabel {
  font-size: 15px !important;
  color: #a2a2a2 !important;
  letter-spacing: 0.24px;
  line-height: 18px;
  font-weight: 600 !important;
}

.PsychicAdvisors .col.col-12.pa-3.pa-md-4 {
  padding: 0px !important;
}

.ico-profile-astrology_icon {
  background: url("/images/horoscopes/AstrologyIcon.svg");
  background-position: center;
  height: 34px;
  width: 34px;
  background-repeat: no-repeat;
  left: -3px;
}

.SubscribeFree.v-btn:not(.v-btn--round).v-size--default,
.SubscribeFree {
  height: 34px !important;
}

.theme--light.SubscribeFree.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background: rgba(67, 66, 93, 0.5);
  border-radius: 10px 20px 20px 10px;
  padding-left: 0px;
}
</style>
