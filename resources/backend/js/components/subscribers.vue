<template>
  <div class="model-subscribers">
    <h1 class="title mb-5">Subscribers</h1>
    <v-tabs
      slider-size="0"
      align-with-title
      centered
      grow
      v-model="active_tab"
    >
      <v-tabs-slider></v-tabs-slider>

      <v-tab
        tabindex="0"
        :class="mobile ? 'pr-0 pl-0' : ''"
        style="margin-left: 0px"
        >Monthly</v-tab
      >
      <v-tab-item>
        <div class="subscriptions-data">
          <div class="subscriptions-option" style="z-index:2;">
            <v-row>
              <v-col cols="4">
            <div class="subscribers-search">
              <img src="/images/model-dashboard/search.svg" class="img-search" height="16" width="16" alt="">
              <input type="text" class="search-input" v-model="search">
              <button @click="searchClear" class="close-btn" v-if="search">
                <img src="/images/model-dashboard/close.svg" class="img-close" height="16" width="16" alt="">
              </button>
            </div>
            </v-col>
            <v-col cols="4">
            </v-col>
             <v-col cols="4">
            <div style="text-align:right;">
            <v-select
              style="text-align:right;padding-left:30px;"
              class="filter-select widthSelect float-right"
              label="Filter by"
              dense
              solo
              small
              :height="30"
              :items="filters"
              v-model="filterSelected"
              item-text="tag"
              item-value="id"
              background-color="#FFFFFF"
              :menu-props="{contentClass: 'checkListGray', offsetY:true}"
            >
            <template slot="item" slot-scope="data">
              <v-icon style="width:25px;height:25px;position:relative;right:0;margin-top:2px;margin-right:5px" color="gray">{{data.item.id == filterSelected ? 'mdi-radiobox-marked' : 'mdi-radiobox-blank'}}</v-icon>      
              <b style="padding-left:10px;">{{data.item.tag}}</b><font style="font-size:24px;padding-left:5px;padding-bottom:3px;">{{data.item.id==3 ? '↑' : data.item.id==4 ? '↓' : ''}}</font>
            </template>
            <template slot="selection" slot-scope="data">
              <b style="padding-left:10px;">{{data.item.tag}}</b><font style="font-size:24px;padding-left:5px;padding-bottom:3px;">{{data.item.id==3 ? '↑' : data.item.id==4 ? '↓' : ''}}</font>
            </template>
            </v-select>
            </div>
            </v-col>
            </v-row>
          </div>
          <div>
          <v-data-table
          v-if="subscribers.length"
          :items="obj_subscribers"
          :items-per-page="5">
            <template v-slot:item="{item}">
            <tr style="border:0 !important;">
            <td class="px-2">
            <div class="subscriber">
            <div class="subscriber-detail">
              <h2 class="subscriber-name">{{item.name}}</h2>
              <h4 class="subscriber-date">Subscribed on {{item.created_at}}</h4>
            </div>
            <div class="subscriber-setting">
              <v-btn style="z-index:1;color:#E31616;border: 2px solid #E31616 !important;height:30px !important;min-width: 100px !important;border-radius:9px !important" class="py-0 btn-second"
              @click="blockUser(item)"
              :loading="item.user_id == blocking_id"
              :disabled="item.user_id == blocking_id"
              >
              <span style="font-size: 12px;">Block</span>
            </v-btn>
            </div>
          </div>
          </td>
          </tr>
              </template>
          </v-data-table>
          <div class="w-100 view-profile" v-else>
          <br>
          <br>
          <h4 class="text-center mb-3 recent-streams mt-10">No Subscribers Yet!</h4>        
          </div>
          </div>          
         </div>
      </v-tab-item>
      <v-tab tabindex="1" :class="mobile ? 'pr-0 pl-0' : ''">Blocked</v-tab>
      <v-tab-item>
        <div class="subscriptions-data">
          <div class="subscriptions-option" style="z-index:2;">
            <v-row>
              <v-col cols="4">
            <div class="subscribers-search">
              <img src="/images/model-dashboard/search.svg" class="img-search" height="16" width="16" alt="">
              <input type="text" class="search-input" v-model="searchB">
              <button @click="searchClearB" class="close-btn" v-if="searchB">
                <img src="/images/model-dashboard/close.svg" class="img-close" height="16" width="16" alt="">
              </button>
            </div>
            </v-col>
            <v-col cols="4">
            </v-col>
             <v-col cols="4">
            <div style="text-align:right;">
            <v-select
              style="text-align:right;padding-left:30px;"
              class="filter-select widthSelect float-right"
              label="Filter by"
              dense
              solo
              small
              :height="30"
              :items="filters"
              v-model="filterSelectedB"
              item-text="tag"
              item-value="id"
              background-color="#FFFFFF"
              :menu-props="{contentClass: 'checkListGray', offsetY:true}"
            >
            <template slot="item" slot-scope="data">
              <v-icon style="width:25px;height:25px;position:relative;right:0;margin-top:2px;margin-right:5px" color="gray">{{data.item.id == filterSelected ? 'mdi-radiobox-marked' : 'mdi-radiobox-blank'}}</v-icon>      
              <b style="padding-left:10px;">{{data.item.tag}}</b><font style="font-size:24px;padding-left:5px;padding-bottom:3px;">{{data.item.id==3 ? '↑' : data.item.id==4 ? '↓' : ''}}</font>
            </template>
            <template slot="selection" slot-scope="data">
              <b style="padding-left:10px;">{{data.item.tag}}</b><font style="font-size:24px;padding-left:5px;padding-bottom:3px;">{{data.item.id==3 ? '↑' : data.item.id==4 ? '↓' : ''}}</font>
            </template>
            </v-select>
            </div>
            </v-col>
            </v-row>
          </div>
          <div>
          <v-data-table
          v-if="subscribers.length"
          :items="obj_subscribersB"
          :items-per-page="5">
            <template v-slot:item="{item}">
            <tr style="border:0 !important;">
            <td class="px-2">
            <div class="subscriber">
            <div class="subscriber-detail">
              <h2 class="subscriber-name">{{item.name}}</h2>
              <h4 class="subscriber-date">Subscribed on {{item.created_at}}</h4>
            </div>
            <!--<div class="subscriber-setting">
              <v-btn style="z-index:1;color:#E31616;border: 2px solid #E31616 !important;height:30px !important;min-width: 100px !important;border-radius:9px !important" class="py-0 btn-second"
              type="button"
              @click="blockUser(item)"
              :loading="item.blocking"
              :disabled="item.blocking"
              >
              <span style="font-size: 12px;">Block</span>
            </v-btn>
            </div>-->
          </div>
          </td>
          </tr>
              </template>
          </v-data-table>
          <div class="w-100 view-profile" v-else>
          <br>
          <br>
          <h4 class="text-center mb-3 recent-streams mt-10">No Blocked Subscribers!</h4>        
          </div>
          </div>          
         </div>
      </v-tab-item>
    </v-tabs>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
export default {
  data() {
    return {
      active_tab: 0,
      counterReferral: 0,
      search: '',
      searchB: '',
      subscribers: [],
      filters:[{id:"1",tag:"A - Z"}, {id:"2",tag:"Z - A"}, {id:"3",tag:"Sign Up"}, {id:"4",tag:"Sign Up"}],
      filterSelected:'1',
      filterSelectedB:'1',
      blocking_id:0,
    };
  },
  props: ["user"],
  mounted() {

          var i=0;
          for (i = 0; i < this.user.userReferral.length; i++) {
            

            if(this.user.userReferral[i].user_referral)
            this.counterReferral++;
      
          }


  },
  computed: {
    obj_subscribers() {
      var subs = this.subscribers.filter((subscriber) => {
        let str =
          subscriber.name +
          " " +
          subscriber.created_at;         
        if (subscriber.status !== 'BLOCKED' && (!this.search || str.toLowerCase().indexOf(this.search.toLowerCase()) !== -1)) {
              return true;
        }
      });
      return subs.sort((a,b) => {
      switch (this.filterSelected) {
        case "1":
         {
           return (a.name.toUpperCase() < b.name.toUpperCase()) ? -1 : (a.name.toUpperCase() > b.name.toUpperCase()) ? 1 : 0;
         }
        case "2":
          {
           return (a.name.toUpperCase() > b.name.toUpperCase()) ? -1 : (a.name.toUpperCase() < b.name.toUpperCase()) ? 1 : 0;
          }
        case "3":
          {
            var da=moment(a.created_at, 'n/j/Y');
            var db=moment(b.created_at, 'n/j/Y');
            return (da.isBefore(db)) ? -1 : (da.isAfter(db)) ? 1 : 0;
          }          
        case "4":
          {
            var da=moment(a.created_at, 'n/j/Y');
            var db=moment(b.created_at, 'n/j/Y');
            return (da.isBefore(db)) ? -1 : (da.isAfter(db)) ? 0 : 1;
          }
      }
     });
    },
    obj_subscribersB() {
      var subs = this.subscribers.filter((subscriber) => {
        let str =
          subscriber.name +
          " " +
          subscriber.created_at;         
        if (subscriber.status == 'BLOCKED' && (!this.searchB || str.toLowerCase().indexOf(this.searchB.toLowerCase()) !== -1)) {
              return true;
        }
      });
      return subs.sort((a,b) => {
      switch (this.filterSelectedB) {
        case "1":
         {
           return (a.name.toUpperCase() < b.name.toUpperCase()) ? -1 : (a.name.toUpperCase() > b.name.toUpperCase()) ? 1 : 0;
         }
        case "2":
          {
           return (a.name.toUpperCase() > b.name.toUpperCase()) ? -1 : (a.name.toUpperCase() < b.name.toUpperCase()) ? 1 : 0;
          }
        case "3":
          {
            var da=moment(a.created_at, 'n/j/Y');
            var db=moment(b.created_at, 'n/j/Y');
            return (da.isBefore(db)) ? -1 : (da.isAfter(db)) ? 1 : 0;
          }          
        case "4":
          {
            var da=moment(a.created_at, 'n/j/Y');
            var db=moment(b.created_at, 'n/j/Y');
            return (da.isBefore(db)) ? -1 : (da.isAfter(db)) ? 0 : 1;
          }
      }
     });
    },
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  mounted() {
    this.getSubscribers();
  },
  methods: {
   getSubscribers() {
      axios
        .get("/api/v1/psychic/subscribers")
        .then((response) => {
           if(response.data.data)
           this.subscribers = response.data.data;
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
          }
        });
    },
      blockUser(item) {
      this.blocking_id = item.user_id;
      var item_index;
      for(var i=0;i<this.subscribers.length;i++){
       if(this.subscribers[i].user_id == item.user_id){
        item_index=i;
       }
      }
      axios
        .post("/api/v1/psychic/block-user", {user_id: item.user_id})
        .then((response) => {
          this.subscribers[item_index].status="BLOCKED";
          this.blocking_id=0;
           if(response)
           console.log(response);
        })
        .catch((error) => {
          this.blocking_id=0;
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
          }
        });
    },
    windowScrollTo() {
      window.scrollTo(0, 0);
    },
    searchClear() {
      this.search = '';
    },
    searchClearB() {
      this.searchB = '';
    }
  },
};
</script>

<style lang="scss">
.model-subscribers {
  max-width: 856px;
  padding: 44px 38px;
  .title {
    font-size: 24px!important;
    font-weight: 500;
    color: #42424D;
    font-family: "Montserrat", sans-serif !important;
  }
  .v-tab {
    letter-spacing: 0px;
    display: block;
    padding: 0 0 4px;
    flex: initial!important;
    min-width: auto;
    margin-right: 22px;
    font-size: 16px;
    font-family: "Montserrat", sans-serif !important;
    font-weight: 600;
    text-transform: capitalize;
    color: #42424D!important;
  }
  .v-tab--active, .v-tab--active:hover {
    color: #F77F98!important;
    border-bottom: 2px solid #F77F98;
    opacity: 1;
  }
  .theme--light.v-tabs-items {
    box-shadow: 0px 10px 13px #00000029;
  }
  .theme--light.v-tabs .v-tab--active:hover::before, .theme--light.v-tabs .v-tab::before {
    opacity: 0;
  }
  .v-tabs-bar {
    height: auto;
  }
  .v-item-group {
    margin-bottom: 20px;
  }
  .subscriptions-data {
    padding: 24px;
    min-height: 361px;
  }
  .subscribers-search {
    border: 1px solid #CBCBCD;
    border-radius: 24px;
    min-width: 231px;
    width: 231px;
    height: 32px;
    display: flex;
    align-items: center;
    padding: 0 10px;
    .search-input {
      border: none;
      outline: none;
      padding-left: 5px!important;
      padding-right: 5px!important;
      font-family: "Montserrat", sans-serif !important;
      font-weight: 500;
      color: #131220;
    }
    .close-btn {
      outline: none;
    }
  }
  .subscriptions-option {
    display: flex;
    margin-bottom: 24px;
  }
  .v-select {
    height: 30px;
    margin-left: 22px;
    .v-input__control {
      .v-select__slot {
        border: none;
        .v-label {
          font-family: "Montserrat", sans-serif !important;
          color: #1F1E34!important;
          font-size: 14px!important;
          font-weight: 500;
          opacity: 1;
        }
        .v-select__selections {
          input {
            border: none;
          }
        }
      }
    }
  }
  .subscriber {
    padding: 22px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    .subscriber-name {
      font-size: 18px;
      color: #131220;
      font-weight: 600;
      margin-bottom: 4px;
      line-height: 22px;
    }
    .subscriber-date {
      margin-bottom: 0;
      line-height: 15px;
      font-size: 12px;
      color: #131220;
      font-weight: 600;
    }
    .subscriber-setting {
      button {
        outline: none;
      }
    }
  }
  @media (max-width: 576px) {
    padding: 20px 0;
    .title {
      font-size: 20px!important;
      margin-left: 20px;
    }
    .v-tabs-bar {
      margin-left: 22px;
    }
    .subscriptions-data {
      padding-left: 20px;
      padding-right: 20px;
      .subscriber {
        padding-left: 24px;
        .subscriber-name {
          font-size: 16px;
        }
      }
    }
    .v-select {
      margin-left: 10px;
    }
  }
}
</style>

<style>
.sfVtabProfile
  .v-tabs:not(.v-tabs--vertical):not(.v-tabs--right)
  > .v-slide-group--is-overflowing.v-tabs-bar--is-mobile:not(.v-slide-group--has-affixes)
  .v-slide-group__prev {
  display: none;
  visibility: hidden;
}

.sfVtabProfile .v-tab {
  min-width: 84px !important;
}

.sfNextabProfile
  .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: transparent !important;
  font-weight: 600;
  letter-spacing: 0.28px;
  color: #a2a2a2;
  opacity: 1;
  font-size: 14px;
}

.sfColsAd {
  margin: 0px 20px !important;
  max-width: 95px !important;
}

.donut-chart {
  position: relative;
  width: 190px;
  height: 190px;
  border-radius: 100%;
}
p.center-date {
  background: #ffffff;
  box-shadow: 0px 3px 6px #0000000d;
  position: absolute;
  text-align: center;
  font-size: 14px;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 145px;
  height: 145px;
  margin: auto;
  border-radius: 50%;

  padding: 15% 0 0;
  font-weight: 500;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
}
.center-date span.scnd-font-color {
  line-height: 0;
}
.recorte {
  border-radius: 50%;
  clip: rect(0px, 0px, 0px);
  height: 100%;
  position: absolute;
  width: 100%;
}
.cake {
  border-radius: 50%;
  clip: rect(0px, 200px, 100px, 0px);
  height: 100%;
  position: absolute;
  width: 100%;
  font-family: monospace;
  font-size: 1.5rem;
}
#part1 {
  transform: rotate(0deg);
}

#part1 .cake {
  background-color: #ebf4fd;
  transform: rotate(76deg);
}
#porcion2 {
  transform: rotate(76deg);
}
#porcion2 .cake {
  background-color: #c1dbfb;
  transform: rotate(180deg);
}

#porcionFin {
  transform: rotate(180deg);
}
#porcionFin .cake {
  background-color: #43425d;
  transform: rotate(180deg);
}
.nota-final {
  clear: both;
  color: #4fc4f6;
  font-size: 1rem;
  padding: 2rem 0;
}
.nota-final strong {
  color: #e64c65;
}
.nota-final a {
  color: #fcb150;
  font-size: inherit;
}

.noROwM .row{
    margin-right: 0px !important;
    margin-left: 0px !important;
}
.noROwM .container{
  padding-left: 0px !important;
   padding-right: 0px !important;
}
</style>
<style scoped>
.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:last-child, .theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:last-child {
    border-bottom: 0 !important;
}
.filter-select{
  width:162px;
}
</style>