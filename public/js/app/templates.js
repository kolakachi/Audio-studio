Vue.component('vue-multiselect', window.VueMultiselect.default)
new Vue({
    el: "#app-id",
    data : {
        isLoading: false,
        preview: false,
        tags: [{
            objective_id: 0,
            name: '',
        }],
        tag: {
            objective_id: 0,
            name: ''
        },
        tagEdit: {
            id: '',
            name: '',
            objective_id: 0,
        },
        templates: [{
            objective_id: 0,
            name: '',
            template: '',
            tags: []
        }],
        template: {
            objective_id: 0,
            name: '',
            template: '',
            tags:[]
        },
        templateEdit: {
            id: '',
            name: '',
            objective_id: 0,
            template: '',
            tags: []

        },
        objective: {
            niche_id: 0,
            name: ''
        },
        
        url : {
            createTag: '',
            updateTag: '',
            deleteTag: '',

            createTemplate: '',
            updateTemplate: '',
            deleteTemplate: '',
        },
        niche:{
            name: '',
            id: 0
        }
    },
    mounted() {
        this.tags = JSON.parse($("#tags").val());
        this.templates = JSON.parse($("#templates").val());
        this.objective = JSON.parse($("#objective").val());
        this.url.createTag = $("#create-tag-url").val();
        this.url.updateTag = $("#update-tag-url").val();
        this.url.deleteTag = $("#delete-tag-url").val();

        this.url.createTemplate = $("#create-template-url").val();
        this.url.updateTemplate = $("#update-template-url").val();
        this.url.deleteTemplate = $("#delete-template-url").val();
        this.addTextKey();
        $('.select2-tags').select2({
            data: this.tags,
            templateResult: this.selectItem,
            templateSelection: function (tags) {
                return tags.name
            }
        });
        $('.select2-edit-tags').select2({
            data: this.tags,
            templateResult: this.selectItem,
            templateSelection: function (tags) {
                return tags.name
            }
        });
        
        
    },
  
    methods: {
        selectItem(item) {
            let template = $(
                `
                <span class="tx-center">
                    <span class="mb-0 pl-1">${item.text}</span>
                </span>
                `
            )
            return template
        },
        addTextKey(){
            this.tags = this.tags.map((tag) => {
                 tag['text'] = tag.name
                 return tag
             });
        },
        nameWithLang ({ name, id }) {
            return `${id}`
        },
        addTag() {
            this.isUpload = false;
            this.isLoading = true;
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.tag.name);
            formData.append('objective_id', this.objective.id);
            // this.isLoading = true;

                axios.post(this.url.createTag, formData)
                    .then((response) => {
                        $('#add-tag').modal('hide');
                            this.tag = {
                                name: "",
                                objective_id: 0,
                            }
                    
                        this.$notify({
                            title: 'Success',
                            message: response.data.message,
                            type: 'success'
                        });
                        this.isUpload = true;
                        this.isLoading = false;
                        this.tags.push(Object.assign({}, response.data.tag, {}));
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
        selectTag(index){
            this.tagEdit = Object.assign({}, this.tags[index]);
        },
        updateTag(){
            this.isUpload = false;
            this.isLoading = true;
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.tagEdit.name);
            formData.append('id', this.tagEdit.id);
            // this.isLoading = true;

            axios.post(this.url.updateTag, formData)
                .then((response) => {
                    $('#edit-tag').modal('hide');
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isUpload = true;
                    this.isLoading = false;
                    let editTag = response.data.tag;
                    this.tags = this.tags.map((tag) => {
                        if (tag.id === editTag.id) {
                            tag = Object.assign({}, editTag);
                        }
                        return tag;
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
        deleteTag(index){
            let tag = Object.assign({}, this.tags[index]);
            tag._token = $('input[name=_token]').val();

            const customAlert = swal({
                title: 'Warning',
                text: `Are you sure you want to delete this tag? This action cannot be undone.`,
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
                    axios.delete(this.url.deleteTag, {data: tag})
                        .then(response => {
                            this.isLoading = false;
                            this.tags.splice(index, 1);
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

        addTemplate() {
            this.isUpload = false;
            this.isLoading = true;
            this.template.tags = $("#template-tags").val();

            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.template.name);
            formData.append('template', this.template.template);
            formData.append('tags', JSON.stringify(this.template.tags));
            formData.append('objective_id', this.objective.id);
            // this.isLoading = true;

                axios.post(this.url.createTemplate, formData)
                    .then((response) => {
                        $('#add-template').modal('hide');
                            this.template = {
                                objective_id: 0,
                                name: '',
                                template: '',
                                tags:[]
                            }
                    
                        this.$notify({
                            title: 'Success',
                            message: response.data.message,
                            type: 'success'
                        });
                        this.isUpload = true;
                        this.isLoading = false;
                        this.templates.push(Object.assign({}, response.data.template, {}));
                        $("#template-tags").select2().val([]).trigger('change');
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
        selectTemplate(index){
            this.templateEdit = Object.assign({}, this.templates[index]);
            var tags = Object.values(this.templateEdit.tags);
            $("#template-edit-tags").select2().val(tags).trigger('change');
        },
        updateTemplate(){
            this.isUpload = false;
            this.isLoading = true;
            this.templateEdit.tags = $("#template-edit-tags").val();

            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('name', this.templateEdit.name);
            formData.append('template', this.template.template);
            formData.append('tags', JSON.stringify(this.template.tags));

            formData.append('id', this.templateEdit.id);
            // this.isLoading = true;

            axios.post(this.url.updateTemplate, formData)
                .then((response) => {
                    $('#edit-template').modal('hide');
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isUpload = true;
                    this.isLoading = false;
                    let editTemplate = response.data.template;
                    this.templates = this.templates.map((template) => {
                        if (template.id === editTemplate.id) {
                            template = Object.assign({}, editTemplate);
                        }
                        return template;
                    });
                    $("#template-edit-tags").select2().val([]).trigger('change');
                    this.templateEdit = {
                        id: '',
                        name: '',
                        objective_id: 0,
                        template: '',
                        tags: []
            
                    }

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
        deleteTemplate(index){
            let template = Object.assign({}, this.templates[index]);
            template._token = $('input[name=_token]').val();

            const customAlert = swal({
                title: 'Warning',
                text: `Are you sure you want to delete this template? This action cannot be undone.`,
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
                    axios.delete(this.url.deleteTemplate, {data: template})
                        .then(response => {
                            this.isLoading = false;
                            this.templates.splice(index, 1);
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
