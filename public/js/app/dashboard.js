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
        },
        query:[],
    },
    mounted() {
        this.url.upload = $("#upload-text-url").val();
    },
  
    methods: {
        openFileExplorer(){
            $("#doc-upload").click();
        },

        fileonUpload(event){
            var file = event.currentTarget.files[0];
            this.objectUrl = URL.createObjectURL(file);
            this.fileType = file.type;
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

        }

       
        
    }
    
})
