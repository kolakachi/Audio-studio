import {threadModel} from './ThreadModel.js';

(function ($) {
    var subjectLinePlaceholders = placeholders;
    subjectLinePlaceholders.unshift({
        variable_example : "Name of your campaign",
        variable_label : "What is the name of your campaign ?",
        variable_placeholder : "campaign_name",
        variable_type: "Text"
    })
    var subjectLineData = {};
    $(document).on('click', '#scriptAiModalButton',function () {
        sayHello();
        setTimeout(createButton, 1000);
        $(document).on('click', '.generate-button',  function(){
            var parent = $(this).parent().parent();
            parent.hide('slow', function(){ parent.remove(); });

            createUserReply(userImage);
            createThinkingBubble();
            setTimeout(function (){
                createResponse("Yes, lets do this");
                setTimeout(function(){
                    createResponse(subjectLinePlaceholders[0].variable_label);
                    setTimeout(function(){
                        createInput(subjectLinePlaceholders[0].variable_example);
                    }, 1000);
                }, 1000);

            }, 1000);
        });

        $(document).on('keyup', '.reply-input', function(event){
            if (event.keyCode == 13 && $(this).val() != "") {
                var parent = $(this).parent().parent();
                parent.hide('slow', function(){ parent.remove(); });

                subjectLineData[subjectLinePlaceholders[0].variable_placeholder] = $(this).val();
                subjectLinePlaceholders.shift();

                if(subjectLinePlaceholders.length > 0){
                    createUserReply(userImage, $(this).val());
                    createThinkingBubble();

                    setTimeout(function (){
                        setTimeout(function(){
                            createResponse(subjectLinePlaceholders[0].variable_label);
                            setTimeout(function(){
                                createInput(subjectLinePlaceholders[0].variable_example);
                            }, 1000);
                        }, 1000);

                    }, 1000);
                }else{
                    createUserReply(userImage, $(this).val());
                    createThinkingBubble();

                    setTimeout(function (){
                        setTimeout(function(){
                            createResponse("Thank you so much for your responses<br /> please wait while we process your headlines");
                            setTimeout(function(){
                                createThinkingBubble();
                                setLoader();
                                setTimeout(function(){
                                    generateSubjectHeadLine(subjectLineData);
                                }, 2000);
                            }, 1000);
                        }, 1000);

                    }, 1000);
                }
            }
        });
    });
})(jQuery);

function sayHello(){
    let avatar = threadModel.avatar;
    let welcomeBubble = threadModel.chatThread;

    let newThread = threadModel.createNewThread("row", avatar, welcomeBubble);
    let threadContainer = threadModel.createThreadContainer("chat-item", newThread);
    let newThreadContainer = $(threadContainer);
    newThreadContainer.appendTo('#thread-main-container');
    newThreadContainer.animate({
        left: '300px',
        opacity: '0.8'
    }, 'slow');
}

function createButton(){
    let avatar = threadModel.avatar;
    let btnClasses = "btn btn-primary generate-button";
    let btnContent = "<span>Generate a Subject Line</span>";
    let firstButton = threadModel.createThreadButton(btnContent, btnClasses);
    let newThread = threadModel.createNewThread("row", avatar, firstButton);
    let threadContainer = threadModel.createThreadContainer("col-12 mt-3", newThread);
    let newThreadContainer = $(threadContainer);
    newThreadContainer.appendTo('#thread-main-container');
    newThreadContainer.animate({
        left: '300px',
        opacity: '0.8'
    }, 'slow');


}

function createResponse(text){
    $('#thread-main-container').find('.thinking-bubble').remove();
    let avatar = threadModel.avatar;
    let chatBubble = threadModel.createThreadBubble(text, "bubble-paragraph", "card p-2");
    let newThread = threadModel.createNewThread("row", avatar, chatBubble);
    let threadContainer = threadModel.createThreadContainer("col-12 mt-3", newThread);
    let newThreadContainer = $(threadContainer);

    newThreadContainer.appendTo('#thread-main-container');
    newThreadContainer.animate({
        left: '300px',
        opacity: '0.8'
    }, 'slow');
    autoScroll();
}

function createUserReply(gravatar, reply = "Generate a Subject Line"){
    let imgsrc = gravatar;
    let imgClasses = "align-self-center rounded-circle thread-avatar";
    let avatar = threadModel.createThreadAvatar(imgsrc, imgClasses);
    let welcomeBubble = threadModel.createThreadBubble(reply, "bubble-paragraph", "card p-2 mr-2");

    let newThread = threadModel.createNewThread("row float-right", welcomeBubble, avatar);
    let threadContainer = threadModel.createThreadReplyContainer("col-12 mt-3 float-right", newThread);
    let newThreadContainer = $(threadContainer);
    newThreadContainer.appendTo('#thread-main-container');
    newThreadContainer.animate({
        right: '0px',
        opacity: '0.8'
    }, 'slow');

    autoScroll();
}

function createInput(placeholder){
    let avatar = threadModel.avatar;
    let inputElement = threadModel.createThreadTextInput("form-control reply-input", "form-group col-7 p-0", placeholder);
    let newThread = threadModel.createNewThread("row", avatar, inputElement);
    let threadContainer = threadModel.createThreadContainer("col-12 mt-3", newThread);
    let newThreadContainer = $(threadContainer);

    newThreadContainer.appendTo('#thread-main-container');
    newThreadContainer.animate({
        left: '300px',
        opacity: '0.8'
    }, 'slow');

    autoScroll();
}

function createThinkingBubble(){
    let avatar = threadModel.avatar;
    let chatBubble = threadModel.createThreadThinkingBubble();
    let newThread = threadModel.createNewThread("row", avatar, chatBubble);
    let threadContainer = threadModel.createThreadContainer("col-12 mt-3 thinking-bubble", newThread);
    let newThreadContainer = $(threadContainer);

    newThreadContainer.appendTo('#thread-main-container');
    newThreadContainer.animate({
        left: '300px',
        opacity: '0.8'
    }, 'slow');

    autoScroll();
}

function autoScroll(){
    $('#thread-main-container').animate({
        scrollTop: $('#thread-main-container').get(0).scrollHeight
    }, 1000);
}

function generateSubjectHeadLine(subjectLineData){
    subjectLineData._token = $('input[name=_token]').val();
    var url = '/subjectlinewriter/add';
    $.post(url, subjectLineData, function(data){

        if(data.status_code == 201){

            window.location = data.url;

        }
    }).fail(function(jqXHR, textStatus, error) {
        if(jqXHR.status == 401){
            window.location = "/logout";
        }else if(jqXHR.status == 500){
            var message = "Unable to complete request."
            createResponse(message);
            location.reload();
        }else{
            location.reload();
        }

    });
}

function setLoader(){
    $(".loader-box").removeAttr("style");
}
