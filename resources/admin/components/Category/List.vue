<template>
    <div>
        <v-data-table
                v-if="categories.length"
                :headers="[
               {text: '',align: 'left', value: 'image'},
               {text: 'Name',align: 'left', value: 'name'},
               {text: 'Description',align: 'left', value: 'description'},
               {text: 'Models',align: 'left', value: 'users_count'},
               {value: 'actions'}
               ]"
                :items="categories"
                class="elevation-1"
                disable-pagination
                hide-default-footer
        >
            <template v-slot:item.image="props" class="mt-4">
                <img class="pa-2 cursor-pointer" v-if="props.item.image" @click="pickImage(props.item)"
                     height="90"
                     v-bind:src="getImage(props.item.image.path)"
                     alt="John"
                >
                <div v-else class="pa-2">
                    <v-avatar tile color="grey lighten-2 cursor-pointer" size="75" @click="pickImage(props.item)">
                        <v-icon size="50" dark>mdi-image-area</v-icon>
                    </v-avatar>
                </div>
            </template>
            <template v-slot:item.name="props">
                <v-edit-dialog
                        :return-value.sync="name"
                        @save="save(props.item)"
                        @open="name = props.item.name"
                > {{ props.item.name }}
                    <template v-slot:input>
                        <v-text-field
                                v-model="name"
                                label="Edit"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <!-- <template v-slot:item.description="props">
                <v-edit-dialog
                        :return-value.sync="description"
                        @save="saveDescription(props.item)"
                        @open="description = props.item.description"
                > {{ props.item.description }}
                    <template v-slot:input>
                        <v-text-field
                                v-model="description"
                                label="Edit"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template> -->
            <template v-slot:item.users_count="props">
                {{props.item.users_count}}
            </template>
            <!-- <template v-slot:item.color="props">
                <div class="pa-2">
                    <div class="cursor-pointer" @click="changeColor(props.item)"
                         v-bind:style="{backgroundColor: props.item.color, height: '100%', width: '100%', minHeight: '50px', minWidth: '70px'}"></div>
                </div>
            </template> -->
            <template v-slot:item.actions="props">
                <div style="min-width: 90px">
                    <v-icon class="float-right"
                            color="red"
                            @click="deleteItem(props.item)"
                    >
                        mdi-delete
                    </v-icon>
                </div>
            </template>
        </v-data-table>
        <v-dialog v-model="dialog" persistent max-width="340">
            <v-card>
                <v-list>
                    <v-list-item>
                        <v-list-item-content>
                            <v-color-picker
                                    v-model="color"
                                    hide-mode-switch
                                    mode="hexa"
                                    show-swatches
                                    class="mx-auto"
                            ></v-color-picker>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="dialog = false">cancel</v-btn>
                    <v-btn text @click="saveColor()">save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <ImageLoad @setImage="setImage" :open="triggerImage"/>
    </div>
</template>


<script>

    import {mapGetters} from 'vuex';
    import {getImage} from '../../util'
    import ImageLoad from '../ImageLoad';

    export default {
        data() {
            return {
                name: null,
                dialog: false,
                color: false,
                description: false,
                item: null,
                store: 'category',
                triggerImage: false

            }
        },
        components: {
            ImageLoad
        },
        props: {
            deleteItem: {
                type: Function,
                required: true
            },
        },
        methods: {
            async saveColor() {
                await this.$store.dispatch(this.store + '/update', {id: this.item.id, data: {color: this.color}}).then(() => {
                    this.item.color = this.color;
                    this.dialog = false;
                });
            },
            async saveDescription(item) {
                if(this.user.role_id != 3)return;
                await this.$store.dispatch(this.store + '/update', {id: item.id, data: {description: this.description}}).then(() => {
                    this.$store.dispatch(this.store + '/getItems');
                });
            },
            changeColor(item) {
                this.item = item;
                this.color = this.item.color ? this.item.color : "";
                this.dialog = true;
            },
            getImage: getImage,
            async save(item) {
                if(this.user.role_id != 3)return;
                await this.$store.dispatch(this.store + '/update', {id: item.id, data: {name: this.name}}).then(() => {
                    this.$store.dispatch(this.store + '/getItems');
                });
            },
            pickImage(item){
                this.item = item;
                this.triggerImage = !this.triggerImage;
            },
            async setImage(img) {

                if(this.user.role_id != 3)return;
                await this.$store.dispatch(this.store + '/update', {id: this.item.id, data: {image: img.path, name: img.name}}).then((response) => {
                    if(!this.item.image)
                        this.item.image = {};
                    this.item.image.path = response.data;
                    this.dialog = false;
                });
            },
        },
        computed: {
            ...mapGetters({
                loading: 'category/loading',
                categories: 'category/items',
                user: 'user/view'
            })
        },
        watch: {
            loading(val) {
                this.$store.dispatch('util/setLoading', val);
            },
        },
        created() {
            if (!this.categories.length)
                this.$store.dispatch(this.store + '/getItems');
        }
    }
</script>
<style>
    .v-data-table td.v-data-table__mobile-row:first-child {
        height: 90px;
    }
</style>