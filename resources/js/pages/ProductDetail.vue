<template>
    <div class="container">
        <div class="row page-content">
            <div class="col-md-12" style="padding: 0px 20px">
                <div class="col-md-12 mb-10">
                    <img class="detail-image" :src="'/images/'+product.image">
                </div>

                <div class="col-md-12 detail-description mb-10">
                    {{product.description}}
                </div>

                <div class="col-md-12 detail-time-location mb-10">
                    <i class="fa fa-mobile"></i>Mandal
                    <i class="fa fa-clock"></i>  {{product.created_at}}
                </div>

                <div class="col-md-12 mb-10">
                    <button type="submit" class="btn btn-black" @click="this.$router.push('/dashboard')">
                        List
                    </button>
                </div>
                <div class="col-md-12 mb-10">
                    <button type="submit" class="btn btn-black" @click="this.$router.push('/editproduct/'+product.id)">
                        Edit
                    </button>
                </div>
                 <div class="col-md-12 mb-10">
                    <button type="submit" class="btn btn-black" @click="deleteProduct">
                        Delete
                    </button>
                </div>
                <div class="col-md-12 mb-10">
                    <button type="submit" class="btn btn-black" @click="this.$router.push('/message/1')">
                        Message
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductDetail",
    data() {
        return {
            product:{},
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/product/edit/'+this.$route.params.id)
                .then(response => {
                    console.log(response.data)
                    this.product = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
        console.log(this.$route.params.id);
    },
    methods: {
        deleteProduct: function(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete('/api/product/delete/'+this.$route.params.id)
                    .then(response => {
                        this.$router.push('/myproduct')
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
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
