<template>
    <div>
        <v-container>
            <label v-if="show" v-on:click="display" >
                <a href="#" class="nav-link"><i class="fa fa-search"></i> Search</a>
            </label>
            <v-text-field v-if="!show"
            id="search_in"
            ref="search_in"
            placeholder="search..."
            outlined
            color="#CBCBCD"
            rounded
            dense
            flat
            prepend-inner-icon="mdi-magnify"   
            v-model="search"
            clearable
            class="magnifyInput"
            v-on:blur="searchboxblur"
          ></v-text-field>
        </v-container>
    </div>
</template>

<script>   
   
    export default {
        data: () => ({
         show:true,
        }),

         methods:{
            display:function(){
                this.show=false;
                this.$refs['search_in'].focus()
            },
            searchboxblur:function () {
               this.show=true
             }  

         },
         mounted() {
           if(this.$vuetify.breakpoint.mdAndDown){
             this.display()
           }
         },
        
        
        }

</script>
<style>
  .magnifyInput .v-input__prepend-inner {
    margin-top: 5px !important;
  }
  #search_in{
    border: none;
  }
</style>
<style scoped>
 label {
    margin:0px !important;
 }
 #search_in {
    border:1px solid #CBCBCD !important;
 }
 .magnifyInput {
    width: 210px;
    margin-right: 24px;
    margin-top: 2px;
 }

 @media screen and (max-width: 600px) {
  .magnifyInput {
    margin-right: 0px;
  }
 }
</style>
