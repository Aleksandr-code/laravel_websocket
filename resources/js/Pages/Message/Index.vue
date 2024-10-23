<template>
    <div class="mx-auto w-3/4 mt-6">
        <div class="mb-3">
            <div class="mb-3 flex items-center">
                <label class="mr-2 w-32" for="message">Input message:</label>
                <input class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-5 ring-1 ring-slate-200 shadow-sm"
                       id="message" type="text" v-model="text">
            </div>
            <a @click.prevent="storeMessage" class="hover:bg-blue-400 hover:cursor-pointer group flex items-center justify-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-4 shadow-sm">
                <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                    <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                </svg>
                Добавить
            </a>
        </div>
        <div v-if="messages">
            <div class="mb-2 font-semibold">Messages:</div>
            <div v-for="message in messages" class="flex mb-3 border-b-2">
                <div class="mr-6">{{message.id}}</div>
                <div class="mr-6">{{message.text}}</div>
                <div class="ml-auto">{{message.time}}</div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Index",

    props: {
        messages: Object,
    },

    data(){
        return {
            text: ''
        }
    },

    mounted() {
        Echo.channel(`message-public-submitted`)
            .listen('.message.store', (e) => {
                console.log(e.message);
                this.messages.unshift(e.message);
            });
        // Echo.private(`message-private-submitted.${this.$attrs.auth.user.id}`)
        //     .listen('.message.store', (e) => {
        //         console.log(e.message);
        //         this.messages.unshift(e.message);
        //     });
    },

    methods:{
        storeMessage(){
            //this.$inertia.post('/message', {text: this.text})
            axios.post('/message', {text: this.text})
                .then(
                    res => {
                        console.log(res.data);
                        this.messages.unshift(res.data);

                    }
                ).catch(er => {
                    console.log(er)
                }
            )
            this.text = ''
        }
    }
}


</script>

<style scoped>

</style>
