package com.thomsonreuters.datamodel.client;

import java.util.ArrayList;
import java.util.List;


public class LookupDefClient {
	
	private long id;
	private String name;
	private String type;
	private long defaultId;
	private List<LookupValueDefClient> lookupValues;

	public LookupDefClient() {
		setLookupValues(new ArrayList<>());
	}
	public long getId() {
		return id;
	}
	public void setId(long id) {
		this.id = id;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
	}
	public long getDefaultId() {
		return defaultId;
	}
	public void setDefaultId(long defaultId) {
		this.defaultId = defaultId;
	}
	public List<LookupValueDefClient> getLookupValues() {
		return lookupValues;
	}
	public void setLookupValues(List<LookupValueDefClient> lookupValues) {
		this.lookupValues = lookupValues;
	}	

	public void addLookupValue(long id, long lookupId, long order, String value, String caption) {
		this.lookupValues.add(new LookupValueDefClient(id, lookupId, order, value, caption));
	}
}
