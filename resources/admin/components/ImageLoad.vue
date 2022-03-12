<template>
    <div>
        <input :id="id" type="file" style="display: none" @change="photoProccess" ref="photo" accept="image/*"/>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                base64: null,
                name: null
            }
        },
        props: {
            id: {
                type: String,
                default: 'photo'
            },
            open: {},
        },
        watch:{
            open(){
                this.clickUpload();
            }
        },
        methods: {
            photoProccess() {
                let $this = this;
                let reader = new FileReader();
                let file = this.$refs.photo.files[0];

                reader.onloadend = function () {
                    $this.$emit('setImage', {name: $this.name, path: reader.result});
                }

                if (this.$refs.photo.files.length) {
                    reader.readAsDataURL(file);
                    this.name = file.name;
                }
            },
            clickUpload() {
                document.getElementById(this.id).click()
            },
        }
    }
</script>

