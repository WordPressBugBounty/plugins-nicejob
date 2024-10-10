(function() {
  tinymce.create("tinymce.plugins.nicejob_stories_button", {
    init : function(ed, url) {
      ed.addButton("nicejob_stories_button", {
        title : "NiceJob Stories",
        cmd : "nicejob_stories",
        image : "../wp-content/plugins/nicejob/nicejob-button-40.png"
      });
      ed.addCommand("nicejob_stories", function() {
        ed.execCommand("mceInsertContent", 0, "[nicejob-stories style='grid' show='reviews' max-height=300 branding='bottom']");
      });
    },
    createControl : function(n, cm) { return null; },
    getInfo : function() { return { longname : "NiceJob Buttons", author : "NiceJob", version : "1" }; }
  });

  tinymce.PluginManager.add("nicejob_stories_button", tinymce.plugins.nicejob_stories_button);
})();