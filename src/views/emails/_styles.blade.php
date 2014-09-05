{{-- based on http://internations.github.io/antwort/ --}}
<style type="text/css">
    /* Resets: see reset.css for details */
    .ReadMsgBody { width: 100%; background-color: #F8F8F8;}
    .ExternalClass {width: 100%; background-color: #F8F8F8;}
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
    body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color: #F8F8F8}
    body {margin:0; padding:0;}
    table {border-spacing:0;}
    table td {border-collapse:collapse;}
    .yshortcuts a {border-bottom: none !important;}


    /* Constrain email width for small screens */
    @media screen and (max-width: 600px) {
        table[class="container"] {
            width: 95% !important;
        }
    }

    /* Give content more room on mobile */
    @media screen and (max-width: 480px) {
        td[class="container-padding"] {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
    }

    /* Styles for forcing columns to rows */
    @media only screen and (max-width : 600px) {

        /* force container columns to (horizontal) blocks */
        td[class="force-col"] {
            display: block;
            padding-right: 0 !important;
        }

        table[class="col-2"] {
            /* unset table align="left/right" */
            float: none !important;
            width: 100% !important;

            /* change left/right padding and margins to top/bottom ones */
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* remove bottom border for last column/row */
        table[id="last-col-2"] {
            border-bottom: none !important;
            margin-bottom: 0;
        }

        /* align images right and shrink them a bit */
        img[class="col-2-img"] {
            float: right;
            margin-left: 6px;
            max-width: 130px;
        }

        table[class="col-3"] {
            /* unset table align="left/right" */
            float: none !important;
            width: 100% !important;

            /* change left/right padding and margins to top/bottom ones */
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* remove bottom border for last column/row */
        table[id="last-col-3"] {
            border-bottom: none !important;
            margin-bottom: 0;
        }

        /* align images right and shrink them a bit */
        img[class="col-3-img"] {
            float: right;
            margin-left: 6px;
            max-width: 130px;
        }
    }
</style>