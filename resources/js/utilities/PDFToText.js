export default function Pdf2TextClass(){
    var self = this;
    this.complete = 0;

    this.pdfToText = function(data, callbackPageDone, callbackAllDone){
        console.assert( data  instanceof ArrayBuffer  || typeof data == 'string' );
        var loadingTask = pdfjsLib.getDocument(data);
        loadingTask.promise.then(function(pdf) {


            var total = pdf._pdfInfo.numPages;
            //callbackPageDone( 0, total );        
            var layers = {};       
            for (var i = 1; i <= total; i++){
                pdf.getPage(i).then( function(page){
                    var n = page.pageNumber;
                    page.getTextContent().then( function(textContent){
                    
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
                        // }, 1000);              
                        }
                    }); // end  of page.getTextContent().then
                }); // end of page.then
            } // of for
        });
    }; // end of pdfToText()
};