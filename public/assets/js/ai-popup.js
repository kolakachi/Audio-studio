import data from './data.json' assert { type: "json" };

Vue.createApp({
    data() {
        return {
          stepCount: 0,
          demoStepCount: 0,
          stepOptions: data.options,
          intro:data.intro,
          questions: data.questions,
          conversation: [],
          answeredQuestions: [],
          isTyping: false,
          canType: false,
          done: false,
        };
    },
    methods: {
        // SET 'is typing..'
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
        askQuestion(question) {

            this.toggleTyping(question)

            this.conversation.push({
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
                    this.askQuestion({
                        hasOptions: false,
                        text: "Thank you for your response, we will get back to your shortly",
                    });
                    console.log(this.answeredQuestionList());
                }
                this.setTyping(false);
                this.incCount();
            }, 3);
        },

        // WHEN OPTION IS SELECTED
        selectOption(e) {
            e.preventDefault();
            let option = e.target.value;
            [...e.target].forEach((element,ind) => {
                if (ind != e.target.selectedIndex) {
                  element.setAttribute("disabled", "disabled");
                }
            });
            this.answeredQuestions.push({
                answer: option
            });
            this.nextQuestion();
        },

        // WHEN TEXT IS SENT
        sendMessage(e){
            if(this.canType == true && this.done == false){
                let value = this.$refs.answer.value;
                if(value.length > 0){
                    this.answeredQuestions.push({
                      answer: value,
                    });
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
            let md = this.$refs.modal
            md.style.display = "flex";
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
    mounted() {
        this.startConversation(3)
    },
    beforeUnmount(){
        this.resetEveryThing()
    }
}).mount("#ai-popup");
