<template>
    <div class="container">
        <div class="row page-content">
            <div class="col-md-12" style="padding: 0px 20px">
                <div class="message-header mt-10">
                    <div class="col-image message-image-wrapper">
                        <img src="../../img/product_default.jpg" class="mesage-image" />
                        <div class="time-location">
                            19:00 TailWind
                        </div>
                    </div>

                    <div class="message-function">
                        <button class="btn btn-black btn-white">???</button>

                        <div class="header-bottom-des">Message Here</div>
                    </div>
                </div>

                <div class="message-container">
                    <div v-for="message in messages" :key="message.id" class="message-row">
                        <div class="message-content" :class="getClassName(message.user.name)">
                            <div class="message-left flex-4">
                                <img src="../../img/avarta1.jpg" class="user-avarta"/>
                                <div class="username">{{message.user.name}}</div>
                            </div>
                            <div class="message-right flex-8">
                                {{message.message}}
                            </div>
                        </div>
                    </div>

                    <!-- <div class="message-row">
                        <div class="message-content mine">
                            <div class="message-left flex-4">
                                <img src="../../img/avarta2.jpg" class="user-avarta"/>
                                <div class="username">Panda</div>
                            </div>
                            <div class="message-right flex-8">
                                Hello, How are you?
                            </div>
                        </div>
                    </div>
                    <div class="message-row">
                        <div class="message-content mine">
                            <div class="message-left flex-4">
                                <img src="../../img/avarta2.jpg" class="user-avarta"/>
                                <div class="username">Panda</div>
                            </div>
                            <div class="message-right flex-8">
                                Hello, How are you?
                            </div>
                        </div>
                    </div>
                    <div class="message-row">
                        <div class="message-content mine">
                            <div class="message-left flex-4">
                                <img src="../../img/avarta2.jpg" class="user-avarta"/>
                                <div class="username">Panda</div>
                            </div>
                            <div class="message-right flex-8">
                                Hello, How are you?
                            </div>
                        </div>
                    </div>
                    <div class="message-row">
                        <div class="message-content mine">
                            <div class="message-left flex-4">
                                <img src="../../img/avarta2.jpg" class="user-avarta"/>
                                <div class="username">Panda</div>
                            </div>
                            <div class="message-right flex-8">
                                Hello, How are you?
                            </div>
                        </div>
                    </div> -->
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
import axios from 'axios';
export default {

    name: "Message",
        
    setup(props){
        let messages = ref([]);
        let newMessage = ref('');
        let hasScrollToBottom = ref('');

        onMounted(()=>{
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('/api/message')
                    .then(response => {
                        console.log(response.data)
                        messages.value = response.data
                        // this.products = response.data;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        })

        onUpdated(()=>{
            // scrollBottom();
        })

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

        window.Echo.private('chat-channel').listen('SendMessage', (e)=>{
            messages.value.push({
                message: e.message.message,
                user: window.Laravel.user
            })
        })

        const sendMessage = async()=>{
            let mesag = {
                message:newMessage,
                user: window.Laravel.user,
            }
            messages.value.push(mesag);
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/message/add', mesag)
                    .then(response => {
                        // this.$router.push({name: 'myproduct'})
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
            hasScrollToBottom
        }
    },
    // data() {
    //     return {
    //         // messages:[],
    //         message:'',
    //     }
    // },
    // updated(){

    // },
    // created() {

    //     console.log(window.Laravel.user)
    // },

    // methods: {
    //     sendMessage: function(){
    //         let mesag = {
    //             message:this.message,
    //             user: window.Laravel.user,
    //         }
    //         messages.value.push(mesag);
    //         this.$axios.get('/sanctum/csrf-cookie').then(response => {
    //             this.$axios.post('/api/message/add', mesag)
    //                 .then(response => {
    //                     // this.$router.push({name: 'myproduct'})
    //                     console.log(response)
    //                 })
    //                 .catch(function (error) {
    //                     console.error(error);
    //                 });
    //         })
    //     }
    // }
}
</script>
