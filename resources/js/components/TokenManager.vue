<template>
    <div class="form-group row">
        <label for="token" class="col-md-4 col-form-label text-md-right">Your Token</label>

        <div class="col-md-4">
            <input id="token" type="text" class="form-control" name="token" required disabled :value="tokenV">
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" @click="changeToken" v-if="!wait">
                <span>Change Token</span>
            </a>
            <a class="btn btn-disabled" @click="holdFunc" v-if="wait">
                <span>Wait For Change</span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            this.tokenV = this.token
        },
        data() {
            return {
                wait:false,
                tokenV:'token'
            }
        },
        props:['token'],
        methods: {
            holdFunc(){
                console.log('WAIT');
            },
            changeToken(){
                this.wait = true;
                axios.post('/changetoken').then(response =>{  
                    this.wait = false;
                    this.tokenV=response.data;
                });
            }
        },
    }
</script>
