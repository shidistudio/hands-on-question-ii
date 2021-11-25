import Vue from 'vue'

new Vue({
    el: '#upload-section',
    data: {
        imageUrl: '',
        imageBinary: '',
        result: '',
        filelist: [],
    },
    mounted() {

    },
    methods: {
        async createFile(url, type) {
            if (typeof window === 'undefined') return // make sure we are in the browser

            this.postFile(url);
        },
        processUrlForm() {;
            this.result = null;
            this.createFile(this.imageUrl);
        },
        processFileChange(name, file) {
            this.result = null;
            var reader = new FileReader();
            reader.addEventListener('load', this.postFile);
            reader.readAsArrayBuffer(file);
        },
        postFile(event) {
            let formData = new FormData();
            formData.append("file", event.target != null ? new Blob([event.target.result]) : event)
            let url = "/api/moderate";
            // formData = event.target.result;
            axios.post(url, formData, {
                headers: {
                    "Content-Type": "application/json",
                }
            }).then((response) => {

                if (response) {
                    this.result = "\n" + JSON.stringify(response.data, null, 2);
                    console.log(this.result);
                }


            }).catch((error) => {
                console.log({ error: error });
            })
        },

        // upload drag & drop

        dragover(event) {
            console.log("dragover");
            if (!event.target.classList.contains("drag-on-hover")) {
                // event.currentTarget.classList.remove('drag-end-hover');
                event.currentTarget.classList.add('drag-on-hover');
            }
        },
        dragleave(event) {
            if (!event.target.classList.contains("drag-end-hover")) {
                // event.currentTarget.classList.add('drag-end-hover');
                event.currentTarget.classList.remove('drag-on-hover');
            }
        },
        drop(event) {
            event.preventDefault();
            this.$refs.file.files = event.dataTransfer.files;
            this.filelist = [...this.$refs.file.files];
            event.currentTarget.classList.remove('drag-on-hover');
            event.currentTarget.classList.remove('drag-end-hover');
            console.log(this.$refs.file.files[0]);
            this.processFileChange("demo", this.$refs.file.files[0]);
        },
    }
})
