<template>
    <div class="container">
        <div class="row page-content">
            <div class="col-md-12" style="padding: 0px 20px">
                <form class="product-form" @submit.prevent="saveProduct">
                    <div class="edit-image-wrapper mt-10">
                        <div class="edit-image-preview" v-if="preview">
                            <img :src="preview" class="preview-image">
                        </div>

                        <div class="edit-image-selector">
                            <div class="file-button">
                                <label for="select-file"><i class="fa fa-camera"></i></label>
                                <input type="file" accept="image/*" id="select-file" @change="previewImage"/>
                            </div>
                        </div>
                    </div>

                    <div class="edit-textarea mt-10">
                        <textarea v-model="description"></textarea>
                    </div>

                    <div class="edit-location mt-10">
                        
                    </div>

                    <div class="edit-time mt-10">

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
            preview: null,
            image: null,
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
                    this.preview = '/images/'+response.data.image
                    const dt = new DataTransfer()
                    dt.items.add(new File([], this.preview));
                    this.image = dt.files
                    console.log(this.image)
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    },
    methods: {
        previewImage: function(event) {
            var input = event.target;
            if (input.files) {
                var reader = new FileReader();
                console.log(reader);
                reader.onload = (e) => {
                    console.log("preview--", e);
                    this.preview = e.target.result;
                }
                reader.readAsDataURL(input.files[0])
                this.image = input.files;

                console.log(this.image);
            }
        },
        saveProduct: function(){
            console.log(this.product)
            var fordata = new FormData();
            fordata.append('image', this.image[0]);
            fordata.append('imageName', this.image[0].name);
            fordata.append('description', this.description);
            console.log(this.image[0]);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/product/update/'+this.product.id, fordata)
                    .then(response => {
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
