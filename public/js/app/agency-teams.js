new Vue({
    el: "#agency-teams",
    data : {
        requestIsLoading :false,
        searchQuery:'',
        sumOfUsers: 0,
        sumOfUsersToday: 0,
        sumOfUsersThisWeek: 0,
        user: {
            first_name : '',
            last_name: '',
            email: '',
            role: 'member',
            password: '',
            confirm_password: '',
        },
        userEdit: {
            first_name : '',
            last_name: '',
            email: '',
            role: 'member',
            password: '',
            confirm_password: '',
        },
        activeUser: {},
        userWorkspaces: [],
        users: [],
        userAccess: [],
        workspaces: [],
        formErrors:[],
        selectedAll : false,
        url :{
            add: ``,
            delete: ``,
            update:``,
            search:'',
            updatePassword: ``,
            updateSub: ``,
            getLink : `{{ route('post.normal.link')}}`,

            jvz : {
                front_end : '',
                unlimited_pro : '',
                dfy_audiences: '',
                agency : '',
                agency_second : '',
            },
        },
        subscriptions: {
            front_end : {
                id: '',
                status: true,
                limit: 0,
                start_date:'',
                end_date:'',
                type:'',
                config: {}
            },
            unlimited_pro : {
                id: '',
                status: false,
                limit: 0,
                start_date:'',
                end_date:'',
                type:'',
                config: {}
            },
            dfy_audiences : {
                id: '',
                status: false,
                limit: 0,
                start_date:'',
                end_date:'',
                type:'',
                config: {}
            },
            agency : {
                id: '',
                status: false,
                limit: 0,
                start_date:'',
                end_date:'',
                type:'',
                config: {}
            },
            // agency_second : {
            //     id: '',
            //     status: false,
            //     limit: 0,
            //     start_date:'',
            //     end_date:'',
            //     type:'',
            //     config: {}
            // },
        },
        newSubscriptions: {
            'front_end': {
                'id' :  '',
                'status' : false,
                'limit' :  0,
                'start_date' : '',
                'end_date' : '',
                'type' : '',
                'name' : 'Front End',
                'config' : {
                    'ads_search' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'normal_post' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'cta_post' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'slide_post' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'rules' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'hash_tag' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'caption' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'team_members' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'workspaces' : {
                        'duration' : '',
                        'count' : 0
                    },
                }
        
            },
            'unlimited_pro' : {
                'id' :  '',
                'status' :  false,
                'limit' :  0,
                'limit' :  0,
                'subscription_id' :  0,
                'end_date' : '',
                'type' :  '',
                'name' : 'Unlimited Pro',
                'config' : {
                    'team_members' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'workspaces' : {
                        'duration' : '',
                        'count' : 0
                    },
                },
            },
            'dfy_audiences' : {
                'id' : '',
                'status' :  false,
                'limit' :  0,
                'subscription_id' :  0,
        
                'start_date' : '',
                'end_date' :  '',
                'type' :  '',
                'name' : 'DFY Audiences',
                'config' : [],
            },
            'agency'  : {
                'id' : '',
                'status' : false,
                'limit' : 0,
                'subscription_id' : 0,
        
                'start_date' : '',
                'end_date' : '',
                'type' : '',
                'name' : 'Agency',
                'config' : {
                    'team_members' : {
                        'duration' : '',
                        'count' : 0
                    },
                    'workspaces' : {
                        'duration' : '',
                        'count' : 0
                    },
                },
            },
        },
        
    },
    mounted(){

        this.url.jvz.front_end = $("#jv_front_end").val();
        this.url.jvz.unlimited_pro = $("#jv_unlimited_pro").val();
        this.url.jvz.dfy_audiences = $("#jv_dfy_audiences").val();
        this.url.jvz.agency = $("#jv_agency").val();
        this.url.jvz.agency_second = $("#jv_agency_second").val();

        this.url.add = $("#user-create").val();
        this.url.act = $("#act-url").val() + '/';

        this.url.update = $("#update-details").val();
        this.url.delete = $("#user-delete").val();
        this.url.updateSub = $("#update-subscriptions").val();
        this.url.search = $("#user-search-url").val();

        this.url.updatePassword = $("#update-password").val();
        if($("#users").val()){
            this.users = JSON.parse($("#users").val());
        }

        // this.sumOfUsers = $("#sumOfUsers").val();
        // this.sumOfUsersToday = $("#sumOfUsersToday").val();
        // this.sumOfUsersThisWeek = $("#sumOfUsersThisWeek").val();

        // this.activeUser = JSON.parse($("#active-user").val());

        // this.workspaces = JSON.parse($("#workspaces").val());
        // this.newSubscriptions = this.getEmptySub();
        var vueInstance = this;
        $(document).on('click', ".edit-user", function(){
            var index = $(this).data('id');
            var selectedUser = vueInstance.users[index];
            vueInstance.editMember(index);
        });

        $(document).on('click', ".delete-user", function(){
            var index = $(this).data('id');
            vueInstance.deleteMember(index);
        });
        $(document).on('click', ".user-password", function(){
            var index = $(this).data('id');
            var selectedUser = vueInstance.users[index];
            vueInstance.changeMemberPassword(index);
        });

        $(document).on('click', ".user-sub", function(){
            var index = $(this).data('id');
            var selectedUser = vueInstance.users[index];
            vueInstance.editSubscriptions(selectedUser);
        });

    },
    methods: {
        copyLink(link){

            var webhook = link;

            const el = document.createElement('textarea');
            el.value =  webhook;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            el.style.zIndex = 2050;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            if(document.execCommand("copy")) {
                this.$notify({
                    title: 'Success',
                    message: 'IPN link copied',
                    type: 'success'
                });
                document.body.removeChild(el);

            }else{
                this.$notify.error({
                    title: 'Error',
                    message: 'Unable to copy IPN link'
                });
                document.body.removeChild(el);

            }
        },
        editSubscriptions(user){
            this.userEdit = Object.assign({}, user, {});
            this.subscriptions = user.subscriptions;
        },
        searchUser(){
            let formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('search_query', this.searchQuery);
            this.requestIsLoading = true;
            axios.post(this.url.search, formData)
                .then((response) => {
                    this.users = response.data.users;
                    // this.$notify({
                    //     title: "Success",
                    //     message: response.data.message,
                    //     type: "success"
                    // });
                    this.requestIsLoading = false;
                })
                .catch( (error) => {
                    if(error.response){
                        if(error.response.status == 400){
                            let formErrors = error.response.data.errors;
                            for ( var key in formErrors ) {
                                this.formErrors.push(formErrors[key][0]);
                            }
                        }
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message
                        });
                    }

                     this.requestIsLoading = false;
                });
        },
        storeUser(){
            let formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            this.requestIsLoading = true;
            formData.append('subscriptions', JSON.stringify(this.newSubscriptions));

            for ( var key in this.user ) {
                let value = this.user[key];
                formData.append(key, value);
            }

            axios.post(this.url.add, formData)
                .then((response) => {
                    this.users.push(response.data.user);
                    this.$notify({
                        title: "Success",
                        message: response.data.message,
                        type: "success"
                    });
                    this.sumOfUsers = response.sumOfUsers;
                    this.sumOfUsersToday = response.sumOfUsersToday;
                    this.sumOfUsersThisWeek = response.sumOfUsersThisWeek;

                    $("#agencyNewUser").modal('hide');
                    this.requestIsLoading = false;
                })
                .catch( (error) => {
                    if(error.response){
                        if(error.response.status == 400){
                            let formErrors = error.response.data.errors;
                            for ( var key in formErrors ) {
                                this.formErrors.push(formErrors[key][0]);
                            }
                        }
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message
                        });
                    }

                     this.requestIsLoading = false;
                });
        },
        userHasAccess(index){
            let workspace = this.workspaces[index];
            return this.userWorkspaces.includes(workspace.id);
        },
        selectAllWorkspaces(){
            let allAccess = this.userAccess;
            for (var i in allAccess) {
                if (this.selectedAll == false) {
                    allAccess[i].has_access = true;

                }else{
                    allAccess[i].has_access = false;
                }
            }
        },
        addMember(){
            this.userWorkspaces = [];
            this.userAccess = [];
            this.newSubscriptions = this.getEmptySub();
            for(index in this.workspaces){
                let access = {
                    name : this.workspaces[index].name,
                    id : this.workspaces[index].id,
                    has_access: this.userHasAccess(index)
                }
                this.userAccess.push(Object.assign({}, access, {}));
                // console.log(this.userAccess);

            }
        },
        editMember(userIndex){
            this.userEdit = {};
            this.userEdit = Object.assign({}, this.users[userIndex], {});
            this.userAccess = [];
            this.userWorkspaces = this.userEdit.user_workspaces;
            for(index in this.workspaces){
                let access = {
                    name : this.workspaces[index].name,
                    id : this.workspaces[index].id,
                    has_access: this.userHasAccess(index)
                }
                this.userAccess.push(Object.assign({}, access, {}));
                // console.log(this.userAccess);

            }

        },
        changeMemberPassword(userIndex){
            this.userEdit = {};
            this.userEdit = Object.assign({}, this.users[userIndex], {});
        },
        deleteMember(index){
            this.userEdit = {};
            this.userEdit = Object.assign({}, this.users[index], {});
            this.userEdit.index = index;
        },
        updateUser(){
            let formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            this.requestIsLoading = true;
            for ( var key in this.userEdit ) {
                let value = this.userEdit[key];
                formData.append(key, value);
            }

            axios.post(this.url.update, formData)
                .then((response) => {
                    let updatedUser = response.data.user;
                    this.users = this.users.map((user, index) => {
                        if (user.id === updatedUser.id) {
                            user = Object.assign({}, updatedUser);
                        }
                        return user;
                    })
                    this.requestIsLoading = false;

                    // this.users.push(response.data.user);
                    this.$notify({
                        title: "Success",
                        message: response.data.message,
                        type: "success"
                    });
                    $("#editModal").modal('hide');
                })
                .catch( (error) => {
                    if(error.response){
                        if(error.response.status == 400){
                            let formErrors = error.response.data.errors;
                            for ( var key in formErrors ) {
                                this.formErrors.push(formErrors[key][0]);
                            }
                        }
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message
                        });
                    }

                     this.requestIsLoading = false;
                });
        },
        updateUserPassword(){
            let formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            this.requestIsLoading = true;
            for ( var key in this.userEdit ) {
                let value = this.userEdit[key];
                formData.append(key, value);
            }

            axios.post(this.url.updatePassword, formData)
                .then((response) => {
                    this.requestIsLoading = false;
                    // let updatedUser = response.data.user;
                    // this.users = this.users.map((user, index) => {
                    //     if (user.id === updatedUser.id) {
                    //         user = Object.assign({}, updatedUser);
                    //     }
                    //     return user;
                    // })
                    // this.users.push(response.data.user);
                    this.$notify({
                        title: "Success",
                        message: response.data.message,
                        type: "success"
                    });
                    $("#passwordModal").modal('hide');
                })
                .catch( (error) => {
                    if(error.response){
                        if(error.response.status == 400){
                            let formErrors = error.response.data.errors;
                            for ( var key in formErrors ) {
                                this.formErrors.push(formErrors[key][0]);
                            }
                        }
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message
                        });
                    }

                     this.requestIsLoading = false;
                });
        },
        deleteUser(){

            let user = {
                id: this.userEdit.id,
                _token: $('input[name=_token]').val()
            };
            let index = this.userEdit.index;
            axios.delete(this.url.delete, {data: user})
                .then(response => {
                    this.requestIsLoading = false;
                    this.users.splice(index, 1);
                    $("#deleteModal").modal('hide');

                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });

                    this.sumOfUsers = response.sumOfUsers;
                    this.sumOfUsersToday = response.sumOfUsersToday;
                    this.sumOfUsersThisWeek = response.sumOfUsersThisWeek;

                }).catch(error => {
                    if (error.response) {
                        this.requestIsLoading = false;
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                    }else{
                        this.requestIsLoading = false;
                        this.$notify.error({
                            title: 'Error',
                            message: "Unable to complete request. Try again Later"
                        });
                    }
                });
        },

        updateUserSubscriptions(){
            let formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('subscriptions', JSON.stringify(this.subscriptions));
            formData.append('id', this.userEdit.id);
            this.requestIsLoading = true;
            axios.post(this.url.updateSub, formData)
                .then((response) => {
                    let updatedUser = response.data.user;
                    this.users = this.users.map((user, index) => {
                        if (user.id === updatedUser.id) {
                            user = Object.assign({}, updatedUser);
                        }
                        return user;
                    });
                    this.requestIsLoading = false;

                    this.$notify({
                        title: "Success",
                        message: response.data.message,
                        type: "success"
                    });
                    $("#subscriptionModal").modal('hide');
                })
                .catch( (error) => {
                    if(error.response){
                        if(error.response.status == 400){
                            let formErrors = error.response.data.errors;
                            for ( var key in formErrors ) {
                                this.formErrors.push(formErrors[key][0]);
                            }
                        }
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message
                        });
                    }

                     this.requestIsLoading = false;
                });
        },

        getEmptySub (){
            return {
                'front_end': {
                    'id' :  '',
                    'status' : true,
                    'limit' :  0,
                    'start_date' : '',
                    'end_date' : '',
                    'type' : '',
                    'name' : 'Front End',
                    'config' : {
                        'ads_search' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'normal_post' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'cta_post' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'slide_post' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'rules' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'hash_tag' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'caption' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'team_members' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'workspaces' : {
                            'duration' : '',
                            'count' : 0
                        },
                    }
            
                },
                'unlimited_pro' : {
                    'id' :  '',
                    'status' :  false,
                    'limit' :  0,
                    'limit' :  0,
                    'subscription_id' :  0,
                    'end_date' : '',
                    'type' :  '',
                    'name' : 'Unlimited Pro',
                    'config' : {
                        'team_members' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'workspaces' : {
                            'duration' : '',
                            'count' : 0
                        },
                    },
                },
                'dfy_audiences' : {
                    'id' : '',
                    'status' :  false,
                    'limit' :  0,
                    'subscription_id' :  0,
            
                    'start_date' : '',
                    'end_date' :  '',
                    'type' :  '',
                    'name' : 'DFY Audiences',
                    'config' : [],
                },
                'agency'  : {
                    'id' : '',
                    'status' : false,
                    'limit' : 0,
                    'subscription_id' : 0,
            
                    'start_date' : '',
                    'end_date' : '',
                    'type' : '',
                    'name' : 'Agency',
                    'config' : {
                        'team_members' : {
                            'duration' : '',
                            'count' : 0
                        },
                        'workspaces' : {
                            'duration' : '',
                            'count' : 0
                        },
                    },
                },
            };
        },
        


    }
})
