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
 
namespace Berazy\Invoice;

/**
 * The Berazy Invoice SOAP API client.
 *
 * @package Berazy
 * @author  Johan Sall Larsson <johan@berazy.se>
 * @author  Simon Stal <simon@berazy.se>
 * @since   2.0.0
 */
class InvoiceClient extends \SoapClient {
    
    /**
     * The customer number.
     * @var int
     */
    private $customerNumber;
    
    /**
     * The authorization token.
     * @var string
     */
    private $authToken;
    
    /**
     * The class map.
     * @var array
     */
    private $classMap = array(
        'SsnCheckRequest'            => 'Contract\SsnCheckRequest',
        'SsnCheckRequestType'        => 'Contract\SsnCheckRequestType',
        'InvoiceStatusRequest'       => 'Contract\InvoiceStatusRequest',
        'InvoiceStatusRequestType'   => 'Contract\InvoiceStatusRequestType',
        'InvoiceDetailsRequest'      => 'Contract\InvoiceDetailsRequest',
        'InvoiceDetailsRequestType'  => 'Contract\InvoiceDetailsRequestType',
        'ActivateInvoiceRequest'     => 'Contract\ActivateInvoiceRequest',
        'ActivateInvoiceRequestType' => 'Contract\ActivateInvoiceRequestType', 
        'ResendInvoiceRequest'       => 'Contract\ResendInvoiceRequest',
        'ResendInvoiceRequestType'   => 'Contract\ResendInvoiceRequestType',
        'PauseInvoiceRequest'        => 'Contract\PauseInvoiceRequest'
        'PauseInvoiceRequestType'    => 'Contract\PauseInvoiceRequestType',
        'SearchCompanyRequest'       => 'Contract\SearchCompanyRequest',
        'SearchCompanyRequestType'   => 'Contract\SearchCompanyRequestType'
    );
    
    /**
     * Default constructor.
     * @param array $options SoapClient options
     * @see http://www.php.net/manual/en/soapclient.soapclient.php
     */
    public function __construct($options = array()) { 
        $default = array_merge(array( 
            'trace' => TRUE, 
            'encoding' => 'utf-8', 
            'connection_timeout' => 0, 
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'cache_wsdl' => WSDL_CACHE_MEMORY,
            'compression' => 0,
            'profile_agent' => 'PHP-SOAP/'. phpversion() . ', gzip',
            'classmap' => $this->classMap
        ), $options);
        parent::__construct('https://www.berazy.se/soap/invoice_v2.0?wsdl', $default);
    }
    
    /**
     * Intercept the soap call to add key and customerNo 
     * in each request, if using defined classes.
     * @param  string $function
     * @param  array  $args
     * @return mixed
     */
    public function __call($function, $args) {
        $soapRequest = $args[0];
        if (is_object($soapRequest) && ($soapRequest instanceof Contract\SoapRequest)) {
            if ($soapRequest->getRequest() instanceof Contract\AuthenticationType) {
                $soapRequest->getRequest()->setKey($this->getAuthToken());
                $soapRequest->getRequest()->setCustomerNo($this->getCustomerNumber());
            }
        }
        return $this->__soapCall($function, $args);
    }
    
    /********************************************************************************
     * Getters and setters
     *******************************************************************************/
     
    /**
     * Returns the customer number.
     * @return int
     */
    public function getCustomerNumber() {
        return $this->customerNumber;
    }
    
    /**
     * Sets the customer number.
     * @return this
     */
    public function setCustomerNumber($customerNumber) {
        $this->customerNumber = $customerNumber;
        return $this;
    }
    
    /**
     * Returns the authorization token.
     * @return string
     */
    public function getAuthToken() {
        return $this->authToken;
    }
    
    /**
     * Sets the authorization token.
     * @return this
     */
    public function setAuthToken($authToken) {
        $this->authToken = $authToken;
        return $this;
    }

}

?>