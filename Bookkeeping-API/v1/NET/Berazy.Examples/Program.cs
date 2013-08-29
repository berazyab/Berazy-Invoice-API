using Berazy.Examples.Contracts;
using Berazy.Examples.Extensions;
using Berazy.Examples.Utils;
using System;
using System.Configuration;

namespace Berazy.Examples {

    /// <summary>
    /// Bookkeeping API example.
    /// </summary>
    internal class Program {

        /// <summary>
        /// A test organizational number or unique identifier number for an individual. 
        /// </summary>
        const string TestOrganizationalNumber = "";

        // <summary>
        /// A test E-mail address. 
        /// </summary>
        const string TestEmailAddress = "";

        // <summary>
        /// A test OCR number for credit. 
        /// </summary>
        const int TestOcrNumberToCredit = -1;

        /// <summary>
        /// Main method.
        /// </summary>
        /// <param name="args"></param>
        static void Main(string[] args) {

            try {
                VerifySetup();
                string line;
                Console.WriteLine("Choose operation to invoke:\n");
                Console.WriteLine("1. CreateInvoice\n");
                Console.WriteLine("2. CreditInvoice\n");
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
        static CreateInvoiceResponseType CreateInvoice() {
            if (string.IsNullOrWhiteSpace(TestOrganizationalNumber) || string.IsNullOrWhiteSpace(TestEmailAddress)) {
                throw new ArgumentException("Constants TestOrgnizationalNumber and TestEmailAddress needs to be set!");
            }
            var client = new BookkeepingClient();
            var request = new CreateInvoiceRequest() {
                Request = new CreateInvoiceRequestType() {
                    IsInTestMode = true,
                    MakeInvoiceReservation = 1,
                    ForceToSend = 0,
                    Service = ServiceType.InvoiceService,
                    PrintSetup = PrintSetupType.EPdfPrint,
                    SSN = TestOrganizationalNumber,
                    EmailAddress = TestEmailAddress,
                    OrderNo = Guid.NewGuid().ToString(),
                    InvoiceDate = DateTimeUtils.UnixTime(DateTime.UtcNow),
                    InvoiceDueDate = DateTimeUtils.UnixTime(DateTime.UtcNow.AddDays(30)),
                    InvoiceRows = new InvoiceRowsType() {
                        new InvoiceRowType() {
                            ArticleText = "Biljett",
                            ArticleNo = "666",
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
            Console.WriteLine(XmlUtils.Serialize<CreateInvoiceRequest>(request));
            return client.CreateInvoice(request).Response;
        }

        /// <summary>
        /// Credit an invoice row example.
        /// </summary>
        /// <returns></returns>
        static CreditInvoiceResponseType CreditInvoice() {
            if (TestOcrNumberToCredit == -1) {
                throw new ArgumentException("Constant TestOcrNumberToCredit needs to be set with a valid OCR for this example!");
            }
            var client = new BookkeepingClient();
            var request = new CreditInvoiceRequest() {
                Request = new CreditInvoiceRequestType() {
                    IsInTestMode = true,
                    PrintSetup = PrintSetupType.EPdfPrint,
                    IsVatIncluded = 1,
                    Ocr = TestOcrNumberToCredit,
                    CreditRows = new CreditRowsType() { 
                        new CreditRowType() {
                            ArticleNumber = "666",
                            Vat = 0,
                            Quantity = 1,
                            Price = 100
                        }
                    }
                }
            };
            Console.WriteLine("XML request: ");
            Console.WriteLine(XmlUtils.Serialize<CreditInvoiceRequest>(request));
            return client.CreditInvoice(request).Response;
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
        /// Verifies setup.
        /// </summary>
        static void VerifySetup() {
            var customerNo = ConfigurationManager.AppSettings.Get("customerNo");
            var authToken = ConfigurationManager.AppSettings.Get("authToken");
            var ipAddress = ConfigurationManager.AppSettings.Get("ipAddress");
            if (
                string.IsNullOrWhiteSpace(customerNo) ||
                string.IsNullOrWhiteSpace(authToken) ||
                string.IsNullOrWhiteSpace(ipAddress)
            ) {
                throw new ArgumentException("All examples requires customerNo, authToken and ipAddress to be set in App.config.");
            }

        }

    }

}
