<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-if="!loading">
                    <div class="card-header">Account</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">{{user.id}}</div>
                            <div class="col-12">{{user.display_name}}</div>
                            <div class="col-12">{{user.email}}</div>
                            <div class="col-12">{{user.country_code}}</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                user: {},
                loading: true,
                errors: []
            }
        },
        mounted() {
            this.loadUser();
        },
        ready() {
            this.loadUser();
        },

        methods: {

            loadUser(){
                axios.get('/api/v1/user/account')
                    .then(res => {
                      this.user =  res.data.success.account;
                      this.loading = false;
                    })
                    .catch(error => {
                    if (typeof error.response.data === 'object') {
                        this.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        this.errors = ['Something went wrong. Please try again.'];
                    }
                });
            }
        }
    }
</script>
