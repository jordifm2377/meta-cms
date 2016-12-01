package com.thomsonreuters.common.response;

import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonPropertyOrder;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

@JsonInclude(Include.NON_EMPTY)
@JsonPropertyOrder({ "responseType", "message", "entity", "entityId", "term", "currentParentId", "newParentId", "userId" })
public class ServiceResponse {
	
	public static final String OK = "OK";
	public static final String WARNING = "WARNING";
	public static final String ERROR = "ERROR";
	
	public static final String GET = "GET";
	public static final String SEARCH = "SEARCH";
	
	public static final String ADD = "ADD";
	public static final String DELETE = "DELETE";
	
	private String responseType;
	private String message;
	private String entity;
	private Long entityId;
	private String term;
	private Long currentParentId;
	private Long newParentId;
	private Long userId;
	
	public ServiceResponse() {
		// default constructor
	}
	
	public ServiceResponse(String responseType, String message) {
		
		// constructor with required fields for common error/warning
		this.responseType = responseType;
		this.message = message;
	}
	
	public ServiceResponse(String responseType, String message, Long entityId) {
		
		// constructor with GET error fields
		this.responseType = responseType;
		this.message = message;
		this.entityId = entityId;
	}
	
	public ServiceResponse(String responseType, String message, String value, String action) {
		
		// constructor with GET/SEARCH error fields
		this.responseType = responseType;
		this.message = message;
		
		if (action.equals(GET)) { // entity Id may not be number
			entity = value;
		} else if (action.equals(SEARCH)) {
			term = value;
		} else {
			// treated as constructor with ADD/UPDATE/DELETE error fields
		}
	}
	
	public ServiceResponse(String responseType, String message, Long entityId, Long userId) {
		
		// constructor with ADD/UPDATE/DELETE error fields
		this.responseType = responseType;
		this.message = message;
		this.entityId = entityId;
		this.userId = userId;
	}
	
	public ServiceResponse(String responseType, String message, Long entityId, Long parentId, String action, Long userId) {
		
		// constructor with TREE ASSOCIATE/DISASSOCIATE error fields
		this.responseType = responseType;
		this.message = message;
		this.entityId = entityId;
		this.userId = userId;
		
		if (action.equals(ADD)) {
			newParentId = parentId;
		} else if (action.equals(DELETE)) {
			currentParentId = parentId;
		} else {
			// treated as constructor with ADD/UPDATE/DELETE error fields
		}
	}
	
	public ServiceResponse(String responseType, String message, Long entityId, Long currentParentId, Long newParentId, Long userId) {
		
		// constructor with TREE MOVE error fields
		this.responseType = responseType;
		this.message = message;
		this.entityId = entityId;
		this.currentParentId = currentParentId;
		this.newParentId = newParentId;
		this.userId = userId;
	}
	
	// getters
	
	@JsonProperty("responseType")
	public String getResponseType() {
		return responseType;
	}
	
	@JsonProperty("message")
	public String getMessage() {
		return message;
	}
	
	@JsonProperty("entity")
	public String getEntity() {
		return entity;
	}
	
	@JsonProperty("entityId")
	public Long getEntityId() {
		return entityId;
	}
	
	@JsonProperty("term")
	public String getTerm() {
		return term;
	}
	
	@JsonProperty("currentParentId")
	public Long getCurrentParentId() {
		return currentParentId;
	}
	
	@JsonProperty("newParentId")
	public Long getNewParentId() {
		return newParentId;
	}
	
	@JsonProperty("userId")
	public Long getUserId() {
		return userId;
	}
	
	// setters
	
	public void setResponseType(String responseType) {
		this.responseType = responseType;
	}
	
	public void setMessage(String message) {
		this.message = message;
	}
	
	public void setEntity(String entity) {
		this.entity = entity;
	}
	
	public void setEntityId(Long entityId) {
		this.entityId = entityId;
	}
	
	public void setTerm(String term) {
		this.term = term;
	}
	
	public void setCurrentParentId(Long currentParentId) {
		this.currentParentId = currentParentId;
	}
	
	public void setNewParentId(Long newParentId) {
		this.newParentId = newParentId;
	}
	
	public void setUserId(Long userId) {
		this.userId = userId;
	}
}
