using Berazy.PoS.Client;
using Berazy.PoS.Client.Contracts;
using Berazy.PoS.Client.Utils;
using Berazy.PoS.Example.Utils;
using Berazy.PoS.Example.Utils.Ext;
using System;
using System.Configuration;
using System.Xml.Serialization;

namespace Berazy.PoS.Example {

    /// <summary>
    /// Bookkeeping API example.
    /// </summary>
    internal class Program {

        /// <summary>
        /// The Bookkeeping API client.
        /// </summary>
        static PoSInvoiceClient Client { get; set; }

        /// <summary>
        /// Main method.
        /// </summary>
        /// <param name="args"></param>
        static void Main(string[] args) {

            try {
                Initialize();
                string line;
                Console.WriteLine("Choose operation to invoke:\n");
                Console.WriteLine("1. Create invoice\n");
                Console.WriteLine("2. Credit invoice\n");
                do {
                    line = Console.ReadLine();
                    if (line.IsNotNull()) {
                        switch (line) {
                            case "1":
                                OutPutResponse(CreateInvoice());
                                break;
                            case "2":
                                OutPutResponse(CreditInvoice());
                                break;
                            case "q":
                            case "quit":
                            case "exit":
                                return;
                            default:
                                Console.WriteLine("\nPlease choose an operation from 1-2.");
                                break;
                        }
                    }
                } while (line.IsNotNull());
            } catch (Exception ex) {
                Console.WriteLine("\nAn exception occured, press CTRL+Z to exit or enter 'q', 'quit' or 'exit'.\n\nException: {0} {1}", ex.Message, ex.InnerException);
                Console.ReadLine();
            }
        }

        /// <summary>
        /// Create an invoice example.
        /// </summary>
        static PoSCreateInvoiceResponseType CreateInvoice() {
            string ssn = null;
            string orgNumber = null;
            string emailAddress = null;
            orgNumber.ThrowIfNull("Organizational number must be set!");
            ssn.ThrowIfNull("Social security number must be set!");
            emailAddress.ThrowIfNull("E-mail address must be set!");
            var request = new PoSCreateInvoiceRequest() {
                Request = new PoSCreateInvoiceRequestType() {
                    IsInTestMode = true,
                    MakeInvoiceReservation = 1,
                    ForceNoSsnCheck = 0,
                    ForceNoOrganizationNumberCheck = 0,
                    Service = PoSServiceType.InvoiceService,
                    PrintSetup = PoSPrintSetupType.EPdfPrint,
                    SSN = ssn,
                    OrganizationNumber = orgNumber,
                    EmailAddress = emailAddress,
                    OrderNumber = Guid.NewGuid().ToString(),
                    InvoiceDate = DateTimeUtils.UnixTime(DateTime.UtcNow),
                    InvoiceDueDate = DateTimeUtils.UnixTime(DateTime.UtcNow.AddDays(30)),
                    InvoiceRows = new PoSInvoiceRowsType() {
                        new PoSInvoiceRowType() {
                            ArticleText = "Biljett",
                            ArticleNumber = "666",
                            Description = "GOT - STO 2099-01-01",
                            Quantity = 1,
                            Vat = 0,
                            Price = 100,
                            Unit = "pcs",
                            BookkeepingAccount = 9999
                        }
                    }
                }
            };
            Console.WriteLine("XML request: ");
            Console.WriteLine(Serialize<PoSCreateInvoiceRequest>(request));
            return Client.CreateInvoice(request).Response;
        }

        /// <summary>
        /// Credit an invoice row example.
        /// </summary>
        /// <returns></returns>
        static PoSCreditInvoiceResponseType CreditInvoice() {
            int? ocrNumber = null;
            ocrNumber.ThrowIfNull("OCR number must be set!");
            var request = new PoSCreditInvoiceRequest() {
                Request = new PoSCreditInvoiceRequestType() {
                    IsInTestMode = true,
                    PrintSetup = PoSPrintSetupType.EPdfPrint,
                    IsVatIncluded = 1,
                    Ocr = ocrNumber.Value,
                    CreditRows = new PoSCreditRowsType() { 
                        new PoSCreditRowType() {
                            ArticleNumber = "666",
                            Vat = 0,
                            Quantity = 1,
                            Price = 100
                        }
                    }
                }
            };
            Console.WriteLine("XML request: ");
            Console.WriteLine(Serialize<PoSCreditInvoiceRequest>(request));
            return Client.CreditInvoice(request).Response;
        }

        /// <summary>
        /// Initialization.
        /// </summary>
        static void Initialize() {
            var customerNo = ConfigurationManager.AppSettings.Get("customerNo");
            var authToken = ConfigurationManager.AppSettings.Get("authToken");
            var ipAddress = ConfigurationManager.AppSettings.Get("ipAddress");
            if (customerNo.IsEmpty() || authToken.IsEmpty() || ipAddress.IsEmpty()) {
                throw new ArgumentException("All examples requires customerNo, authToken and ipAddress to be set in App.config!");
            }
            int customerNumber = 0;
            if (!int.TryParse(customerNo, out customerNumber)) {
                throw new ArgumentException("CustomerNo must be an int!");
            }
            Client = new PoSInvoiceClient() {
                CustomerNumber = customerNumber,
                AuthToken = authToken,
                IpAddress = ipAddress
            };
        }

        /// <summary>
        /// Writes out all public fields.
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="response"></param>
        static void OutPutResponse<T>(T response) {
            var retval = "\nResponse: \n";
            var type = typeof(T);
            var propInfos = type.GetProperties();
            foreach (var propInfo in propInfos) {
                if (!propInfo.Name.Equals("ExtensionData")) {
                    retval += string.Format("{0}: {1}\n", propInfo.Name, propInfo.GetValue(response, null));
                }
            }
            Console.WriteLine(retval);
        }

        /// <summary>
        /// Serialize an object to XML.
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="obj"></param>
        public static string Serialize<T>(T obj) {
            var serializer = new XmlSerializer(typeof(T));
            using (var writer = new Utf8StringWriter()) {
                serializer.Serialize(writer, obj);
                return writer.ToString();
            }
        }


    }

}
