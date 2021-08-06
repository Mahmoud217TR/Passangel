<template>
    <div style="width:300px;overflow:auto" v-on:click="copyText">
        <pre class="mb-0" >{{ data }}</pre>
        <textarea :id='counter' type='text' hidden>{{data}}</textarea>
        <Toast v-if="show" message="Copied"></Toast>
    </div>
</template>

<script>
    import Toast from './Toast.vue';
    
    export default {
        components: { Toast },

        mounted() {
            console.log('Component mounted.')
        },
        props:['data','counter'],
        methods: {
            copyText(){
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(this.data).select();
                document.execCommand("copy");
                $temp.remove();
                this.showToast();
            },
            showToast(){
                this.show = true;
                setTimeout(() => this.show =false, this.time);
            }
        },
        data() {
            return {
                show: false,
                time: 2000,  
            }
        },
    }
</script>
