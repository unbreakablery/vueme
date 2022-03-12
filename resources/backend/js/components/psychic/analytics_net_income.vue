<template>
   <v-row>
        <v-container>
            <v-card min-height="320px">
                <v-row>
                    <v-col class="col-5 col-md-8 col-lg-9">
                        <div class="font-weight-bold text-dark" style="font-size:20px" >Analytics</div>
                    </v-col>
                </v-row>
                <v-card-text class="pa-0">
                    <v-container>                        
                        <v-row>
                            <v-col class="col-7 col-md-4  col-lg-3">
                                <v-row>
                                    <v-col>
                                        <v-select small style="font-size:12px"
                                                @change="f_get_data_oveview()"                                                     
                                                :items="search_months"                                                        
                                                v-model="selected_month" 
                                                 :loading="loading"
                                                solo
                                                dense
                                                 background-color="#F0F0F7"
                                                :menu-props="{contentClass: 'checkList-lineWhite'}"
                                                class="widthSelect float-left"
                                                :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important'}]"
                                        ></v-select>
                                    </v-col>                                            
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-container>
                            <!----- <v-row style="font-size: 24px;
    text-align: center;
    display: contents;">
<div class="text-primary" style="color: rgb(191, 186, 186) !important;    margin-top: 50px;" v-if="no_data" >No data for this period</div>

                            </v-row>  -->
                            <div :style="[mobile ? {'font-size':'20px', 'right': '20%'}:{}]" class="text-center text_no_data" v-if="no_data">No data for this period</div>
                            <div class="spinner-border text-primary" v-if="loading"></div>
                             <canvas :height="f_height_canvas()" id="overviews"></canvas>                             
                             <br>
                            <v-progress-linear color="#FF6888" ></v-progress-linear>
                            <br>
                            <div>
                                <v-row>
                                    <v-col class="col-2 totals_earnings" >
                                        <div class="d-inline float-right">From  <b>{{first_month}}</b></div>
                                    </v-col>
                                    <v-col class="col-2 totals_earnings" >
                                        <div class="d-inline float-right">To  <b>{{last_month}}</b></div>
                                    </v-col>
                                </v-row>
                                 <br><br>
                                <v-row>
                                    <v-col class="col-1 totals_earnings" style="text-align:right">
                                        <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="#EA0000"></v-icon>
                                    </v-col>
                                    <v-col class="col-8 totals_earnings">
                                        <div class="font-weight-bold text-dark d-inline" >Monthly Subscriptions</div>
                                        <div class="d-inline float-right">${{total_subscriptions | numFormat("0,0.00")}}</div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col class="col-1 totals_earnings" style="text-align:right">
                                        <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="#2700ff"></v-icon>
                                    </v-col>
                                    <v-col class="col-8 totals_earnings">
                                        <div class="font-weight-bold text-dark d-inline" >Tips</div>
                                        <div class="d-inline float-right">${{total_tips | numFormat("0,0.00")}}</div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col class="col-1 totals_earnings" style="text-align:right">
                                        <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="#1bf90f"></v-icon>
                                    </v-col>
                                    <v-col class="col-8 totals_earnings">
                                        <div class="font-weight-bold text-dark d-inline" >Chat</div>
                                        <div class="d-inline float-right">${{total_chats | numFormat("0,0.00")}}</div>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col class="col-1 totals_earnings" style="text-align:right">
                                        <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="#00F3FF"></v-icon>
                                    </v-col>
                                    <v-col class="col-8 totals_earnings">
                                        <div class="font-weight-bold text-dark d-inline" >Video Chat</div>
                                        <div class="d-inline float-right">${{total_video | numFormat("0,0.00")}}</div>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col class="col-1 totals_earnings" style="text-align:right">
                                        <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="#E300FF"></v-icon>
                                    </v-col>
                                    <v-col class="col-8 totals_earnings">
                                        <div class="font-weight-bold text-dark d-inline" >Calls</div>
                                        <div class="d-inline float-right">${{total_calls | numFormat("0,0.00")}}</div>
                                    </v-col>
                                </v-row>
                                <br><br>
                                <v-progress-linear color="#FF6888" ></v-progress-linear>
                                <br>
                                <v-row>
                                    <v-col class="col-1 totals_earnings" style="text-align:right">                                        
                                    </v-col>
                                    <v-col class="col-8 totals_earnings">                         
                                        <div class="font-weight-bold text-dark d-inline" ><b>TOTAL</b></div>
                                        <div class="d-inline float-right">${{total_full | numFormat("0,0.00")}}</div>
                                    </v-col>
                                </v-row>
                                <br>
                            </div>


                            </div>
                          </v-card-text>
                    </v-card>
                </v-container>
         </v-row>
</template>

<script>

import {mapGetters} from 'vuex';
import Chart from 'chart.js';
export default {
    data(){
        return {

            search_months: [    
                {text:'All Times', value: -1 },
                {text:'This month', value: 0 },            
                {text:'Last 3 months',value: 2},
                {text:'Last 6 month', value: 5},
                {  text:'Last year', value: 11}
            ],

            selected_month: -1, 
            chart: null,
            loading:false,
            no_data:false,
            height_canvas: '100px',
            total_calls:0,
            total_chats:0,
            total_video:0,
            total_tips:0,
            total_full:0,
            total_subscriptions:0,
            first_month:'',
            last_month:'',
        }
    },
    mounted(){
        this.f_get_data_oveview();
    },
    computed:{
        ...mapGetters({
            mobile: 'util/mobile',
        })
    },
    methods: {
        f_height_canvas(){
        console.log(this.mobile);
        return  this.mobile ? '180px' : '100px'
    },
    f_min_height(){
        return this.mobile ? '290px' : '380px';
    },
        f_get_data_oveview: function() {
            this.loading =true;
            axios.get('/api/v1/user/analytics/overview?months='+this.selected_month, {
            })
            .then(response => {
                this.no_data=false;
                  if (this.chart != null) {
                        this.chart.destroy();                                
                      }
                      this.loading =false;


                   /*if(response.data[0].views.reduce((a,b) => a + b, 0) === 0 &&
                      response.data[0].sessions.reduce((a,b) => a + b, 0) === 0){
                      this.no_data =true;
                   }else*/{
                    console.log(response);
                        let datachart = this.get_data_chart(response);
                        this.createChart("overviews",datachart);
                        this.total_subscriptions = response.data[0].total_subscriptions;
                        this.total_tips = response.data[0].total_tips;
                        //this.total_tips = response.data[0].total_tips;
                        this.total_chats = response.data[0].total_chats;
                        this.total_video = response.data[0].total_video;
                        this.total_calls = response.data[0].total_calls;
                        this.first_month = response.data[0].first_month;                       
                        this.last_month = response.data[0].last_month;
                        this.total_full=this.total_subscriptions+this.total_tips+this.total_chats+this.total_video+this.total_calls;


                   }
            })
            .catch(error => {
                alert(error);
                this.message_error = error;
            });
        },
        get_data_chart(response){
          let graphic_type = 'line';
          if(this.selected_month ===0){
            graphic_type = 'bar';
          }
            return {
                type: graphic_type,
                data: {
                    labels: response.data[0].months,
                    height: '330px',
                    datasets: [
                    {
                        label: 'Monthly Subscription',
                        data: response.data[0].subscriptions,
                        borderColor: '#EA0000',                       
                        borderWidth: 1
                    },
                    {
                        label: 'Tips',
                        data: response.data[0].tips,
                        borderColor: '#2700ff',                       
                        borderWidth: 1
                    },
                    {
                        label: 'Chats',
                        data: response.data[0].chats,
                        borderColor: '#1bf90f',
                        borderWidth: 1
                    },
                    {
                        label: 'Video Chat',
                        data: response.data[0].video,
                        borderColor: '#00F3FF',
                       
                        borderWidth: 1
                    },
                    { // another line graph
                        label: 'Calls',
                        data: response.data[0].calls,
                        borderColor: '#E300FF',                       
                        borderWidth: 1
                    }

                    ]
                },
                options: {
                    legend:{
                        display: false,
                        position:'bottom',
                        align:'start'
                    },
                    responsive: true,
                    lineTension: 1,
                    scales: {
                    yAxes: [{
                        ticks: {
                        beginAtZero: true,
                        padding: 25,
                        }
                    }]
                    }
                }

                };
                        
        },    
        createChart(chartId, chartData) {
            const ctx = document.getElementById(chartId);
            this.chart = new Chart(ctx, {
            type: chartData.type,
            data: chartData.data,
            options: chartData.options,
            });
        }
    }}
</script>

<style scoped>
.spinner-border{
   position: absolute;
    right: 45%;
    height: 60px;
    width: 60px;
    top: 160px;
    border-radius: 100%;
    color: #9759FF !important;
 }
 .text_no_data{
      position: absolute;
    right: 35%;
    top: 170px;
    color: rgb(191, 186, 186) !important;
    font-size:24px;
 }
</style>>

