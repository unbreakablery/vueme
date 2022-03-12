<template>
   <div>
       <v-row>
            <v-col cols="12" class="">
                <p-analytics-overview></p-analytics-overview>
                <br>                
                <p-analytics-stream ></p-analytics-stream>
                <br>
                <p-analytics-fan-insight/>
            </v-col>
       </v-row>
   </div>
</template>

<script>
    function getData() {
        return {

        };
    }
    export default {
        name: "analytics",   
        props:['user'],
        data: getData       
    }
</script>
