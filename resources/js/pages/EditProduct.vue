<template>
    <div class="container">
        <div class="row page-content">
            <div class="col-md-12" style="padding: 0px 20px">
                <form class="product-form" @submit.prevent="saveProduct">
                    <div class="edit-image-wrapper mt-10">
                        <div class="edit-image-preview" v-for="(img, index ) in preview" :key="index">
                            <img :src="getImage(img)" class="preview-image" style="width:100px; height:75px">
                            <!-- <div class="">
                                <p>X</p>
                            </div> -->
                            <div @click="deleteImg(img, index)" class="file-dbtn">
                                <label>X</label>
                            </div>
                        </div>

                        <div class="edit-image-selector" v-if="preview.length < 3">
                            <div class="file-button">
                                <label for="select-file"><i class="fa fa-camera"></i></label>
                                <input type="file" multiple="multiple" name="img[]" accept="image/*" id="select-file" @change="previewImage"/>
                            </div>
                        </div>
                    </div>

                    <div class="edit-textarea mt-10">
                        <textarea v-model="description"></textarea>
                    </div>

                    <div class="edit-location mt-10 w-100">
                        <input type="text" v-model="product.location" class="w-100" placeholder="Location">
                    </div>

                    <div class="edit-time mt-10 w-100">
                        <input type="time" v-model="product.time" class="w-100">
                    </div>

                    <div class="col-md-12 mt-10 mb-10">
                        <button class="btn btn-black" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditProduct",
    data() {
        return {
            preview: [],
            images: [],
            oldImages:[],
            product:{},
            description:''
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/product/edit/'+this.$route.params.id)
                .then(response => {
                    console.log(response.data)
                    this.product = response.data;
                    this.description = response.data.description
                    this.product.time = response.data.time
                    this.product.location = response.data.location
                    this.preview = response.data.image.split(',');
                    const dt = new DataTransfer()
                    for(var i = 0; i<this.preview.length; i++){
                        dt.items.add(new File([], '/images/'+this.preview[i]));
                    }
                    this.oldImages = dt.files
                    // console.log(this.oldImages)
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    },
    methods: {
        deleteImg: function(img, index){
            // this.preview.remove(index)
            this.preview.splice(index, 1);
            const dt = new DataTransfer()
            for(var i = 0; i<this.preview.length; i++){
                if(index !== i){
                    dt.items.add(new File([], '/images/'+this.preview[i]));
                }
            }
            this.oldImages = dt.files
        },
        getImage: function(img){
            console.log(img)
            if(img.length > 200){
                return img;
            }else{
                return '/images/'+ img;
            }
        },
        previewImage: function(event) {
             var input = event.target;
             var files = [];
            //  var cnt = this.images.length;
            if (input.files) {
                var length = 3-this.preview.length;
                for(var i=0; i<length; i++){
                    var reader = new FileReader();
                    console.log(reader);
                    reader.onload = (e) => {
                        console.log("preview--", e);
                        this.preview.push(e.target.result);
                    }
                    reader.readAsDataURL(input.files[i])
                    files.push(input.files[i])
                    // cnt++;
                    // this.images.push(input.files[i])
                    // this.product.image = input.files[0];
                    // this.product.imageName = input.files[0].name;
                }
                this.images = files; 
                // console.log(this.images);
            }
            // var input = event.target;
            // if (input.files) {
            //     var reader = new FileReader();
            //     console.log(reader);
            //     reader.onload = (e) => {
            //         console.log("preview--", e);
            //         this.preview = e.target.result;
            //     }
            //     reader.readAsDataURL(input.files[0])
            //     this.image = input.files;

            //     console.log(this.image);
            // }
        },
        saveProduct: function(){
            // console.log(this.product)
            console.log(this.images)
            console.log(this.oldImages)
            var fordata = new FormData();
            for(var i=0; i<this.oldImages.length; i++){
                fordata.append('oldImages[]', this.oldImages[i]);
            }
            for(var i=0; i<this.images.length; i++){
                fordata.append('images[]', this.images[i]);
            }
            // fordata.append('imageName', this.image[0].name);
            fordata.append('description', this.description);
            fordata.append('location', this.product.location);
            fordata.append('time', this.product.time);
            
            // console.log(this.image[0]);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/product/update/'+this.product.id, fordata)
                    .then(response => {
                        console.log(response)
                        this.$router.push({name: 'myproduct'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    }
}
</script>
