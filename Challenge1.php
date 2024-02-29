<?php
/*This is a function that receives 3 parameters. These are 2 lists of products and an extra product
It basically compares the $ext list with the $o list, updating the quantity of $o products based on $ext products.
Also it adds the $p product if not present in the $o list.
Finally it adds the $ext products that were not present in the $o list
It returns an updated list of items.
Some more comments inside the code and at the bottom
*/
function($p, $o, $ext) {
    $items = [];
    $sp = false;
    $cd = false;

    $ext_p = [];
    //Generate a list from ext that uses key as the id and value as quantity
    foreach ($ext as $i => $e) {
      $ext_p[$e['price']['id']] = $e['qty'];
    }

    //Check other list o in the key items data.
    foreach ($o['items']['data'] as $i => $item) {
      //Grab id value of each item
        $product = [
        'id' => $item['id']
      ];

      /*If that id was found in the $ext array. Grab the quantity value, if quantity is less than 1
      flag the product as deleted, if not just add a quantity value. After, delete that id from first list*/
      if (isset($ext_p[$item['price']['id']])) {
          $qty = $ext_p[$item['price']['id']];
          if ($qty < 1) {
              $product['deleted'] = true;
          } else {
              $product['qty'] = $qty;
          }
          unset($ext_p[$item['price']['id']]);
      //If the id is not found in the ext array, but is present on the p array, flag sp as true
      } else if ($item['price']['id'] == $p['id']) {
          $sp = true;
      } else {
      //If the id is not found anywhere, flag cd as true and product as deleted
      $product['deleted'] = true;
          $cd = true;
      }
      //Add product to the items list
      $items[] = $product;
    }

    //If sp flag is set to false add p product with quantity 1 to the items array
    if (!$sp) {
      $items[] = [
        'id'=> $p['id'],
        'qty'=> 1
      ];
    }

    //Loop through the provisory list, adding products that were not found in the $o list if quantity is less than 1 skip adding it to the items list
    foreach ($ext_p as $i => $details) {
      if ($details['qty'] < 1) {
          continue;
      }

      //Add each item to the items list setting the id as the price and the quantity as the same
      $items[] = [
        'id'=> $details['price'],
        'qty'=> $details['qty']
      ];
    }

    return $items;
}

/* some comments to improve the code :
1) array had no php based notation, used more javascript notation, i had to update them
2) cd variable doesn't do anything in the code, is confusing.
3) It doesn't have any error checking or contemplates any edge case. What if any product is duplicated for example? Quantity should be summed.
4) Don't understand why something would be under a price key if we are using only the id.
5) i would not add a continue keyword inside a foreach, you can just use if $details['qty'] > 1
6) Too many if , if else clauses, it can be refactored using guard clauses.
7) Also too much foreachs, it probably can be refactored to use less
8) I know the intention of the challenge is to make it hard to understand but variables and functions should not
have this kind of names, they should be descriptive to help understand the purpose of the code
*/