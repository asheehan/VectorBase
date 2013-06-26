/**
 *
 * CSS Browser Selector v0.4.0 (Nov 02, 2010)
 * Rafael Lima (http://rafael.adm.br)
 * http://rafael.adm.br/css_browser_selector
 * License: http://creativecommons.org/licenses/by/2.5/
 * Contributors: http://rafael.adm.br/css_browser_selector#contributors
 */
(function ($) {
  Drupal.behaviors.browserSelectors = {
      attach: function(context, settings) {
        var ua = navigator.userAgent.toLowerCase(),
          is = function (t) {
            return ua.indexOf(t) > -1;
          },
          g = 'gecko',
          w = 'webkit',
          s = 'safari',
          o = 'opera',
          m = 'mobile',
          h = document.documentElement,
          b = [
            (!(/opera|webtv/i.test(ua)) && /msie\s(\d+)/.test(ua)) ? ('ie ie' + RegExp.$1) :
            is('firefox/') ? g + (/firefox\/(\d+)(\.?(\d*))/.test(ua) ? ' ff' + RegExp.$1 + (RegExp.$3 != 0 ? ' ff' + RegExp.$1 + '_' + RegExp.$3 : '') : '') :
            is('gecko/') ? g :
            is('opera') ? o + (/version\/(\d+)/.test(ua) ? ' ' + o + RegExp.$1 : (/opera(\s|\/)(\d+)/.test(ua) ? ' ' + o + RegExp.$2 : '')) :
            is('konqueror') ? 'konqueror' :
            is('blackberry') ? m + ' blackberry' :
            is('android') ? m + ' android' :
            is('chrome') ? w + ' chrome' :
            is('iron') ? w + ' iron' :
            is('applewebkit/') ? w + ' ' + s + (/version\/(\d+)/.test(ua) ? ' ' + s + RegExp.$1 : '') :
            is('mozilla/') ? g : '',
            is('j2me') ? m + ' j2me' :
            is('iphone') ? m + ' iphone' :
            is('ipod') ? m + ' ipod' :
            is('ipad') ? m + ' ipad' :
            is('mac') ? 'mac' :
            is('darwin') ? 'mac' :
            is('webtv') ? 'webtv' :
            is('win') ? 'win' + (is('windows nt 6.0') ? ' vista' : (is('windows nt 6.1') ? ' win7' : (is('windows nt 6.2') ? ' win8' : ''))) :
            is('freebsd') ? 'freebsd' :
            is('x11') ? 'linux' :
            is('linux') ? 'linux' : ''
          ];
        c = b.join(' ');
        h.className += ' ' + c;
        return c;
    }
  };
})(jQuery);
