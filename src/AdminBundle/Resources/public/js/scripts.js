(function($){
    
    $(document).ready(function(){
       
        //select2 plugin initalize
        $('select').select2({
            allowClear: true
        });

        //initalize popups
        $('[data-original-title]').tooltip();                
                
    });
    
})(jQuery);