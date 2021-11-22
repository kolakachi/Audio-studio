
new Vue({
    el: "#app-id",
    data : {
        isLoading: false,
        preview: false,
        objectives: [{
            niche_id: 0,
            name: '',
        }],
        objective: {
            niche_id: 0,
            name: ''
        },
        objectiveEdit: {
            id: '',
            name: '',
            niche_id: 0,
        },
        url : {
            create: '',
            update: '',
            delete: '',
            templates: ''
        },
        niche:{
            name: '',
            id: 0
        }
    },
    mounted() {
        this.objectives = JSON.parse($("#objectives").val());
        this.niche = JSON.parse($("#niche").val());
        this.url.create = $("#create-url").val();
        this.url.update = $("#update-url").val();
        this.url.delete = $("#delete-url").val();
        this.url.templates = $("#templates-url").val() + '/';
    },
  
    methods: {
        addObjective() {
            this.isUpload = false;
            this.isLoading = true;
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.objective.name);
            formData.append('niche_id', this.niche.id);
            // this.isLoading = true;

                axios.post(this.url.create, formData)
                    .then((response) => {
                        $('#add-objective').modal('hide');
                            this.objective = {
                                name: "",
                                niche_id: 0,
                            }
                    
                        this.$notify({
                            title: 'Success',
                            message: response.data.message,
                            type: 'success'
                        });
                        this.isUpload = true;
                        this.isLoading = false;
                        this.objectives.push(Object.assign({}, response.data.objective, {}));
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
        selectObjective(index){
            this.objectiveEdit = Object.assign({}, this.objectives[index]);
        },
        updateObjective(){
            this.isUpload = false;
            this.isLoading = true;
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.objectiveEdit.name);
            formData.append('id', this.objectiveEdit.id);
            // this.isLoading = true;

            axios.post(this.url.update, formData)
                .then((response) => {
                    $('#edit-objective').modal('hide');
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isUpload = true;
                    this.isLoading = false;
                    let editObjective = response.data.objective;
                    this.objectives = this.objectives.map((objective) => {
                        if (objective.id === editObjective.id) {
                            objective = Object.assign({}, editObjective);
                        }
                        return objective;
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
        deleteObjective(index){
            let objective = Object.assign({}, this.objectives[index]);
            objective._token = $('input[name=_token]').val();

            const customAlert = swal({
                title: 'Warning',
                text: `Are you sure you want to delete this objective? This action cannot be undone.`,
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
                    axios.delete(this.url.delete, {data: objective})
                        .then(response => {
                            this.isLoading = false;
                            this.objectives.splice(index, 1);
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
