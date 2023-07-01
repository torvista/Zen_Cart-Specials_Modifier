<?php

declare(strict_types=1);

/**
 * Plugin Specials Modifier: https://github.com/torvista/Zen_Cart-Specials_Modifier
 * @updated 01/07/2023
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

/* @var queryFactory $db */

/**
 * @return void
 */
function specials_modifier_recalculate(): void
{
    global $db;
    $sql_specials_modifiers = 'SELECT products_id, specials_modifier FROM ' . TABLE_SPECIALS . ' WHERE specials_modifier LIKE "%\%%"';
    $specials_modifiers = $db->Execute($sql_specials_modifiers);
    foreach ($specials_modifiers as $special_modifier) {
        if (str_ends_with($special_modifier['specials_modifier'], '%')) {
            $product_info = $db->Execute(
                'SELECT products_id, products_price, products_priced_by_attribute
                          FROM ' . TABLE_PRODUCTS . '
                          WHERE products_id = ' . (int)$special_modifier['products_id'] . ' LIMIT 1'
            );
            // check if priced by attribute
            if ($product_info->fields['products_priced_by_attribute'] === '1') {
                $products_price = zen_get_products_base_price($special_modifier['products_id']);
            } else {
                $products_price = $product_info->fields['products_price'];
            }
            $specials_price = (float)$products_price - (((float)$special_modifier['specials_modifier'] / 100) * (float)$products_price);
            $db->Execute('UPDATE ' . TABLE_SPECIALS . ' SET specials_new_products_price = ' . $specials_price . ' WHERE products_id = ' . (int)$special_modifier['products_id']);
            zen_update_products_price_sorter($special_modifier['products_id']);
        }
    }
}

