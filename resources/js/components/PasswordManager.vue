<template>
    <div>
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right" >Password</label>

            <div class="col-md-5">
                <input id="password" :type="p_type" class="form-control" name="password" ref="pass" required autocomplete="new-password" v-on:keyup="checkStrength();checkMatch()">
                <span v-if="theme == 'error'" class="invalid-feedback" role="alert">
                    <strong>{{ message }}</strong>
                </span>
            </div>
            <div class="col-md-2 pt-2">
                <span ref='strength'>
                    <strong >Password Strength</strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

            <div class="col-md-5">
                <input id="password-confirm" :type="p_type" class="form-control" name="password_confirmation" ref="passconfirm" required autocomplete="new-password" v-on:keyup="checkMatch">
            </div>
            <div class="col-md-2 pt-2">
                <span ref='match'>
                    <strong >Password Match</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 pr-0 offset-4">
                <a class="btn btn-primary" @click="toggleShow">
                    <svg class="pb-1" v-if='!show' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg>
                    <span v-if='!show'>Show</span>
                    <svg class="pb-1" v-if='show' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M11.885 14.988l3.104-3.098.011.11c0 1.654-1.346 3-3 3l-.115-.012zm8.048-8.032l-3.274 3.268c.212.554.341 1.149.341 1.776 0 2.757-2.243 5-5 5-.631 0-1.229-.13-1.785-.344l-2.377 2.372c1.276.588 2.671.972 4.177.972 7.733 0 11.985-8.449 11.985-8.449s-1.415-2.478-4.067-4.595zm1.431-3.536l-18.619 18.58-1.382-1.422 3.455-3.447c-3.022-2.45-4.818-5.58-4.818-5.58s4.446-7.551 12.015-7.551c1.825 0 3.456.426 4.886 1.075l3.081-3.075 1.382 1.42zm-13.751 10.922l1.519-1.515c-.077-.264-.132-.538-.132-.827 0-1.654 1.346-3 3-3 .291 0 .567.055.833.134l1.518-1.515c-.704-.382-1.496-.619-2.351-.619-2.757 0-5 2.243-5 5 0 .852.235 1.641.613 2.342z"/></svg>
                    <span v-if='show'>Hide</span>
                </a>
            </div>
            <div class="col-2 pr-0">
                <a class="btn btn-back" @click="generatePassword">
                    <svg class="pb-1" width="22" height="22" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"><path d="M23.621 9.012c.247.959.379 1.964.379 3 0 6.623-5.377 11.988-12 11.988s-12-5.365-12-11.988c0-6.623 5.377-12 12-12 2.581 0 4.969.822 6.927 2.211l1.718-2.223 1.935 6.012h-6.58l1.703-2.204c-1.62-1.128-3.582-1.796-5.703-1.796-5.52 0-10 4.481-10 10 0 5.52 4.48 10 10 10 5.519 0 10-4.48 10-10 0-1.045-.161-2.053-.458-3h2.079zm-7.621 7.988h-8v-6h1v-2c0-1.656 1.344-3 3-3s3 1.344 3 3v2h1v6zm-5-8v2h2v-2c0-.552-.448-1-1-1s-1 .448-1 1z"/></svg>
                    <span>Generate Password</span>
                </a>
            </div>
            <div class="col-2 pr-0 pl-0" @click="toggleAdvanced">
                <a class="btn btn-back">
                    <svg class="pb-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 9c.552 0 1 .449 1 1s-.448 1-1 1-1-.449-1-1 .448-1 1-1zm0-2c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm-9 4c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm18 0c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm-9-6c.343 0 .677.035 1 .101v-3.101c0-.552-.447-1-1-1s-1 .448-1 1v3.101c.323-.066.657-.101 1-.101zm9 4c.343 0 .677.035 1 .101v-7.101c0-.552-.447-1-1-1s-1 .448-1 1v7.101c.323-.066.657-.101 1-.101zm0 10c-.343 0-.677-.035-1-.101v3.101c0 .552.447 1 1 1s1-.448 1-1v-3.101c-.323.066-.657.101-1 .101zm-18-10c.343 0 .677.035 1 .101v-7.101c0-.552-.447-1-1-1s-1 .448-1 1v7.101c.323-.066.657-.101 1-.101zm9 6c-.343 0-.677-.035-1-.101v7.101c0 .552.447 1 1 1s1-.448 1-1v-7.101c-.323.066-.657.101-1 .101zm-9 4c-.343 0-.677-.035-1-.101v3.101c0 .552.447 1 1 1s1-.448 1-1v-3.101c-.323.066-.657.101-1 .101z"/></svg>
                    <span>Advanced Options</span>
                </a>
            </div>
        </div>
        <div v-if="advanced" class="adv-box p-3 pt-4 offset-4 col-6 mb-2">
            <div class="form-group row">
                <label for="len" class="col-md-3 col-form-label pr-0">Password Length</label>
                <div class="col-md-2 pl-0">
                    <input id="len" type="number" class="form-control" max="100" name="len" ref="len" value=32>
                </div>
                <label for="CA" class="col-md-4 col-form-label pr-0">Minimum Capital Alphabet Characters</label>
                <div class="col-md-3 pl-0">
                    <input id="CA" type="number" class="form-control" name="CA" ref="CA" value=1>
                </div>
            </div>
            <div class="form-group row">
                <label for="Num" class="col-md-3 col-form-label pr-0">Minimum Numbers</label>
                <div class="col-md-2 pl-0">
                    <input id="Num" type="number" class="form-control" name="Num" ref="Num" value=1>
                </div>
                <label for="SA" class="col-md-4 col-form-label pr-0">Minimum Small Alphabet Characters</label>
                <div class="col-md-3 pl-0">
                    <input id="SA" type="number" class="form-control" name="SA" ref="SA" value=1>
                </div>
            </div>
            <div class="form-group row">
                <label for="Sym" class="col-md-3 col-form-label pr-0">Minimum Symbols</label>
                <div class="col-md-2 pl-0">
                    <input id="Sym" type="number" class="form-control" name="Sym" ref="Sym" value=2>
                </div>
                <a class="btn btn-primary" @click="generateAdvancedPassword">
                    <svg class="pb-1" width="22" height="22" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"><path d="M23.621 9.012c.247.959.379 1.964.379 3 0 6.623-5.377 11.988-12 11.988s-12-5.365-12-11.988c0-6.623 5.377-12 12-12 2.581 0 4.969.822 6.927 2.211l1.718-2.223 1.935 6.012h-6.58l1.703-2.204c-1.62-1.128-3.582-1.796-5.703-1.796-5.52 0-10 4.481-10 10 0 5.52 4.48 10 10 10 5.519 0 10-4.48 10-10 0-1.045-.161-2.053-.458-3h2.079zm-7.621 7.988h-8v-6h1v-2c0-1.656 1.344-3 3-3s3 1.344 3 3v2h1v6zm-5-8v2h2v-2c0-.552-.448-1-1-1s-1 .448-1 1z"/></svg>
                    <span>Generate Advanced Password</span>
                </a>
            </div>
            <div class="form-group row" v-if="adv_err_flag">
                <span class="adv-error col-md-12">
                    <strong>{{adv_err_msg}}</strong>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       
        mounted() {
            console.log('Component mounted.')
            console.log(this.theme)
            console.log(this.message)
            if(this.theme == 'error'){
                this.$refs.pass.classList.add('is-invalid');
            }

            if(this.passedit){
                this.$refs.pass.value = this.passedit;
                this.$refs.passconfirm.value = this.passedit;
                this.checkStrength();
                this.checkMatch();
            }
        },
        props:['message','theme','passedit'],
        data() {
            return {
                show: false,
                p_type: 'password',
                advanced: false,
                adv_err_flag: false,
                adv_err_msg: '',
            }
        },
        methods: {
            toggleShow(){
                if(this.show){
                    this.p_type = 'password';
                }else{
                    this.p_type = 'text';
                }
                this.show = !this.show;
            },
            checkStrength(){
                var password = this.$refs.pass.value
                var strength = 0;

                if(password.length > 8){
                    strength += 20;
                }
                if(/[a-z]/.test(password)){
                    strength += 20;
                }
                if(/[A-Z]/.test(password)){
                    strength += 20;
                }
                if(/[0-9]/.test(password)){
                    strength += 20;
                }
                if(/[!?<>{}()-_=+*/@#$%^&.,;:`~]/.test(password)){
                    strength += 20;
                }

                if(strength >= 100){
                    this.$refs.strength.innerHTML  = "<strong style='color:green'>Strong</strong>"
                }else if(strength >= 80){
                    this.$refs.strength.innerHTML  = "<strong style='color:gold'>Medium</strong>"
                }else if(strength >= 60){
                    this.$refs.strength.innerHTML  = "<strong style='color:orange'>Weak</strong>"
                }else{
                    this.$refs.strength.innerHTML  = "<strong style='color:crimson'>Very Weak</strong>"
                }

            },checkMatch(){
                var pass1 = this.$refs.pass.value
                var pass2 = this.$refs.passconfirm.value
                if(pass1 == pass2){
                    this.$refs.match.innerHTML  = "<strong style='color:green'>Passwords Matched!</strong>"
                }else{
                    this.$refs.match.innerHTML  = "<strong style='color:crimson'>Passwords doesn't Match!</strong>"
                }
            },
            generatePassword(){
                if(!this.show){
                    this.toggleShow()
                }
                axios.post('/generate').then(response =>{  
                    this.$refs.pass.value = response.data;
                    this.$refs.passconfirm.value = response.data;
                    this.checkStrength();
                    this.checkMatch();
                });
                
            },
            toggleAdvanced(){
                this.advanced = !this.advanced;
            },
            raiseAdvError(message){
                this.adv_err_flag = true;
                this.adv_err_msg = message;
            },
            generateAdvancedPassword(){
                
                var len = parseInt(this.$refs.len.value);
                var CA = parseInt(this.$refs.CA.value);
                var SA = parseInt(this.$refs.SA.value);
                var Num = parseInt(this.$refs.Num.value);
                var Sym = parseInt(this.$refs.Sym.value);

                if(len > 100){
                    this.raiseAdvError("Password Length must be (Equal to/Less than) 100!")
                    console.log('error')
                    return;
                }

                if(len < CA+SA+Num+Sym){
                    this.raiseAdvError("Password Length must be (Equal to/Longer than) the other Password Components!")
                    console.log('error')
                    return;
                }else{
                    this.adv_err_flag =false
                }

                if(!this.show){
                    this.toggleShow()
                }

                axios.post('/advancedGenerate', null, { params: {len,CA,SA,Num,Sym}}).then(response =>{  
                    console.log(response.data);
                    var tmp = response.data.substring(1, response.data.length)
                    console.log(tmp)
                    this.$refs.pass.value = tmp;
                    this.$refs.passconfirm.value = tmp;
                    this.checkStrength();
                    this.checkMatch();
                });
            },
        },
    }
</script>
<style scoped>

svg{
    fill:#FDFDFD;
}

.adv-error{
    color:salmon;
    font-size: 14px;
}

.adv-box{
    background-color: rgba(51, 71, 86, 0.7);
    color:#FDFDFD;
    border: solid 1px #ced4da;
    border-radius:10px ;
}

</style>
