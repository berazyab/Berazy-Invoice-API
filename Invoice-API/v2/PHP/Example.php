<?php
/**
 * Berazy Invoice SOAP API Client
 *
 * @author      Johan Sall Larsson <johan@berazy.se>
 * @author      Simon Stal <simon@berazy.se>
 * @copyright   2013 Berazy AB (publ)
 * @version     2.0.0
 * @package     Berazy
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 
/********************************************************************************
 * >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> README <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
 * 1. Set a valid customer number and authentication token.
 * 2. Uncomment any operation and set proper values.
 * 3. Run.
 *******************************************************************************/
     
    spl_autoload_register('customAutoLoader');

/********************************************************************************
 * Initialize InvoiceClient
 *******************************************************************************/
    
    // Override any default options by adding an array in the constructor e.g.
    // new \Berazy\Invoice\InvoiceClient(array('connection_timeout' => 999));
    $client = new \Berazy\Invoice\InvoiceClient();
    $client->setCustomerNumber('CUSTOMER_NUMBER_AS_INT')
           ->setAuthToken('AUTH_TOKEN');
    
/********************************************************************************
 * SsnCheck request
 *******************************************************************************/
 
    $ssnCheckRequest = new \Berazy\Invoice\Contract\SsnCheckRequest();
    $ssnCheckRequestType = new \Berazy\Invoice\Contract\SsnCheckRequestType();
    $ssnCheckRequestType->setSsn('ORG_NO_OR_SSN');
    $ssnCheckRequestType->setCredit_check(0);
    $ssnCheckRequest->setRequest($ssnCheckRequestType);
    //clientCall('SsnCheck', $ssnCheckRequest);
    
/********************************************************************************
 * InvoiceStatus request
 *******************************************************************************/

    $invoiceStatusRequest = new \Berazy\Invoice\Contract\InvoiceStatusRequest();
    $invoiceStatusRequestType = new \Berazy\Invoice\Contract\InvoiceStatusRequestType();
    $invoiceStatusRequestType->setOcr('OCR_NUMBER_AS_INT');
    $invoiceStatusRequest->setRequest($invoiceStatusRequestType);
    //clientCall('InvoiceStatus', $invoiceStatusRequest);

/********************************************************************************
 * InvoiceDetails request
 *******************************************************************************/

    $invoiceDetailsRequest = new \Berazy\Invoice\Contract\InvoiceDetailsRequest();
    $invoiceDetailsRequestType = new \Berazy\Invoice\Contract\InvoiceDetailsRequestType();
    $invoiceDetailsRequestType->setOcr('OCR_NUMBER_AS_INT');
    $invoiceDetailsRequest->setRequest($invoiceDetailsRequestType);
    //clientCall('InvoiceStatus', $invoiceStatusRequest);
    
/********************************************************************************
 * ActivateInvoice request
 *******************************************************************************/

    $activateInvoiceRequest = new \Berazy\Invoice\Contract\ActivateInvoiceRequest();
    $activateInvoiceRequestType = new \Berazy\Invoice\Contract\ActivateInvoiceRequestType();
    $activateInvoiceRequestType->setOcr('OCR_NUMBER_AS_INT');
    $activateInvoiceRequest->setRequest($invoiceDetailsRequestType);
    //clientCall('ActivateInvoice', $activateInvoiceRequest);

/********************************************************************************
 * ResendInvoice request
 *******************************************************************************/

    $resendInvoiceRequest = new \Berazy\Invoice\Contract\ResendInvoiceRequest();
    $resendInvoiceRequestType = new \Berazy\Invoice\Contract\ResendInvoiceRequestType();
    $resendInvoiceRequestType->setOcr('OCR_NUMBER_AS_INT');
    $resendInvoiceRequestType->setEmail('EMAIL_ADDRESS');
    $resendInvoiceRequestType->setInvoice_state(1);
    $resendInvoiceRequestType->setPrint_setup(1);
    $resendInvoiceRequest->setRequest($resendInvoiceRequestType);
    //clientCall('ResendInvoice', $resendInvoiceRequest);
    
/********************************************************************************
 * PauseInvoice request
 *******************************************************************************/

    $pauseInvoiceRequest = new \Berazy\Invoice\Contract\PauseInvoiceRequest();
    $pauseInvoiceRequestType = new \Berazy\Invoice\Contract\PauseInvoiceRequestType();
    $pauseInvoiceRequestType->setOcr('OCR_NUMBER_AS_INT');
    $pauseInvoiceRequestType->setPause(TRUE);
    $pauseInvoiceRequest->setRequest($pauseInvoiceRequestType);
    //clientCall('PauseInvoice', $pauseInvoiceRequest);
   
/********************************************************************************
 * SearchCompany request
 *******************************************************************************/

    $searchCompanyRequest = new \Berazy\Invoice\Contract\SearchCompanyRequest();
    $searchCompanyRequestType = new \Berazy\Invoice\Contract\SearchCompanyRequestType();
    $searchCompanyRequestType->setCompany_name('Berazy');
    $searchCompanyRequestType->setPhonetic_search(TRUE);
    $searchCompanyRequestType->setNumber_hits(10);
    $searchCompanyRequest->setRequest($searchCompanyRequestType);
    //clientCall('SearchCompany', $searchCompanyRequest);
    
/********************************************************************************
 * Client call
 *******************************************************************************/
    
    /**
     * The client call
     * @param string $method eg. SsnCheck, InvoiceStatus etc
     * @param object $request
     */
    function clientCall($method, $request) {
        global $client;
        try {
            $response = $client->$method($request);
            var_dump($client->__getLastRequest());
            var_dump($response);
        } catch (\Exception $e) {
            // Do logging here ...
            var_dump($e->getMessage());
            var_dump($client->__getLastRequest());
        }
    }

/********************************************************************************
 * Autoloading. Do NOT use if you are using Composer to autoload dependencies.
 *******************************************************************************/    
    
    /**
     * Autoloading
     * @param string $class
     */
    function customAutoLoader($class) {
        $file = rtrim(dirname(__FILE__), '/') . '/' . $class . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            return;
        }
    }
    
?>