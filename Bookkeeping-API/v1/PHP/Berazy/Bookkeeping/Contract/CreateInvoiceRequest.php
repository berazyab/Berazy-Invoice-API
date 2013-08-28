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
 * Class equivalent to the XML root element methodCall.
 * <metodCall ...></methodCall>
 *
 * @package	Berazy
 * @author	Johan Sall Larsson <johan@berazy.se>
 * @author	Simon Stal <simon@berazy.se>
 * @since	1.0.0
 *
 * @XmlElement methodCall
 * @XmlNamespace http://www.berazy.se/API/createInvoiceBookkeeping
 * @XmlSchemaLocation http://www.berazy.se/API/createInvoiceBookkeeping http://www.berazy.se/API/createInvoiceBookkeepingSchema1.0.xsd
 */
class CreateInvoiceRequest {
	
	/**
	 * The method name.
	 * @var string
	 */
	private $methodName = 'createInvoice';
	
	/**
	 * The request body.
	 * @var CreateInvoiceRequestType
	 */
	private $request;
	
	/********************************************************************************
     * Getters and setters
     *******************************************************************************/
	 
	/**
	 * @XmlElement methodName
	 */
	public function getMethodName() {
		return $this->methodName;
	}
	
	/**
	 * @XmlElement request
	 */
	public function getRequest() {
		return $this->request;
	}

	public function setRequest(CreateInvoiceRequestType $request) {
		$this->request = $request;
	}
	
}

?>