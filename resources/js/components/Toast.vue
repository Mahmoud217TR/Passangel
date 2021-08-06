<template>
    <transition name="fade">
        <div class="vue-toast justify-content-center" v-if="show">
            <center>{{ message }}</center>
        </div>
    </transition>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            
        },
        props:['message','customTime'],
        data() {
            return {
                show:true,
            }
        },
    }
</script>
<style scoped>

.vue-toast{
    color: ghostwhite;
    background-color: rgba(169, 169, 169, 0.9);
    border-radius: 13px;
    padding: 5px;
    position: fixed;
    left: 50%;
    bottom: 30px;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

</style>
