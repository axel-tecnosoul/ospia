(function($){

    var active_id = '';
    // panel
    $('.main-content .dg-panel li:first a').addClass('active');
    $('.main-content .dg-panel li a').click(function(e){
        var $this = $(this);
        $('.main-content .dg-panel li a').removeClass('active');
        $this.addClass('active');
        get_active_id();
        hide_sections();
        show_settings();
        section_show_hide();
    });

    get_active_id();
    hide_sections();
    show_settings();
    section_show_hide();

    function get_active_id() {
        $('.main-content .dg-panel li').each(function(){
            var $link = $(this).find('a');
            if($link.hasClass('active')) {
                active_id = $link[0].dataset.id;
            }
        })
    }
    
    function hide_sections() {
        var sections = $('.dg-settings-nav li');
        var eleIndex = 0;
        sections.each(function(index, ele){
            var $this = $(this);
            if(ele.dataset.panel !== active_id ) {
                $this.addClass('hide');
                $this.find('a').removeClass('active');
            } else {
                $this.removeClass('hide');
                eleIndex++;

                if (eleIndex > 1 ) {
                    $this.find('a').removeClass('active');
                } else {
                    $this.find('a').addClass('active');
                }
            }

            
        });
    }
    /**
     * Tab functionality
     */
    function section_show_hide() {
        $('.content .dg-settings-nav li a').click(function(e){
            var $this = $(this);
            var $data = e.target.dataset;
            $('.content .dg-settings-nav li a').removeClass('active');
            $this.addClass('active');
            show_settings();
        })
    }
    

    function show_settings() {
        var settings = $('.content .form-container .section-wrapper');
        settings.each(function(index, ele){
            var $this = $(this);
            var navid = ele.dataset.navid;
            var section = $('.dg-settings-nav li a[data-navid="'+navid+'"]');
            if(section.hasClass('active')) {
                $this.addClass('active');
            } else {
                $this.removeClass('active');
            }
        })
    }
})(jQuery)