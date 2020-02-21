<?php
/**
 * This is a basic test file for testing the credit card type validation in wigum
 */
 date_default_timezone_set('America/Phoenix');

// Main WIGUM Include
require(__DIR__ . '/library/core/class.credit_card.php');

$cc = new CreditCard();

$test_cases = [
    4532600724275645 => CreditCardType::visa,
    4485770449110968 => CreditCardType::visa,
    4866650533212244 => CreditCardType::visa,
    4111111111111111 => CreditCardType::visa,
    5187684336377838 => CreditCardType::master_card,
    5114321219977255 => CreditCardType::master_card,
    5421831646630879 => CreditCardType::master_card,
    5525251093386195 => CreditCardType::master_card,
    344627909448727 => CreditCardType::american_express,
    378016434122099 => CreditCardType::american_express,
    349891777400732 => CreditCardType::american_express,
    6011996392572593 => CreditCardType::discover,
    6011081566689257 => CreditCardType::discover,
    6011866072406646 => CreditCardType::discover,
    3096826328004269 => CreditCardType::jcb,
    3112766591318303 => CreditCardType::jcb,
    3528597275776757 => CreditCardType::jcb,
    30409568602061 => CreditCardType::diners_club,
    30101203406343 => CreditCardType::diners_club,
    30500389674642 => CreditCardType::diners_club,
    36789649190374 => CreditCardType::diners_club,
    36690927987038 => CreditCardType::diners_club,
    36580107053778 => CreditCardType::diners_club,
];

$results = [];
foreach ($test_cases as $cc_number => $card_type) {
    $result = $cc->validate_credit_card($cc_number, 12, date('Y') + 1);
    if ($result !== null) {
        $results[$cc_number] = $result;
    } elseif ($cc->vars->cc_type != $card_type) {
        $results[$cc_number] = "Matched the wrong card type. Expected $card_type, got {$cc->vars->cc_type}";
    } else {
        $results[$cc_number] = "Valid";
    }
}

echo "Failures (empty is good):\n";
print_r($results);
