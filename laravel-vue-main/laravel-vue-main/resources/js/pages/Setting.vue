<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" style="padding: 0px 20px">
                <div class="col-md-12 setting-image-wrapper mb-10 mt-50">
                    <img class="setting-image" src="../../img/avarta1.jpg">
                </div>

                <div class="col-md-12 setting-name-wrapper">
                    Panda
                </div>

                <div class="col-md-12 mb-10 mt-50">
                    <button type="submit" class="btn btn-black" @click="this.$router.push('/editsetting')">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Setting"
}
</script>
