using System.Xml.Serialization;

namespace Berazy.PoS.Client.Contracts {

    /// <summary>
    /// http://www.berazy.se/API/createInvoicePOSSchema1.0.xsd
    /// </summary>
    [XmlRoot(ElementName = "methodCall", Namespace = "http://www.berazy.se/API/createInvoicePOS")]
    public class PoSCreateInvoiceResponse {

        /// <summary>
        /// The schema location XML attribute.
        /// </summary>
        [XmlAttribute(AttributeName = "schemaLocation", Namespace = "http://www.w3.org/2001/XMLSchema-instance")]
        public string SchemaLocation = "http://www.berazy.se/API/createInvoicePOS http://www.berazy.se/API/createInvoicePOSSchema1.0.xsd";

        /// <summary>
        /// The request method name.
        /// </summary>
        [XmlElement(ElementName = "methodName")]
        public string MethodName = "createInvoice";

        /// <summary>
        /// The response body.
        /// </summary>
        [XmlElement(ElementName = "response")]
        public PoSCreateInvoiceResponseType Response { get; set; }

    }

    public class PoSCreateInvoiceResponseType {

        [XmlElement(ElementName = "statusCode")]
        public int StatusCode { get; set; }

        [XmlElement(ElementName = "ocr")]
        public string Ocr { get; set; }

        [XmlElement(ElementName = "bg_account")]
        public string BgAccount { get; set; }

        [XmlElement(ElementName = "dueDate")]
        public int InvoiceDueDate { get; set; }

        [XmlElement(ElementName = "customerSsn")]
        public string CustomerSsn { get; set; }

        [XmlElement(ElementName = "customerName")]
        public string CustomerName { get; set; }

        [XmlElement(ElementName = "customerAddress")]
        public string CustomerAddress { get; set; }

        [XmlElement(ElementName = "customerZip")]
        public string CustomerPostalCode { get; set; }

        [XmlElement(ElementName = "customerCity")]
        public string CustomerCity { get; set; }

        [XmlElement(ElementName = "companyOrgNo")]
        public string CompanyOrganizationNumber { get; set; }

        [XmlElement(ElementName = "companyName")]
        public string CompanyName { get; set; }

        [XmlElement(ElementName = "companyAddress")]
        public string CompanyAddress { get; set; }

        [XmlElement(ElementName = "companyZip")]
        public string CompanyPostalCode { get; set; }

        [XmlElement(ElementName = "companyCity")]
        public string CompanyCity { get; set; }

        [XmlElement(ElementName = "showInvoiceFooterTextInResponse")]
        public string ShowInvoiceFooterTextInResponse { get; set; }

        [XmlArray("invoiceRows")]
        [XmlArrayItem("row")]
        public PoSInvoiceRowsType InvoiceRows { get; set; }
        
        [XmlElement(ElementName = "pdfFile")]
        public string PdfFile { get; set; }

        [XmlElement(ElementName = "errorCode")]
        public string ErrorCode { get; set; }

        [XmlElement(ElementName = "description")]
        public string Description { get; set; }

    }

}
