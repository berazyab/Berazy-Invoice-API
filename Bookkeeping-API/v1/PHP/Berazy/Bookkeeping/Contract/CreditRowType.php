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
 * Class equivalent to the XML element CreditRowType.
 * <creditRow ...></creditRow>
 *
 * @package Berazy
 * @author  Johan Sall Larsson <johan@berazy.se>
 * @author  Simon Stal <simon@berazy.se>
 * @since   1.0.0
 *
 * @XmlElement creditRow
 */
class CreditRowType {

    /**
     * The article number.
     * @var string
     */
    private $articleNumber;
    
    /**
     * VAT of the article, either 0, 6, 12 or 25.
     * @var int
     */
    private $vat;
    
    /**
     * The quantity of the sold articles.
     * @var int
     */
    private $quantity;
    
    /**
     * Price incl. VAT or excl. VAT (depending on isVatIncluded) in price per unit.
     * @see isVatIncluded
     * @var int
     */
    private $price;

    /********************************************************************************
     * Getters and setters
     *******************************************************************************/
     
    /**
     * @XmlElement articleNo
     */
    public function getArticleNumber() {
        return $this->articleNumber;
    }

    public function setArticleNumber($articleNumber) {
        $this->articleNumber = $articleNumber;
        return $this;
    }
    
    /**
     * @XmlElement vat
     */
    public function getVat() {
        return $this->vat;
    }

    public function setVat($vat) {
        $this->vat = $vat;
        return $this;
    }
    
    /**
     * @XmlElement quantity
     */
    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }
    
    /**
     * @XmlElement price
     */
    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }
    
}

?>