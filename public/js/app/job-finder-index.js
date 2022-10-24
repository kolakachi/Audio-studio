new Vue({
    el: "#job-finder",
    data : {
        requestIsLoading :false,
        searchQuery:'',
        url :{
            search: '',
            link: 'https://www.freelancer.com/projects/',
        },
        jobs:[]
        
    },
    mounted(){

        this.url.search = $("#job-finder-url").val();

    },
    methods: {
        
        searchUser(){
            let formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('search_query', this.searchQuery);
            this.requestIsLoading = true;
            axios.post(this.url.search, formData)
                .then((response) => {
                    this.jobs = response.data.jobs;
                    this.requestIsLoading = false;
                    console.log(this.jobs);
                })
                .catch( (error) => {
                    if(error.response){
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message
                        });
                    }

                     this.requestIsLoading = false;
                });
        },
    }
})
