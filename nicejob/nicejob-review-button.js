(function() {
    tinymce.create("tinymce.plugins.nicejob_review_button", {
      init : function(ed, url) {
        ed.addButton("nicejob_review_button", {
          title : "NiceJob Review",
          cmd : "nicejob_review",
          image : "../wp-content/plugins/nicejob/nicejob-button-40.png"
        });
        ed.addCommand("nicejob_review", function() {
          ed.execCommand("mceInsertContent", 0, "[nicejob-review type='a' text='Click here for an estimate']");
        });
      },
      createControl : function(n, cm) { return null; },
      getInfo : function() { return { longname : "NiceJob Buttons", author : "NiceJob", version : "1" }; }
    });
  
    tinymce.PluginManager.add("nicejob_review_button", tinymce.plugins.nicejob_review_button);
  })();