<template>
    <div class="container">
        <div class="row page-content">
            <div class="col-md-12" style="padding: 0px 20px">
                <div class="message-header mt-10">
                    <div class="col-image message-image-wrapper">
                        <img :src="getProductImage()" class="mesage-image" />
                        <div class="time-location">
                            {{getTimeLocation()}}
                        </div>
                    </div>

                    <div class="message-function">
                        <button class="btn btn-black btn-white">???</button>

                        <div class="header-bottom-des">Message Here</div>
                    </div>
                </div>

                <div class="message-container">
                    <div v-for="message in messages" :key="message.id" >
                        <div v-if="checkMsg(message)" class="message-row">
                            <div class="message-content" :class="getClassName(message.user.name)">
                                <div class="message-left flex-4">
                                    <img :src="'/images/'+message.user.image" class="user-avarta"/>
                                    <div class="username">{{message.user.name}}</div>
                                </div>
                                <div class="message-right flex-8">
                                    {{message.message}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message-send">
                    <input type="text" class="message-input" v-model="newMessage" />
                    <button @click="sendMessage" class="btn btn-black">Send</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive, inject, ref, onMounted, onUpdated} from 'vue';
import { useRoute } from "vue-router";
import axios from 'axios';
export default {

    name: "Message",
        
    setup(props){
        const route =useRoute()
        let messages = ref([]);
        let newMessage = ref('');
        let productImage = ref('');
        let product = ref({time:'',location:''});
        let hasScrollToBottom = ref('');

        onMounted(()=>{
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('/api/message/'+route.params.id+'/'+route.params.proid)
                    .then(response => {
                        messages.value = response.data
                    })
                    .catch(function (error) {
                        console.error(error);
                    });

                axios.get('/api/product/edit/'+route.params.proid)
                    .then(response => {
                        productImage.value = response.data.image.split(',')[0]
                        product.value = response.data
                    })
                    .catch(function (error) {
                        console.error(error);
                });
            });

        })

        onUpdated(()=>{
       
        })

        const getTimeLocation = ()=>{
            return product.value.time + ' ' + product.value.location
        }

        const checkMsg = (message)=>{
            if((window.Laravel.user.id == message.user_id && route.params.id == message.to_id)
             || (route.params.id == message.user_id && window.Laravel.user.id == message.to_id)){
                if(route.params.proid == message.product_id){
                    return true
                }else{
                    return false
                }
            }else{
                return false
            }
        }
        const getClassName = (Uname)=>{
            if(window.Laravel.user.name == Uname){
                return "mine"
            }else{
                return "other-message"
            }
        }

        const scrollBottom = ()=>{
            if(messages.value.length > 0){
                let el = hasScrollToBottom.value;
                el.scrollTop = el.scrollHeight;
            }
        }

        const getProductImage = ()=>{
            return '/images/'+productImage.value;
        }

        const sendMessage = async()=>{
            let mesag = {
                message:newMessage.value,
                user: window.Laravel.user,
                to_id:route.params.id,
                product_id:route.params.proid,
                user_id:window.Laravel.user.id
            }
            messages.value.push(mesag);
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/message/add', mesag)
                    .then(response => {
                        newMessage.value = '';
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }

        return {
            messages,
            newMessage,
            sendMessage,
            getClassName,
            scrollBottom,
            hasScrollToBottom,
            checkMsg,
            getProductImage,
            getTimeLocation
        }
    },
}
</script>
