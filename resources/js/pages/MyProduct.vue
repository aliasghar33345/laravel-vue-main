<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12 page-content mt-10">
                <div v-for="product in products" :key="product.id" class="col-md-6 col-sm-6 col-image">
                    <router-link :to="{name: 'productdetail', params: { id: product.id }}">
                        <img class="product-image"  :src="'/images/'+product.image.split(',')[0]" />
                        <div class="time-location">
                            {{product.time}} {{product.location}}
                        </div>
                    </router-link>
                </div>
               
                <!-- <div class="col-md-6 col-sm-6 col-image">
                    <img class="product-image" src="../../img/product_default.jpg"/>
                    <div class="time-location">
                        13:01 TailWind
                    </div>
                </div> 
                <div class="col-md-6 col-sm-6 col-image">
                    <img class="product-image" src="../../img/product_default.jpg"/>
                    <div class="time-location">
                        13:00 TailWind   :src={"getImage(product.image, index)"}
                    </div> 
                </div>
                <div class="col-md-6 col-sm-6 col-image">
                    <img class="product-image" src="../../img/product_default.jpg"/>
                    <div class="time-location">
                        13:00 TailWind
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-image">
                    <img class="product-image" src="../../img/product_default.jpg"/>
                    <div class="time-location">
                        13:00 TailWind
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-image">
                    <img class="product-image" src="../../img/product_default.jpg"/>
                    <div class="time-location">
                        13:00 TailWind
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MyProduct",
    data() {
        return {
            name: null,
            products:[],
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/product')
                .then(response => {
                    console.log(response.data)
                    this.products = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
        }
    },
    methods:{
        getImage: function(img, index){
            return '../../img/'+img;
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    }
}
</script>
