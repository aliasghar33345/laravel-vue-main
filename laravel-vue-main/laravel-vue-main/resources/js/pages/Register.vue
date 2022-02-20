<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>

                <div class="card card-default">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="name" class=" col-form-label text-md-right">Name</label>
                                <div class="">
                                    <input id="name" type="email" class="form-control" v-model="name" required
                                           autofocus autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="email" class=" col-form-label text-md-right">E-Mail</label>
                                <div class="">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                           autofocus autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="password" class=" col-form-label text-md-right">Password</label>
                                <div class="">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="password" class=" col-form-label text-md-right">Password confirm</label>
                                <div class="">
                                    <input id="password" type="password" class="form-control" v-model="confirm"
                                           required autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row mb-0">
                                <div class="">
                                    <button type="submit" class="btn btn-black" @click="handleSubmit">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import jplang from "../lang/jp.js";

export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirm: "",
            error: null
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.name.trim().length == 0) {
                this.error = jplang.inputnameerror;
                return;
            }

            if (this.email.trim().length == 0) {
                this.error = jplang.inputemailerror;
                return;
            }

            if (this.password.trim().length == 0) {
                this.error = jplang.inputpassworderror;
                return;
            }

            if (this.confirm.trim().length == 0) {
                this.error = jplang.inputpasswordconfirmerror;
                return;
            }

            if (this.confirm != this.password) {
                this.error = jplang.passwordconfirmerror;
                return;
            }

            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/login"
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
