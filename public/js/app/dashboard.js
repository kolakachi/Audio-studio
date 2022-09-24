function Pdf2TextClass(){
    var self = this;
    this.complete = 0;

    this.pdfToText = function(data, callbackPageDone, callbackAllDone){
        console.assert( data  instanceof ArrayBuffer  || typeof data == 'string' );
        var loadingTask = pdfjsLib.getDocument(data);
        loadingTask.promise.then(function(pdf) {


            var total = pdf._pdfInfo.numPages;
            //callbackPageDone( 0, total );        
            var layers = {};       
            for (i = 1; i <= total; i++){
                pdf.getPage(i).then( function(page){
                    var n = page.pageNumber;
                    page.getTextContent().then( function(textContent){
                    
                        //console.log(textContent.items[0]);0
                        if( null != textContent.items ){
                            var page_text = "";
                            var last_block = null;
                            for( var k = 0; k < textContent.items.length; k++ ){
                                var block = textContent.items[k];
                                if( last_block != null && last_block.str[last_block.str.length-1] != ' '){
                                    if( block.x < last_block.x )
                                        page_text += "\r\n"; 
                                    else if ( last_block.y != block.y && ( last_block.str.match(/^(\s?[a-zA-Z])$|^(.+\s[a-zA-Z])$/) == null ))
                                        page_text += ' ';
                                }
                                page_text += block.str;
                                last_block = block;
                            }

                            // textContent != null && console.log("page " + n + " finished."); //" content: \n" + page_text);
                            layers[n] =  page_text + "\n\n";
                        }
                        ++ self.complete;
                        //callbackPageDone( self.complete, total );
                        if (self.complete == total){
                            callbackPageDone(layers);

                        // window.setTimeout(function(){
                        //     var full_text = "";
                        //     var num_pages = Object.keys(layers).length;
                        //     for( var j = 1; j <= num_pages; j++)
                        //         full_text += layers[j] ;
                        //     // console.log(full_text);
                        // }, 1000);              
                        }
                    }); // end  of page.getTextContent().then
                }); // end of page.then
            } // of for
        });
    }; // end of pdfToText()
}; // end of class

new Vue({
    el: "#app-id",
    data : {
        isLoading: false,
        preview: false,
        objectUrl: "",
        fileType: "",
        fileName:'',
        books: [],
        filter: '',
        embed: '',
        selectedAudio:{},
        business_info: {
            name: '',
            phone_number: '',
            category: '',
            website: '',
            description: '',
            location: {

            },
            store_code: ''
        },
        url : {
            upload: '',

            create: "",
            update: "",
            edit: "",
            delete: "",
            download: "",
            embed: '',
            getBookURL:'',
            getResults:''
        },
        query:[],

        stepCount: 0,
        demoStepCount: 0,
        stepOptions: data.options,
        intro:data.intro,
        questions: data.questions,
        conversation: [],
        answeredQuestions: {},
        isTyping: false,
        canType: false,
        done: false,
        choices:[]
    },
    mounted() {
        this.url.upload = $("#upload-text-url").val();
        this.startConversation(3);

        this.url.create = $("#create-book-url").val();
        this.url.getResults = $("#get-ai-results-url").val();
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
        openFileExplorer(){
            $("#doc-upload").click();
        },

        fileonUpload(event){
            var file = event.currentTarget.files[0];
            this.objectUrl = URL.createObjectURL(file);
            this.fileType = file.type;
            this.fileName = event.currentTarget.files[0].name;
        },
        clearUpload(){
            this.objectUrl = '';
            this.fileType = '';
            this.fileName = '';
        },
        uploadFile(){
            this.isLoading = true;
            var ext = $("#doc-upload").val().split('.').pop();
            if(this.fileType.includes("text")){
                this.readTextFile();
            }

            if(this.fileType.includes("pdf")){
                this.readPDFFile();
            }

            if(ext == 'doc' || ext == 'docx'){
                this.generateDocxText();
            }
        },

        readTextFile() {
            var rawFile = new XMLHttpRequest();
            let vueInstance = this
            rawFile.open("GET", this.objectUrl, false);
            rawFile.onreadystatechange = function ()
            {
                if(rawFile.readyState === 4)
                {
                    if(rawFile.status === 200 || rawFile.status == 0)
                    {
                        var allText = rawFile.responseText;
                        vueInstance.uploadScrapedText(allText);
                    }
                }
            }
            rawFile.send(null);
        },

        readPDFFile() {
            var pdff = new Pdf2TextClass();
            pdff.pdfToText(this.objectUrl, this.getPDFText);
        },

        getPDFText(layers){
            var full_text = "";
            var num_pages = Object.keys(layers).length;
            for( var j = 1; j <= num_pages; j++){
                full_text += layers[j] ;
            }
            this.uploadScrapedText(full_text);
            // for( var j = 1; j <= num_pages; j++)
                
            
        },
        loadFile(url,callback){
            PizZipUtils.getBinaryContent(url,callback);
        },
        generateDocxText() {
            let vueInstance = this
            this.loadFile(this.objectUrl,function(error,content){
                if (error) { throw error };
    
                // The error object contains additional information when logged with JSON.stringify (it contains a properties object containing all suberrors).
                function replaceErrors(key, value) {
                    if (value instanceof Error) {
                        return Object.getOwnPropertyNames(value).reduce(function(error, key) {
                            error[key] = value[key];
                            return error;
                        }, {});
                    }
                    return value;
                }
    
                function errorHandler(error) {
                    console.log(JSON.stringify({error: error}, replaceErrors));
    
                    if (error.properties && error.properties.errors instanceof Array) {
                        const errorMessages = error.properties.errors.map(function (error) {
                            return error.properties.explanation;
                        }).join("\n");
                        console.log('errorMessages', errorMessages);
                        // errorMessages is a humanly readable message looking like this:
                        // 'The tag beginning with "foobar" is unopened'
                    }
                    throw error;
                }
    
                var zip = new PizZip(content);
                var doc = new window.docxtemplater(zip, { paragraphLoop: true, linebreaks: true });
                var text= doc.getFullText();
                vueInstance.uploadScrapedText(text);

                console.log(text);
            })
        },

        uploadScrapedText(text){
            const formData = new FormData();

            formData.append('_token', $('input[name=_token]').val());
            formData.append('text', text);

            this.isLoading = true;

            axios.post(this.url.upload, formData)
                .then((response) => {
                    this.isLoading = true;
                    window.location = response.data.url
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.$notify.error({
                        title: 'Error',
                        message: error.response.data.message
                    });
                })

        },

        setTyping(value){
            this.isTyping = value;
        },

        // DELAY EXECUTOR
        wait(execute, time = 1) {
            if(time == null){
                execute()
            }else{
                setTimeout(() => {
                    execute();
                }, time * 1000);
            }
        },

        // START CONVERSATION
        startConversation(time = 3) {
            this.wait(() => {
                this.setTyping(true);
    
                this.wait(() => {
                    this.setTyping(false);
                    this.introduceDemo(this.intro[this.readDemoCount()]);
                    this.setTyping(true);
                    this.incDemoCount();
                    if(this.intro.length > this.readDemoCount()){
                        this.startConversation(2);
                    }else{
                        this.startQuestionnaire();
                    }
                },time);
            },time)
        },

        // START ASKING QUESTION
        startQuestionnaire(){
            this.wait(() => {
                this.setTyping(false);
                this.askQuestion(this.questions[this.readCount()]);
                this.tickCurrentOption();
                this.incCount()
            }, 2);
        },

        // GET COUNT CURRENT VALUE
        readCount(){
            return this.stepCount;
        },

        // INCREMENT COUNTER
        incCount(){
            this.stepCount++;
            return this.stepCount;
        },

        // GET DEMO COUNTER CURRENT VALUE
        readDemoCount(){
            return this.demoStepCount;
        },

        // INCREMENT DEMO CONVERSATION STARTER
        incDemoCount(){
            this.demoStepCount++;
            return this.demoStepCount;
        },

        // TICK CURRENT OPTION
        tickCurrentOption(){
            this.stepOptions[this.stepCount].tick = true;
        },

        // CONVERSATION STARTER
        introduceDemo(demo){
            this.conversation.push({
              isAnswer: false,
              ...demo,
            });
        },

        // DEMO COUNT
        demoCount(){
            return this.intro.length;
        },

        // SET DONE TO TRUE
        closeConversation(){
            this.done = true;
        },

        // SET DONE TO FALSE
        openConversation(){
            this.done = false;
        },

        // TOGGLE TYPING
        toggleTyping(question){
            if (question.hasOptions == true) {
              this.canType = false;
            } else {
              this.canType = true;
            }
        },

        // ASK A QUESTION
        askQuestion(question, hasButton = false, textIndex = 0) {

            this.toggleTyping(question)

            this.conversation.push({
                hasButton: hasButton,
                textIndex: textIndex,
                isAnswer: false,
                ...question
            });
        },

        // LIST OF ANSWERED QUESTION
        answeredQuestionList(){
            let QnA = JSON.parse(JSON.stringify(this.answeredQuestions))
            return {QnA}
        },

        // REPLY TO A QUESTION BY TYPING
        replyQuestion(answer) {
            this.conversation.push({
                isAnswer: true,
                text: answer
            });
        },

        getQnA(){
            return this.answeredQuestionList();
        },

        // GO TO NEXT QUESTION
        nextQuestion() {
            this.setTyping(true);
            this.tickCurrentOption();
            this.wait(() => {
                if (this.questions.length > this.readCount()) {
                    this.askQuestion(this.questions[this.readCount()]);
                } else {
                    this.closeConversation()
                    
                    let formData = new FormData();
                    for ( var key in this.answeredQuestions ) {
                        let value = this.answeredQuestions[key];
                        formData.append(key, value);
                    }
                    this.isLoading = true;
                    axios.post(this.url.getResults, formData)
                        .then((response) => {
                            this.isLoading = false;

                            
                            this.choices = response.data.choices;
                            for(let key in this.choices){
                                this.askQuestion({
                                    hasOptions: false,
                                    text: this.choices[key].text,
                                }, true, key);
                            }

                            this.$notify({
                                title: 'Success',
                                message: response.data.message,
                                type: 'success'
                            });
                            
                        })
                        .catch((error) => {
                            this.isLoading = false;
                            this.$notify.error({
                                title: 'Error',
                                message: error.response.data.message
                            });
                        })

                    
                }
                this.setTyping(false);
                this.incCount();
            }, 3);
        },

        // WHEN OPTION IS SELECTED
        selectOption(e, question) {

            let option = e.target.value;
            this.replyQuestion(option);
            [...e.target].forEach((element,ind) => {
                if (ind != e.target.selectedIndex) {
                  element.setAttribute("disabled", "disabled");
                }
            });
            this.answeredQuestions[question]= option;
            // this.answeredQuestions.push({
            //     [question]: option
            // });
            this.wait(()=>{
                this.nextQuestion();
            },1.5)
        },

        // WHEN TEXT IS SENT
        sendMessage(e){
            if(this.canType == true && this.done == false){
                let value = this.$refs.answer.value;
                if(value.length > 0){
                    this.answeredQuestions["keywords"]= value;
                    // this.answeredQuestions.push({
                    //   [currentQuestion.question]: value,
                    // });
                    // console.log([currentQuestion, value]);
                    this.replyQuestion(value);
                    this.nextQuestion();
                }
            }
            this.clearInput()
        },

        clearInput(){
            this.$refs.answer.value = "";
        },

        resetEveryThing(){
            this.stepCount = 0;
            this.demoStepCount = 0;
            this.conversation = [];
            this.answeredQuestions = [];
            this.canType = false;
            this.done = false;
            this.clearInput();
            this.startConversation();
            this.stepOptions.map(option => option.tick = false)
        },

        closeModal(){
            let md = this.$refs.modal
            md.style.display = "none";
        },
        openModal(){
            document.getElementById('chatModal').style.display = 'flex';
        },
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
        
    },
    watch:{

        // SCROLL ON CHANGE
        conversation: {
            handler: function(newVal, oldVal){
                let chat = this.$refs.conversation;
                let scrollHeight = chat.scrollHeight + 200;
                chat.scrollBy(0, scrollHeight);
            },
            deep: true
        }
    },
    beforeUnmount(){
        this.resetEveryThing()
    }
    
})
