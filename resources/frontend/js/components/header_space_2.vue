<template>
    <!-- <div :style="{height:space+ 'px'}" style="width:100%">&nbsp;</div> -->
    <div v-if="!mobile" style="height: 80px; width:100%">&nbsp;</div>
    
</template>

<script>

    import Vue from "vue";
    import { mapGetters } from "vuex";
    export default {
        props: ["guest"],
        name: 'header-space',        
        data: function() {
           return {
               login_counter: 0
           };
        },
        mounted() {
           
        },
         computed: {
            ...mapGetters({
            space: "util/space",
            mobile: "util/mobile",
            }),

            },
        methods: {
       
        },
    };
</script>

<style scoped>
  
</style>