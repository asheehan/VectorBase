
-- SUMMARY --
Taxonomy subterms displays nodes of subterms' term in taxonomy/term/<tid>.
You can specify subterms recursion depth by vocabularie and/or by term (by default it is disabled).
The module uses the existing page callback to render the page.
In fact the module just catches the top terms argument, adds its children and puts them back in the arguments of the original callback.
The module is aware of i18nmenu and taxonomy_breadcrumb.
Altering the taxonomy/term/% page callback by another module should be supported if you specify a module's weight greater than taxonomy_subterms (see hook_enable).

-- REQUIREMENTS --
Module taxonomy.

-- INSTALLATION --
* Install as usual, see http://drupal.org/node/70151 for further information.

-- CONFIGURATION --
Menu wide : within the voabulary and term edit form.

-- TROUBLESHOOTING --

-- CONTACT --

Current maintainers:
* David Berlioz aka quazardous - https://drupal.org/user/399916

