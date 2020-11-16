<?php

namespace App\Http\Controllers;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

use Illuminate\Http\Request;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

class SubscriptionController extends Controller
{
    public function create(){

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUJnPBDuH9XMSh4P1n1cxdbHUQMA5Fmk9vDCaMw2v5Webzick9P8IT6_O5aWvp78OKiLzwsN3iEaOmCO',     // ClientID
                'EE99jY3IjUs4fb1tnmVhLI347C9wxb_0lI5W9bVWTYpCkNe8d9tZN_pSRdU1vzkedTeqlGOn6h4Efs80'      // ClientSecret
            )
        );

        $plan = new Plan();
        $plan->setName('T-Shirt of the Month Club Plan')
            ->setDescription('Template creation.')
            ->setType('fixed');
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));

        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
        
        $paymentDefinition->setChargeModels(array($chargeModel));
        
        $merchantPreferences = new MerchantPreferences();

        $merchantPreferences->setReturnUrl("http://127.0.0.1:8000/execute-plan")
            ->setCancelUrl("http://127.0.0.1:8000/cancell-plan")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));


        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $output = $plan->create($apiContext);
        
        dd($output);
    }
    public function planlist(){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUJnPBDuH9XMSh4P1n1cxdbHUQMA5Fmk9vDCaMw2v5Webzick9P8IT6_O5aWvp78OKiLzwsN3iEaOmCO',     // ClientID
                'EE99jY3IjUs4fb1tnmVhLI347C9wxb_0lI5W9bVWTYpCkNe8d9tZN_pSRdU1vzkedTeqlGOn6h4Efs80'      // ClientSecret
            )
        );
        $params = array('page_size' => '2');
        $planList = Plan::all($params, $apiContext);
        dd($planList);
    }
    public function getId(){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUJnPBDuH9XMSh4P1n1cxdbHUQMA5Fmk9vDCaMw2v5Webzick9P8IT6_O5aWvp78OKiLzwsN3iEaOmCO',     // ClientID
                'EE99jY3IjUs4fb1tnmVhLI347C9wxb_0lI5W9bVWTYpCkNe8d9tZN_pSRdU1vzkedTeqlGOn6h4Efs80'      // ClientSecret
            )
        );
        $plan = Plan::get($this->create()->getId(), $apiContext);
        dd($plan);
    }
    public function activePlan($id){
        $createdPlan = $this->getId($id);
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUJnPBDuH9XMSh4P1n1cxdbHUQMA5Fmk9vDCaMw2v5Webzick9P8IT6_O5aWvp78OKiLzwsN3iEaOmCO',     // ClientID
                'EE99jY3IjUs4fb1tnmVhLI347C9wxb_0lI5W9bVWTYpCkNe8d9tZN_pSRdU1vzkedTeqlGOn6h4Efs80'      // ClientSecret
            )
        );

        $patch = new Patch();

        $value = new PayPalModel('{
            "state":"ACTIVE"
            }');

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);

        $createdPlan->update($patchRequest, $apiContext);

        $plan = Plan::get($this->create()->getId(), $apiContext);
        dd($plan);
    }
}
