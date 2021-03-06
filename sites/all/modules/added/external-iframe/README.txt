External iFrame opens external links in an iframe with a simple banner consisting of your logo and a button to close the banner and leave your site. This module treats all absolute http links outside of your site's domain and sub-domains as external links.
Each link is validated on the external iframe page and a cookie is set so a user can return to the page (from a bookmark for example) for a period of time without encountering a "link not trusted" message. The time period for which a link is trusted is configurable in the module settings.

To install module:
1) Extract module files to /sites/all/modules
2) Enable module in the drupal administrative interface
3) Edit user permissions and give necessary access for External iFrame administration
4) Configure how long external links remain trusted in the External iFrame settings page (/admin/settings/externaliframe)
5) That's it! You're off to the races.
6) To exclude any external links from being handled by this module, give the <a> tag a class of "external-nofollow" ie. <a href="http://foobar.com" class="external-nofollow">

Customizing the template:
1) Copy page--external.tpl.php to your theme
2) Edit as necessary

Notes:
- This module considers any link outside your domain and sub-domains as external links
- Because of link validation you cannot send the full external link url to your friends. A share this feature is expected in the next release.
- Ignores https

