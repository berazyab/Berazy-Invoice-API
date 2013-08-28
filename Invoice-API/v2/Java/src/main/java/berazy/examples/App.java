package berazy.examples;

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

import java.lang.reflect.Field;
import java.util.Scanner;

import berazy.examples.service.InvoiceServiceAgent;

/**
 * Simple WS example program.
 */
public class App {
    
    /**
     * The API key used in all examples.
     * @remarks Mandatory for all requests.
     */
    static final String API_KEY = null;

    /**
     * The customer number used in all examples.
     * @remarks Mandatory for all requests.
     */
    static final int CUSTOMER_NO = -1;

    /**
     * A test organizational number or unique identifier number for an individual.
     */
    static final String TEST_ORG_NO = null; 

    /**
     * A test OCR invoice number.
     */
    static final int TEST_OCR_NO = -1;

    /**
     * A test company name.
     */
    static final String TEST_COMPANY_NAME = null; 
    
    /**
     * Operation examples.
     * @param args
     */
    public static void main( String[] args ) {
        verifySetup();
        Scanner scanner = null;
        try {
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
     * Verifies setup.
     */
    @SuppressWarnings("unused")
    static void verifySetup() {
        if (API_KEY == null || 
            CUSTOMER_NO < 0 ||
               TEST_ORG_NO == null || 
               TEST_OCR_NO < 0 || 
               TEST_COMPANY_NAME == null
        ) {
            throw new IllegalArgumentException("All tests need all constants to be set.");
        }
    }
    
    /**
     * Writes out all public fields.
     * @param response
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
     * @return
     */
    static SsnCheckResponseType ssnCheck() {
        SsnCheckRequestType requestType = new SsnCheckRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setSsn(TEST_ORG_NO);
        requestType.setCreditCheck(0);
        SsnCheckRequest request = new SsnCheckRequest();
        request.setRequest(requestType);
        SsnCheckResponse response = InvoiceServiceAgent.getInstance().getService().ssnCheck(request);
        return response.getResponse().getValue();
    }
    
    /**
     * Executes the "InvoiceStatus" operation.
     * @return
     */
    static InvoiceStatusResponseType invoiceStatus() {
        InvoiceStatusRequestType requestType = new InvoiceStatusRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setOcr(TEST_OCR_NO);
        InvoiceStatusRequest request = new InvoiceStatusRequest();
        request.setRequest(requestType);
        InvoiceStatusResponse response = InvoiceServiceAgent.getInstance().getService().invoiceStatus(request);
        return response.getResponse().getValue();
    }
    
    /**
     * Executes the "InvoiceDetails" operation.
     * @return
     */
    static InvoiceDetailsResponseType invoiceDetails() {
        InvoiceDetailsRequestType requestType = new InvoiceDetailsRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setOcr(TEST_OCR_NO);
        InvoiceDetailsRequest request = new InvoiceDetailsRequest();
        request.setRequest(requestType);
        InvoiceDetailsResponse response = InvoiceServiceAgent.getInstance().getService().invoiceDetails(request);
        return response.getResponse().getValue();
    }
    
    /**
     * Executes the "ActivateInvoice" operation.
     * @return
     */
    static ActivateInvoiceResponseType activateInvoice() {
        ActivateInvoiceRequestType requestType = new ActivateInvoiceRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setOcr(TEST_OCR_NO);
        ActivateInvoiceRequest request = new ActivateInvoiceRequest();
        request.setRequest(requestType);
        ActivateInvoiceResponse response = InvoiceServiceAgent.getInstance().getService().activateInvoice(request);
        return response.getResponse().getValue();
    }

    /**
     * Executes the "ResendInvoice" operation.
     * @return
     */
    static ResendInvoiceResponseType resendInvoice() {
        ResendInvoiceRequestType requestType = new ResendInvoiceRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setOcr(TEST_OCR_NO);
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
     * @return
     */
    static PauseInvoiceResponseType pauseInvoice() {
        PauseInvoiceRequestType requestType = new PauseInvoiceRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setOcr(TEST_OCR_NO);
        PauseInvoiceRequest request = new PauseInvoiceRequest();
        request.setRequest(requestType);
        PauseInvoiceResponse response = InvoiceServiceAgent.getInstance().getService().pauseInvoice(request);
        return response.getResponse().getValue();
    }

    /**
     * Executes the "SearchCompany" operation.
     * @return
     */
    static SearchCompanyResponseType searchCompany() {
        SearchCompanyRequestType requestType = new SearchCompanyRequestType();
        requestType.setKey(API_KEY);
        requestType.setCustomerno(CUSTOMER_NO);
        requestType.setCompanyName(TEST_COMPANY_NAME);
        requestType.setPhoneticSearch(true);
        requestType.setNumberHits(10);
        SearchCompanyRequest request = new SearchCompanyRequest();
        request.setRequest(requestType);
        SearchCompanyResponse response = InvoiceServiceAgent.getInstance().getService().searchCompany(request);
        return response.getResponse().getValue();
    }
    
}
