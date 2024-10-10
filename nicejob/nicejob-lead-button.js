(function() {
    tinymce.create("tinymce.plugins.nicejob_lead_button", {
      init : function(ed, url) {
        ed.addButton("nicejob_lead_button", {
          title : "NiceJob Lead",
          cmd : "nicejob_lead",
          image : "../wp-content/plugins/nicejob/nicejob-button-40.png"
        });
        ed.addCommand("nicejob_lead", function() {
          ed.execCommand("mceInsertContent", 0, "[nicejob-lead type='a' text='Click here for an estimate']");
        });
      },
      createControl : function(n, cm) { return null; },
      getInfo : function() { return { longname : "NiceJob Buttons", author : "NiceJob", version : "1" }; }
    });
  
    tinymce.PluginManager.add("nicejob_lead_button", tinymce.plugins.nicejob_lead_button);
  })();