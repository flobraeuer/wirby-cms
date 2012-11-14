Backbone.Collection = Backbone.Collection.extend({
  initialize: function() {
    // Setzt die Abfrageverzögerung
    this.autoRefreshInterval = 1 * 1000;
    this.changeRefresh();
  },
  changeRefresh: function() {
    if (this.autoRefresh) {
      var that = this;
      setTimeout(function() {
        $.ajax({
          url: that.url + "/_changes",
          timeout: 2 * 60 * 1000,
          global: false,
          // ### Erfolgreich Daten empfangen
          success: function(data) {
            // Bestehende Models werden aktualisiert
            if (that.get(data.id)) that.get(data.id).clear({silent:true}).set(data);
            // ´changeRefresh´ geht in die nächste Runde
            that.autoRefreshInterval = 1 * 1000;
            that.changeRefresh();
          },
          error: function(er, e, es) {
            // Bei Serverfehlern wird die Abfrageverzögerung erhöht.
            if (!e || e != "timeout") that.autoRefreshInterval *= 2;
            // ´changeRefresh´ geht in die nächste Runde
            that.changeRefresh();
          }
        });
      },
      that.autoRefreshInterval);
    }
  }
});
