package com.thomsonreuters.datamodel.client;

public class ApiAttributeClient {

	private String id;
	private String instanceId;
	private String entityId;
	private String attributeId;
	private String attributeEntityId;
	private String mandatory;
	private String valueId;
	private String value;
	

	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getInstanceId() {
		return instanceId;
	}
	public void setInstanceId(String instanceId) {
		this.instanceId = instanceId;
	}
	public String getEntityId() {
		return entityId;
	}
	public void setEntityId(String entityId) {
		this.entityId = entityId;
	}
	public String getAttributeId() {
		return attributeId;
	}
	public void setAttributeId(String attributeId) {
		this.attributeId = attributeId;
	}
	public String getAttributeEntityId() {
		return attributeEntityId;
	}
	public void setAttributeEntityId(String attributeEntityId) {
		this.attributeEntityId = attributeEntityId;
	}
	public String getMandatory() {
		return mandatory;
	}
	public void setMandatory(String mandatory) {
		this.mandatory = mandatory;
	}
	public String getValueId() {
		return valueId;
	}
	public void setValueId(String valueId) {
		this.valueId = valueId;
	}
	public String getValue() {
		return value;
	}
	public void setValue(String value) {
		this.value = value;
	}

}
