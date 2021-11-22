export var threadModel = {
    avatar : `  <div class="chat-head">
                    <span class="icon">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                            <path
                                d="M0.810929 8.88671C0.15587 8.66836 0.149596 8.31573 0.823478 8.09111L24.7758 0.107424C25.4396 -0.113438 25.8199 0.258012 25.6341 0.908051L18.7899 24.8591C18.6017 25.5229 18.2189 25.5455 17.9378 24.9156L13.4277 14.7659L20.9571 4.72672L10.9179 12.2561L0.810929 8.88671Z"
                                fill="white"
                            ></path>
                        </svg>
                    </span>
                </div>`,
    chatThread : `  <div class="chat-bubble">
                        <p class="bubble-paragraph">Hey! 👋<br>My name is Nancy and I am an AI bot.<br> I am here to help you write attention grabing subject lines for your next email promo. <br>Are you ready?<br>
                        </p>
                    </div>`,
    threadButton : ``,

    createThreadAvatar : function (src, avatarClasses = "", containerClasses = ""){
        let html = `    <div class="${containerClasses}">
                            <img class="${avatarClasses}" src="${src}" alt=" ">
                        </div>`;

        return html;
    },

    createThreadBubble : function (innerHtml, bubbleClasses = "", containerClasses = ""){
        let html = `<div class="${containerClasses}">
                        <p class="${bubbleClasses}">${innerHtml}</p>
                    </div>`;

        return html;
    },

    createThreadButton : function (innerHtml, buttonClasses = ""){
        let html = `<button type="button" class="${buttonClasses}" >
                        ${innerHtml}
                    </button>
                    `;

        return html;
    },

    createThreadTextInput : function (inputClasses = "", containerClasses= "", placeholder=""){
        let html = `<div class="${containerClasses}">
                        <input class="${inputClasses}" type="text" placeholder="${placeholder}">
                    </div>`;

        return html;
    },

    createThreadThinkingBubble : function(){
        let html = `<div class="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>`;

        return html;
    },

    createThreadContainer  : function (classes, innerHtml){
        let html = `<div class="${classes}">${innerHtml}</div>`;

        return html;
    },

    createNewThread : function (classes, firstElement, secondElement =""){
        let html = `<div class="${classes}">${firstElement} ${secondElement}</div>`;

        return html;
    },

    createThreadReplyContainer  : function (classes, innerHtml){
        let html = `<div class="${classes}" style="right:-800px;">${innerHtml}</div>
                    <div class="clearfix"></div>`;

        return html;
    },

}
