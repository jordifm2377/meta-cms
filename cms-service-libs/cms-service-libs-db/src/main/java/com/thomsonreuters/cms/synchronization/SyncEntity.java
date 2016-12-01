package com.thomsonreuters.cms.synchronization;

import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonPropertyOrder;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

@JsonInclude(Include.NON_EMPTY)
@JsonPropertyOrder({ "actionLogId", "tableName", "tablePkValue", "action", "updatedColumns", "loggedOn", "backSynchronizationStatus", "backSynchronizationOn", "backSynchronizationMsg" })
public class SyncEntity {
	
	private Long actionLogId;
	private String tableName;
	private Long tablePkValue;
	private String action;
	private String updatedColumns;
	private String loggedOn;
	private String backSynchronizationStatus;
	private String backSynchronizationOn;
	private String backSynchronizationMsg;
	
	public SyncEntity() {
		// default constructor
	}
	
	// getters
	
	@JsonProperty("actionLogId")
	public Long getActionLogId() {
		return actionLogId;
	}
	
	@JsonProperty("tableName")
	public String getTableName() {
		return tableName;
	}
	
	@JsonProperty("tablePkValue")
	public Long getTablePkValue() {
		return tablePkValue;
	}
	
	@JsonProperty("action")
	public String getAction() {
		return action;
	}
	
	@JsonProperty("updatedColumns")
	public String getUpdatedColumns() {
		return updatedColumns;
	}
	
	@JsonProperty("loggedOn")
	public String getLoggedOn() {
		return loggedOn;
	}
	
	@JsonProperty("backSynchronizationStatus")
	public String getBackSynchronizationStatus() {
		return backSynchronizationStatus;
	}
	
	@JsonProperty("backSynchronizationOn")
	public String getBackSynchronizationOn() {
		return backSynchronizationOn;
	}
	
	@JsonProperty("backSynchronizationMsg")
	public String getBackSynchronizationMsg() {
		return backSynchronizationMsg;
	}
	
	// setters
	
	public void setActionLogId(Long actionLogId) {
		this.actionLogId = actionLogId;
	}
	
	public void setTableName(String tableName) {
		this.tableName = tableName;
	}
	
	public void setTablePkValue(Long tablePkValue) {
		this.tablePkValue = tablePkValue;
	}
	
	public void setAction(String action) {
		this.action = action;
	}
	
	public void setUpdatedColumns(String updatedColumns) {
		this.updatedColumns = updatedColumns;
	}
	
	public void setLoggedOn(String loggedOn) {
		this.loggedOn = loggedOn;
	}
	
	public void setBackSynchronizationStatus(String backSynchronizationStatus) {
		this.backSynchronizationStatus = backSynchronizationStatus;
	}
	
	public void setBackSynchronizationOn(String backSynchronizationOn) {
		this.backSynchronizationOn = backSynchronizationOn;
	}
	
	public void setBackSynchronizationMsg(String backSynchronizationMsg) {
		this.backSynchronizationMsg = backSynchronizationMsg;
	}
    
    @Override
    public String toString() {
    	
    	StringBuilder stringBuilder = new StringBuilder();
    	
    	stringBuilder.append("logId: ");
    	stringBuilder.append(actionLogId);
    	
    	stringBuilder.append(", table: ");
    	stringBuilder.append(tableName);
    	
    	stringBuilder.append(", id: ");
    	stringBuilder.append(tablePkValue);
    	
    	stringBuilder.append(", action: ");
    	stringBuilder.append(action);
    	
    	if (updatedColumns != null) {
        	stringBuilder.append(", columns: ");
        	stringBuilder.append(updatedColumns);
    	}
    	
    	return stringBuilder.toString();
    }
}
