import Vue from 'vue'

new Vue({
    el: '#upload-section',
    data: {
        imageUrl: '',
        imageBinary: '',
        result: '',
    },
    mounted() {

    },
    methods: {
        processUrlForm() {
            // handling by image path
        },
        processFileChange(name, file) {
            var reader = new FileReader();
            reader.addEventListener('load', this.postFile);
            reader.readAsArrayBuffer(file);
        },
        postFile(event) {
            let url = "https://asia-east2-falcon-293005.cloudfunctions.net/falcon";
            axios.post(url, event.target.result, {
                headers: {
                    "Content-Type": "image/jpeg"
                }
            }).then((response) => {
                console.log({result: response});
            }).catch((error) => {
                console.log({error: error});
            })
        }
    }
})
