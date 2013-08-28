using Berazy.Examples.BerazyLiveWebService;
using Berazy.Examples.DataAccess.ServiceAgent;
using Berazy.Examples.Utils.Ext;
using System;
using System.Configuration;

namespace Berazy.Examples {

    /// <summary>
    /// Simple WS example program.
    /// </summary>
    internal class Program {

        /// <summary>
        /// A test organizational number or unique identifier number for an individual. 
        /// </summary>
        const string TestOrganizationNumber = null;

        /// <summary>
        /// An test OCR invoice number.
        /// </summary>
        const int TestOcrNumber = -1;

        /// <summary>
        /// A test company name.
        /// </summary>
        const string TestCompanyName = null;

        /// <summary>
        /// The Authorization Token used in all examples, see app.config.
        /// </summary>
        /// <remarks>Mandatory for all requests.</remarks>
        static string AuthToken { get; set; }

        /// <summary>
        /// The Customer number used in all examples, see app.config.
        /// </summary>
        /// <remarks>Mandatory for all requests.</remarks>
        static int CustomerNumber { get; set; }

        static void Main(string[] args) {
            try {
                VerifySetup();
                string line;
                Console.WriteLine("Choose operation to invoke:\n");
                Console.WriteLine("1. SsnCheck\n");
                Console.WriteLine("2. InvoiceStatus\n");
                Console.WriteLine("3. InvoiceDetails\n");
                Console.WriteLine("4. ActivateInvoice\n");
                Console.WriteLine("5. ResendInvoice\n");
                Console.WriteLine("6. PauseInvoice\n");
                Console.WriteLine("7. SearchCompany\n");
                do {
                    line = Console.ReadLine();
                    if (line.IsNotNull()) {
                        switch (line) {
                            case "1":
                                OutPutResponse(SsnCheck());
                                break;
                            case "2":
                                OutPutResponse(InvoiceStatus());
                                break;
                            case "3":
                                OutPutResponse(InvoiceDetails());
                                break;
                            case "4":
                                OutPutResponse(ActivateInvoice());
                                break;
                            case "5":
                                OutPutResponse(ResendInvoice());
                                break;
                            case "6":
                                OutPutResponse(PauseInvoice());
                                break;
                            case "7":
                                OutPutResponse(SearchCompany());
                                break;
                            case "q":
                            case "quit":
                            case "exit":
                                return;
                            default:
                                Console.WriteLine("\nPlease choose an operation from 1-7.");
                                break;
                        }
                    }
                } while (line.IsNotNull());
            } catch (Exception ex) {
                Console.WriteLine("\nAn exception occured, press CTRL+Z to exit or enter 'q', 'quit' or 'exit'.\n\nException: {0}", ex.Message);
                Console.ReadLine();
            }
        }

        static SsnCheckResponseType SsnCheck() {
            return InvoiceServiceAgent.Instance().SsnCheck(new SsnCheckRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                ssn = TestOrganizationNumber,
                credit_check = 0
            });
        }

        static InvoiceStatusResponseType InvoiceStatus() {
            return InvoiceServiceAgent.Instance().InvoiceStatus(new InvoiceStatusRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                ocr = TestOcrNumber
            });
        }

        static InvoiceDetailsResponseType InvoiceDetails() {
            return InvoiceServiceAgent.Instance().InvoiceDetails(new InvoiceDetailsRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                ocr = TestOcrNumber
            });
        }

        static ActivateInvoiceResponseType ActivateInvoice() {
            return InvoiceServiceAgent.Instance().ActivateInvoice(new ActivateInvoiceRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                ocr = TestOcrNumber
            });
        }

        static ResendInvoiceResponseType ResendInvoice() {
            return InvoiceServiceAgent.Instance().ResendInvoice(new ResendInvoiceRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                ocr = TestOcrNumber,
                co_address1 = "This",
                co_address2 = "is",
                co_address3 = "only",
                co_address4 = "a",
                co_address5 = "test",
                print_setup = 1,
                invoice_state = 1,
                clear_co_address = true
            });
        }

        static PauseInvoiceResponseType PauseInvoice() {
            return InvoiceServiceAgent.Instance().PauseInvoice(new PauseInvoiceRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                ocr = TestOcrNumber
            });
        }

        static SearchCompanyResponseType SearchCompany() {
            return InvoiceServiceAgent.Instance().SearchCompany(new SearchCompanyRequestType() {
                key = AuthToken,
                customerno = CustomerNumber,
                company_name = TestCompanyName,
                phonetic_search = true,
                number_hits = 10
            });
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
            var customerNumber = ConfigurationManager.AppSettings.Get("customerNo");
            var authToken = ConfigurationManager.AppSettings.Get("authToken");
            if (string.IsNullOrWhiteSpace(authToken) ||
                string.IsNullOrWhiteSpace(customerNumber) ||
                string.IsNullOrWhiteSpace(TestOrganizationNumber) ||
                TestOcrNumber < 0 ||
                string.IsNullOrWhiteSpace(TestCompanyName)) {
                    throw new ArgumentException("All examples requires customerNo, authToken to be set in App.config and all constants to be set in Program.cs.");
            }
            int customerNo = -1;
            if (!int.TryParse(customerNumber, out customerNo)) {
                throw new ArgumentException("CustomerNumber must be an int.");
            }
            CustomerNumber = customerNo;
            AuthToken = authToken;
        }

    }

}
