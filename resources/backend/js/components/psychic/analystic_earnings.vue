<template>
    <v-row>
                      

                <v-container>
                    <v-card min-height="320" >
                          <v-card-text class="pa-0" style="height: 50%">
                            <v-container>
                                <v-row>
                                        <v-col class="12">
                                        <div class="font-weight-bold text-dark d-inline" >Earnings Goal</div>
                                         <v-col cols="5" class="d-inline-block float-right px-0">
                                                <v-select small   
                                                         style="font-size:12px"                                                                                                          
                                                        :items="['Daily','Monthly']"                                                        
                                                        v-model="selected_goal" 
                                                        solo
                                                        dense
                                                        @change="f_change_goal_period"
                                                        background-color="#F0F0F7"
                                                        :menu-props="{contentClass: 'checkList-lineWhite'}"
                                                        class="widthSelect float-right"
                                                        :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important'}]"
                                                ></v-select>
                                            </v-col>    
                                    </v-col>
                                   
                                </v-row>
                                 <v-row>
                                        <v-col cols="12" style="max-height: 50px;font-size:12px">
                                        <div class="font-weight-bold text-dark d-inline mt-2" >Set your goal</div>                                        
                                        <v-col cols="3" class="d-inline-block float-right px-0">                                        
                                         <v-text-field 
                                                       style="font-size:12px"                                       
                                                        v-model="earnings_goal" 
                                                        solo
                                                        dense
                                                        @input="isTyping = true"                                                       
                                                        class="input_goal"
                                                        :rules="[minRules]"

                                                ></v-text-field>
                                         </v-col>
                                         
                                        </v-col>
                                    
                                </v-row>
                                  <v-row>
                                        <v-col class="col-12 totals_earnings">                                       
                                        <div class="font-weight-bold text-dark d-inline" >Current status</div>
                                        <div class="d-inline float-right current_amount">${{earnings | numFormat('0,0.00')}}</div>
                                    </v-col>
                                  </v-row>
                                <v-progress-linear :value="avg_current"></v-progress-linear>
                                <v-divider></v-divider>
                                <v-row>
                                        <v-col class="col-12 totals_earnings">
                                        <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="primary"></v-icon>
                                        <div class="font-weight-bold text-dark d-inline" >Total Number of Sessions</div>
                                          <div class="d-inline float-right">{{total_sessions}}</div>
                                    </v-col>
                                   
                                </v-row>

                                <v-row>
                                        <v-col class="col-12 totals_earnings">
                                         <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="primary"></v-icon>
                                        <div class="font-weight-bold text-dark d-inline" >Total Number of Minutes</div>
                                        <div class="d-inline float-right">{{total_minutes | numFormat('0,0.00')}}</div>
                                    </v-col>                                   
                                </v-row>

                                   <v-row>
                                        <v-col class="col-12 totals_earnings">
                                          <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="primary"></v-icon>
                                        <div class="font-weight-bold text-dark d-inline" >AverageNumber of Minutes per session </div>
                                        <div class="d-inline float-right">{{avg_minutes_x_session | numFormat('0,0.00')}}</div>
                                    </v-col>
                                   
                                </v-row>
                                    <v-row>
                                        <v-col class="col-12 totals_earnings">
                                         <v-icon class="fas fa-circle d-inline pr-2" style="font-size: 11px;" color="primary"></v-icon>
                                        <div class="font-weight-bold text-dark d-inline" >Average Earnings per session</div>
                                        <div class="d-inline float-right">${{avg_earnings_x_session | numFormat('0,0.00')}}</div>
                                    </v-col>
                                   
                                </v-row>
                              <v-divider></v-divider>
                              
                              <!-------  <v-row>
                                         <v-col class="col-12">
                                        <a class="view_full_report">View Full Report</a>
                                    </v-col>  
                                </v-row> ------>

                            </v-container>
                           
                          </v-card-text>
                   
                    </v-card>
                </v-container>
           
         </v-row>
</template>

<script>
    export default {

        data(){
            return{
               selected_goal:'Monthly',
               earnings_goal_month: '$'+this.user.earnings_goal_month,
               earnings_goal_daily: '$'+this.user.earnings_goal_daily,
               earnings_goal: '$'+this.user.earnings_goal_month,
               total_sessions:0,
               total_minutes:0,
               avg_minutes_x_session:0,
               avg_earnings_x_session:0,
               earning_this_month:0,
               earning_today:0,
               earnings:0,
               avg_current:0,
               isTyping:false,
              

            };
        },
        props:['user'],
        mounted(){
            
        },

        watch:{
           'earnings_goal': function(newVal,oldval){
              
                if( newVal === ''){
                    this.earnings_goal = '$0'
                }else{                    
                   
                     this.avg_current = this.earnings/this.f_get_earning_number(this.earnings_goal) * 100;
                }
                
               

           },
        'avg_current': _.debounce(function(){
                this.isTyping = false;
              
                  
           },2000),
                
                'isTyping': function(value) {
            if (!value) {
                this.f_update_goal();
            }}
        },
        
        mounted(){
            this.f_get_data_earnings();
        },
          methods: {
        
         minRules(event){
             
            var reg = new RegExp('^[0-9]+$');
            if ( !reg.test(this.f_get_earning_number(this.earnings_goal)))  {           
                    return 'Error';
          }else{
              return true;
          }
        },
        f_get_earning_number(earn){
            return parseInt(earn.toString().replace('$','')); 
        }, 
        f_change_goal_period(){
             if(this.selected_goal==='Monthly'){
                 this.earnings_goal = this.earnings_goal_month;
                 this.earnings = this.earning_this_month;
             }
             if(this.selected_goal==='Daily'){
                  this.earnings_goal = this.earnings_goal_daily;
                   this.earnings = this.earning_today;
             }
        },
        f_update_goal(){
                let earn =this.f_get_earning_number(this.earnings_goal)
               
                 if(earn && earn>0){
                       axios.put('/api/v1/user/psychic/account', {
                       goal: parseInt(earn),
                       period: this.selected_goal,
                  
                     })
                    .then(response => {
                       
                         if(response.data === 'OK'){
                            
                         }
                        
                    })
                    .catch(error => {
                        alert(error);
                        this.message_error = error;
                    });
                 }
                 
        },
        f_get_data_earnings: function() { 

    
                axios.get('/api/v1/user/analytics/earnings', {
                 
                })
                    .then(response => {
                       
                          this.total_sessions = response.data.total_sessions;
                          this.total_minutes = response.data.minutes;
                          this.avg_minutes_x_session = response.data.avg_minutes_x_session;
                          this.avg_earnings_x_session = response.data.avg_earnings_x_session;
                          this.earning_this_month = response.data.earning_this_month;
                           this.earnings = this.earning_this_month;
                          this.avg_current = this.earning_this_month/this.f_get_earning_number(this.earnings_goal_month) * 100; 
                          this.earning_today = response.data.earning_today;
                          

                    })
                    .catch(error => {
                        alert(error);
                        this.message_error = error;
                    });
        },
          }
        
    }
</script>

<style lang="scss" scoped>
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