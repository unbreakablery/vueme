<template>
    <div class="vue-dashboard-media vue-dashboard-gallery" style="padding: 0px;">
        <div class="row main-split">
            <div class="col-md" id="list-of-media">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-media-tab" data-toggle="tab" href="#nav-media" role="tab" aria-controls="nav-media" aria-selected="true">Media</a>

                        <a href="/dashboard/post" class="nav-item nav-link">Posts</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent" style="">
                  <div class="tab-pane fade show active" id="nav-media" role="tabpanel" aria-labelledby="nav-media-tab" >
                      
                        <div style=" padding-bottom: 15px;">

                            <list-of-media ref="media_list" enable-search="true"></list-of-media>
                            
                        </div>

                        <div style="position: sticky; bottom: 0px; z-index: 999; background-color: #fff; padding: 15px; width: 100%;">
                            <button type="button" class="btn btn-purple"  data-toggle="modal" data-target=".bd-example-modal-xl">Add New Media</button>
                            
                            <a href="/dashboard/post/new">
                                <button type="button" class="btn btn-pink" style="padding-left: 10px; padding-right: 10px;">Create New Post</button>
                            </a>

                            <button type="button" class="btn btn-danger" @click="deleteSelected()" v-if="selectedMedia.length">Delete Selected</button>
                        </div>
                  </div>
                </div>
            </div>

            <div class="col-md selected-file-details" style="">
                <div v-if="selectedMedia.length > 0">
                    <div>
                        <h5 style="margin-top: 30px; font-size: 14px; color: rgba(31, 30, 52, .8);">Details</h5>

                        <div style="overflow-y: scroll; height: calc(100vh - 128px);">

                            <div v-for="media in selectedMedia" class="selected-medium">
                                <div class="a-image">
                                    <img v-if="media.type == 'IMAGE'" v-bind:src="media.url" />
                                </div>

                                <div class="a-video" v-if="media.type == 'VIDEO'"> 
                                    <video v-bind:src="media.url" muted="true" controls="" preload="auto"></video>
                                </div>

                               <!--  <span class="filename">{{ media.filename }}</span><br> -->

                                <span class="date-and-size">
                                    {{ media.created_at | dateformat }}<br>
                                    <span style="font-size: 80%; display: block;">
                                        <span v-if="media.dimension != '0x0'">{{ media.dimension }}</span>
                                        <span v-if="media.size">; {{ media.size | filesize }}</span>
                                    </span>
                                </span>
                                
                                <form class="form-dashboard" @submit="updateMedia($event, media)">
                                    <input type="hidden" name="description" value="" />

                                    <div class="form-group">    
                                        <!-- <label>Name</label> -->
                                        <input type="text" class="form-control" name="name" v-model="media.name">
                                       
                                        <button type="submit" class="btn-save" v-if="! media.saving">Save</button>
                                        <span class="btn-save" v-if="media.saving">Saving...</span>
                                         | 
                                        <span class="text-danger" style="font-size: 80%; font-weight: 600; cursor: pointer;" v-if="! media.deleting" @click="deleteMediaWithoutKey(media)">
                                            Delete Item
                                        </span>
                                        <span class="text-danger" style="font-size: 80%; font-weight: 600; cursor: pointer;" v-if="media.deleting">Deleting...</span>
 
                                        
                                    </div>
                                </form>

                                <hr>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-xl" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="border-radius: 0px;">
                    <div class="modal-header" style="background-color: #fff; border-bottom: 0px; border-radius: 0px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: -1rem auto -1rem -1rem; z-index: 900;">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h5 class="modal-title" style="position: absolute; z-index: 800; width: 100%; text-align: center;">Add Media</h5>
                        
                    </div>
                    <div class="modal-body" style="background-color: #F9F9F9;">

                        <dashboard-media-uploader ref="upload"></dashboard-media-uploader>
                        

                    </div>
                    <!-- <div class="modal-footer" style="border-radius: 0px; justify-content: flex-start;">
                            
                        <span style="font-weight: 500; font-size: 12px; color: rgba(31, 30, 52, .4);">
                            {{ files.length }} Items
                        </span>

                        <div style="float: right;">

                            <button type="button" class="btn btn-purple-border" style="padding: 0.375rem 0.75rem;" @click="start_an_album()">Upload As Album</button>
                            <button type="button" class="btn btn-gray" @click="start_uploading">Upload</button>
                            
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                message: '',
                errors: [],
            
                naming_album: false,
                album_name: '',
                creating_album: false,
                created_album: {},
                medium_for_album: [],
                adding_medium_to_album: false,

                selectedMedia: [],
            };
        },

        filters: {
            dateformat: function (DateTime) {
                if (typeof DateTime == "string") {

                    var jsDate=new Date(DateTime);
                
                    return jsDate.toLocaleDateString('en-US', { dateStyle: "long", month: 'long', year: 'numeric', day: 'numeric' });
                }        
            },

            filesize: function(fileSizeInBytes) {

                fileSizeInBytes=fileSizeInBytes*1000;

                var i = -1;
                var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
                do {
                    fileSizeInBytes = fileSizeInBytes / 1024;
                    i++;
                } while (fileSizeInBytes > 1024);

                return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];

            }
        },

        computed: {
           
        },
      
        methods: {
            deleteMediaWithoutKey(media) {

                this.$set(media, 'deleting', true);
                
                axios.delete(
                    '/api/v1/media/'+media.id,
                    {},
                    {}
                )
                .then(response => {                   
                    this.$delete(
                        this.$refs.media_list.medium, 
                        this.$refs.media_list.medium.map((media) => {return media.id;}).indexOf(media.id)
                    );
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
                    
                    this.message = "";
                });

            },

            deleteSelected() {

                this.selectedMedia.forEach((sm) => {

                    this.deleteMediaWithoutKey(sm);

                });

            },

            updateMedia(e, media) {
                e.preventDefault();

                this.$set(media, 'saving', true);

                axios.put(
                    '/api/v1/media/'+media.id,
                    media
                )
                .then(response => {

                    console.log(response.data);  

                    setTimeout(() => {
                        this.$set(media, 'saving', false);
                    }, 500);
                    
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
                    
                    this.message = "";

                    setTimeout(() => {
                        this.$set(media, 'saving', false);
                    }, 500);
                });

            },

            

        },  
        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            
        }
    }
</script>
