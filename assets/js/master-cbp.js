(function ($) {
  "use strict";

  $(function () {
    var json_file = masteraddons.plugin_url + "/custom_breakpoints.json",
      
      master_cbp_define = function (row, device) {
        $.each(device, function (key, value) {
          key = new RegExp("[$]{2}" + key + "[$]{2}", "g");
          row = row.replace(key, value);
        });

        return row;
      };

    if (typeof elementor === "undefined") {
      return;
    }

    elementor.on("panel:init", function () {

      var $resonsive = $(
        "#elementor-panel-footer-responsive .elementor-panel-footer-sub-menu"
      );

      if (!$resonsive.length) {
        return;
      }

      $.getJSON(json_file + "?ver=" + Date.now(), function (devices) {
        
        var itemHtml = "";

        $.each(devices, function (idx, device) {

          var panel = [
              `<div class="elementor-panel-footer-sub-menu-item" data-device-mode="${idx}">
                  <i class="elementor-icon eicon-device-mobile master-cbp-device-${device.orientation} master-cbp-${idx}" aria-hidden="true"></i>
                  <span class="elementor-title">${device.name}</span>
                  <span class="elementor-description">
                    
                    Type: ${device.orientation} <br>
                    ${device.select1}: ${device.input1}<br>
                    ${device.select2}: ${device.input2}
                    
                  </span>
              </div>`,
            ],
            items = [
              `<a class="master-cbp-elementor elementor-responsive-switcher tooltip-target elementor-responsive-switcher-${idx}" data-device="${idx}" data-tooltip="${device.name}" data-tooltip-pos="w" original-title="">
                  <i class="elementor-icon eicon-device-mobile master-cbp-device-${device.orientation} master-cbp-${idx}" aria-hidden="true"></i>
              </a>`,
            ],

            deviceHtml = "";

          $.each(panel, function () {
            deviceHtml += master_cbp_define(this, device);
          });

          $.each(items, function () {
            itemHtml += master_cbp_define(this, device);
          });

          var $panel = $(deviceHtml);

          $resonsive.append($panel);
        });

        elementor.hooks.addAction("panel/open_editor/widget", function (
          panel,
          model,
          view
        ) {
          var fn = function () {
            var $item = $(itemHtml),
              $widgetHolder = $(
                ".elementor-control-responsive-switchers__holder"
              );
            $widgetHolder.append($item);
          };

          $(
            ".elementor-component-tab.elementor-panel-navigation-tab.elementor-tab-control-style"
          )
            .off("click", fn)
            .on("click", fn);
        });

        // active class
        $(".elementor-panel-footer-sub-menu-item").on("click", function (e) {
          $(".elementor-panel-footer-sub-menu-item").removeClass("active");
          $(e.currentTarget).addClass("active");
        });
      });
    });
  });
})(jQuery);
