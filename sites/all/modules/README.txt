Place downloaded and custom modules that extend your site functionality beyond
Drupal core in this directory to ensure clean separation from core modules and
to facilitate safe, self-contained code updates. Contributed modules from the
Drupal community may be downloaded at http://drupal.org/project/modules. Be
sure to select "7.x" in the "Filter by compatibility" section.

For this instance of drupal, VectorBase organizes its modules into two
distinct folders.  'added' is the folder which holds all 3rd party (contributed)
modules. 'custom' is for all built-from-scratch or heavily modified modules.
Note that if you move a module to a subdirectory after it has been enabled, 
you may need to clear the Drupal cache so that it can be found. In addition,
there are some modules that are not sub-folder agnostic and will break the
site if moved.  This includes 'admin_menu' and 'entityreference'. In general,
you should avoid making these hard-coded dependencies on paths leading from the
root 'modules' directory down to your code (be especially mindful of this if you
save path data in the database). Drupal provides an api to dynamically lookup 
module path info (drupal_get_path).

In multisite configuration, modules found in this directory
(sites/all/modules) are available to all sites. Alternatively, the 
sites/your_site_name/modules directory pattern may be used to restrict modules to 
a specific site instance.

Refer to http://drupal.org/developing/modules for further information on extending
Drupal with modules.
