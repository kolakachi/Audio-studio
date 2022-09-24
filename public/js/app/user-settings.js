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
        user: {
            id:'',
            name: '',
            email : ``,
            password: ``,
            confirm_password:'',
        },
        url :{
            update_details: ``,
            update_password:``,
        }
        
    },
    mounted(){
        this.url.update_details = $("#update-details").val();
        this.url.update_password = $("#update-password").val();

        let user = JSON.parse($("#user-details").val());
        this.user.id = user.id;
        this.user.name = user.name;
        this.user.email = user.email;

    },
    methods: {
        updateDetails(){
            const formData = new FormData();

            for ( var key in this.user ) {
                formData.append(key, this.user[key]);
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

        updatePassword(){
            const formData = new FormData();

            for ( var key in this.user ) {
                formData.append(key, this.user[key]);
            }
            formData.append('_token', $('input[name=_token]').val());
            this.isLoading = true;

            axios.post(this.url.update_password, formData)
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

        // updateSMTPDetails(){
        //     const formData = new FormData();

        //     for ( var key in this.whitelabelConfig ) {
        //         let value = this.whitelabelConfig[key];
        //         formData.append(key, value);
        //     }
        //     formData.append('_token', $('input[name=_token]').val());
        //     this.isLoading = true;

        //     axios.post(this.url.update_smtp_details, formData)
        //         .then((response) => {
        //            this.$notify({
        //                 title: 'Success',
        //                 message: response.data.message,
        //                 type: 'success'
        //             });
        //             this.isLoading = false;
                    
        //         })
        //         .catch((error) => {
        //             // this.isLoading = false;
        //             if(error.response){
        //                 this.$notify.error({
        //                     title: 'Error',
        //                     message: error.response.data.message
        //                 });
        //                 this.isLoading = false;
        //             }else{
        //                 this.$notify.error({
        //                     title: 'Error',
        //                     message: 'oops! Unable to complete request.'
        //                 });
        //                 this.isLoading = false;
        //             }

        //         });
        // },
        // openFileInput(){
        //     $("#logo-input").click();
        // },
        // readImage(){
        //     if (window.File && window.FileList && window.FileReader) {
        //         var files = event.target.files; //FileList object
        //         var file = files[0];
        //         this.whitelabelConfig.image_file = file;
        //         this.whitelabelConfig.media_path = window.URL.createObjectURL(file);
                
        //     }
        // },
        // uploadImage(){
        //     let formData = new FormData();
        //     formData.append('image_file', this.whitelabelConfig.image_file);
        //     formData.append('_token', $('input[name=_token]').val());
        //     this.isUploading = true;

        //     axios.post(this.url.update_logo, formData,{
        //         headers: {
        //             'Content-Type': 'multipart/form-data'
        //         },
        //     })
        //     .then((response) => {
        //         this.isLoading = false;
        //         this.$notify({
        //             title: 'Success',
        //             message: 'Logo uploaded',
        //             type: 'success'
        //         });
                
        //     })
        //     .catch( (error) => {

        //         this.$notify.error({
        //             title: 'Error',
        //             message: 'oops! Unable to complete request.'
        //         });

        //         this.isLoading = false;
        //     });
        // },

        // updateWelcomeEmail(){
        //     const formData = new FormData();
        //     this.whitelabelConfig.welcome_mail = tinymce.get('emailEditor').getContent();

        //     for ( var key in this.whitelabelConfig ) {
        //         let value = this.whitelabelConfig[key];
        //         formData.append(key, value);
        //     }
        //     formData.append('_token', $('input[name=_token]').val());
        //     this.isLoading = true;

        //     axios.post(this.url.update_welcome_email, formData)
        //         .then((response) => {
        //            this.$notify({
        //                 title: 'Success',
        //                 message: response.data.message,
        //                 type: 'success'
        //             });
        //             this.isLoading = false;
                    
        //         })
        //         .catch((error) => {
        //             // this.isLoading = false;
        //             if(error.response){
        //                 this.$notify.error({
        //                     title: 'Error',
        //                     message: error.response.data.message
        //                 });
        //                 this.isLoading = false;
        //             }else{
        //                 this.$notify.error({
        //                     title: 'Error',
        //                     message: 'oops! Unable to complete request.'
        //                 });
        //                 this.isLoading = false;
        //             }

        //         });
        // },
        
    }
})
