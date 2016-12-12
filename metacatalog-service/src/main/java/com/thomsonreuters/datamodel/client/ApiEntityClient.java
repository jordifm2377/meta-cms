package com.thomsonreuters.datamodel.client;

import java.util.List;

public class ApiEntityClient {
	
	private String id;
	private String entityId;
	private String relId;
	private String orderType;
	private String parentEntitiyId;
	private String parentInstanceId;
	private String status;
	private String action;
	private List<ApiEntityClient> entities;
	private List<ApiAttributeClient> attributes;


	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getEntityId() {
		return entityId;
	}
	public void setEntityId(String entityId) {
		this.entityId = entityId;
	}
	public String getRelId() {
		return relId;
	}
	public void setRelId(String relId) {
		this.relId = relId;
	}
	public String getOrderType() {
		return orderType;
	}
	public void setOrderType(String orderType) {
		this.orderType = orderType;
	}
	public String getParentEntitiyId() {
		return parentEntitiyId;
	}
	public void setParentEntitiyId(String parentEntitiyId) {
		this.parentEntitiyId = parentEntitiyId;
	}
	public String getParentInstanceId() {
		return parentInstanceId;
	}
	public void setParentInstanceId(String parentInstanceId) {
		this.parentInstanceId = parentInstanceId;
	}
	public String getStatus() {
		return status;
	}
	public void setStatus(String status) {
		this.status = status;
	}
	public String getAction() {
		return action;
	}
	public void setAction(String action) {
		this.action = action;
	}
	public List<ApiEntityClient> getEntities() {
		return entities;
	}
	public void setEntities(List<ApiEntityClient> entities) {
		this.entities = entities;
	}
	public List<ApiAttributeClient> getAttributes() {
		return attributes;
	}
	public void setAttributes(List<ApiAttributeClient> attributes) {
		this.attributes = attributes;
	}

}
