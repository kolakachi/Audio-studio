new Vue({
    el: "#agency-index",
    data : {
        activeAsset: {
            title:'',
            agency_url: '',
            popup_url: '',
            description:'',
            preview_url: '',
            download_url:''

        },
        assets:[
            {
                title:"DFY Agency Website", 
                agency_url:"/assets/img/AGENCY/DESKTOP.png", 
                popup_url:"/assets/img/POP_UP/DESKTOP_1.png",
                description: 'We have created an editable high-converting agency website for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a web designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Agency website is rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/1F5zpGDqcOC_lt1Y8bBY7Ad450Va-uryu?usp=sharing',
                download_url:'https://drive.google.com/drive/folders/1F5zpGDqcOC_lt1Y8bBY7Ad450Va-uryu?usp=sharing'
            },
            {
                title:"Letterhead", 
                agency_url:"/assets/img/AGENCY/LETTERHEAD.png", 
                popup_url:"/assets/img/POP_UP/LETTERHEAD_2.png",
                description: 'We have created some editable highly-engaging Letterheads for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Letterheads are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/18IL8YxFBNUexBzekEd6LCXXXR9h8emVe?usp=sharing',
                download_url:'https://drive.google.com/drive/folders/18IL8YxFBNUexBzekEd6LCXXXR9h8emVe?usp=sharing'
            },
            {
                title:"Invoice", 
                agency_url:"/assets/img/AGENCY/INVOICE.png", 
                popup_url:"/assets/img/POP_UP/INVOICE.png",
                description: 'We have created some editable highly-engaging Invoices for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This invoices are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/1p7EysyiHAqpWI1knwtO_erXQXU60OeGJ?usp=sharing',
                download_url:'https://drive.google.com/drive/folders/1p7EysyiHAqpWI1knwtO_erXQXU60OeGJ?usp=sharing'
            },
            {
                title:"Brochure", 
                agency_url:"/assets/img/AGENCY/BROCHURE.png", 
                popup_url:"/assets/img/POP_UP/BROCHURE_1.png",
                description: 'We have created some easily editable, highly-engaging Brochures for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information, edit to your taste to suit your marketing goals. This Brochures are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/1BsliU4h37b8VTPKfB6lKscKN0Y8oblwy?usp=sharing',
                download_url:'https://drive.google.com/drive/folders/1BsliU4h37b8VTPKfB6lKscKN0Y8oblwy?usp=sharing'
            },
            {
                title:"Business Card", 
                agency_url:"/assets/img/AGENCY/BUSINESS_CARD.png", 
                popup_url:"/assets/img/POP_UP/BUSINESS_CARD_1.png",
                description: 'We have created some editable highly-engaging Business Cards for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Business cards are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/file/d/16kNUbtvwbHaNvzEBkXRUfiiBR5XmfH-e/view?usp=sharing',
                download_url:'https://drive.google.com/file/d/16kNUbtvwbHaNvzEBkXRUfiiBR5XmfH-e/view?usp=sharing'
            },
            {
                title:"Powerpoint Proposal", 
                agency_url:"/assets/img/AGENCY/POWERPOINT.png", 
                popup_url:"/assets/img/POP_UP/POWERPOINT_1.png",
                description: 'We have created some editable highly-engaging Powerpoint Proposals for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Powerpoint Proposals are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/file/d/15aV-KnZ3k2Xax4w83z6P-L7hGXmAr0ej/view?usp=sharing',
                download_url: "https://drive.google.com/file/d/15aV-KnZ3k2Xax4w83z6P-L7hGXmAr0ej/view?usp=sharing"
            },
            {
                title:"Video Presentation", 
                agency_url:"/assets/img/AGENCY/VIDEO_PRESENTATION.png", 
                popup_url:"/assets/img/POP_UP/VIDEO_PRESENTATION_1.png",
                description: 'We have created some editable highly-converting Video presentations for you by our team of expert video editors. So you’ll no longer have to pay or hire a Video editor anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Video presentations are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/file/d/15aV-KnZ3k2Xax4w83z6P-L7hGXmAr0ej/view?usp=sharing',
                download_url:'https://drive.google.com/file/d/15aV-KnZ3k2Xax4w83z6P-L7hGXmAr0ej/view?usp=sharing'
            },
            {
                title:"Flyer", 
                agency_url:"/assets/img/AGENCY/FLYER_DESIGN.png", 
                popup_url:"/assets/img/POP_UP/FLYER_1.png",
                description: 'We have created some editable highly-engaging Flyer Designs for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Flyer designs are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/1fY0NzdvnvhYfWbNMxidXzpMUNaJoJntq?usp=sharing',
                download_url: 'https://drive.google.com/drive/folders/1fY0NzdvnvhYfWbNMxidXzpMUNaJoJntq?usp=sharing'
            },
            {
                title:"Legal Contract", 
                agency_url:"/assets/img/AGENCY/LEGAL_CONTRACT.png", 
                popup_url:"/assets/img/POP_UP/LEGAL_CONTRACT_1.png",
                description: 'We have created some editable highly-engaging Legal contracts for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a writer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Legal contracts are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/file/d/1AZ5TrtBaGulgyny3hPjzsAsCbfctEjCA/view',
                download_url: "https://drive.google.com/file/d/1AZ5TrtBaGulgyny3hPjzsAsCbfctEjCA/view"
            },
            {
                title:"Ad Banner", 
                agency_url:"/assets/img/AGENCY/ADS_BANNER.png", 
                popup_url:"/assets/img/POP_UP/ADS_BANNER_1.png",
                description: 'We have created some editable highly-engaging Ad Banners for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Ad Banners are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/1gJsIIyUxeHgQU88y7OyWGwhDFmlNzaP8?usp=sharing',
                download_url:'https://drive.google.com/drive/folders/1gJsIIyUxeHgQU88y7OyWGwhDFmlNzaP8?usp=sharing'
            },
            {
                title:"Email Sequence", 
                agency_url:"/assets/img/AGENCY/EMAIL_SEQUENCE.png", 
                popup_url:"/assets/img/POP_UP/EMAIL_SEQUENCE_1.png",
                description: 'We have created some editable highly-converting Email sequence for you by our team of expert writers, so you’ll no longer have to pay or hire a copywriter anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Email sequence are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/drive/folders/1xG9PLgRAPQWiAlGbXtobhIluV3tHatDU',
                download_url: 'https://drive.google.com/drive/folders/1xG9PLgRAPQWiAlGbXtobhIluV3tHatDU'
            },
            {
                title:"Telemarketing Script", 
                agency_url:"/assets/img/AGENCY/TELEMARKETING_SCRIPT.png", 
                popup_url:"/assets/img/POP_UP/TELEMARKETING_SCRIPT_1.png",
                description: 'We have created some editable highly-engaging & converting Telemarketing Scripts for you by our team of expert designers and writers, so you’ll no longer have to pay or hire a graphics designer  or copywriter anymore. All you need to do is to add your Logo and contact information to suit your marketing goals. This Telemarketing scripts are rated 5star by our early users.',
                preview_url: 'https://drive.google.com/file/d/1mdDAXKYXEb7PRIfp3vNQHACZgQvvXNxI/view',
                download_url: "https://drive.google.com/file/d/1mdDAXKYXEb7PRIfp3vNQHACZgQvvXNxI/view"
                
            }
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
