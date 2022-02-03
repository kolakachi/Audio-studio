
new Vue({
    el: '#app-id',
    data: {
        isLoading: false,
        books: [],
        filter: '',
        embed: '',
        selectedAudio:{},

        url: {
            create: "",
            update: "",
            edit: "",
            delete: "",
            download: "",
            embed: '',
            getBookURL:''
        }

    },


    mounted() {
        this.url.create = $("#create-book-url").val();
        this.url.getBookURL = $("#fetch-book-url").val() + "/";

        this.url.edit = $("#edit-book-url").val() + "/";
        this.url.update = $("#update-book-url").val();
        this.url.download = $("#download-book-url").val() + "/";
        this.url.delete = $("#delete-book-url").val();
        this.url.embed = $("#widget-url").val()+ '/';
        this.books = JSON.parse($("#books").val());
        GreenAudioPlayer.init({
            selector: '.listen-result-player', // inits Green Audio Player on each audio container that has class "player"
            stopOthersOnPlay: false,
            showDownloadButton: false,
            showTooltips: true
        });
        $('#listenModal').on('hidden.bs.modal', function () {
            let preview = document.getElementById('listen-result')
            preview.pause();
        });

    },

    computed: {
        getBooks() {

            var result = this.books.filter((video) => {
                return book.name.toLowerCase().includes(this.filter.toLowerCase());
                
            });
            return result;
        },
    },

    methods: {    
        deleteBook(index){
            let book = Object.assign({}, this.books[index]);
            book._token = $('input[name=_token]').val();

            const customAlert = swal({
                title: 'Warning',
                text: `Are you sure you want to delete this Book? This action cannot be undone.`,
                icon: 'warning',
                closeOnClickOutside: false,
                buttons: {
                    cancel: {
                        text: "cancel",
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Confirm",
                        value: 'delete',
                        visible: true,
                        className: "btn-danger",
                    }
                }
            });

            customAlert.then(value => {
                if (value == 'delete') {
                    this.isLoading = true;
                    axios.delete(this.url.delete, {data: book})
                        .then(response => {
                            this.isLoading = false;
                            this.books.splice(index, 1);
                            this.$notify({
                                title: 'Success',
                                message: response.data.message,
                                type: 'success'
                            });
                        }).catch(error => {
                            if (error.response) {
                                this.isLoading = false;
                                this.$notify.error({
                                    title: 'Error',
                                    message: error.response.data.message
                                });
                            }else{
                                this.$notify.error({
                                    title: 'Error',
                                    message: 'oops! Unable to complete request.'
                                });
                            }
                        });

                }
            });
        },
        setActiveAudioBook(index){
            let audioBook = this.books[index];
            this.selectedAudio = audioBook;
            this.updateAudioEmbed(audioBook);
        },
        updateAudioEmbed(selectedAudio) {
            this.embed = `<div style="position: relative; height: 0; padding-bottom: 62.50%;overflow:hidden;"><audio controls><source src="${this.url.getBookURL}${selectedAudio.audio_path}" type="audio/mp3"></audio></div>`;
        },

        copyEmbed() {
            document.addEventListener("copy", this.copyEmbedHandler);
            if (document.execCommand("copy")) {
                this.copyMessage();
            }
            document.removeEventListener("copy", this.copyEmbedHandler);
        },
        copyEmbedHandler(e) {
            e.clipboardData.setData("text/plain", this.embed);
            e.preventDefault();
        },
        copyEmbedURL(){
            document.addEventListener("copy", this.copyURLHandler);
            if (document.execCommand("copy")) {
                this.copyMessage();
            }
            document.removeEventListener("copy", this.copyURLHandler());
        },
        copyURLHandler(e){
            e.clipboardData.setData("text/plain", this.url.getBookURL + this.selectedAudio.audio_path);
            e.preventDefault();
        },
        copyMessage(){
            this.$notify({
                title: 'Success',
                message: "Copied",
                type: 'success'
            });
        },
        previewBook(index){
            let audioBook = this.books[index];
            this.selectedAudio = audioBook;
            var audio = document.getElementById('listen-result');
            audio.src = this.url.getBookURL + this.selectedAudio.audio_path;
            $("#listenModal").modal('show');
        }
        
    }


})