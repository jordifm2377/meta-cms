package com.thomsonreuters.datamodel.client;


public class LookupValueDefClient {
	
	private long id;
	private long lookupId;
	private long order;
	private String value;
	private String caption;
	
	public LookupValueDefClient(long id, long lookupId, long order, String value, String caption) {
		this.setId(id);
		this.setLookupId(lookupId);
		this.setOrder(order);
		this.setValue(value);
		this.setCaption(caption);
	}

	public long getId() {
		return id;
	}

	public void setId(long id) {
		this.id = id;
	}

	public long getLookupId() {
		return lookupId;
	}

	public void setLookupId(long lookupId) {
		this.lookupId = lookupId;
	}

	public long getOrder() {
		return order;
	}

	public void setOrder(long order) {
		this.order = order;
	}

	public String getValue() {
		return value;
	}

	public void setValue(String value) {
		this.value = value;
	}

	public String getCaption() {
		return caption;
	}

	public void setCaption(String caption) {
		this.caption = caption;
	}

}
