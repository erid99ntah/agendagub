// Set CodeIgniter base_url in JavaScript var to use within

console.log(_BASE_URL_);
console.log(_CSRF_NAME_);

jQuery(function($)
{   
        /**
         * New jQuery function to set/refresh CSRF token in Body & to attach AjaxPOST
         * @param  {[type]} $ [description]
         * @return {[type]}   [description]
         */      
        
         $.fn.CsrfAjaxSet = function(CsrfObject) {
            // getting meta object from body head section by csrf name
            var CsrfMetaObj = $('meta[name="' + _CSRF_NAME_ + '"]'),
            CsrfSecret = {};
            // if CsrfObject not set/pass in function
            if (typeof CsrfObject == 'undefined') {
                // assign meta object in CsrfObject
                CsrfObject = CsrfMetaObj;
                // get meta tag name & value
                CsrfSecret[CsrfObject.attr('name')] = CsrfObject.attr('content');
            }
            // CsrfObject pass in function
            else {
                // get Csrf Token Name from JSON
                var CsrfName = Object.keys(CsrfObject);
                // set csrf token name & hash value in object
                CsrfSecret[CsrfName[0]] = CsrfObject[CsrfName[0]];
            }
            // attach CSRF object for each AjaxPOST automatically
            $.ajaxSetup({
                data: CsrfSecret
            });
        };
        /**
         * New jQuery function to get/refresh CSRF token from CodeIgniter
         * @param  {[type]} $ [description]
         * @return {[type]}   [description]
         */
         $.fn.CsrfAjaxGet = function() {
            //return $.get(_BASE_URL_ + 'Csrfdata', function(CsrfJSON) {
            return $.get(_BASE_URL_ + 'Csrfdata', function(CsrfJSON) {
                $(document).CsrfAjaxSet(CsrfJSON);
            }, 'JSON');            
        };
});