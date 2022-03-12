<template>
    
    <v-row>
        <v-container>
            <v-card min-height="320" >
                  <v-card-text class="pa-0" style="height: 100%">
                    <v-container>
                        <v-row>
                            <v-col class="col-5 col-md-8 col-lg-9">
                                <div class="font-weight-bold text-dark" style="font-size:20px" >Stream Details</div>
                                <br><br>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="col-2 ">
                                <div class="earning">                                    
                                    <span class="earning-amount">${{ total_earning | numFormat("0,0.00") }}</span>
                                    <span class="earning-title">Earned</span>
                                </div>
                            </v-col>
                            <v-col class="col-2 earning" >
                                <span class="earning-amount">{{ fans_purchased  }}</span>
                                <span class="earning-title">Fans Purchased</span>
                            </v-col>
                            <v-col class="col-8 float-right" >
                                <div class="d-inline float-right ">
                                    <v-icon class="fas fa-thumbs-up pr-2" color="#131220" style="font-size: 15px; padding-bottom:9px" ></v-icon>
                                    <span class="font-weight-bold text-dark"  style="font-color:#131220;font-size: 12px;" >{{like}}</span>
                                </div>
                                
                            </v-col>
                        </v-row>
                        <br>
                        <v-progress-linear color="#E7E6E8" ></v-progress-linear>
                        <br>

                        <v-row>
                            <v-col cols=6 class="col-6 ">
                                
                                                    <v-select  style="font-size:12px"
                                                            @change="f_get_data_oveview()"
                                                            :items="search_months"
                                                            v-model="selected_month" 
                                                            
                                                            solo
                                                            dense
                                                             background-color="#F0F0F7"
                                                            :menu-props="{contentClass: 'checkList-lineWhite'}"
                                                            class="widthSelect float-left"
                                                            :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important'}]"
                                                    ></v-select>
                            </v-col>
                            <v-col cols=6 class="col-6 ">
                                <div class="d-inline float-right current_amount">
                                
                                                    <v-select small style="font-size:12px"
                                                        
                                                        label="Stream Date"
                                                        solo
                                                        dense
                                                        :items="date_stream"
                                                            
                                                             background-color="#F0F0F7"
                                                            :menu-props="{contentClass: 'checkList-lineWhite'}"
                                                            class="widthSelect float-left"
                                                            :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important'}]"
                                                    ></v-select>
                                </div>
                                
                            </v-col>
                        </v-row>
                        <br>
                        <v-row>
                            <v-col cols=12 class="col-12">
                                <v-icon class="fas fa-crown d-inline pr-2" color="#131220" style="font-size: 16px; padding-bottom:9px" ></v-icon>
                                <div class="font-weight-bold text-dark d-inline" style="font-color:#131220" >TOP FANS</div>
                                <div class="earning">
                                    <span class="earning-amount">{{ kof  }}</span>                                
                                </div>
                            </v-col>                            
                        </v-row>
                        <v-data-table
                            id="information"
                            class="col-4 credit-log-table"
                            hide-default-footer                            
                            :items="itemsTop"
                            :hide-default-header="mobile">
                            <template v-slot:item="{item}">
                              <tr :key="item.id" style="height:40px">
                                <td class="px-0">{{item.name}}</td>                                
                              </tr>
                            </template>
                          </v-data-table>

                        
                      <v-divider></v-divider>                     

                    </v-container>

                  </v-card-text>

            </v-card>
        </v-container>
           
    </v-row>
</template>

<script>
import {mapGetters} from 'vuex';
    export default {

        data(){
            return{

            search_months: [    
                {text:'January', value: 1 },
                {text:'February', value: 2 },
                {text:'March', value:  3},
                {text:'April', value:  4},
                {text:'May', value:  5},
                {text:'June', value:  6},
                {text:'July', value:  7},
                {text:'August', value:  8},
                {text:'September', value:  9},
                {text:'October', value:  10},
                {text:'November', value:  11},
                {text:'December', value:  12}
            ],
            date_stream:[],

            selected_month: 1,               
            fans_purchased:0,
            total_earning:0,
            itemsTop: [],
            kof:'',
            like:''
              

            };
        },
    computed:{
        ...mapGetters({
            mobile: 'util/mobile',
        })
    },
        props:['user'],
        
        
        mounted(){
            this.selected_month =this.f_get_month();
            this.f_get_data_oveview();
            
        },
        methods: {
        
            f_get_month:function() {
                let today = new Date();
                return today.getMonth()+1;
            },
            f_get_data_oveview: function() {
                
                axios.get('/api/v1/user/analytics/stream?t=v&months='+this.selected_month, {
                })
                .then(response => {
                       
                        console.log(response); 
                        this.itemsTop=response.data[0].itemsTop;
                        this.kof=response.data[0].itemsTop[0].name;
                        this.date_stream=response.data[0].date_stream;
                        this.fans_purchased=response.data[0].purchased;
                        this.total_earning=response.data[0].earned;
                        this.like=response.data[0].like;
                       
                })
                .catch(error => {
                    alert(error);
                    this.message_error = error;
                });
            }   
        
        
        }
}
        
    
</script>

<style lang="scss" scoped>


.earning {
    
    padding-left: 24px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    .earning-title {
      color: #1F1E34!important;
      font-size: 11px;
      opacity: 0.8!important;
    }
    .earning-amount {
      color: #1F1E34;
      font-size: 20px;
      font-weight: bold;
    }
  }
   .totals_earnings{
       font-size: 10px;
   }
   .view_full_report{
           text-decoration: underline !important;
    font-size: 10px;
    color: #1474e8 !important;
   }
   .current_amount{
       color: #4AD991;
    font-weight: 600;
    font-size: 12px;
   }
   .input_goal input[type='number'] {
    -moz-appearance:textfield !important;
}
.input_goal input::-webkit-outer-spin-button,
.input_goal input::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
}

</style>