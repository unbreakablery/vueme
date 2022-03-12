<template>
     <div class="vue-dashboard-media" style="padding: 0px;">
        <div class="row main-split">
            <div class="col" id="list-of-media">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a href="/dashboard/media/gallery" class="nav-item nav-link">Media</a>

                        <a href="/dashboard/post" class="nav-item nav-link active">Posts</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent" style="">
                    <div class="tab-pane fade show active" id="nav-posts" role="tabpanel" aria-labelledby="nav-posts-tab" >

                        <list-of-posts ref="listofposts" enable-search="true" :status=" status "></list-of-posts>
                    
                    </div>
                </div>
            </div>

            <div class="col selected-file-details" style="">

               <div>
                   <div style="height: 60px;"></div>

                   <div v-if="list_of_posts && list_of_posts.selected_posts">
                       <div style="font-size: 12px; font-weight: 500; margin-top: 15px; margin-bottom: 15px;">{{ list_of_posts.selected_posts.length }} Item selected</div>

                        <div v-if="list_of_posts.selected_posts.length > 0">
                            <a v-bind:href="'/dashboard/post/' + list_of_posts.selected_posts[0].id" v-if="list_of_posts.selected_posts.length == 1">
                                <button type="button" class="btn btn-block btn-pink">
                                    Edit
                                </button>
                            </a>

                            <ul class="nav flex-column nav-sidebar-selected">
                                <li class="nav-item">
                                    <a class="nav-link" @click="make_selected_premium( list_of_posts.selected_posts )">Make Premium</a>
                                </li>

                                <li class="nav-item">
                                   <a class="nav-link" @click="list_of_posts.delete_selected_posts( list_of_posts.selected_posts );">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
	
    export default {
        props: ['status'],

        data() {
            return {

                list_of_posts: {},

            };
        },

        methods: {
            make_selected_premium(list_of_selected) {
                list_of_selected.forEach((s_post) => {
                    
                    this.list_of_posts.make_premium( s_post );

                });
            }
        },

        mounted() {
            this.list_of_posts=this.$refs.listofposts;
        }
    }
</script>