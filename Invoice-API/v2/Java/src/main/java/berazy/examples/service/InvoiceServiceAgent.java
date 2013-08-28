package berazy.examples.service;

import http.schema_invoice_berazy_se.v2.InvoiceService;
import http.schema_invoice_berazy_se.v2.InvoiceService_Service;

/**
 * Service singleton.
 */
public class InvoiceServiceAgent {

	/**
	 * Thread safe instance.
	 */
	static InvoiceServiceAgent instance;
	
	/**
	 * Read lock to prevent re-initialization.
	 */
	static final Object readLock = new Object();
	
	/**
	 * The invoice service.
	 */
	InvoiceService invoiceService;
	
	/**
	 * Default constructor.
	 */
	InvoiceServiceAgent() {
    	invoiceService = new InvoiceService_Service().getInvoiceServicePort();
	}
	
	/**
	 * Returns the thread safe instance.
	 * @return
	 */
	public static InvoiceServiceAgent getInstance() {
		if (instance == null) {
			synchronized(readLock) {
		        if (instance == null) {
		           instance = new InvoiceServiceAgent();
		        }
			}
		}
		return instance;
	}
	
	/**
	 * Returns the service.
	 * @return
	 */
	public InvoiceService getService() {
		return invoiceService;
	}
	
}
