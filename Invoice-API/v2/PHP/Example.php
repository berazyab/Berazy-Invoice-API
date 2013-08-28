<?php
/**
 * Berazy Invoice SOAP API Client
 *
 * @author      Johan Sall Larsson <johan@berazy.se>
 * @author      Simon Stal <simon@berazy.se>
 * @copyright   2013 Berazy AB (publ)
 * @version     1.0.0
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
 
/********************************************************************************
 * Custom autoloading
 * Do not use if you are using Composer to autoload dependencies.
 *******************************************************************************/
     
    function customAutoLoader($class) {
        $file = rtrim(dirname(__FILE__), '/') . '/' . $class . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            return;
        }
    }
    spl_autoload_register('customAutoLoader');

/********************************************************************************
 * Initialize InvoiceClient
 *******************************************************************************/
 
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
    
    /*
    try {
        $response = $client->SsnCheck($ssnCheckRequest);
        var_dump($client->__getLastRequest());
        var_dump($response);
    } catch (\Exception $e) {
        // Do logging here ...
        var_dump($e->getMessage());
        var_dump($client->__getLastRequest());
    }
    */
    
/********************************************************************************
 * InvoiceStatus request
 *******************************************************************************/

    $invoiceStatusRequest = new \Berazy\Invoice\Contract\InvoiceStatusRequest();
    $invoiceStatusRequestType = new \Berazy\Invoice\Contract\InvoiceStatusRequestType();
    $invoiceStatusRequestType->setOcr('OCR_NUMBER_AS_INT');
    $invoiceStatusRequest->setRequest($invoiceStatusRequestType);
    
    /*
    try {
        $response = $client->InvoiceStatus($invoiceStatusRequest);
        var_dump($client->__getLastRequest());
        var_dump($response);
    } catch (\Exception $e) {
        // Do logging here ...
        var_dump($e->getMessage());
        var_dump($client->__getLastRequest());
    }
    */
 
?>