<?php

use MicroModule\MicroserviceGenerator\Generator\DataTypeInterface;
use MicroModule\MicroserviceGenerator\Service\ProjectBuilder;

set_time_limit(0);

require 'vendor/autoload.php';
require 'test.php';


$data = [
    "5fd49320-4d8b-4106-b2f2-909c2201f00d",
    "0ca69329-4d8b-4106-b2f2-909c2201f79e",
    [
        "id" => 999,
        "visa_transaction_file_id" => 176,
        "transaction_amount" => 48.83,
        "acquirer_transaction_amount" => 48.83,
        "acquirer_currency_code" => "SAR",
        "issuer_transaction_amount" => 48.83,
        "issuer_currency_code" => "SAR",
        "merchant_category_code" => "7011",
        "merchant_descriptor_name" => "ABRAJ ALKALDIA CO",
        "merchant_city" => "RIYADH",
        "merchant_country" => "682",
        "purchase_date" => "20190606",
        "local_date" => "",
        "local_time" => "",
        "transaction_date" => "00010101",
        "transaction_time" => "0000",
        "central_processing_date" => "20190608",
        "card_acceptor_id" => "154231167184",
        "acquirer_bin" => "402168",
        "cardholder_account_number" => "eyJpIjoiblJHQmM0VDlQV01SdlwvTCtkWDZQRmc9PSIsInYiOiJOYjN5NEFzMDRiKzNxWm10Q2VzM0RzSGRvQkNEd0ZCODZxRDdPS0tHQ1FRPSJ9",
        "eci" => "",
        "cardholder_account_number_hashed" => "4IF/pR5olDNsxS0Ku1IJ6ata7U2/kZMUqq7Qi916VgY=",
        "promotion_code" => "6SA17CEMEABLULOYXXXFEB17A",
        "tran_code" => "05",
        "visa_tran_id" => null,
        "token_requestor_id" => "",
        "token_transaction_indicator" => "0",
        "pos_entry_mode" => "07",
        "country_currency_code" => "SAR",
        "staged_id" => 9152688,
        "card_bin" => "400000",
        "line_number" => 499,
        "created_at" => "2020-06-21 07:24:50",
        "updated_at" => "2020-08-24 05:38:44"
    ]
];

//$decorator = new class
$decorator = new DecoratorGenerator();
$className = \Micro\Game\Transaction\Domain\Command\TransactionAddCommand::class;
$decoratorClassName = \Micro\Game\Transaction\Domain\Command\TransactionAddCommand::class.'Decorator';
$code = $decorator->generate($className, $decoratorClassName);
eval($code);
$commandFactory = new \Micro\Game\Transaction\Domain\Factory\CommandFactory();
$command = $commandFactory->makeTransactionAddCommand($data[0], $data[1], $data[2]);
$anonymousDecorator = new $decoratorClassName($command);

$args = [];
$args[] = $anonymousDecorator->getProcessUuid();
$args[] = $anonymousDecorator->getUuid();
$args[] = $anonymousDecorator->getTransaction();
unset($anonymousDecorator);



