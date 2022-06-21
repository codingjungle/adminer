;( function($, _, undefined){
    "use strict";
    ips.createModule('ips.ui.adminer.click', function(){
        /**
         * Respond to a dialog trigger
         *
         * @param   {element}   elem        The element this widget is being created on
         * @param   {object}    options     The options passed
         * @param   {event}     e           if lazyload, event that is fire
         * @returns {void}
         */
         var respond = function (elem, options, e) {
            let el = $(elem);
            if (!el.data('_loadedClickadminer')) {
                var mobject = new _loadedClickadminer(el, options);
                mobject.init();
                el.data('_loadedClickadminer', mobject);
            }
        },
        /**
         * Retrieve the instance (if any) on the given element
         *
         * @param	{element} 	elem 		The element to check
         * @returns {mixed} 	The instance or undefined
         */
        getObj = function (elem) {
            if( $( elem ).data('_loadedClickadminer') ){
                return $( elem ).data('_loadedClickadminer');
            }
            return undefined;
        };

        // Register this module as a widget to enable the data API and
        // jQuery plugin functionality
        ips.ui.registerWidget( 'adminerclick', ips.ui.adminer.click, [] );

        // Expose public methods
        return {
            respond: respond,
            getObj: getObj
        };
    });
    var _loadedClickadminer = function(elem, options){
        var init = function(){
            // elem.on('click','a',function(e){
            //     e.preventDefault();
            //     let t = $(this),
            //         ref = t.attr('href');
            //     if( ref !== '#' ){
            //         window.location.href = ips.getSetting('baseURL') +'/admin/?'+ ref + '&app=adminer&module=adminer&controller=adminer';
            //     }
            // })
            //elem.attr('height', $('#acpMainArea').outerHeight()-$('#ipsLayout_header').outerHeight()-$('#acpPageHeader').outerHeight()-50);
        };
        return {
            init: init
        }
    };
 }(jQuery, _));
