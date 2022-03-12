    <template>
    <v-dialog  v-model="show_message" width="335">
      <v-card style="background-color: #F0F0F8;">
        <div class="text-right">
                <v-icon class="text-right" @click="show_message=false">mdi-close</v-icon>
        </div>  
        <v-card-title v-if="dialog_data.title" class="text-center justify-center title_dmessage px-8 pb-0 pt-5">           
            {{dialog_data.title}}
        </v-card-title>
        <v-card-text v-if="dialog_data.subtitle" class="text-center subtitle pb-0 px-8 pt-1">         
          {{dialog_data.subtitle}}
        </v-card-text>
        <v-flex v-if="dialog_data.buttom_text" class="d-flex align-sm-center justify-sm-center align-center justify-center pt-5 pb-7">
          <a v-if="dialog_data.link" :href="dialog_data.link" @click="show_message = false">
               <v-btn class="rounded-pill" color="primary" dark>{{dialog_data.buttom_text}}</v-btn>
          </a>
          <v-btn v-else @click="show_message = false" class="rounded-pill" color="primary" dark>{{dialog_data.buttom_text}}</v-btn>
        </v-flex>

        <v-flex v-if="dialog_data.review" class="d-flex align-sm-center justify-sm-center align-center justify-center pt-5 pb-7">
         <div class="text-center mr-5">
              <v-btn fab width="78" height="78" @click="send_opinion('NEGATIVE')" :disabled="disabled" :loading="disabled" color="#EAEAEA" class="mb-5">
              <img src="/images/icons/thumbs-down-solid.png" />
              
         </v-btn>
          <div style="font-size: 12px;font-weight: 500;color: #707070;">Could be better</div>
         </div>
          <div class="text-center ml-5">
              <v-btn fab width="78" height="78" @click="send_opinion('POSITIVE')"  :disabled="disabled" :loading="disabled" color="#EAEAEA" class="mb-5">
               <img src="/images/icons/thumbs-up-solid.png" />
              
         </v-btn>
              <div style="font-size: 12px;font-weight: 500;color: #707070;">Great</div>    
          </div>
           
        </v-flex>
       
      </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: 'standard_dialog',      
        data () {
            return {
                show_message:false,
                dialog_data:{},
                disabled:false
            }
        },

        mounted() {
            this.$root.$on('open_standard_dialog', (data) =>
            {        
               this.dialog_data = data;
               this.show_message = true;
            });
            this.$root.$on('close_standard_dialog', () =>
            {
               this.show_message = false; 
            });
            


        },
       
        methods:{
            review_down(){
                this.show_message =false;
                this.dialog_data={
                 title: 'Sorry to hear that.',
                 subtitle: 'Give us more information so we can make improvements.',
                 link: 'https://respectfully.zendesk.com/hc/en-us/requests/new?ticket_form_id=360001204692',
                 buttom_text: 'Leave Feedback'
                }
                this.show_message = true;
            },
            review_up(){

            },
            send_opinion(opinion) {  
                this.disabled = true;             
                axios
                    .put("/api/v1/user/opinion",{
                        room: this.dialog_data.room,
                        opinion: opinion
                    })
                    .then(response => {
                    this.disabled = false;
                    this.show_message =false;
                      if(opinion == 'NEGATIVE'){
                          this.review_down();
                      } 
                      
                    })
                    .catch(function(error) {
                    this.show_message =false;
                    if (
                        error.response &&
                        (error.response.status === 401 || error.response.status === 419)
                    ) {
                        location.reload();
                    }
                    });
                },
            
        }
    }
</script>

<style scoped>
.title_dmessage{
    font-size: 16px !important;
    font-weight: 600 !important;
    color: #1F1E34 !important;

}
.subtitle{
    font-size: 14px !important;
    font-weight: 500 !important;
    color: #656B72 !important;;
}
.v-dialog .mdi-close::before{
    margin-top: 0px !important;
    padding: 20px 20px !important;
}


</style>