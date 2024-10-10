(function() {
    tinymce.create("tinymce.plugins.nicejob_recommendation_button", {
        init : function(ed, url) {
            ed.addButton("nicejob_recommendation_button", {
                title : "NiceJob Recommendation",
                cmd : "nicejob-recommendation",
                image : "../wp-content/plugins/nicejob/nicejob-button-40.png"
            });
            ed.addCommand("nicejob-recommendation", function() {
                ed.execCommand("mceInsertContent", 0, '[nicejob-recommendation type="a" class="" text="Recommend us!"]');
            });
        },
        createControl : function(n, cm) { return null; },
        getInfo : function() { return { longname : "NiceJob Buttons", author : "NiceJob", version : "1" }; }
    });

    tinymce.PluginManager.add("nicejob_recommendation_button", tinymce.plugins.nicejob_recommendation_button);
})();
