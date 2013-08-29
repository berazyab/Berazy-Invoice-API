package berazy.examples;

/**
 * Berazy Invoice SOAP API Client
 *
 * @author    <a href="mailto:johan@berazy.se">Johan Sall Larsson</a>
 * @version   1.0.0
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
 
import http.schema_invoice_berazy_se.v2.ActivateInvoiceRequest;
import http.schema_invoice_berazy_se.v2.ActivateInvoiceResponse;
import http.schema_invoice_berazy_se.v2.InvoiceDetailsRequest;
import http.schema_invoice_berazy_se.v2.InvoiceDetailsResponse;
import http.schema_invoice_berazy_se.v2.InvoiceStatusRequest;
import http.schema_invoice_berazy_se.v2.InvoiceStatusResponse;
import http.schema_invoice_berazy_se.v2.PauseInvoiceRequest;
import http.schema_invoice_berazy_se.v2.PauseInvoiceResponse;
import http.schema_invoice_berazy_se.v2.ResendInvoiceRequest;
import http.schema_invoice_berazy_se.v2.ResendInvoiceResponse;
import http.schema_invoice_berazy_se.v2.SearchCompanyRequest;
import http.schema_invoice_berazy_se.v2.SearchCompanyResponse;
import http.schema_invoice_berazy_se.v2.SsnCheckRequest;
import http.schema_invoice_berazy_se.v2.SsnCheckResponse;
import http.types_invoice_berazy_se.v2.ActivateInvoiceRequestType;
import http.types_invoice_berazy_se.v2.ActivateInvoiceResponseType;
import http.types_invoice_berazy_se.v2.InvoiceDetailsRequestType;
import http.types_invoice_berazy_se.v2.InvoiceDetailsResponseType;
import http.types_invoice_berazy_se.v2.InvoiceStatusRequestType;
import http.types_invoice_berazy_se.v2.InvoiceStatusResponseType;
import http.types_invoice_berazy_se.v2.PauseInvoiceRequestType;
import http.types_invoice_berazy_se.v2.PauseInvoiceResponseType;
import http.types_invoice_berazy_se.v2.ResendInvoiceRequestType;
import http.types_invoice_berazy_se.v2.ResendInvoiceResponseType;
import http.types_invoice_berazy_se.v2.SearchCompanyRequestType;
import http.types_invoice_berazy_se.v2.SearchCompanyResponseType;
import http.types_invoice_berazy_se.v2.SsnCheckRequestType;
import http.types_invoice_berazy_se.v2.SsnCheckResponseType;

import java.io.IOException;
import java.io.InputStream;
import java.lang.reflect.Field;
import java.util.Properties;
import java.util.Scanner;

import berazy.examples.service.InvoiceServiceAgent;

/**
 * Simple example of client usage.
 *
 * @author <a href="mailto:johan@berazy.se">Johan Sall Larsson</a>
 * @since  1.0.0
 */
public class App {
    
    /**
     * The Authentication token/key used in all examples.
     * Set by profile in POM file during build.
     * @remarks Mandatory for all requests.
     */
    static String authToken;

    /**
     * The customer number used in all examples.
     * Set by profile in POM file during build.
     * @remarks Mandatory for all requests.
     */
    static int customerNo;
    
    /**
     * Operation examples.
     * @param args
     */
    public static void main(String[] args) {

        Scanner scanner = null;
        try {
            loadProperties();
            System.out.println("Choose operation to invoke:\n");
            System.out.println("1. SsnCheck");
            System.out.println("2. InvoiceStatus");
            System.out.println("3. InvoiceDetails");
            System.out.println("4. ActivateInvoice");
            System.out.println("5. ResendInvoice");
            System.out.println("6. PauseInvoice");
            System.out.println("7. SearchCompany\n");
            scanner = new Scanner(System.in);
            while(scanner.hasNextLine()){
                String line = scanner.nextLine();
                line = (line != null) ? line.trim().toLowerCase() : "";
                if (line.equals("1")) {
                    outPutResponse(ssnCheck());
                } else if (line.equals("2")) {
                    outPutResponse(invoiceStatus());
                } else if (line.equals("3")) {
                    outPutResponse(invoiceDetails());
                } else if (line.equals("4")) {
                    outPutResponse(activateInvoice());
                } else if (line.equals("5")) {
                    outPutResponse(resendInvoice());
                } else if (line.equals("6")) {
                    outPutResponse(pauseInvoice());
                } else if (line.equals("7")) {
                    outPutResponse(searchCompany());
                } else if (line.equals("q") || line.equals("quit") || line.equals("exit")) {
                    System.exit(0);
                } else {
                    System.out.println("\nPlease choose an operation from 1-7.");
                }
            }
            scanner.close();
        } catch(Exception ex) {
            System.out.println(String.format("\nAn exception occured, press CTRL+C to exit or enter 'q', 'quit' or 'exit'.\n\nException: %s", ex.getMessage()));
        } finally {
            if (scanner != null) {
                scanner.close();
            }
        }
    }
    
    /**
     * Loads the .properties file and sets authToken
     * and customerNo.
     * @throws IllegalArgumentException
     */
    static void loadProperties() {
        try {
            ClassLoader loader = App.class.getClassLoader();
            InputStream in = loader.getResourceAsStream("invoice-api-settings.properties");
            Properties properties = new Properties();
            properties.load(in);
            authToken = properties.getProperty("authToken");
            customerNo = Integer.parseInt(properties.getProperty("customerNo"));
        } catch (IOException e) {
            throw new IllegalArgumentException("A valid authToken and customerNo must be set in the .pom file before build!");
        }
    }
    
    /**
     * Null checker.
     * @param obj the object to be tested
     * @param str exception message
     * @throws IllegalArgumentException
     */
    static void throwIfNull(Object obj, String str) {
        if (obj == null) {
            throw new IllegalArgumentException(str);
        }
    }
    
    /**
     * Writes out all public fields.
     * @param T response
     */
    static <T> void outPutResponse(T response) {
        String retval = "\nResponse: \n";
        Class<?> clazz = response.getClass();
        Field[] fields = clazz.getDeclaredFields();
        for (Field field : fields) {
            field.setAccessible(true);
            if (!field.getName().equalsIgnoreCase("ExtensionData")) {
                try {
                    retval += String.format("%s: %s\n", field.getName(), field.get(response));
                } catch (IllegalArgumentException e) {
                    e.printStackTrace();
                } catch (IllegalAccessException e) {
                    e.printStackTrace();
                }
            }
        }
        System.out.println(retval);
    }
    
    /**
     * Executes the "SsnCheck" operation.
     * @return SsnCheckResponseType
     */
    static SsnCheckResponseType ssnCheck() {
        String orgNoOrSsn = null;
        throwIfNull(orgNoOrSsn, "Organizational number or social security number must be set!");
        SsnCheckRequestType requestType = new SsnCheckRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setSsn(orgNoOrSsn);
        requestType.setCreditCheck(0);
        SsnCheckRequest request = new SsnCheckRequest();
        request.setRequest(requestType);
        SsnCheckResponse response = InvoiceServiceAgent.getInstance().getService().ssnCheck(request);
        return response.getResponse().getValue();
    }
    
    /**
     * Executes the "InvoiceStatus" operation.
     * @return InvoiceStatusResponseType
     */
    static InvoiceStatusResponseType invoiceStatus() {
        Integer ocrNumber = null;
        throwIfNull(ocrNumber, "OCR number must be set!");
        InvoiceStatusRequestType requestType = new InvoiceStatusRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setOcr(ocrNumber);
        InvoiceStatusRequest request = new InvoiceStatusRequest();
        request.setRequest(requestType);
        InvoiceStatusResponse response = InvoiceServiceAgent.getInstance().getService().invoiceStatus(request);
        return response.getResponse().getValue();
    }
    
    /**
     * Executes the "InvoiceDetails" operation.
     * @return InvoiceDetailsResponseType
     */
    static InvoiceDetailsResponseType invoiceDetails() {
        Integer ocrNumber = null;
        throwIfNull(ocrNumber, "OCR number must be set!");
        InvoiceDetailsRequestType requestType = new InvoiceDetailsRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setOcr(ocrNumber);
        InvoiceDetailsRequest request = new InvoiceDetailsRequest();
        request.setRequest(requestType);
        InvoiceDetailsResponse response = InvoiceServiceAgent.getInstance().getService().invoiceDetails(request);
        return response.getResponse().getValue();
    }
    
    /**
     * Executes the "ActivateInvoice" operation.
     * @return ActivateInvoiceResponseType
     */
    static ActivateInvoiceResponseType activateInvoice() {
        Integer ocrNumber = null;
        throwIfNull(ocrNumber, "OCR number must be set!");
        ActivateInvoiceRequestType requestType = new ActivateInvoiceRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setOcr(ocrNumber);
        ActivateInvoiceRequest request = new ActivateInvoiceRequest();
        request.setRequest(requestType);
        ActivateInvoiceResponse response = InvoiceServiceAgent.getInstance().getService().activateInvoice(request);
        return response.getResponse().getValue();
    }

    /**
     * Executes the "ResendInvoice" operation.
     * @return ResendInvoiceResponseType
     */
    static ResendInvoiceResponseType resendInvoice() {
        Integer ocrNumber = null;
        throwIfNull(ocrNumber, "OCR number must be set!");
        ResendInvoiceRequestType requestType = new ResendInvoiceRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setOcr(ocrNumber);
        requestType.setCoAddress1("This");
        requestType.setCoAddress2("is");
        requestType.setCoAddress3("only");
        requestType.setCoAddress4("a");
        requestType.setCoAddress5("test");
        requestType.setPrintSetup(1);
        requestType.setInvoiceState(1);
        requestType.setClearCoAddress(true);
        ResendInvoiceRequest request = new ResendInvoiceRequest();
        request.setRequest(requestType);
        ResendInvoiceResponse response = InvoiceServiceAgent.getInstance().getService().resendInvoice(request);
        return response.getResponse().getValue();
    }

    /**
     * Executes the "PauseInvoice" operation.
     * @return PauseInvoiceResponseType
     */
    static PauseInvoiceResponseType pauseInvoice() {
        Integer ocrNumber = null;
        throwIfNull(ocrNumber, "OCR number must be set!");
        PauseInvoiceRequestType requestType = new PauseInvoiceRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setOcr(ocrNumber);
        PauseInvoiceRequest request = new PauseInvoiceRequest();
        request.setRequest(requestType);
        PauseInvoiceResponse response = InvoiceServiceAgent.getInstance().getService().pauseInvoice(request);
        return response.getResponse().getValue();
    }

    /**
     * Executes the "SearchCompany" operation.
     * @return SearchCompanyResponseType
     */
    static SearchCompanyResponseType searchCompany() {
        SearchCompanyRequestType requestType = new SearchCompanyRequestType();
        requestType.setKey(authToken);
        requestType.setCustomerno(customerNo);
        requestType.setCompanyName("Berazy");
        requestType.setPhoneticSearch(true);
        requestType.setNumberHits(10);
        SearchCompanyRequest request = new SearchCompanyRequest();
        request.setRequest(requestType);
        SearchCompanyResponse response = InvoiceServiceAgent.getInstance().getService().searchCompany(request);
        return response.getResponse().getValue();
    }
    
}
