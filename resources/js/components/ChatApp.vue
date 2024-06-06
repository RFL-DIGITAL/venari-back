<template>
    <div class="chat-app">
        <ContactsList :contacts="contacts" @selected="startConversationWith"/>
        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
    </div>
</template>

<script>
import Conversation from "./Conversation.vue";
import ContactsList from "./ContactsList.vue";

export default {
    props: {
        user: {
            Object,
            require: true
        }
    },
    name: "ChatApp",
    data() {
        return {
            selectedContact: null,
            contacts: [],
            messages: [],
        }
    },
    methods: {
        startConversationWith(contact) {
            axios.get(`/chats/personal/${contact.id}`)
                .then(response => {
                    // console.log(response.data.response);
                    this.messages = response.data.response;
                    this.selectedContact = contact;
                })
        },
        saveNewMessage(message) {
            this.messages.push(message);
        },
        handleIncoming(message) {
            if (this.selectedContact && message.from_id === this.selectedContact.id) {
                this.messages.push(message);
                return;
            }

            //unread messages
            // this.updateUnreadCount(message.from_contact, false);
        },
        // updateUnreadCount(contact, reset) {
        //     this.contacts = this.contacts.map((single) => {
        //         if (single.id !== contact.id) {
        //             return single;
        //         }
        //         if (reset) {
        //             single.unread = 0;
        //         } else {
        //             single.unread += 1;
        //         }
        //         return single;
        //     })
        // }
    },
    mounted() {
        // var channel = Echo.private(`messages-${this.user.id}`);
        // console.log(channel);
        // channel.listen('NewMessageEvent', function(e) {
        //     this.handleIncoming(e.message);
        // });
        // Pusher.logToConsole = true;

        // Pusher.logToConsole = true;
        //
        // var pusher = new Pusher('09627fbd442497554d6f', {
        //     cluster: 'ap3'
        // });

        var channel = Echo.channel(`private-messages-${this.user.id}`);
        channel.listen('NewMessageEvent', function(data) {
            alert(JSON.stringify(data));
        });

        // var channel = pusher.subscribe(`private-messages-${this.user.id}`);
        // channel.bind('NewMessageEvent', function(data) {
        //     alert(JSON.stringify(data));
        // });
        // Echo.private(`messages-${this.user.id}`)
        //     .listen('NewMessageEvent', (e) => {
        //         this.handleIncoming(e.message);
        //     })

        axios.get(`/chats/${this.user.id}`)
            .then(response => {
                this.contacts = response.data.response;
            });
    },
    components: {
        Conversation,
        ContactsList
    }
}
</script>

<style lang="scss" scoped>

.chat-app {
    display: flex;
    gap: 18px;
    flex-direction: row;
}

@media screen and (max-width: 1016px) {
    .chat-app {
        flex-direction: column;
        gap: 18px;
    }
}
</style>
