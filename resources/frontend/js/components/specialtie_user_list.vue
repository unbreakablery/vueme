<template>
  <div>
    <v-window v-if="!rows && !filters.rating" v-model="window">
      
      <v-window-item
        v-if="models.length"
        :v-for="(models, index) in items"
        :key="index"
        :style="mobile ? 'min-height: 504px;' : ''"
      >
        <v-row no-gutters class="ma-0 d-flex justify-center">
          <v-col
            :class="`pa-${number == 1 ? 3 : 1} pa-md-4`"
            :cols="12 / number"
            v-for="(item, index) in models"
            :key="index"
            
          >
            <v-hover v-slot:default="{ hover }">
              <v-card
                v-if="!item.loading"
                style="
                  min-height: 228px;
                  border-radius: 20px !important;
                  background: #ebf4fd;
                "
                :elevation="hover ? 12 : 2"
                class="mx-auto list_card"
              >
                <div>
                  <v-row
                    class="m-0"
                    style="
                      height: 118px;
                      background: #ebf4fd;
                      border-radius: 20px 20px 0 0;
                    "
                  >
                    <a v-bind:href="'/' + item.profile.profile_link">
                      <v-badge v-if="item.online" color="green" bottom>
                        <template v-slot:badge>{{ "" }}</template>

                        <div
                          :aria-label="item.profile.display_name"
                          class="user_avatar_lg"
                          :class="[item.online ? 'online' : 'offline']"
                          :style="{
                            'background-image':
                              'url(' + item.profile.profile_headshot_url + ')',
                            'margin-top': '18px',
                            'margin-left': '15px',
                          }"
                        ></div>
                      </v-badge>
                      <v-badge v-else color="grey" bottom>
                        <template v-slot:badge>{{ "" }}</template>

                        <div
                          :aria-label="item.profile.display_name"
                          class="user_avatar_lg"
                          :class="[item.online ? 'online' : 'offline']"
                          :style="{
                            'background-image':
                              'url(' + item.profile.profile_headshot_url + ')',
                            'margin-top': '18px',
                            'margin-left': '15px',
                          }"
                        ></div>
                      </v-badge>
                      <div
                        :aria-label="item.profile.display_name"
                        class="user_avatar_lg"
                        :class="[item.online ? 'online' : 'offline']"
                        
                        :style="{
                          'background-image':
                            'url(' + item.profile.profile_headshot_url + ')',
                          'margin-top': '18px',
                          'margin-left': '15px',
                        }"
                      ></div>
                    </a>
                    <v-card-title
                      class="justify-center d-flex p-0"
                      style="align-items: baseline !important; margin-top: 39px"
                    >
                      <div class="flex-row">
                        <div
                          class="col-12 pr-0 pl-2 pl-lg-3 mb-1"
                          :style="{
                            'font-size': !$vuetify.breakpoint.xsOnly
                              ? '15px'
                              : '14px',
                            color: '#43425D',
                            width: $vuetify.breakpoint.xsOnly
                              ? '202px'
                              : '238px',
                            'line-height': '1.5',
                            'word-break': 'break-word',
                            
                            overflow: 'hidden !important',
                          }"
                        >
                          <a
                            v-bind:href="'/' + item.profile.profile_link"
                            style="color: #43425d; font-weight: 600"
                          >
                            <span>{{ item.profile.display_name }}</span>
                          </a>
                        </div>
                        <a
                          v-bind:href="
                            '/' + item.profile.profile_link + '#reviews'
                          "
                          style="color: #a2a2a2; text-decoration: none"
                          class="d-flex"
                        >
                          <v-rating
                            v-if="item.reviews_rating"
                            :value="parseFloat(item.reviews_rating)"
                            color="amber"
                            dense
                            half-increments
                            background-color="#C7C7C7"
                            empty-icon="mdi-star"
                            readonly
                            size="16"
                            class="starBtn"
                            style="line-height: 0.5"
                            :style="
                              !$vuetify.breakpoint.xsOnly
                                ? ' padding-left:10px'
                                : ' padding-left:5px'
                            "
                          ></v-rating>
                          <div
                            v-else
                            class="review-me"
                            style="line-height: 1.5"
                            :style="
                              !$vuetify.breakpoint.xsOnly
                                ? ' padding-left:12px'
                                : ' padding-left:9px'
                            "
                          >
                            Be the first to
                            <font style="text-decoration: underline"
                              >review me</font
                            >
                          </div>
                        </a>
                      </div>
                    </v-card-title>
                  </v-row>
                </div>
                <v-tooltip top v-if="!user || user.role_id != 1">
                  <template v-slot:activator="{ on }">
                    <v-icon
                      v-if="item.favorite"
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#43425D"
                      style="
                        position: absolute;
                        top: 5px;
                        right: 13px;
                        font-size: 19px !important;
                      "
                      class="ma-1 cursor-pointer"
                      >mdi-heart</v-icon
                    >
                    <v-icon
                      v-else
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      style="
                        position: absolute;
                        top: 5px;
                        right: 13px;
                        font-size: 19px !important;
                      "
                      class="ma-1 cursor-pointer"
                      >mdi-heart-outline</v-icon
                    >
                  </template>
                  <span>{{
                    item.favorite ? "Remove from favorites" : "Add to favorites"
                  }}</span>
                </v-tooltip>
                <v-row justify="space-around"> </v-row>

                <v-card-text
                  style="
                    background: #ffffff;
                    border-radius: 20px;
                    font-size: 10px;
                    padding: 10px !important;
                    position: absolute;
                    bottom: 0;
                  "
                >
                  <div class="row">
                    <div
                      class="col-12 text-center tagline--text pr-0 pl-0"
                      style="min-height: 22px"
                    >
                      {{ item.profile.tagline }}
                    </div>
                  </div>

                  <div
                    class="row mt-2"
                    style="font-size: 10px; padding: 0px 20px"
                  >
                    <div
                      class="col p-0 grey--text"
                      v-if="item.reviews"
                      :style="[
                        !item.profile.years_experience
                          ? { textAlign: 'center' }
                          : { textAlign: 'left' },
                      ]"
                    >
                      <b style="color: #656b72; font-weight: 600">{{
                        item.reviews
                      }}</b>
                      <span v-if="item.reviews == 1"> Review</span>
                      <span v-else> Reviews</span>
                    </div>

                    <div
                      v-if="
                        item.profile.years_experience != null &&
                        item.profile.years_experience > 0
                      "
                      class="col p-0 grey--text"
                      :style="[
                        item.reviews
                          ? { textAlign: 'center', display: 'inline-flex' }
                          : { textAlign: 'center' },
                      ]"
                    >
                      <b
                        style="color: #656b72; font-weight: 600"
                        :style="[
                          item.reviews
                            ? { display: 'inline-flex' }
                            : { textAlign: '' },
                        ]"
                        >{{ item.profile.years_experience }}
                        <span
                          v-if="item.profile.years_experience > 1"
                          :style="[
                            item.reviews
                              ? { padding: '0px 2px' }
                              : { padding: '0px' },
                          ]"
                          >years</span
                        >
                        <span v-else>year</span></b
                      >
                      Experience
                    </div>

                    <div
                      class="col p-0 grey--text"
                      :style="[
                        !item.profile.years_experience || !item.reviews
                          ? { textAlign: 'center' }
                          : { textAlign: 'right' },
                      ]"
                    >
                      <span v-if="item.profile.t_clients == 0"
                        ><b style="color: #656b72; font-weight: 600">New</b>
                        Model</span
                      >
                      <span v-else-if="item.profile.t_clients == 1"
                        ><b style="color: #656b72; font-weight: 600">{{
                          item.profile.t_clients
                        }}</b>
                        Client</span
                      >
                      <span v-else
                        ><b style="color: #656b72; font-weight: 600">{{
                          item.profile.t_clients
                        }}</b>
                        Clients</span
                      >
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-6" style="padding: 0px 3px !important">
                      <span v-for="(cat, index) in item.categories">
                        <img v-if="index < 4" :src="cat.path" />
                      </span>
                    </div>
                    <div class="col-6 text-right">
                      <v-btn
                        style="font-size: 12px"
                        rounded
                        small
                        color="#8EbEF8"
                        height="30"
                        class="m-0 elevation-0 white--text pr-0 pl-3"
                        :href="'/' + item.profile.profile_link"
                      >
                        Profile <img src="/images/icons/chevron-right.svg" />
                      </v-btn>
                    </div>
                  </div>
                </v-card-text>
              </v-card>
              <v-sheet
                v-else
                color="grey lighten-4"
                style="min-height: 240px; background-color: #ebf4fd !important"
              >
                <v-row>
                  <v-col class="d-flex justify-start big-avatar align-center">
                    <v-skeleton-loader type="avatar"></v-skeleton-loader>
                    <v-skeleton-loader
                      width="50%"
                      type="text"
                      class="ml-3"
                    ></v-skeleton-loader>
                  </v-col>
                </v-row>
                <div
                  style="background-color: white !important"
                  class="pb-3 pt-2"
                >
                  <v-row class="mt-10">
                    <v-col class="d-flex justify-start">
                      <v-skeleton-loader
                        width="50%"
                        type="text"
                        class="ml-2"
                      ></v-skeleton-loader>
                    </v-col>
                  </v-row>
                  <v-row class="mt-4">
                    <v-col class="d-flex justify-end">
                      <v-skeleton-loader
                        class="ml-3"
                        type="button"
                        style="border-radius: 10%; width: 90px"
                        width="90"
                      ></v-skeleton-loader>
                    </v-col>
                  </v-row>
                </div>

         
              </v-sheet>
            </v-hover>
            
          </v-col>
        </v-row>
      



      </v-window-item>
      
      <v-row
        no-gutters
        class="mt-5 d-flex justify-center"
        v-else-if="models.length == 0"
      >
        <v-col
          class="d-flex align-center justify-center"
          :style="{ minHeight: number == 1 ? '100px' : '430px' }"
        >
          <label style="color: #9759FF; font-size: 24px"
            >No models found.</label
          >
        </v-col>
      </v-row>
    </v-window>
    <v-window v-else-if="!rows && filters.rating" v-model="window">
      <v-window-item
        v-if="models.length"
        v-for="(models, index) in items"
        :key="index"
      >
        <v-row no-gutters class="ma-0 d-flex justify-center">
          <v-col
            :class="`pa-${number == 1 ? 3 : 1} pa-md-4`"
            class="col-md-3 col-lg-2 col-4"
            v-for="(item, index) in models"
            :key="index"
          >
            <v-hover v-slot:default="{ hover }">
              <v-card
                v-if="!item.loading"
                style="
                  min-height: 175px;
                  background: transparent;
                  box-shadow: none !important;
                "
                :elevation="0"
                class="mx-auto list_card"
              >
                <div>
                  <v-row
                    class="m-0 text-center"
                    style="
                      height: 118px;
                      background: transparent;
                      border-radius: 20px 20px 0 0;
                    "
                  >
                    <div class="col-12 p-0">
                      <a v-bind:href="'/' + item.profile.profile_link">
                        <v-badge
                          :class="
                            $vuetify.breakpoint.xsOnly
                              ? 'user_badge_lg'
                              : 'user_badge_1x'
                          "
                          v-if="item.online"
                          color="green"
                          bottom
                        >
                          <template v-slot:badge>{{ "" }}</template>

                          <div
                            :aria-label="item.profile.display_name"
                            :class="[
                              $vuetify.breakpoint.xsOnly
                                ? 'user_avatar_lg'
                                : 'user_avatar_1x',
                              item.online ? 'online' : 'offline',
                            ]"
                            :style="
                              ({
                                'margin-top': !$vuetify.breakpoint.xsOnly
                                  ? '18px'
                                  : '0px',
                              },
                              {
                                'margin-left': !$vuetify.breakpoint.xsOnly
                                  ? '15px'
                                  : '0px',
                              },
                              {
                                'background-image':
                                  'url(' +
                                  item.profile.profile_headshot_url +
                                  ')',
                              })
                            "
                          ></div>
                        </v-badge>
                        <v-badge
                          :class="
                            $vuetify.breakpoint.xsOnly
                              ? 'user_badge_lg'
                              : 'user_badge_1x'
                          "
                          v-else
                          color="grey"
                          bottom
                        >
                          <template v-slot:badge>{{ "" }}</template>

                          <div
                            :aria-label="item.profile.display_name"
                            :class="[
                              $vuetify.breakpoint.xsOnly
                                ? 'user_avatar_lg'
                                : 'user_avatar_1x',
                              item.online ? 'online' : 'offline',
                            ]"
                            :style="
                              ({
                                'margin-top': !$vuetify.breakpoint.xsOnly
                                  ? '18px'
                                  : '0px',
                              },
                              {
                                'margin-left': !$vuetify.breakpoint.xsOnly
                                  ? '15px'
                                  : '0px',
                              },
                              {
                                'background-image':
                                  'url(' +
                                  item.profile.profile_headshot_url +
                                  ')',
                              })
                            "
                          ></div>
                        </v-badge>
                        <div
                          :aria-label="item.profile.display_name"
                          :class="[
                            $vuetify.breakpoint.xsOnly
                              ? 'user_avatar_lg'
                              : 'user_avatar_1x',
                            item.online ? 'online' : 'offline',
                          ]"
                          v-else
                          :style="
                            ({
                              'margin-top': !$vuetify.breakpoint.xsOnly
                                ? '18px'
                                : '0px',
                            },
                            {
                              'margin-left': !$vuetify.breakpoint.xsOnly
                                ? '15px'
                                : '0px',
                            },
                            {
                              'background-image':
                                'url(' +
                                item.profile.profile_headshot_url +
                                ')',
                            })
                          "
                        ></div>
                      </a>
                    </div>
                    <v-card-title class="justify-center d-flex p-0 col-12">
                      <div class="flex-row">
                        <div
                          class="col-12 px-0 mb-0"
                          :style="{
                            color: '#43425d',
                            'word-break': 'break-word',
                            'font-size': '15px',
                            'min-height': '32px',
                            'margin-bottom': '7px !important',
                            'line-height': $vuetify.breakpoint.xsOnly
                              ? '1'
                              : '1.1',
                          }"
                        >
                          <a
                            v-bind:href="'/' + item.profile.profile_link"
                            :style="{
                              color: '#43425D',
                              'font-weight': '600',
                              opacity: '0.5',
                              'font-size': $vuetify.breakpoint.xsOnly
                                ? '10px'
                                : '12px',
                            }"
                          >
                            <span>{{ item.profile.display_name }}</span>
                          </a>
                        </div>
                        <a
                          v-bind:href="
                            '/' + item.profile.profile_link + '#reviews'
                          "
                          style="color: #a2a2a2; text-decoration: none"
                          class="d-flex"
                        >
                          <v-row class="px-2" style="flex-wrap: nowrap">
                            <v-col>
                              <v-rating
                                :value="parseFloat(item.reviews_rating)"
                                color="amber"
                                dense
                                background-color="#C7C7C7"
                                empty-icon="mdi-star"
                                half-increments
                                readonly
                                size="13"
                                class="starBtn"
                                style="line-height: 0.5"
                              ></v-rating>
                            </v-col>
                          </v-row>
                        </a>
                      </div>
                    </v-card-title>
                  </v-row>
                </div>
              </v-card>
              <v-sheet v-else style="min-height: 240px">
                <v-row>
                  <v-col class="d-flex justify-center big-avatar align-center">
                    <v-skeleton-loader type="avatar"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <div
                  style="background-color: white !important"
                  class="pb-3 pt-2"
                >
                  <v-row>
                    <v-col class="d-flex justify-center">
                      <v-skeleton-loader
                        width="50%"
                        type="text"
                        class="ml-2"
                      ></v-skeleton-loader>
                    </v-col>
                  </v-row>
                </div>
              
              </v-sheet>
            </v-hover>
          </v-col>
        </v-row>
      </v-window-item>
      <v-row
        no-gutters
        class="mt-5 d-flex justify-center"
        v-else-if="models.length == 0"
      >
        <v-col
          class="d-flex align-center justify-center"
          :style="{ minHeight: number == 1 ? '100px' : '430px' }"
        >
          <label style="color: #9759FF; font-size: 24px"
            >No models found.</label
          >
        </v-col>
      </v-row>
    </v-window>
    <v-container v-else-if="rows && !rating_rows && items.length">
      <v-row no-gutters class="ma-0 d-flex justify-center">
        <v-col
          :class="`pa-${number == 1 ? 3 : 1} pa-md-4`"
          :cols="12 / number"
          v-for="(item, index) in items"
          :key="index"
        >
           <v-hover v-slot:default="{ hover }">
              <v-card
                v-if="!item.loading"
                style="
                  min-height: 228px;
                  border-radius: 20px !important;
                  background: #ebf4fd;
                "
                :elevation="hover ? 12 : 2"
                class="mx-auto list_card"
              >
                <div>
                  <v-row
                    class="m-0"
                    style="
                      height: 118px;
                      background: #ebf4fd;
                      border-radius: 20px 20px 0 0;
                    "
                  >
                    <a v-bind:href="'/' + item.profile.profile_link">
                      <v-badge v-if="item.online" color="green" bottom>
                        <template v-slot:badge>{{ "" }}</template>

                        <div
                          :aria-label="item.profile.display_name"
                          class="user_avatar_lg"
                          :class="[item.online ? 'online' : 'offline']"
                          :style="{
                            'background-image':
                              'url(' + item.profile.profile_headshot_url + ')',
                            'margin-top': '18px',
                            'margin-left': '15px',
                          }"
                        ></div>
                      </v-badge>
                      <v-badge v-else color="grey" bottom>
                        <template v-slot:badge>{{ "" }}</template>

                        <div
                          :aria-label="item.profile.display_name"
                          class="user_avatar_lg"
                          :class="[item.online ? 'online' : 'offline']"
                          :style="{
                            'background-image':
                              'url(' + item.profile.profile_headshot_url + ')',
                            'margin-top': '18px',
                            'margin-left': '15px',
                          }"
                        ></div>
                      </v-badge>
                      <div
                        :aria-label="item.profile.display_name"
                        class="user_avatar_lg"
                        :class="[item.online ? 'online' : 'offline']"
                       
                        :style="{
                          'background-image':
                            'url(' + item.profile.profile_headshot_url + ')',
                          'margin-top': '18px',
                          'margin-left': '15px',
                        }"
                      ></div>
                    </a>
                    <v-card-title
                      class="justify-center d-flex p-0"
                      style="align-items: baseline !important; margin-top: 39px"
                    >
                      <div class="flex-row">
                        <div
                          class="col-12 pr-0 pl-2 pl-lg-3 mb-1"
                          :style="{
                            'font-size': !$vuetify.breakpoint.xsOnly
                              ? '15px'
                              : '14px',
                            color: '#43425D',
                            width: $vuetify.breakpoint.xsOnly
                              ? '202px'
                              : '238px',
                            'line-height': '1.5',
                            'word-break': 'break-word',
                            overflow: 'hidden !important',
                          }"
                        >
                          <a
                            v-bind:href="'/' + item.profile.profile_link"
                            style="color: #43425d; font-weight: 600"
                          >
                            <span>{{ item.profile.display_name }}</span>
                          </a>
                        </div>
                        <a
                          v-bind:href="
                            '/' + item.profile.profile_link + '#reviews'
                          "
                          style="color: #a2a2a2; text-decoration: none"
                          class="d-flex"
                        >
                          <v-rating
                            v-if="item.reviews_rating"
                            :value="parseFloat(item.reviews_rating)"
                            color="amber"
                            dense
                            half-increments
                            background-color="#C7C7C7"
                            empty-icon="mdi-star"
                            readonly
                            size="16"
                            class="starBtn"
                            style="line-height: 0.5"
                            :style="
                              !$vuetify.breakpoint.xsOnly
                                ? ' padding-left:10px'
                                : ' padding-left:5px'
                            "
                          ></v-rating>
                          <div
                            v-else
                            class="review-me"
                            style="line-height: 1.5"
                            :style="
                              !$vuetify.breakpoint.xsOnly
                                ? ' padding-left:12px'
                                : ' padding-left:9px'
                            "
                          >
                            Be the first to
                            <font style="text-decoration: underline"
                              >review me</font
                            >
                          </div>
                        </a>
                      </div>
                    </v-card-title>
                  </v-row>
                </div>
                <v-tooltip top v-if="!user || user.role_id != 1">
                  <template v-slot:activator="{ on }">
                    <v-icon
                      v-if="item.favorite"
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#43425D"
                      style="
                        position: absolute;
                        top: 5px;
                        right: 13px;
                        font-size: 19px !important;
                      "
                      class="ma-1 cursor-pointer"
                      >mdi-heart</v-icon
                    >
                    <v-icon
                      v-else
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      style="
                        position: absolute;
                        top: 5px;
                        right: 13px;
                        font-size: 19px !important;
                      "
                      class="ma-1 cursor-pointer"
                      >mdi-heart-outline</v-icon
                    >
                  </template>
                  <span>{{
                    item.favorite ? "Remove from favorites" : "Add to favorites"
                  }}</span>
                </v-tooltip>
                <v-row justify="space-around"> </v-row>

                <v-card-text
                  style="
                    background: #ffffff;
                    border-radius: 20px;
                    font-size: 10px;
                    padding: 10px !important;
                    position: absolute;
                    bottom: 0;
                  "
                >
                  <div class="row">
                    <div
                      class="col-12 text-center tagline--text pr-0 pl-0"
                      style="min-height: 22px"
                    >
                      {{ item.profile.tagline }}
                    </div>
                  </div>

                  <div
                    class="row mt-2"
                    style="font-size: 10px; padding: 0px 20px"
                  >
                    <div
                      class="col p-0 grey--text"
                      v-if="item.reviews"
                      :style="[
                        !item.profile.years_experience
                          ? { textAlign: 'center' }
                          : { textAlign: 'left' },
                      ]"
                    >
                      <b style="color: #656b72; font-weight: 600">{{
                        item.reviews
                      }}</b>
                      <span v-if="item.reviews == 1"> Review</span>
                      <span v-else> Reviews</span>
                    </div>

                    <div
                      v-if="
                        item.profile.years_experience != null &&
                        item.profile.years_experience > 0
                      "
                      class="col p-0 grey--text"
                      :style="[
                        item.reviews
                          ? { textAlign: 'center', display: 'inline-flex' }
                          : { textAlign: 'center' },
                      ]"
                    >
                      <b
                        style="color: #656b72; font-weight: 600"
                        :style="[
                          item.reviews
                            ? { display: 'inline-flex' }
                            : { textAlign: '' },
                        ]"
                        >{{ item.profile.years_experience }}
                        <span
                          v-if="item.profile.years_experience > 1"
                          :style="[
                            item.reviews
                              ? { padding: '0px 2px' }
                              : { padding: '0px' },
                          ]"
                          >years</span
                        >
                        <span v-else>year</span></b
                      >
                      Experience
                    </div>

                    <div
                      class="col p-0 grey--text"
                      :style="[
                        !item.profile.years_experience || !item.reviews
                          ? { textAlign: 'center' }
                          : { textAlign: 'right' },
                      ]"
                    >
                      <span v-if="item.profile.t_clients == 0"
                        ><b style="color: #656b72; font-weight: 600">New</b>
                        Model</span
                      >
                      <span v-else-if="item.profile.t_clients == 1"
                        ><b style="color: #656b72; font-weight: 600">{{
                          item.profile.t_clients
                        }}</b>
                        Client</span
                      >
                      <span v-else
                        ><b style="color: #656b72; font-weight: 600">{{
                          item.profile.t_clients
                        }}</b>
                        Clients</span
                      >
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-6" style="padding: 0px 3px !important">
                      <span :v-for="(cat, index) in item.categories">
                        <img v-if="index < 4" :src="cat.path" />
                      </span>
                    </div>
                    <div class="col-6 text-right">
                      <v-btn
                        style="font-size: 12px"
                        rounded
                        small
                        color="#8EbEF8"
                        height="30"
                        class="m-0 elevation-0 white--text pr-0 pl-3"
                        :href="'/' + item.profile.profile_link"
                      >
                        Profile <img src="/images/icons/chevron-right.svg" />
                      </v-btn>
                    </div>
                  </div>
                </v-card-text>
              </v-card>
              <v-sheet
                v-else
                color="grey lighten-4"
                style="min-height: 240px; background-color: #ebf4fd !important"
              >
                <v-row>
                  <v-col class="d-flex justify-start big-avatar align-center">
                    <v-skeleton-loader type="avatar"></v-skeleton-loader>
                    <v-skeleton-loader
                      width="50%"
                      type="text"
                      class="ml-3"
                    ></v-skeleton-loader>
                  </v-col>
                </v-row>
                <div
                  style="background-color: white !important"
                  class="pb-3 pt-2"
                >
                  <v-row class="mt-10">
                    <v-col class="d-flex justify-start">
                      <v-skeleton-loader
                        width="50%"
                        type="text"
                        class="ml-2"
                      ></v-skeleton-loader>
                    </v-col>
                  </v-row>
                  <v-row class="mt-4">
                    <v-col class="d-flex justify-end">
                      <v-skeleton-loader
                        class="ml-3"
                        type="button"
                        style="border-radius: 10%; width: 90px"
                        width="90"
                      ></v-skeleton-loader>
                    </v-col>
                  </v-row>
                </div>
            
              </v-sheet>
            </v-hover>
        </v-col>
      </v-row>

      <v-row v-if="showLoadMore && !bottomOff &&!loading" class="my-5">
        <v-col class="d-flex justify-center">
          <v-btn color="primary" @click="loadMore">Load More</v-btn>
        </v-col>
      </v-row>

      <v-row
        no-gutters
        class="mt-5 d-flex justify-center"
        v-else-if="items.length == 0"
      >
        <v-col>No result.</v-col>
      </v-row>
    </v-container>
    <v-container v-else-if="rating_rows && items.length">
      <v-row no-gutters class="ma-0 d-flex justify-center">
        <v-col
          :class="`pa-${number == 1 ? 3 : 1} pa-md-4`"
          :cols="12 / number"
          v-for="(item, index) in items"
          :key="index"
        >
          <v-hover v-slot:default="{ hover }">
            <v-card
              v-if="!item.loading"
              style="
                min-height: 225px;
                background: transparent;
                box-shadow: none !important;
              "
              :elevation="0"
              class="mx-auto list_card"
            >
              <div>
                <v-row
                  class="m-0 text-center"
                  style="
                    height: 118px;
                    background: transparent;
                    border-radius: 20px 20px 0 0;
                  "
                >
                  <div class="col-12 p-0">
                    <a v-bind:href="'/' + item.profile.profile_link">
                      <v-badge
                        :class="
                          $vuetify.breakpoint.xsOnly
                            ? 'user_badge_lg'
                            : 'user_badge_1x'
                        "
                        v-if="item.online"
                        color="green"
                        bottom
                      >
                        <template v-slot:badge>{{ "" }}</template>

                        <div
                          :aria-label="item.profile.display_name"
                          :class="[
                            $vuetify.breakpoint.xsOnly
                              ? 'user_avatar_lg'
                              : 'user_avatar_1x',
                            item.online ? 'online' : 'offline',
                          ]"
                          :style="
                            ({
                              'margin-top': !$vuetify.breakpoint.xsOnly
                                ? '18px'
                                : '0px',
                            },
                            {
                              'margin-left': !$vuetify.breakpoint.xsOnly
                                ? '15px'
                                : '0px',
                            },
                            {
                              'background-image':
                                'url(' +
                                item.profile.profile_headshot_url +
                                ')',
                            })
                          "
                        ></div>
                      </v-badge>
                      <v-badge
                        :class="
                          $vuetify.breakpoint.xsOnly
                            ? 'user_badge_lg'
                            : 'user_badge_1x'
                        "
                        v-else
                        color="grey"
                        bottom
                      >
                        <template v-slot:badge>{{ "" }}</template>

                        <div
                          :aria-label="item.profile.display_name"
                          :class="[
                            $vuetify.breakpoint.xsOnly
                              ? 'user_avatar_lg'
                              : 'user_avatar_1x',
                            item.online ? 'online' : 'offline',
                          ]"
                          :style="
                            ({
                              'margin-top': !$vuetify.breakpoint.xsOnly
                                ? '18px'
                                : '0px',
                            },
                            {
                              'margin-left': !$vuetify.breakpoint.xsOnly
                                ? '15px'
                                : '0px',
                            },
                            {
                              'background-image':
                                'url(' +
                                item.profile.profile_headshot_url +
                                ')',
                            })
                          "
                        ></div>
                      </v-badge>
                      <div
                        :aria-label="item.profile.display_name"
                        :class="[
                          $vuetify.breakpoint.xsOnly
                            ? 'user_avatar_lg'
                            : 'user_avatar_1x',
                          item.online ? 'online' : 'offline',
                        ]"
                        :style="
                          ({
                            'margin-top': !$vuetify.breakpoint.xsOnly
                              ? '18px'
                              : '0px',
                          },
                          {
                            'margin-left': !$vuetify.breakpoint.xsOnly
                              ? '15px'
                              : '0px',
                          },
                          {
                            'background-image':
                              'url(' + item.profile.profile_headshot_url + ')',
                          })
                        "
                      ></div>
                    </a>
                  </div>
                  <v-card-title class="justify-center d-flex p-0 col-12">
                    <div class="flex-row">
                      <div
                        class="col-12 px-0"
                        style="min-height: 30px;"
                        :style="{
                          color: '#43425d',
                          'word-break': 'break-word',
                          'font-size': '15px',
                          'line-height': $vuetify.breakpoint.xsOnly
                            ? '1'
                            : '1',
                        }"
                      >
                        <a
                          v-bind:href="'/' + item.profile.profile_link"
                          :style="{
                            color: '#43425D',
                            'font-weight': '600',
                            opacity: '0.5',
                            'font-size': $vuetify.breakpoint.xsOnly
                              ? '10px'
                              : '12px',
                          }"
                        >
                          <span>{{ item.profile.display_name }}</span>
                        </a>
                      </div>
                      <a
                        v-bind:href="
                          '/' + item.profile.profile_link + '#reviews'
                        "
                        style="color: #a2a2a2; text-decoration: none"
                        class="d-flex"
                      >
                        <v-row class="px-2" style="flex-wrap: nowrap">
                          <v-col>
                            <v-rating
                              :value="parseFloat(item.reviews_rating)"
                              color="amber"
                              dense
                              background-color="#C7C7C7"
                              empty-icon="mdi-star"
                              half-increments
                              readonly
                              size="13"
                              class="starBtn"
                              style="line-height: 0.5"
                            ></v-rating>
                          </v-col>
                        </v-row>
                       
                      </a>
                       <div
                        style="text-decoration: none; margin-top:5px"
                        class="d-flex"
                      >
                       <v-row class="px-2" style="flex-wrap: nowrap">
                          <v-col>
                            <v-btn
                              rounded
                              color="#8EbEF8"
                              class="m-0 elevation-0 white--text btnChat"
                              href="/signup"
                              ><font style="padding-right: 10px">Chat</font> 
                              <i class="fas faChevronRight  mr-2"></i>
                              </v-btn
                            ></v-col
                          >
                        </v-row>
                           </div>
                    </div>
                  </v-card-title>
                </v-row>
              </div>
            </v-card>
            <v-sheet v-else style="min-height: 240px">
              <v-row>
                <v-col class="d-flex justify-center big-avatar align-center">
                  <v-skeleton-loader type="avatar"></v-skeleton-loader>
                </v-col>
              </v-row>
              <div style="background-color: white !important" class="pb-3 pt-2">
                <v-row>
                  <v-col class="d-flex justify-center">
                    <v-skeleton-loader
                      width="50%"
                      type="text"
                      class="ml-2"
                    ></v-skeleton-loader>
                  </v-col>
                </v-row>
              </div>
             
            </v-sheet>
          </v-hover>
        </v-col>
      </v-row>

      <v-row v-if="showLoadMore && !loading" class="my-5">
        <v-col class="d-flex justify-center">
          <div @click="loadMore" style="color: #43425D; font-weight: 600; font-size: 14px; cursor: pointer;">Show More <img width="30" height="30" src="/images/icons/load_more.png"/></div>          
        </v-col>
      </v-row>

      <v-row
        no-gutters
        class="mt-5 d-flex justify-center"
        v-else-if="items.length == 0"
      >
        <v-col>No result.</v-col>
      </v-row>
    </v-container>
    <v-alert v-if="!init && items.length == 0 && !loading" type="success"
      >Not found models.</v-alert
    >

  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      hover: false,
      // videoAudioDialog: false,
      item: {},
      // video: false,
      // audio: false,

      showLoadMore: true,
      number: null,
      col: 2,
      window: 0,
      items: [],
      page: 1,
      scrollControl: 0,
      init: true,
      rating: false,
      perPage: 0,
    };
  },
  props: {
    setOnline: {
      type: Function,
    },
    setFeatured: {
      type: Function,
    },
    categorySlug: {
      default: 0,
    },
    skeletor: {
      default: false,
    },
    filters: {
      default: null,
    },
    cols: {
      type: Number,
      default: null,
      required: false,
    },
    rows: {
      type: Number,
      default: null,
      required: false,
    },
    rating_rows: {
      type: Number,
      default: null,
      required: false,
    },
    bottomOff: {
      default: false,
    },
    guest: {
      default: true,
    },
    perPageProp: {
      type: Number,
      default: null,
      required: false,
    },
  },
  watch: {
    // videoAudioDialog(val) {
    //   if (!val) {
    //     this.audio = this.video = this.videoAudioDialog = false;
    //     this.item = {};
    //   }
    // },
    mobile(val) {
      this.number = this.cols || (val ? 1 : 4);
    },
    window(val) {
      if (val + 1 > this.page) {
        
        this.$store.dispatch("psychic/page", ++this.page);

        this.$store.dispatch("psychic/perPage", this.perPage);

        this.$store.dispatch("psychic/getItems", this.getParams()).then(() => {
          this.items[this.items.length - 1] = this.models.data;

          if (this.models.meta.last_page-1 >= this.page) {
            this.items.push(this.getLoadingArray());
          }

          if (this.models.meta.last_page-1 == this.page)
            this.items.splice(this.items.length - 1, 1);
        });
      }
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      models: "psychic/items",
      loading: "psychic/loading",
      loadingFavorite: "favorite/loading",
      user: "util/user",
    }),
  },
  methods: {
    // openVideoAudioDialog(item, video) {
    //   if (item.profile.intro_video_path || item.profile.intro_audio_path) {
    //     if (video) this.video = true;
    //     else this.audio = true;
    //     this.item = item;
    //     this.videoAudioDialog = true;
    //   }
    // },
    // getCategories(item) {
    //   let html = "";
    //   let categories = item.categories;
    //   for (let i = 0; i < categories.length; i++) {
    //     html =
    //       html +
    //       `<a class="cursor-pointer" href="${categories[i].url}" style="text-decoration: none; color:#8EBEF8;"> ${categories[i].name} </a>`;
    //     break;
    //   }

    //   if (categories.length >= 1)
    //     html =
    //       html +
    //       `<a class="cursor-pointer" href="/${item.profile.profile_link}"
    //                         style="text-decoration: none; color: #8EBEF8"
    //                       ><span> • </span> +${categories.length - 1} more</a>`;
    //   //`<span> • </span> +${categories.length - 2} more`;

    //   return html;
    // },
    async loadMore() {
      this.items.push(...this.getLoadingArray());

      this.$store.dispatch("psychic/page", ++this.page);
      this.$store.dispatch("psychic/perPage", this.perPage);
      await this.$store
        .dispatch("psychic/getItems", this.getParams())
        .then(() => {
          this.items.splice(this.items.length - this.cols, this.items.length);

          this.items.push(...this.models.data);

          if (this.models.meta.last_page == this.page)
            this.showLoadMore = false;
        });
    },
    // onScroll() {
    //     window.onscroll = async () => {
    //         let footerHeight = document.getElementsByClassName("footer")[0].offsetHeight + 100;
    //
    //         let bottomOfWindow = parseInt(document.documentElement.scrollTop + window.innerHeight) >= document.documentElement.offsetHeight - footerHeight;
    //
    //         if (this.models.meta.last_page >= this.page && !this.loading && bottomOfWindow) {
    //
    //             this.items.push(...this.getLoadingArray());
    //
    //             this.$store.dispatch('psychic/page', ++this.page);
    //
    //             await this.$store.dispatch('psychic/getItems', this.getParams()).then(() => {
    //
    //                 this.items.splice(this.items.length - this.cols, this.items.length);
    //
    //                 this.items.push(...this.models.data);
    //             });
    //         }
    //     };
    // },
    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
    },
    saveFavorite(item) {
      if (this.guest) EventBus.$emit("open_login", { same_page_login: true });
      else if (!this.loadingFavorite)
        this.$store
          .dispatch("favorite/saveFavorite", {
            id: item.id,
            type: item.favorite ? "remove" : "save",
          })
          .then(() => (item.favorite = !item.favorite));
    },
    getLoadingArray() {
      let array = [];
      for (let i = 0; i < this.number; i++) array.push({ loading: true });
      return array;
    },
  },
  created() {
    let params = this.getParams();

    if (this.mobile) {
      this.number = 1;
      if (params.filters.rating) this.number = 3;
    } else this.number = this.cols || 4;

    this.items = this.rows ? this.getLoadingArray() : [this.getLoadingArray()];

    if (this.mobile) this.perPage = this.perPageProp ? this.perPageProp : 1;
    else if (this.rows) this.perPage = this.rows * this.cols;
    else this.perPage = this.number;
    this.$store.dispatch("psychic/perPage", this.perPage);

    if (!this.skeletor) {
      this.$store.dispatch("psychic/perPage", this.perPage);

      this.$store.dispatch("psychic/getItems", params).then(() => {
        if (this.models.meta.last_page == this.page)
          this.showLoadMore = false;

        const items = this.models.data;

        if (this.rows) {
          this.items = items.sort(() => Math.random() - 0.5);
        } else {
          this.$store.dispatch("psychic/perPage", this.number);

          this.items = [items.sort(() => Math.random() - 0.5)];

          if (this.models.meta.current_page < this.models.meta.last_page)
            this.items.push(this.getLoadingArray());
        }

        if (
          params.filters &&
          typeof params.filters.online != typeof undefined &&
          this.items.length &&
          !this.items[0].length &&
          this.setOnline
        )
          this.setOnline(false);
        else if (
          params.filters &&
          typeof params.filters.featured != typeof undefined &&
          this.items.length &&
          !this.items[0].length &&
          this.setFeatured
        )
          this.setFeatured(false);

        this.init = false;
      });
    }
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>
<style>
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.v-window__next,
.v-window__prev {
  background: transparent !important;
  border: 2px solid #9759FF;
  margin: 0 -4px !important;
}

.v-window__next,
.v-window__prev {
  margin: 0 -4px !important;
}

.big-avatar .v-skeleton-loader__avatar {
  width: 90px !important;
  height: 90px !important;
}

.review-me {
  letter-spacing: 0.2px;
  color: #8ebef8;
  opacity: 1;
  font-weight: 600;
  font-size: 10px;
}
.tagline--text {
  color: #656b72;
  font-weight: 600;
}
.btnChat .v-btn__content{
      font-size: 12px;
      font-weight: 600;
      text-decoration: none;
      
}

.btnChat.v-btn:not(.v-btn--round).v-size--default{
      height: 34px!important;
}


.faChevronRight {

    background: url("/images/icons/chevron-right.svg");
    background-position: center;
    background-repeat: no-repeat;
    height: 30px;
    width: 30px;
    position: absolute;
    right: -24px;
}

</style>
