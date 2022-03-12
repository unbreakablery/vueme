<template>
  <div class="fan-payment">
    <form action="" class="form-dashboard">
      <v-container id="form-panel" class="white m-0" style="padding: 30px 24px !important">
        <table>
          <thead>
           <tr class="table-header">
             <th id="make"></th>
             <th id="card"><h3>Cards</h3></th>
             <th id="expire"><h3>Expire</h3></th>
             <th id="action"><h3>Action</h3></th>
           </tr>
          </thead>
          <tbody>
            <!--
            <tr class="table-border">
              <td><h4 style="color: #131220" id="primary">PRIMARY</h4></td>
              <td><p>1409</p></td>
              <td><p>11/24</p></td>
              <td><v-btn class="Delete" color="#E31616" @click="Delete(i)"><span class="text">Delete</span></v-btn></td>
            </tr>
            -->

            <tr v-if="(cards.length == 0)" class="table-border" style="border-top: 1px solid #1F1E3410; border-bottom: 1px solid #1F1E3410;">
              <td><h4 style="color:#949498; font-size:14px; font-weight:400"  id="primary">Currently empty</h4></td>
            </tr>

            <tr class="table-border"  v-for="method in cards" :key="method[3]">
              <td><h4 class="make-primary">MAKE PRIMARY</h4></td>
              <td><p>{{ method[0] | cardnumber }}</p></td>
              <td><p>{{ method[1] | expire }}</p></td>
              <td><v-btn class="Delete" color="#E31616" :loading="data.card === method[3]" @click="f_delete_card(method)"><span class="text">Delete</span></v-btn></td>
            </tr>
          </tbody>
        </table>
        <div class="new-card-btn">
          <button class="New-Card"  v-if="show" v-on:click="f_show_add_card" ><span class="text">New Card</span></button>
        </div>
        <div action="" class="Person_info" v-if="!show">
          <v-row>
            <v-col :sm="6" cols="12" class="Info-input">
              <label for=""><h4 style="font-size: 12px; margin-bottom: 0">First Name&nbsp; <span style="color: #E31616"> *</span></h4></label>
              <input v-model="data.card_selected.first_name" @change="this.f_check_field" id="first_name" class="font" type="text"/>
            </v-col>
            <v-col :sm="6" cols="12" class="Info-input">
              <label for=""><h4 style="font-size: 12px; margin-bottom: 0">Last Name&nbsp; <span style="color: #E31616"> *</span></h4></label>
              <input v-model="data.card_selected.last_name" @change="this.f_check_field" id="last_name" class="font" type="text"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col :sm="6" cols="12" class="Info-input">
              <label for=""><h4 style="font-size: 12px; margin-bottom: 0">Card Number&nbsp;<span style="color: #E31616"> *</span></h4></label>
              <input v-model="data.card_selected.cc_number" @change="this.f_check_field" id="cc_number" class="font" type="text" v-mask="'####-####-####-####'" placeholder="xxxx-xxxx-xxxx-xxxx"/>
            </v-col>
            <v-col :sm="6" cols="12" class="Info-input" id="date-placeholder">
              <label for=""><h4 style="font-size: 12px; margin-bottom: 0">Expiration Date&nbsp; <span style="color: #E31616"> *</span></h4></label>
              <input type="text" v-model="data.card_selected.cc_exp" class="font" :maxlength="5" style="width: 100%" @change="this.f_check_field" id="cc_exp" v-mask="'##/##'" placeholder="MM/YY"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col :sm="6" cols="12" class="Info-input">
              <label for=""><h4 style="font-size: 12px; margin-bottom: 0">Security Code &nbsp;<span style="color: #E31616"> *</span></h4></label>
              <input v-model="data.card_selected.cc_cvv" @change="this.f_check_field" id="cc_cvv" class="font" type="text" :maxlength="4"/>
            </v-col>
            <v-col :sm="6" cols="12" class="Info-input">
              <label for=""><h4 style="font-size: 12px; margin-bottom: 0">Zip Postal/Code &nbsp;<span style="color: #E31616"> *</span></h4></label>
              <input v-model="data.card_selected.cc_zip" @change="this.f_check_field" id="cc_zip" class="font" type="text"/>
            </v-col>
          </v-row>
          <div class="new-card-btn">
            <v-btn  class="Save" @click="f_add_card"
              :disabled="data.loading"
              :loading="data.loading"><span class="text">Save Information</span></v-btn>
          </div>
        </div>
      </v-container>
    </form>
  </div>
</template>
<script>
// function getData() {
//   return {
//     loading: false,
//     add_card: false,
//     card_error_selected: {
//       last_four: null,
//       type: null,
//       first_name: null,
//       last_name:null,
//       cc_number: null,
//       cc_exp: null,
//       cc_cvv: null,
//       cc_zip: null
//     },
//     card_selected: {
//       last_four: null,
//       type: null,
//       first_name: null,
//       last_name:null,
//       cc_number: null,
//       cc_exp: null,
//       cc_cvv: null,
//       cc_zip: null
//     },
//     card: ""
//   };
// }
import { mask } from "vue-the-mask";
export default {
  directives: { mask },
  name: "payment",
  props: ["cards"],
  data: function() {
    return {
      data: {
          loading: false,
          add_card: false,
          card_error_selected: {
            last_four: null,
            type: null,
            first_name: null,
            last_name:null,
            cc_number: null,
            cc_exp: null,
            cc_cvv: null,
            cc_zip: null
          },
          card_selected: {
            last_four: null,
            type: null,
            first_name: null,
            last_name:null,
            cc_number: null,
            cc_exp: null,
            cc_cvv: null,
            cc_zip: null
          },
          card: ""
        },
        massage: '',
      show: true
    }
  },
  filters: {
    expire: function(value) {
      return value.toString().slice(0, 2) + "/" + value.toString().slice(2, 4);
    },
    cardnumber: function(value) {
      return value.toString().slice(12, 16);
    }
  },
  methods: {
    f_show_add_card() {
      //this.add_card = !this.add_card;
      this.show=false;
    },
    f_check_field(e) {
      switch (e.currentTarget.id) {
        case "first_name":
          this.data.card_error_selected.first_name = !this.data.card_selected.first_name;
          break;
        case "last_name":
          this.data.card_error_selected.last_name = !this.data.card_selected.last_name;
          break;  
        case "cc_number":
          this.data.card_error_selected.cc_number = !this.data.card_selected.cc_number;
          break;
        case "cc_exp":
          this.data.card_error_selected.cc_exp = !this.data.card_selected.cc_exp;
          break;
        case "cc_cvv":
          this.data.card_error_selected.cc_cvv = !this.data.card_selected.cc_cvv;
          break;
        case "cc_zip":
          this.data.card_error_selected.cc_zip = !this.data.card_selected.cc_zip;
          break;
        default:
      }
    },
    f_reset_data() {
      Object.assign(this.$data, this.$options.data.call(this));
    },
    f_validate_form_card() {
      this.data.card_error_selected.cc_number = !this.data.card_selected.cc_number;
      this.data.card_error_selected.cc_exp = !this.data.card_selected.cc_exp;
      this.data.card_error_selected.cc_zip = !this.data.card_selected.cc_zip;
      this.data.card_error_selected.cc_cvv = !this.data.card_selected.cc_cvv;
      this.data.card_error_selected.first_name = !this.data.card_selected.first_name;
       this.data.card_error_selected.last_name = !this.data.card_selected.last_name;
      if (
        !this.data.card_error_selected.cc_number &&
        !this.data.card_error_selected.cc_exp &&
        !this.data.card_error_selected.cc_zip &&
        !this.data.card_error_selected.cc_cvv &&
        !this.data.card_error_selected.first_name &&
        !this.data.card_error_selected.last_name
      ) {
        return true;
      }
      return false;
    },
    f_add_card() {
      
      if (this.f_validate_form_card()) {
        this.data.loading = true;
        axios
          .post("/api/v1/user/account/card", {
            cc_number: this.data.card_selected.cc_number.replace(/-/g, ""),
            cc_exp: this.data.card_selected.cc_exp,
            cc_zip: this.data.card_selected.cc_zip,
            cc_cvv:this.data.card_selected.cc_cvv,
            first_name: this.data.card_selected.first_name,
            last_name: this.data.card_selected.last_name,
            _token: "{{ csrf_token() }}"
          })
          .then(response => {       
            this.message = response.data;
            this.$root.$emit("open_dialog_message", {
              message: this.message.success,
              message_title: "SUCCESS"
            });
            this.f_reset_data();
            this.f_get_cards();
            this.show = true;
          })
          .catch(error => {           
            let message = "";
            this.data.loading = false;
             if(error.response.status === 422){                              
                this.data.card_error_selected = error.response.data.errors;
              
            }else{  
                // this.show_message_decline_transaction(error)
               }
           
          });
      }
    },
    show_message_decline_transaction(error){
                let message = error.response.status === 400 ? error.response.data.error : "";
                message = message == "" ? 'Your payment method could not be added.' : message;
                this.$root.$emit("open_dialog_message", {message: message,message_title: "ERROR"});
    },
    f_array_remove(card) {
      this.cards.splice(this.cards.findIndex(v => v[3] === card[3]), 1);
      if (this.cards.length === 0) {
        this.cards = [];
      }
    },
    f_get_cards() {
      axios
        .get("/api/v1/user/account/cards", {})
        .then(response => {
          this.cards = response.data;
        })
        .catch(error => {
          this.message = error;
        });
    },
    f_delete_card(card) {
      this.data.card = card[3];
      axios
        .delete("/api/v1/user/account/card", {
          params: {
            biller: card[3]
          }
        })
        .then(response => {
          this.f_array_remove(card);
          this.data.card = "";
          this.$root.$emit("open_dialog_message", {
            message: response.data.success,
            message_title: "SUCCESS"
          });
        })
        .catch(error => {
          this.data.card = "";
          if (error.response.status === 400) {
            this.show_message_decline_transaction(error)
          } else {
            this.message =
              "Your payment method could not be removed. ";
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR"
          });
        });
    }
  }
};
// export default {
//   data() {
//     return {
//       show:true,
//       errors: {
//         user_services: [],
//       },
//       message: "",
//       users: [
//       {
//         first_name:"Crystal",
//         last_name:"Hudson",
//         card_num:"1453",
//         expire:"05/07",
//         security_code:"",
//         zip_code:"",
//         // href: "/dashboard/",
//         target: "_self",
//       }
//     ],
//     user:{
//       first_name:"",
//       last_name:"",
//       card_num:"",
//       expire:"",
//       security_code:"",
//       zip_code:"",
//     },
//   };

//   },

//   methods: {
//     display:function() {
//       this.show=false
//       },
//     Delete:function(i){
//       this.users.splice(i,1);
//     },
//      Add:function(){
//        if (this.user.first_name!=""&&this.user.last_name!=""&&this.user.card_num!=""&&this.user.security_code!=""&&this.user.date!=""&&this.user.zip_code!="")
//        {
//         this.users.push(this.user);
//         }
//        else{
//          alert("Input your Information");
//        }
//        this.show=true
//      }
//   },
//   computed: {

//   },
//   mounted() {

//   },
// };
</script>
