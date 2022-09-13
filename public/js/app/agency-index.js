new Vue({
    el: "#agency-index",
    data : {
        activeAsset: {
            title:'',
            agency_url: '',
            popup_url: '',

        },
        assets:[
            {title:"DFY Agency Website", agency_url:"/assets/img/AGENCY/DESKTOP.png", popup_url:"/assets/img/POP_UP/DESKTOP_1.png"},
            {title:"Letterhead", agency_url:"/assets/img/AGENCY/LETTERHEAD.png", popup_url:"/assets/img/POP_UP/LETTERHEAD_2.png"},
            {title:"Invoice", agency_url:"/assets/img/AGENCY/INVOICE.png", popup_url:"/assets/img/POP_UP/INVOICE.png"},
            {title:"Brochure", agency_url:"/assets/img/AGENCY/BROCHURE.png", popup_url:"/assets/img/POP_UP/BROCHURE_1.png"},
            {title:"Business Card", agency_url:"/assets/img/AGENCY/BUSINESS_CARD.png", popup_url:"/assets/img/POP_UP/BUSINESS_CARD_1.png"},
            {title:"Powerpoint Proposal", agency_url:"/assets/img/AGENCY/POWERPOINT.png", popup_url:"/assets/img/POP_UP/POWERPOINT_1.png"},
            {title:"Video Presentation", agency_url:"/assets/img/AGENCY/VIDEO_PRESENTATION.png", popup_url:"/assets/img/POP_UP/VIDEO_PRESENTATION_1.png"},
            {title:"Flyer", agency_url:"/assets/img/AGENCY/FLYER_DESIGN.png", popup_url:"/assets/img/POP_UP/FLYER_1.png"},
            {title:"Legal Contract", agency_url:"/assets/img/AGENCY/LEGAL_CONTRACT.png", popup_url:"/assets/img/POP_UP/LEGAL_CONTRACT_1.png"},
            {title:"Ad Banner", agency_url:"/assets/img/AGENCY/ADS_BANNER.png", popup_url:"/assets/img/POP_UP/ADS_BANNER_1.png"},
            {title:"Email Sequence", agency_url:"/assets/img/AGENCY/EMAIL_SEQUENCE.png", popup_url:"/assets/img/POP_UP/EMAIL_SEQUENCE_1.png"},
            {title:"Telemarketing Script", agency_url:"/assets/img/AGENCY/TELEMARKETING_SCRIPT.png", popup_url:"/assets/img/POP_UP/TELEMARKETING_SCRIPT_1.png"}
        ]
        
    },
    mounted(){

    },
    methods: {
        setActiveAsset(index){
            this.activeAsset = this.assets[index];
        }


    }
})
