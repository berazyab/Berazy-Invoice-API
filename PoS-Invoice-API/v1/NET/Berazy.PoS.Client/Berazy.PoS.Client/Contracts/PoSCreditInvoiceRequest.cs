using System.Collections.Generic;
using System.Xml.Serialization;

namespace Berazy.PoS.Client.Contracts {

    [XmlRoot(ElementName = "methodCall", Namespace = "http://www.berazy.se/API/creditInvoice")]
    public class PoSCreditInvoiceRequest {

        /// <summary>
        /// The schema location XML attribute.
        /// </summary>
        [XmlAttribute(AttributeName = "schemaLocation", Namespace = "http://www.w3.org/2001/XMLSchema-instance")]
        public string SchemaLocation = "http://www.berazy.se/API/creditInvoice http://www.berazy.se/API/creditInvoiceSchema1.0.xsd";

        /// <summary>
        /// The request method name.
        /// </summary>
        [XmlElement(ElementName = "methodName")]
        public string MethodName = "creditInvoice";

        /// <summary>
        /// The request body.
        /// </summary>
        [XmlElement(ElementName = "request")]
        public PoSCreditInvoiceRequestType Request { get; set; }

    }

    public class PoSCreditInvoiceRequestType {

        /// <summary>
        /// If "True": the credit will not be persisted.
        /// For testing purposes only, e.g. Unit Tests.
        /// </summary>
        [XmlElement(ElementName = "testCredit")]
        public bool IsInTestMode { get; set; }

        /// <summary>
        /// E-faktura, PDF
        /// Printa själv
        /// Print on Demand
        /// SMS Faktura
        /// </summary>
        [XmlElement(ElementName = "printSetup")]
        public PoSPrintSetupType PrintSetup { get; set; }

        /// <summary>
        /// Whether or not the price is with VAT included or not.
        /// </summary>
        [XmlElement(ElementName = "includingVat")]
        public int? IsVatIncluded { get; set; }

        /// <summary>
        /// The OCR number.
        /// </summary>
        [XmlElement(ElementName = "ocr")]
        public int Ocr { get; set; }

        /// <summary>
        /// The Order number.
        /// </summary>
        [XmlElement(ElementName = "orderNo")]
        public string OrderNumber { get; set; }

        /// <summary>
        /// The Order number.
        /// </summary>
        [XmlElement(ElementName = "showInvoiceFooterTextInResponse")]
        public int? ShowInvoiceFooterTextInResponse { get; set; }

        /// <summary>
        /// A comment included in the credit.
        /// </summary>
        [XmlElement(ElementName = "comment")]
        public string Comment { get; set; }

        /// <summary>
        /// E-mail address if we shall send the credit invoice via E-mail.
        /// </summary>
        [XmlElement(ElementName = "email")]
        public string EmailAddress { get; set; }

        /// <summary>
        /// Mobile Phone Number, needed for SMS Faktura print setup 4.
        /// Formatted as 46123456789, +46123456789.
        /// </summary>
        [XmlElement(ElementName = "mobile")]
        public string MobilePhoneNumber { get; set; }

        /// <summary>
        /// All rows will be automatically credited.
        /// </summary>
        [XmlElement(ElementName = "creditAllRows")]
        public int? CreditAllInvoiceRows { get; set; }
        
        /// <summary>
        /// The credit rows.
        /// </summary>
        [XmlArray("creditRows")]
        [XmlArrayItem("creditRow")]
        public PoSCreditRowsType CreditRows { get; set; }

        /// <summary>
        /// Serialize nullable values helper
        /// </summary>
        public bool ShouldSerializeIsVatIncluded() {
            return IsVatIncluded != null;
        }
        
        /// <summary>
        /// Serialize nullable values helper
        /// </summary>
        public bool ShouldSerializeShowInvoiceFooterTextInResponse() {
            return ShowInvoiceFooterTextInResponse != null;
        }

        /// <summary>
        /// Serialize nullable values helper
        /// </summary>
        public bool ShouldSerializeCreditAllInvoiceRows() {
            return CreditAllInvoiceRows != null;
        }

    }

    public class PoSCreditRowsType : List<PoSCreditRowType> { }

    public class PoSCreditRowType {

        /// <summary>
        /// The article number.
        /// </summary>
        [XmlElement(ElementName = "articleNo", IsNullable = false)]
        public string ArticleNumber { get; set; }
        
        /// <summary>
        /// VAT of the article, either 0, 6, 12 or 25.
        /// </summary>
        [XmlElement(ElementName = "vat")]
        public int Vat { get; set; }

        /// <summary>
        /// The quantity of the sold articles.
        /// </summary>
        [XmlElement(ElementName = "quantity")]
        public int Quantity { get; set; }

        /// <summary>
        /// Price incl. VAT or excl. VAT (depending on <see cref="IsVatIncluded"/>) in price per unit.
        /// </summary>
        [XmlElement(ElementName = "price")]
        public int Price { get; set; }

    }

}
