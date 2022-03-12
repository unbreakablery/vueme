<template>
    <div class="container " >
        <div class="row justify-content-center m-lg-5 p-lg-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verify your phone number</div>

                    <div class="card-body">
                        <form  @submit.prevent="updatePhone">

                            <label v-html="notice"></label>
                            <div class="row mt-10">
                                <div class="col-sm-4 px-3 form-group">
                                    <label>Country Code<span class="text-danger">*</span></label>
                                    <v-select
                                              :items="country_all"
                                              label="Select"
                                              background-color="#F4F4F4"
                                              filled
                                              flat
                                              item-text="prefix"
                                              item-value="code2"
                                              hide-details
                                              dense
                                              solo
                                              auto
                                              autocomplete
                                              v-model="phone.code2"
                                    >
                                        <template slot="selection" slot-scope="data">
                                            <!-- // HTML that describe how select should render selected items -->
                                            {{ data.item.country }}({{data.item.prefix}})
                                        </template>
                                        <template slot="item" slot-scope="data">
                                            <!-- // HTML that describe how select should render items when the select is open -->
                                            {{ data.item.country }}({{data.item.prefix}})
                                        </template>
                                    </v-select>
                                    <span v-if="errors['code2']" class="float-left text-danger small">{{ errors['code2'][0] }}</span>

                                </div>

                                <div class="col-sm-6 form-group">

                                    <label>Mobile</label>
                                    <v-text-field
                                                  background-color="#F4F4F4"
                                                  label="(555) 555-5555"
                                                  solo
                                                  flat
                                                  dense
                                                  hide-details
                                                  filled
                                                  type="tel"
                                                  v-model="phone.number"
                                    ></v-text-field>
                                    <span v-if="errors['number']" class="float-left text-danger small">{{ errors['number'][0] }}</span>

                                </div>


                            </div>


                            <div class="form-group row mb-0 mt-10">
                                <div class="col-md-12 ">
                                    <v-btn
                                            type="submit"
                                            color="primary"
                                            rounded
                                            :loading="saving"
                                            :disabled="saving"
                                    >
                                        Submit
                                    </v-btn>


                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: ['notice', 'phone', 'user', 'country_all'],
        data: function () {
            return {
                loading: true,
                saving: false,
                errors: [],

            }
        },
        mounted() {

        },
        ready() {

        },

        methods: {
            updatePhone() {

                this.saving = true;

                var input = this.phone;

                axios.post('/api/v1/user/verify/update/phone', input)
                    .then(response => {
                        location.reload();

                    })
                    .catch(error => {
                        if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                            location.reload();
                        }

                        if (typeof error.response.data === 'object') {
                            this.errors = error.response.data.errors;

                        } else {
                            this.errors = ['Something went wrong. Please try again.'];
                        }

                        this.saving = false;
                        this.message = "";
                    });

            },
        }
    }
</script>