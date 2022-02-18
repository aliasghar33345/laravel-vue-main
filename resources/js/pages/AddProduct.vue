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
                        <textarea v-model="product.description"></textarea>
                    </div>

                    <div class="edit-location mt-10">
                        
                    </div>

                    <div class="edit-time mt-10">

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
            preview: null,
            image: null,
            product:{}
        }
    },
    created() {
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
                this.image = input.files[0];
                this.product.image = input.files[0];
                this.product.imageName = input.files[0].name;
                // console.log(this.image);
            }
        },
        saveProduct: function(){
            console.log(this.product)
            var fordata = new FormData();
            fordata.append('image', this.product.image);
            fordata.append('imageName', this.product.imageName);
            fordata.append('description', this.product.description);
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
