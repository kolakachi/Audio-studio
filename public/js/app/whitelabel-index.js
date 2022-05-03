new Vue({
    el: "#whitelabel-app",
    data : {
        isLoading :false,
        searchQuery:'',
        sumOfUsers: 0,
        sumOfUsersToday: 0,
        sumOfUsersThisWeek: 0,
        activeUser: {},
        userWorkspaces: [],
        users: [],
        userAccess: [],
        workspaces: [],
        formErrors:[],
        selectedAll : false,
        whitelabelConfig: {
            app_name: '',
            domain : ``,
            color: ``,
            secondary_color:'',
            description: ``,
            logo: ``,
            support_url: ``,
            email: ``,
            welcome_mail: ``,
            mail_host: ``,
            mail_port: ``,
            mail_username: ``,
            mail_password: ``,
            mail_from_name: ``,
            mail_from_address:'',
            app_secret: ``,
            app_id: ``,
            encryption: ``,
            mail_from_address: ``,

            media_path: ``,
            image_file: {}
        },
        tinymceOptions: {},
        url :{
            update_details: ``,
            update_facebook_app: ``,
            update_smtp_details:``,
            update_logo:'',
            update_welcome_email: ``
        }
        
    },
    mounted(){
        this.url.update_details = $("#update-details").val();
        this.url.update_facebook_app = $("#update-facebook-details").val();
        this.url.update_smtp_details = $("#update-smtp-details").val();
        this.url.update_logo = $("#update-logo").val();
        this.url.update_welcome_email = $("#update-welcome-email").val();


        let whitelabelConfig = $("#white-label-config").val();
        this.whitelabelConfig = (whitelabelConfig == "null")? this.whitelabelConfig : JSON.parse(whitelabelConfig); 
        this.tinymceOptions = {
            height: 300,
            menubar: false,
            statusbar: false,
            toolbar_drawer: 'sliding',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount emoticons'
            ],
            toolbar: 'formatselect | bold italic | align | bullist numlist | forecolor backcolor | undo redo removeformat fullscreen',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ],
        };
        tinymce.init(Object.assign({}, this.tinymceOptions, {selector: '#emailEditor'}));
        // ClassicEditor.create(document.querySelector('#emailEditor')).catch((error) => {
        //     // eslint-disable-next-line no-console
        //     console.error(error);
        //   });

    },
    methods: {
        updateDetails(){
            const formData = new FormData();

            for ( var key in this.whitelabelConfig ) {
                let value = this.whitelabelConfig[key];
                formData.append(key, value);
            }
            formData.append('_token', $('input[name=_token]').val());
            this.isLoading = true;

            axios.post(this.url.update_details, formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            })
                .then((response) => {
                   this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isLoading = false;
                    
                })
                .catch((error) => {
                    // this.isLoading = false;
                    if(error.response){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                        this.isLoading = false;
                    }else{
                        this.$notify.error({
                            title: 'Error',
                            message: 'oops! Unable to complete request.'
                        });
                        this.isLoading = false;
                    }

                });
        },

        updateFacebookDetails(){
            const formData = new FormData();

            for ( var key in this.whitelabelConfig ) {
                let value = this.whitelabelConfig[key];
                formData.append(key, value);
            }
            formData.append('_token', $('input[name=_token]').val());
            this.isLoading = true;

            axios.post(this.url.update_facebook_app, formData)
                .then((response) => {
                   this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isLoading = false;
                    
                })
                .catch((error) => {
                    // this.isLoading = false;
                    if(error.response){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                        this.isLoading = false;
                    }else{
                        this.$notify.error({
                            title: 'Error',
                            message: 'oops! Unable to complete request.'
                        });
                        this.isLoading = false;
                    }

                });
        },

        updateSMTPDetails(){
            const formData = new FormData();

            for ( var key in this.whitelabelConfig ) {
                let value = this.whitelabelConfig[key];
                formData.append(key, value);
            }
            formData.append('_token', $('input[name=_token]').val());
            this.isLoading = true;

            axios.post(this.url.update_smtp_details, formData)
                .then((response) => {
                   this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isLoading = false;
                    
                })
                .catch((error) => {
                    // this.isLoading = false;
                    if(error.response){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                        this.isLoading = false;
                    }else{
                        this.$notify.error({
                            title: 'Error',
                            message: 'oops! Unable to complete request.'
                        });
                        this.isLoading = false;
                    }

                });
        },
        openFileInput(){
            $("#logo-input").click();
        },
        readImage(){
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files; //FileList object
                var file = files[0];
                this.whitelabelConfig.image_file = file;
                this.whitelabelConfig.media_path = window.URL.createObjectURL(file);
                
            }
        },
        uploadImage(){
            let formData = new FormData();
            formData.append('image_file', this.whitelabelConfig.image_file);
            formData.append('_token', $('input[name=_token]').val());
            this.isUploading = true;

            axios.post(this.url.update_logo, formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            })
            .then((response) => {
                this.isLoading = false;
                this.$notify({
                    title: 'Success',
                    message: 'Logo uploaded',
                    type: 'success'
                });
                
            })
            .catch( (error) => {

                this.$notify.error({
                    title: 'Error',
                    message: 'oops! Unable to complete request.'
                });

                this.isLoading = false;
            });
        },

        updateWelcomeEmail(){
            const formData = new FormData();
            this.whitelabelConfig.welcome_mail = tinymce.get('emailEditor').getContent();

            for ( var key in this.whitelabelConfig ) {
                let value = this.whitelabelConfig[key];
                formData.append(key, value);
            }
            formData.append('_token', $('input[name=_token]').val());
            this.isLoading = true;

            axios.post(this.url.update_welcome_email, formData)
                .then((response) => {
                   this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                    this.isLoading = false;
                    
                })
                .catch((error) => {
                    // this.isLoading = false;
                    if(error.response){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                        this.isLoading = false;
                    }else{
                        this.$notify.error({
                            title: 'Error',
                            message: 'oops! Unable to complete request.'
                        });
                        this.isLoading = false;
                    }

                });
        },
        
    }
})
