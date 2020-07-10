(function ($) {
  "use strict";


  $(function () {
    var json_file = masteraddons.plugin_url + "/custom_breakpoints.json",
      cv_apply = function (row, device) {
        $.each(device, function (key, value) {
          key = new RegExp("[$]{2}" + key + "[$]{2}", "g");
          row = row.replace(key, value);
        });

        return row;
      };

      // console.log(json_file);
      
    if (typeof elementor === "undefined") {
      return;
    }

    elementor.on("panel:init", function () {
      console.log("init panel");

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
                  <i class="elementor-icon cbp-elementor-device eicon-device-${idx}" aria-hidden="true"></i>
                  <span class="elementor-title">${device.name}</span>
                  <span class="elementor-description">${device.select1}: ${device.input1}</span>
              </div>`,
            ],
            items = [
              `<a class="cbp-elementor elementor-responsive-switcher tooltip-target elementor-responsive-switcher-${idx}" data-device="${idx}" data-tooltip="${device.name}" data-tooltip-pos="w" original-title="">
                  <i class="cbp-elementor-device cbp-elementor-device-${idx}" aria-hidden="true"></i>
              </a>`,
            ],
            deviceHtml = "";

          $.each(panel, function () {
            deviceHtml += cv_apply(this, device);
          });

          $.each(items, function () {
            itemHtml += cv_apply(this, device);
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
