; (function ($, _, undefined) {
  "use strict";
  ips.controller.mixin('toolbox.changeTheme', 'core.admin.core.changeTheme', true, function () {
    this.after('themePreferenceSelected', function () {
      if ($('body').hasClass('ipsDarkMode')) {
        $('#elAdminer').addClass('adminerDarkMode').removeClass('adminerLightMode');
      }
      else {
        $('#elAdminer').removeClass('adminerDarkMode').addClass('adminerLightMode');
      }

    });

  });
}(jQuery, _));
