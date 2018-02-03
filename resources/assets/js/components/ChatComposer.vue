<template lang="html">
    <div class="chat-composer">
        <input type="text" placeholder="Type your message" v-model="messageText" @keyup.enter="sendMessage">
        <button class="btn btn-primary" @click="sendMessage">Send</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                "messageText": '',
                "user_name": this.get_user_name()
            }
        },
        methods: {
            sendMessage(){
                this.$emit('message_sent', {
                    message: this.messageText,
                    user: {
                        name: this.user_name
                    }
                });
                this.messageText = ''
            },
            get_user_name(){
                axios.get('/auth_user').then(response => {
                    this.user_name = response.data;
                });
            }
        }
    }
</script>

<style lang="css">
    .chat-composer{
        display: flex;
    }
    .chat-composer input{
        flex: 1 auto;
    }
    .chat-composer button{
        border-radius: 0;
    }
</style>