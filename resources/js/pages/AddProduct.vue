<template>
    <div class="container">
        <div class="row page-content">
            <div class="col-md-12" style="padding: 0px 20px">
                <form class="product-form" @submit.prevent="saveProduct">
                    <div class="edit-image-wrapper mt-10">
                        <div class="edit-image-preview" v-for="preview in previews" :key="preview.index">
                            <img :src="preview" class="preview-image" style="width:100px: height:75px">
                            
                        </div>

                        <div class="edit-image-selector">
                            <div class="file-button">
                                <label for="select-file"><i class="fa fa-camera"></i></label>
                                <input type="file" multiple="multiple" name="seletImage[]" accept="image/*" id="select-file" @change="previewImage"/>
                            </div>
                        </div>
                    </div>

                    <div class="edit-textarea mt-10">
                        <textarea v-model="product.description"></textarea>
                    </div>

                    <div class="edit-location mt-10 w-100">
                        <input type="text" v-model="product.location" class="w-100" placeholder="Location">
                    </div>

                    <div class="edit-time mt-10 w-100">
                        <input type="time" v-model="product.time" class="w-100">
                    </div>

                    <div class="col-md-12 mt-10 mb-10">
                        <button type="submit" class="btn btn-black">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // this.$router.push('/myproduct')
    name: "AddProduct",
    data() {
        return {
            previews: [],
            images: [],
            product:{}
        }
    },
    created() {
    },
    methods: {
        previewImage: function(event) {
            var input = event.target;
            if (input.files) {
                for(var i=0; i<input.files.length; i++){
                    var reader = new FileReader();
                    console.log(reader);
                    reader.onload = (e) => {
                        console.log("preview--", e);
                        this.previews.push(e.target.result);
                    }
                    reader.readAsDataURL(input.files[i])
                    // this.images.push(input.files[i])
                    // this.product.image = input.files[0];
                    // this.product.imageName = input.files[0].name;
                }
                this.images = input.files;
                console.log(this.images[0]);

            }
        },
        saveProduct: function(){
            console.log(this.product)
            var fordata = new FormData();
            for(var i=0; i<this.images.length; i++){
                fordata.append('images[]', this.images[i]);
            }
            // fordata.append('imageName', this.product.imageName);
            fordata.append('description', this.product.description);
            fordata.append('location', this.product.location);
            fordata.append('time', this.product.time);
            console.log(fordata);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/product/add', fordata)
                    .then(response => {
                        this.$router.push({name: 'myproduct'})
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }

    }
}
</script>
