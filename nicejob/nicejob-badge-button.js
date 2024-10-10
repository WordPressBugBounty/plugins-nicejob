(function() {
  tinymce.create("tinymce.plugins.nicejob_badge_button", {
    init : function(ed, url) {
      ed.addButton("nicejob_badge_button", {
        title : "NiceJob Badge",
        cmd : "nicejob_badge",
        image : "../wp-content/plugins/nicejob/nicejob-button-40.png"
      });
      ed.addCommand("nicejob_badge", function() {
        ed.execCommand("mceInsertContent", 0, "[nicejob-badge]");
      });
    },
    createControl : function(n, cm) { return null; },
    getInfo : function() { return { longname : "NiceJob Buttons", author : "NiceJob", version : "1" }; }
  });

  tinymce.PluginManager.add("nicejob_badge_button", tinymce.plugins.nicejob_badge_button);
})();