<template>
    <div class="conversation w-100">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center gap-4">
                <img :src="contact.avatar" :alt="contact.name"
                     class="rounded-circle contact-image" v-if="contact">
                <div class="contact-details d-flex flex-column">
                    <span class="contact-name">{{ contact ? contact.name : "Abdel ChatX" }}</span>
<!--                    <span class="contact-phone">{{ contact ? contact.phone : '' }}</span>-->
                </div>
            </div>
            <div class="card-body pb-0">
                <MessagesFeed :contact="contact" :user="user" :messages="messages"/>
                <MessageComposer @send="sendMessage"/>
            </div>
        </div>
    </div>
</template>

<script>
import MessagesFeed from "./MessagesFeed.vue";
import MessageComposer from "./MessageComposer.vue";

export default {
    props: {
        contact: {
            type: Object,
            default: null,
        },
        messages: {
            type: Array,
            default: [],
        },
        user: {
            Object,
            require: true
        }
    },
    data() {
        return {}
    },
    methods: {
        sendMessage(text) {
            if (!this.contact) {
                return;
            }
            axios.post('/messages/send-message', {
                toID: this.contact.id,
                body: text,
                type: this.contact['type'],
            }).then(response => {
                this.$emit('new', response.data.response);
            })
        }
    },
    components: {
        MessagesFeed,
        MessageComposer
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style lang="scss" scoped>
$contact_image_width: 50px;
.card-header {
    font-weight: bold;
    font-size: 18px;
}

.contact-image {
    width: $contact_image_width;
}

.contact-phone {
    font-size: 12px;
    opacity: 0.8;
}
</style>
