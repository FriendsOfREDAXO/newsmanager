// jQuery closure (»Funktionsabschluss«)
// Erzeugt einen Scope, also einen privaten Bereich
// http://molily.de/javascript-core/#closures
(function ($) {

    // Document Ready
    // Führt Code aus, sobald der DOM vollständig geladen wurde
    // https://api.jquery.com/ready/
    $(document).ready(function () {
        jQuery("#rex-newsmanager-seo-einstellungen-seo-description").after('<p class="help-block-seo-description"><small></small></p>');
        jQuery("#rex-newsmanager-seo-einstellungen-seo-description").bind("change input keyup keydown keypress mouseup mousedown cut copy paste", function(e) {
            var v = jQuery(this).val().replace(/(\r\n|\n|\r)/gm, "").length;
            jQuery("p.help-block-seo-description").find("small").html(v + ' Zeichen / Empfehlung: max. 160 Zeichen ');
            return true;
        }).trigger("keydown");
        
        jQuery("#rex-newsmanager-artikel-title").after('<p class="help-block-seo-title"><small></small></p>');
        jQuery("#rex-newsmanager-artikel-title").bind("change input keyup keydown keypress mouseup mousedown cut copy paste", function(e) {
            var v = jQuery(this).val().replace(/(\r\n|\n|\r)/gm, "").length;
            jQuery("p.help-block-seo-title").find("small").html(v + ' Zeichen / Empfehlung: max. 55 Zeichen ');
            return true;
        }).trigger("keydown");
    });
    

    
      
})(jQuery);