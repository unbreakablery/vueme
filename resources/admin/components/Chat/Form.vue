<template>
        <div>
            <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
            >
                <v-row>
                    <v-col cols="12" md="6">
                        <v-card
                                outlined
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <v-list-item-title class="headline mb-1">Personal data</v-list-item-title>
                                    <v-row class="pa-md-3">

                                        <v-col cols="12">
                                            <v-text-field
                                                    v-model="item.display_name"
                                                    :rules="nameRules"
                                                    label="Display name"
                                                    required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field
                                                    v-model="item.name"
                                                    :rules="nameRules"
                                                    label="Name"
                                                    required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field
                                                    v-model="item.last_name"
                                                    :rules="nameRules"
                                                    label="Last name"
                                                    required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field
                                                    v-model="item.email"
                                                    :rules="nameRules"
                                                    label="Email"
                                                    required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field
                                                    v-model="item.city"
                                                    label="City"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field
                                                    v-model="item.state"
                                                    label="State"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-textarea
                                                    v-model="item.description"
                                                    name="input-7-1"
                                                    label="Description"
                                                    outlined
                                                    rows="15"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-card
                                outlined
                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <v-list-item-title class="headline mb-1">Account data</v-list-item-title>
                                    <v-row class="pa-md-3">
                                        <v-col cols="12">
                                            <v-select
                                                    v-model="item.role_id"
                                                    :items="roles"
                                                    item-text="name"
                                                    item-value="id"
                                                    label="Rol"
                                            ></v-select>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-select
                                                    v-model="item.categories"
                                                    :items="categories"
                                                    item-text="name"
                                                    item-value="id"
                                                    chips
                                                    label="Categories"
                                                    multiple
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card>
                    </v-col>
                </v-row>
            </v-form>
            <v-btn @click="save" v-if="user.role_id == 3"
                    color="purple"
                    dark
                    large
                    fixed
                    bottom
                    right
            >
                Save
            </v-btn>
            <v-btn @click="cancel"  style="margin-right: 100px"
                    color="purple"
                    dark
                    large
                    fixed
                    bottom
                    right
            >
                <v-icon>mdi-arrow-left</v-icon> Back to list
            </v-btn>
        </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {requireField} from '../../util';

    export default {
        data: () => ({
            valid: true,
            nameRules: requireField,
            isAdmin: false
        }),
        props: {
            submit: {
                type: Function,
                required: true
            },

            cancel: {
                type: Function,
                required: true
            },

            item: {
                type: Object,
                required: true
            },
        },
        computed: {
            ...mapGetters({
                loading: 'user/loading',
                roles: 'user/roles',
                categories: 'category/items',
                user: 'user/view'
            }),
        },
        watch: {
            loading(val) {
                this.$store.dispatch('util/setLoading', val);
            }
        },
        methods: {
            save() {
                this.$refs.form.validate() && this.submit(this.item);
            }
        },
        created(){
            if (!this.roles.length)
                this.$store.dispatch(this.store + '/getRoles');
            if (!this.categories.length)
                this.$store.dispatch('category/getItems');
        }
    }
</script>

