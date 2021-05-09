<template>
    <form @submit="initiateVideoCall">
        <input type="hidden" v-model="room_name" />
        <button type="submit" @click="initiateVideoCall" class="btn btn-primary">
            <i class="fa fa-camera"></i>
        </button>
    </form>
</template>

<script>
export default {
name: "VideoForm",
    props: [
        'room_name'
    ],
    methods: {
        initiateVideoCall(e) {
            console.info(e);
        }
    }
}
</script>

<style scoped>

</style>
