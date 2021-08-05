<template>
    <div class="form-group row">
        <a class="btn btn-primary col-2 offset-4" @click="exportBackup">Export backup</a>
        <a class="btn btn-back col-2 offset-1" >Import backup</a>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            exportBackup(){
                
            }
        },
    }
</script>
