<template>
    <div class="chat-app">
        <ContactsList :contacts="contacts" @selected="startConversationWith"/>
        <Conversation :contact="selectedContact" :user="user" :messages="messages" @new="saveNewMessage"/>
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
            if (contact.type === 'message') {
                axios.get(`/chats/personal/${contact.id}`)
                    .then(response => {
                        this.messages = response.data.response;
                        this.selectedContact = contact;
                    })
            }
            else {
                axios.get(`/chats/group/${contact.id}`)
                    .then(response => {
                        console.log(response.data.response);
                        this.messages = response.data.response;
                        this.selectedContact = contact;
                    })
            }

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
        Echo.private(`messages-${this.user.id}`)
            .listen('NewMessageEvent', (e) => {
                this.handleIncoming(e.message);
            })

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
