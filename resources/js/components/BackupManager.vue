<template>
    <div class="form-group row">
        <a class="btn btn-primary col-2 offset-4" @click="exportBackup">
            <svg class='pb-1' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M19 18.5c0-.276.224-.5.5-.5s.5.224.5.5-.224.5-.5.5-.5-.224-.5-.5zm5-2.5v6h-24v-6l5-14h14l5 14zm-16-6l4 4 4-4h-3v-5h-2v5h-3zm14 7h-20v3h20v-3z"/></svg>
            <span>Export backup</span>
            </a>
        <a class="btn btn-back col-2 offset-1" @click="fileBrowse">
            <svg  class='pb-1' xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M19 2h-14l-5 14v6h24v-6l-5-14zm-7 3l4 4h-3v5h-2v-5h-3l4-4zm10 15h-20v-3h20v3zm-3-1.5c0-.276.224-.5.5-.5s.5.224.5.5-.224.5-.5.5-.5-.224-.5-.5z"/></svg>
            <span>Import backup</span>
        </a>
        <input id='fileUpload' type='file' hidden accept=".psgl" ref="uploader" @change='importBackup'></input>
        <Toast message = "Backup Exported" v-if="exportToast"></Toast>
        <Toast message = "Backup Imported" v-if="importToast"></Toast>
    </div>
</template>

<script>
    import Toast from './Toast.vue';

    export default {
        components: { Toast },

        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                exportToast:false,
                importToast:false,
            }
        },
        methods: {
            showToast(type){
                if(type == 'import'){
                    this.importToast = true;
                    setTimeout(() => this.importToast =false, 2000);
                }else if(type == 'export'){
                    this.exportToast = true;
                    setTimeout(() => this.exportToast =false, 2000);
                }
            },
            exportBackup(){
                axios.post('/backup').then(response =>{  
                    console.log('Making Backup...');
                    console.log(response.data['url']);
                    console.log(response.data['name']);
                    var fileUrl = response.data['url'];
                    var fileName = response.data['name'];
                    var download = document.createElement("a");
                    download.href = fileUrl;
                    download.setAttribute("download", fileName);
                    download.click();
                    var del = response.data['del'];
                    axios.post('/delbackup', null, { params: {del}}).then(response =>{  console.log(response.data);});
                    this.showToast('export');
                });
            },
            fileBrowse(){
                document.getElementById("fileUpload").click();
            },
            importBackup(){              
                var fr=new FileReader();
                var content = '';
                fr.onload=function(){
                    content = fr.result;
                    axios.post('/import', null, { params: {content}}).then(response =>{
                        console.log(response.data)
                    });
                }
                fr.readAsText(this.$refs.uploader.files[0]);
                document.getElementById('fileUpload').value = ""
                 this.showToast('import');
            }
        },
    }
</script>
<style scoped>
svg{
    fill:#FDFDFD;
}
</style>
