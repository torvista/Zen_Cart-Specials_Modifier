# Zen Cart - Specials Modifier

## Function
Stores the parameter used to modify the Specials price (percentage or absolute value) so the percentage can be recalculated if the base price is subsequently updated.  
Provides a button on the Special page to recalculate all the Specials prices.  
The function `specials_modifier_recalculate()` can be used by other scripts to update the Specials prices.

## Install
TEST ON A DEVELOPMENT SERVER FIRST!

1. Run the query from `specials_modifier_install.sql` in  *Admin->Tools->Install SQL Patches*  
to add the new field `specials_modifier` to store the original Specials modifier.
1. Copy the files  
- `ADMIN_FOLDER/specials.php`: modified file to overwrite your vanilla file or merge into your previously-modified file
- `ADMIN_FOLDER/specials.158 php`: vanilla/core file provided for comparison only. Not required for functionality but useful to keep in place as a visual indication that the specials file is not vanilla anymore.
- `ADMIN_FOLDER/includes/functions/extra_functions/specials_modifier.php`: the recalculation function is located here so other scripts may use it, eg. after completing a base price update/import.
- `ADMIN_FOLDER/includes/languages/english/extra_definitions/specials_modifier.php`: in extra_definitions to maintain the specials language file original for upgrades.

## Uninstall
1. Revert the specials.php file to the original version.
1. Remove the other files.
1. Run the query from `specials_modifier_uninstall.sq` in the *Admin->Tools->Install SQL Patches* to remove the `specials_modifier` extra field.

## Changelog
01/07/2023 torvista: inital commit

