
new Vue({
    el: "#app-id",
    data : {
        isLoading: false,
        preview: false,
        niches: [{
            name: '',
        }],
        niche: {
            name: ''
        },
        nicheEdit: {
            id: '',
            name: '',
        },
        url : {
            create: '',
            update: '',
            delete: '',
            edit:''
        },
    },
    mounted() {
        this.niches = JSON.parse($("#niches").val());
        this.url.create = $("#create-url").val();
        this.url.update = $("#update-url").val();
        this.url.delete = $("#delete-url").val();
        this.url.edit = $("#edit-url").val() + '/';
    },
  
    methods: {
        addNiche() {
            this.isUpload = false;
            this.isLoading = true;
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.niche.name);
            // this.isLoading = true;

                axios.post(this.url.create, formData)
                    .then((response) => {
                        $('#add-niche').modal('hide');
                            this.niche = {
                                name: ""
                            }
                    
                        this.$notify({
                            title: 'Success',
                            message: response.data.message,
                            type: 'success'
                        });
                        this.isUpload = true;
                        this.isLoading = false;
                        this.niches.push(Object.assign({}, response.data.niche, {}));
                    })
                    .catch((error) => {
                        // this.isLoading = false;
                        if(error.response){
                            this.$notify.error({
                                title: 'Error',
                                message: error.response.data.message
                            });
                            this.isUpload = true;
                            this.isLoading = false;
                        }else{
                            this.$notify.error({
                                title: 'Error',
                                message: 'oops! Unable to complete request.'
                            });
                            this.isUpload = true;
                            this.isLoading = false;
                        }

                    });
        },
        selectNiche(index){
            this.nicheEdit = Object.assign({}, this.niches[index]);
        },
        updateNiche(){
            this.isUpload = false;
            this.isLoading = true;
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.nicheEdit.name);
            formData.append('id', this.nicheEdit.id);
            // this.isLoading = true;

            axios.post(this.url.update, formData)
                .then((response) => {
                    $('#edit-niche').modal('hide');
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isUpload = true;
                    this.isLoading = false;
                    let editNiche = response.data.niche;
                    this.niches = this.niches.map((niche) => {
                        if (niche.id === editNiche.id) {
                            niche = Object.assign({}, editNiche);
                        }
                        return niche;
                    });

                    // $('.data-table-custom').DataTable().destroy();
                    // $('.data-table-custom').DataTable();
                })
                .catch((error) => {
                    // this.isLoading = false;
                    if(error.response){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                        this.isUpload = true;
                        this.isLoading = false;
                    }else{
                        this.$notify.error({
                            title: 'Error',
                            message: 'oops! Unable to complete request.'
                        });
                        this.isUpload = true;
                        this.isLoading = false;
                    }

                });
        },
        deleteNiche(index){
            let niche = Object.assign({}, this.niches[index]);
            niche._token = $('input[name=_token]').val();

            const customAlert = swal({
                title: 'Warning',
                text: `Are you sure you want to delete this niche? This action cannot be undone.`,
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
                    axios.delete(this.url.delete, {data: niche})
                        .then(response => {
                            this.isLoading = false;
                            this.niches.splice(index, 1);
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
    }
    
})
