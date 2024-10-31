jQuery(document).ready( function($) {
        // These widgets are sometimes populated via ajax
        ajaxWidgets = [
                'AllThingsSEO_feed',
        ];

        ajaxPopulateWidgets = function(el) {
                show = function(id, i) {
                        var p, e = $('#' + id + ' div.inside:visible').find('.widget-loading');
                        if ( e.length ) {
                                p = e.parent();
                                setTimeout( function(){
                                        p.load( ajaxurl.replace( '/admin-ajax.php', '' ) + '/../wp-content/plugins/seo-friendly-social-links/rss.php', '', function() {
                                                p.hide().slideDown('normal', function(){
                                                        $(this).css('display', '');
                                                        if ( 'dashboard_quick_press' == id )
                                                                quickPressLoad();
                                                });
                                        });
                                }, i * 500 );
                        }
                }
                if ( el ) {
                        el = el.toString();
                        if ( $.inArray(el, ajaxWidgets) != -1 )
                                show(el, 0);
                } else {
                        $.each( ajaxWidgets, function(i) {
                                show(this, i);
                        });
                }
        };
        ajaxPopulateWidgets();

        postboxes.add_postbox_toggles(pagenow, { pbshow: ajaxPopulateWidgets } );
} );