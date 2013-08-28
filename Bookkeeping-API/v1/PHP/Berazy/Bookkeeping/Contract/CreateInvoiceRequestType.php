<?php
/**
 * Berazy Bookkeeping API Client
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
 
 namespace Berazy\Bookkeeping\Contract;

/**
 * Class equivalent to the XML element RequestType.
 * <request ...></request>
 *
 * @package	Berazy
 * @author	Johan Sall Larsson <johan@berazy.se>
 * @author	Simon Stal <simon@berazy.se>
 * @since	1.0.0
 */
class CreateInvoiceRequestType {

	/**
	 * If "true" the invoice won't persist any invoice.
	 * @var string
	 */
	private $isTestModeEnabled;
	
	/**
	 * If 1 the invoice will NOT be sent to the customer 
	 * until activation, see activate_invoice.
	 * @var int
	 */
	private $makeInvoiceReservation;
	
	/**
	 * Force to send invoice even though the end user has got a bad credit rate. 
	 * Suitable for use with errorCode 116, 117 120 and 121.
	 * @var int
	 */
	private $forceToSend;

	/**
	 * 1. Fakturaservice
	 * 2. Fakturabelåning
	 * 3. Factoring
	 * @var int
	 */
	private $service;

	/**
	 * 1. E-faktura, PDF
	 * 2. Printa själv
	 * 3. Print on Demand
	 * 4. SMS Faktura
	 * @var int
	 */
	private $printSetup;

	/**
	 * Social Security Number, Organization Number, or a 32 character auth key (ONLY for WAP Purchase API).
	 * @var string
	 */
	private $ssn;

	/**
	 * ?
	 * @var int
	 */
	private $sendToOrganization;

	/**
	 * Used to send invoices to other countries.
	 * @var ForeignCustomerType
	 */
	private $foreignCustomer;
	
	/**
	 * To send the invoice to another address instead of the company address
	 * @var CareOfAddressType
	 */
	private $careOfAddress;

	/**
	 * This value will be visible on the invoice as an order number.
	 * @var string
	 */
	private $invoiceReference;

	/**
	 * The reference number of the order made from the end customer. 
	 * Will be visible on the invoice for the end customer.
	 * @var string
	 */
	private $invoiceOrderNo;

	/**
	 * Shipping fee for an order. This value will be added as an invoice row.
	 * @var int
	 */
	private $shippingFee;

	/**
	 * Expedition fee. This value will be added as an invoice row.
	 * @var int
	 */
	private $expeditionFee;

	/**
	 * Date when the invoice shall be sent to the receiver.
	 * @var int
	 */
	private $invoiceDate;

	/**
	 * Invoice Due Date in Unixtime format.
	 * @var int
	 */
	private $invoiceDueDate;

	/**
	 * ?
	 * @var string
	 */
	private $clientIpAddress;

	/**
	 * URL for callback trigger when invoice has been changed or a payment is received.
	 * @var string
	 */
	private $callbackUrl;

	/**
	 * Mobile Phone Number
	 * @var string
	 */
	private $mobile;

	/**
	 * Email Address.
	 * @var string
	 */
	private $emailAddress;

	/**
	 * Order Number, must be unique for each invoice and should be an internal value. 
	 * Used to get the status or credit the invoice.
	 * @var string
	 */
	private $orderNumber;

	/**
	 * Visible as Our Reference.
	 * @var string
	 */
	private $ourReference;

	/**
	 * Visible as Your Reference.
	 * @var string
	 */
	private $yourReference;

	/**
	 * The invoice rows.
	 * @var array
	 */
	private $invoiceRows;

	/**
	 * Add an invoice Comment for the end user. Visible below the article rows on the invoice.
	 * @var string
	 */
	private $comment;

	/**
	 * Discount percentage of the total invoice amount.
	 * @var int
	 */
	private $discount;

	/**
	 * The billing variable (?).
	 * @var string
	 */
	private $billingVar;
	
	/********************************************************************************
     * Getters and setters
     *******************************************************************************/
	 
	/**
	 * @XmlElement testInvoice
	 */
	public function isTestModeEnabled() {
		return $this->isTestModeEnabled;
	}
	
	public function setIsTestModeEnabled($isTestModeEnabled) {
		$this->isTestModeEnabled = $isTestModeEnabled;
	}
	
	/**
	 * @XmlElement makeInvoiceReservation
	 */
	public function getMakeInvoiceReservation() {
		return $this->makeInvoiceReservation;
	}
	
	public function setMakeInvoiceReservation($makeInvoiceReservation) {
		$this->makeInvoiceReservation = $makeInvoiceReservation;
	}
		
	/**
	 * @XmlElement forceToSend
	 */
	public function getForceToSend() {
		return $this->forceToSend;
	}
	
	public function setForceToSend($forceToSend) {
		$this->forceToSend = $forceToSend;
	}
	
	/**
	 * @XmlElement service
	 */
	public function getService() {
		return $this->service;
	}
	
	public function setService($service) {
		$this->service = $service;
	}
	
	/**
	 * @XmlElement printSetup
	 */
	public function getPrintSetup() {
		return $this->printSetup;
	}
	
	public function setPrintSetup($printSetup) {
		$this->printSetup = $printSetup;
	}
	
	/**
	 * @XmlElement ssn
	 */
	public function getSsn() {
		return $this->ssn;
	}
	
	public function setSsn($ssn) {
		$this->ssn = $ssn;
	}
	
	/**
	 * @XmlElement send_to_organization
	 */
	public function getSendToOrganization() {
		return $this->sendToOrganization;
	}
	
	public function setSendToOrganization($sendToOrganization) {
		$this->sendToOrganization = $sendToOrganization;
	}
	
	/**
	 * @XmlElement foreignCustomer
	 */
	public function getForeignCustomer() {
		return $this->foreignCustomer;
	}
	
	public function setForeignCustomer(ForeignCustomerType $foreignCustomer) {
		$this->foreignCustomer = $foreignCustomer;
	}
	
	/**
	 * @XmlElement careOfAddress
	 */
	public function getCareOfAddress() {
		return $this->careOfAddress;
	}
	
	public function setCareOfAddress(CareOfAddressType $careOfAddress) {
		$this->careOfAddress = $careOfAddress;
	}
	
	/**
	 * @XmlElement invoiceRef
	 */
	public function getInvoiceReference() {
		return $this->invoiceReference;
	}
	
	public function setInvoiceReference($invoiceReference) {
		$this->invoiceReference = $invoiceReference;
	}
	
	/**
	 * @XmlElement invoiceOrderNo
	 */
	public function getInvoiceOrderNo() {
		return $this->invoiceOrderNo;
	}
	
	public function setInvoiceOrderNo($invoiceOrderNo) {
		$this->invoiceOrderNo = $invoiceOrderNo;
	}

	/**
	 * @XmlElement shippingFee
	 */
	public function getShippingFee() {
		return $this->shippingFee;
	}
	
	public function setShippingFee($shippingFee) {
		$this->shippingFee = $shippingFee;
	}
	
	/**
	 * @XmlElement expFee
	 */
	public function getExpeditionFee() {
		return $this->expeditionFee;
	}
	
	public function setExpeditionFee($expeditionFee) {
		$this->expeditionFee = $expeditionFee;
	}
	
	/**
	 * @XmlElement invoiceDate
	 */
	public function getInvoiceDate() {
		return $this->invoiceDate;
	}
	
	public function setInvoiceDate($invoiceDate) {
		$this->invoiceDate = $invoiceDate;
	}

	/**
	 * @XmlElement dueDate
	 */
	public function getInvoiceDueDate() {
		return $this->invoiceDueDate;
	}
	
	public function setInvoiceDueDate($invoiceDueDate) {
		$this->invoiceDueDate = $invoiceDueDate;
	}

	/**
	 * @XmlElement clientIp
	 */
	public function getClientIpAddress() {
		return $this->clientIpAddress;
	}
	
	public function setClientIpAddress($clientIpAddress) {
		$this->clientIpAddress = $clientIpAddress;
	}
	
	/**
	 * @XmlElement callback
	 */
	public function getCallbackUrl() {
		return $this->callbackUrl;
	}
	
	public function setCallbackUrl($callbackUrl) {
		$this->callbackUrl = $callbackUrl;
	}
	
	/**
	 * @XmlElement mobile
	 */
	public function getMobile() {
		return $this->mobile;
	}
	
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}
	
	/**
	 * @XmlElement email
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
	}
	
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}
	
	/**
	 * @XmlElement orderNo
	 */
	public function getOrderNumber() {
		return $this->orderNumber;
	}
	
	public function setOrderNumber($orderNumber) {
		$this->orderNumber = $orderNumber;
	}
	
	/**
	 * @XmlElement ourRef
	 */
	public function getOurReference() {
		return $this->ourReference;
	}
	
	public function setOurReference($ourReference) {
		$this->ourReference = $ourReference;
	}
	
	/**
	 * @XmlElement yourRef
	 */
	public function getYourReference() {
		return $this->yourReference;
	}
	
	public function setYourReference($yourReference) {
		$this->yourReference = $yourReference;
	}
	
	/**
	 * @XmlElement invoiceRows
	 */
	public function getInvoiceRows() {
		return $this->invoiceRows;
	}
	
	public function setInvoiceRows(array $invoiceRows) {
		$this->invoiceRows = $invoiceRows;
	}
	
	/**
	 * @XmlElement comments
	 */
	public function getComment() {
		return $this->comment;
	}
	
	public function setComment($comment) {
		$this->comment = $comment;
	}
	
	/**
	 * @XmlElement discount
	 */
	public function getDiscount() {
		return $this->discount;
	}
	
	public function setDiscount($discount) {
		$this->discount = $discount;
	}
	
	/**
	 * @XmlElement billingVar
	 */
	public function getBillingVar() {
		return $this->billingVar;
	}
	
	public function setBillingVar($billingVar) {
		$this->billingVar = $billingVar;
	}
	
}

?>