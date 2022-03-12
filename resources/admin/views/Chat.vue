<template>
    <div>
        <v-card-title>
            Chats
            <div class="flex-grow-1"></div>
        </v-card-title>
        <div style="padding: 16px 16px 8px">
            <List v-if="!item"/>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import List from "../components/Chat/List";

    export default {
        data() {
            return {
                store: 'chat',
                item: null
            }
        },
        components: {
            List
        },
        methods: {
            cancel() {
                this.item = null
            }
        },
    }

</script>
