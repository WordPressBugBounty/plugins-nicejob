(function() {
  tinymce.create("tinymce.plugins.nicejob_engage_button", {
    init : function(ed, url) {
      ed.addButton("nicejob_engage_button", {
        title : "NiceJob Engage",
        cmd : "nicejob_engage",
        image : "../wp-content/plugins/nicejob/nicejob-button-40.png"
      });
      ed.addCommand("nicejob_engage", function() {
        ed.execCommand("mceInsertContent", 0, "[nicejob-engage position='left' event-types='Booking,Review']");
      });
    },
    createControl : function(n, cm) { return null; },
    getInfo : function() { return { longname : "NiceJob Buttons", author : "NiceJob", version : "1" }; }
  });

  tinymce.PluginManager.add("nicejob_engage_button", tinymce.plugins.nicejob_engage_button);
})();