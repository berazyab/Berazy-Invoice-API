using Berazy.PoS.Client.Contracts;
using Berazy.PoS.Client.Utils;
using Berazy.PoS.Client.Utils.Ext;
using System;
using System.IO;
using System.Net;
using System.Security.Cryptography;
using System.Text;

namespace Berazy.PoS.Client {
    
    /// <summary>
    /// POS Invoice client.
    /// </summary>
    public class PoSInvoiceClient {

        #region Private Constants.

        /// <summary>
        /// The endpoint URL.
        /// </summary>
        const string CreateInvoiceEndpointUrl = "https://www.berazy.se/API/createInvoicePOS";

        /// <summary>
        /// The endpoint URL.
        /// </summary>
        const string CreditInvoiceEndpointUrl = "https://www.berazy.se/API/creditInvoice";

        #endregion

        #region Public Fields.

        /// <summary>
        /// The customer number.
        /// </summary>
        public int CustomerNumber { get; set; }

        /// <summary>
        /// The authentication token/key.
        /// </summary>
        public string AuthToken { get; set; }

        /// <summary>
        /// The IP address.
        /// </summary>
        public string IpAddress { get; set; }

        #endregion

        #region Public Functions.

        /// <summary>
        /// Creates an invoice.
        /// </summary>
        /// <param name="request"></param>
        public PoSCreateInvoiceResponse CreateInvoice(PoSCreateInvoiceRequest request) {
            return SendRequest<PoSCreateInvoiceRequest, PoSCreateInvoiceResponse>(CreateInvoiceEndpointUrl, request);
        }

        /// <summary>
        /// Credits 1-N invoice rows with given amount.
        /// </summary>
        /// <param name="request"></param>
        public PoSCreditInvoiceResponse CreditInvoice(PoSCreditInvoiceRequest request) {
            return SendRequest<PoSCreditInvoiceRequest, PoSCreditInvoiceResponse>(CreditInvoiceEndpointUrl, request);
        }

        #endregion

        #region Private Functions.

        /// <summary>
        /// Creates the POST request.
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="serviceUrl"></param>
        /// <param name="obj"></param>
        TResponse SendRequest<TRequest, TResponse>(string serviceUrl, TRequest obj) {
            serviceUrl.ThrowIfNull("ServiceUrl in SendRequest cannot be null!");
            obj.ThrowIfNull("Obj in SendRequest cannot be null!");
            var data = XmlUtils.Serialize<TRequest>(obj);
            var address = new Uri(serviceUrl);
            var byteData = UTF8Encoding.UTF8.GetBytes(data);
            var key = Hash(string.Format("{0}{1:yyyyMMdd}{2}", IpAddress, DateTime.Now, AuthToken));
            var request = WebRequest.Create(address) as HttpWebRequest;
            request.Method = "POST";
            request.ContentType = "application/xml";
            request.ContentLength = byteData.Length;
            request.Headers.Add("customerNo", CustomerNumber.ToString());
            request.Headers.Add("key", key);
            using (Stream postStream = request.GetRequestStream()) {
                postStream.Write(byteData, 0, byteData.Length);
            }
            using (HttpWebResponse response = request.GetResponse() as HttpWebResponse) {
                using (var reader = new StreamReader(response.GetResponseStream(), Encoding.UTF8)) {
                    return XmlUtils.Deserialize<TResponse>(reader);
                }
            }
        }

        /// <summary>
        /// Computes the MD5 hash key.
        /// </summary>
        /// <param name="value"></param>
        string Hash(string value) {
            using (var hash = MD5.Create()) {
                byte[] data = hash.ComputeHash(Encoding.UTF8.GetBytes(value));
                var builder = new StringBuilder(); 
                for (int i = 0; i < data.Length; i++) {
                    builder.Append(data[i].ToString("x2"));
                }
                return builder.ToString();
            }

        }

        #endregion

    }

}
