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
 * Class equivalent to the XML element CareOfType.
 * <careOf ...></careOf>
 *
 * @package Berazy
 * @author  Johan Sall Larsson <johan@berazy.se>
 * @author  Simon Stal <simon@berazy.se>
 * @since   1.0.0
 */
class CareOfType
{

    /**
     * Company Name / Invoice Receiver Name
     * @var string
     */
    private $name;

    /**
     * Address line.
     * @var string
     */
    private $addressLine1;

    /**
     * Optional extra address line.
     * @var string
     */
    private $addressLine2;

    /**
     * Optional postal code.
     * @var string
     */
    private $postalCode;

    /**
     * Optional city / town.
     * @var string
     */
    private $city;

    /********************************************************************************
     * Getters and setters
     *******************************************************************************/
     
    /**
     * @XmlElement co_name
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @XmlElement co_address
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }
    
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
        return $this;
    }
    
    /**
     * @XmlElement co_address2
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }
    
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
        return $this;
    }
    
    /**
     * @XmlElement co_zip
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }
    
    /**
     * @XmlElement co_city
     */
    public function getCity()
    {
        return $this->city;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    
}
