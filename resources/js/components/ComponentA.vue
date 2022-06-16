<template>
    <div>
        <p>{{newMessage}}</p>
        <vue-qrcode color:dark value="https://www.1stg.me" />
    </div>
</template>
<script>
import VueQrcode from 'vue-qrcode'
export default {
    components: {
    VueQrcode,
    },
    data() {
        return {
        newMessage: "hai",
        };
    },
    methods: {
        fetchMessages() {
            //GET request to the messages route in our Laravel server to fetch all the messages
            axios.get('/messages').then(response => {
                //Save the response in the messages array to display on the chat view
                this.messages = response.data;
            });
        }
    },
    created(){
        console.log('holla');
        window.Echo.private('success-scanning')
        .listen('MessageSent', (e) => {
            this.newMessage = "holla"
        });
    }
};
</script>
